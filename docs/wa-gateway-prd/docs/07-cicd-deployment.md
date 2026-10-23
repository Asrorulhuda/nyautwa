# 07 — CI/CD dan Deployment (GitHub)

**Prinsip utama:** kode **tidak pernah di-deploy atau di-push langsung ke `main`**. Semua perubahan lewat Pull Request, diuji otomatis, dicoba dulu di **staging**, baru dipromosikan ke **production** dengan persetujuan manual.

## 1. Alur ringkas

```
feature/*  ──PR──►  develop  ──auto──►  STAGING
fix/*                 │                    │ uji manual + smoke test
                      │                    ▼
                      └──── PR rilis ───►  main (protected)
                                            │
                                  tag vX.Y.Z (dari main)
                                            │
                                  approval manual (reviewer)
                                            ▼
                                       PRODUCTION
                                   (backup → migrate → deploy
                                    → health check → auto-rollback)
```

| Branch | Fungsi | Siapa boleh push | Deploy otomatis |
|---|---|---|---|
| `feature/*`, `fix/*` | Kerja harian | Developer | Tidak (hanya CI) |
| `develop` | Integrasi | Hanya via PR | **Staging** |
| `main` | Kode yang sudah lolos staging | **Hanya via PR dari `develop`** | Tidak ada. Production dipicu oleh tag |
| `hotfix/*` | Perbaikan darurat dari `main` | Developer | Tidak (PR ke `main` lalu back-merge ke `develop`) |

## 2. Branch protection (atur di GitHub → Settings → Branches)

**`main`**
- Require a pull request before merging, minimal **1–2 approval**, dismiss stale approvals.
- Require status checks: `ci / php`, `ci / node`, `ci / security`, `ci / docker-build`.
- Require branch up to date before merging.
- Require conversation resolution.
- Restrict who can push: **tidak ada** (termasuk admin: aktifkan *Do not allow bypassing*).
- Block force push dan deletion.
- Hanya izinkan PR dengan source `develop` atau `hotfix/*` (cek lewat workflow `ci` job `guard-main`).
- Require linear history (gunakan *Squash* atau *Rebase and merge*).

**`develop`**
- Require PR, 1 approval, status checks yang sama, block force push.

**Tags**
- Tag ruleset untuk pola `v*`: hanya maintainer yang boleh membuat tag.

## 3. GitHub Environments

| Environment | Trigger | Proteksi |
|---|---|---|
| `staging` | Push ke `develop` | Tidak perlu approval |
| `production` | Tag `v*` dari `main` | **Required reviewers** (min. 1 orang selain pembuat tag), *wait timer* opsional 5 menit, batasi ke tag `v*` |

Secrets per environment (jangan di level repo agar tidak bocor lintas environment):

| Secret | Keterangan |
|---|---|
| `SSH_HOST`, `SSH_USER`, `SSH_KEY` | Akses server deploy (user khusus, bukan root) |
| `DEPLOY_PATH` | Contoh `/opt/wa-gateway` |
| `APP_URL` | Untuk health check dan smoke test |
| `GHCR_TOKEN` | Opsional bila image private (default memakai `GITHUB_TOKEN`) |

Rahasia aplikasi (`.env` berisi DB, Redis, kunci enkripsi) **disimpan di server**, bukan di repo dan tidak ditulis ulang oleh pipeline.

## 4. Workflow yang disediakan

| File | Trigger | Tugas |
|---|---|---|
| [`ci.yml`](../.github/workflows/ci.yml) | PR ke `develop`/`main`, push ke `develop` | Lint, analisis statis, tes PHP & Node, audit dependensi, scan secret, build Docker, guard sumber PR ke `main` |
| [`deploy-staging.yml`](../.github/workflows/deploy-staging.yml) | Push ke `develop` | Build & push image `sha-<commit>`, deploy ke staging, migrasi, smoke test |
| [`deploy-production.yml`](../.github/workflows/deploy-production.yml) | Tag `v*` | Pastikan tag berasal dari `main`, build image versi, **tunggu approval**, backup DB, migrasi, deploy, health check, rollback otomatis bila gagal |
| [`rollback.yml`](../.github/workflows/rollback.yml) | Manual (`workflow_dispatch`) | Kembalikan production ke versi sebelumnya |

Pendukung: [`CODEOWNERS`](../.github/CODEOWNERS), [`pull_request_template.md`](../.github/pull_request_template.md), [`dependabot.yml`](../.github/dependabot.yml).

## 5. Isi pemeriksaan CI

| Job | Pemeriksaan |
|---|---|
| `php` | `composer validate`, `php -l`, PHP_CodeSniffer (PSR-12), PHPStan level 6+, PHPUnit dengan service MySQL & Redis, tes isolasi tenant |
| `node` | `npm ci`, ESLint, tes unit engine, cek tidak ada versi Baileys yang tidak dipin |
| `security` | `composer audit`, `npm audit --omit=dev`, Gitleaks (scan secret), Trivy untuk image |
| `docker-build` | Build image app dan engine (tanpa push) untuk memastikan Dockerfile valid |
| `guard-main` | Menolak PR ke `main` bila source bukan `develop` atau `hotfix/*` |

Tes wajib ada sejak MVP: isolasi tenant (user tenant A tidak bisa baca data tenant B), idempotensi kirim pesan, verifikasi HMAC webhook, perhitungan kuota, validasi SSRF webhook.

## 6. Prosedur rilis

1. Fitur selesai → PR ke `develop` → CI hijau → review → merge.
2. Merge ke `develop` otomatis deploy ke **staging**.
3. Uji di staging dengan nomor uji: scan QR, kirim/terima pesan, webhook, kuota, migrasi. Gunakan checklist di bagian 9.
4. Buka **PR rilis** `develop → main` (judul `Release vX.Y.Z`), isi changelog. Butuh approval + CI hijau.
5. Setelah merge, buat tag dari `main`:
   ```bash
   git checkout main && git pull
   git tag -a v1.2.0 -m "Release v1.2.0"
   git push origin v1.2.0
   ```
6. Workflow production berjalan sampai tahap approval. Reviewer memeriksa staging lalu menyetujui di tab Actions.
7. Pipeline: backup DB → migrasi → deploy → health check → selesai (atau rollback otomatis).
8. Pantau 30 menit pertama: tingkat gagal pesan, sesi terputus, panjang antrean.

## 7. Strategi deploy di server

- Server memakai Docker Compose; image ditarik dari GHCR dengan tag versi (`v1.2.0`), **tidak pernah `latest`**.
- Pipeline menyimpan versi sebelumnya di `DEPLOY_PATH/.previous_version` untuk rollback cepat.
- Urutan: tarik image baru → backup DB → jalankan migrasi (`migrate` one-off container) → update service `app` dan `worker` → update service `engine` **terakhir dan terpisah**.
- **Engine Baileys memegang sesi aktif**, jadi restart-nya memutus koneksi sementara. Lakukan di jendela sepi, dan pastikan sesi dipulihkan otomatis (< 60 detik). Hindari restart engine untuk perubahan yang hanya menyentuh PHP (pakai *path filter* agar engine tidak ikut di-deploy bila tidak berubah).
- Health check: `GET /healthz` (app, DB, Redis) dan `GET /internal/engine/health` (jumlah sesi pulih). Deploy dianggap gagal bila tidak sehat dalam 2 menit.

## 8. Aturan migrasi database

- Migrasi harus **backward compatible** dengan versi aplikasi sebelumnya (pola *expand → migrate → contract*), supaya rollback aplikasi tidak butuh rollback database.
- Dilarang `DROP COLUMN`/`DROP TABLE` di rilis yang sama dengan kode yang berhenti memakainya; lakukan di rilis berikutnya.
- Setiap migrasi diuji di staging dengan salinan data yang dianonimkan.
- Backup otomatis sebelum migrasi production; simpan minimal 14 hari.
- Rollback database hanya dari backup, sebagai langkah terakhir dan butuh keputusan manusia.

## 9. Checklist sebelum menyetujui production

- [ ] CI hijau di commit yang akan dirilis.
- [ ] Staging berjalan ≥ 1 hari tanpa error baru.
- [ ] Skenario inti lolos: QR, kirim teks, kirim media, terima pesan, webhook, kuota habis.
- [ ] Migrasi sudah dicoba di staging dan backward compatible.
- [ ] Changelog dan nomor versi benar (SemVer).
- [ ] Tidak ada perubahan Baileys tanpa uji khusus (lihat bagian 11).
- [ ] Ada orang yang siaga memantau setelah rilis.

## 10. Hotfix

1. Buat `hotfix/deskripsi` dari `main`.
2. PR ke `main` (CI + 1 approval).
3. Tag `vX.Y.Z+1` → pipeline production (tetap butuh approval).
4. Back-merge `main` ke `develop` agar perbaikan tidak hilang.

## 11. Update Baileys

Baileys sering berubah dan bisa merusak sesi.
- Versi **dipin** persis di `package.json` dan `package-lock.json`.
- Dependabot untuk Baileys dibuat **manual-review**, tidak auto-merge.
- Wajib uji di staging dengan nomor uji: scan QR baru, pemulihan sesi lama setelah restart, kirim/terima teks dan media, status centang.
- Rilis update Baileys sebagai rilis tersendiri, bukan digabung dengan fitur lain, supaya rollback jelas.

## 12. Versioning dan changelog

- SemVer: `MAJOR` (breaking API), `MINOR` (fitur), `PATCH` (perbaikan).
- `CHANGELOG.md` diperbarui di PR rilis (format Keep a Changelog).
- Versi API publik terpisah (`/api/v1`) dari versi aplikasi.

## 13. Langkah setup satu kali

1. Buat repo, aktifkan branch protection (bagian 2) dan tag ruleset.
2. Buat environment `staging` dan `production` (+ reviewer) dan isi secrets (bagian 3).
3. Siapkan server staging dan production: Docker, user `deploy`, folder `DEPLOY_PATH`, `docker-compose.yml`, `.env`, `deploy` public key.
4. Tambah `docker/app.Dockerfile` dan `docker/engine.Dockerfile`.
5. Aktifkan Dependabot, secret scanning, push protection, dan CodeQL di Settings → Security.
6. Uji alur dengan PR kecil: `feature → develop → staging → PR rilis → tag → production`.

> Workflow di folder `.github/workflows` adalah **templat awal**. Sesuaikan nama image, path, dan perintah dengan struktur proyek sebenarnya, lalu uji di staging sebelum dipakai untuk production.
