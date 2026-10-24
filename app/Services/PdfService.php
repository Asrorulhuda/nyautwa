<?php

declare(strict_types=1);

namespace App\Services;

class PdfService {
    private array $pages = [];
    private string $stream = '';

    public function newPage(): void { if ($this->stream !== '') { $this->pages[] = $this->stream; $this->stream = ''; } }
    public function rect(float $x, float $y, float $w, float $h, float $r, float $g, float $b): void { $this->stream .= sprintf("%.2f %.2f %.2f rg %.2f %.2f %.2f %.2f re f\n", $r, $g, $b, $x, $y, $w, $h); }
    public function text(float $x, float $y, string $text, int $size = 10, string $font = 'F1', float $r = 0.09, float $g = 0.13, float $b = 0.12): void {
        $safe = str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text);
        $this->stream .= sprintf("%.2f %.2f %.2f rg BT /%s %d Tf %.2f %.2f Td (%s) Tj ET\n", $r, $g, $b, $font, $size, $x, $y, $safe);
    }


    public function generateIntegrationPdf(): string {
        $this->newPage();
        $this->rect(0, 800, 595.28, 41.89, 0.086, 0.639, 0.415);
        $this->text(40, 815, "NYAUTWA - WHATSAPP GATEWAY SAAS", 14, "F2", 1, 1, 1);
        $this->text(40, 775, "PANDUAN INTEGRASI REST API & SIPANDA2", 15, "F2");
        $this->text(40, 760, "Dokumen Resmi Spesifikasi Integrasi Sistem Eksternal", 9, "F1", 0.41, 0.46, 0.44);

        $sections = [
            [728, "1. KREDENSIAL & ENDPOINT URL", [
                [712, "Base Server URL     : https://nyautwa.asr-desain.my.id", "F2"],
                [698, "Endpoint Pesan      : POST /api/v1/messages  (Standar REST)", "F1"],
                [684, "Endpoint Alias      : POST /send-message & POST /send-media (Drop-in Sipanda)", "F1"],
                [670, "Metode Autentikasi  : Bearer Token, X-Api-Key Header, atau Parameter Body api_key", "F1"],
            ]],
            [642, "2. PARAMETER PENGIRIMAN FLEKSIBEL (MULTI-ALIAS)", [
                [626, "Nomor Tujuan   : to | phone | number | target  (Contoh: 081234567890 / 62812...)", "F1"],
                [612, "Isi Pesan      : text | message | body | caption (Mendukung Spintax: {Halo|Hai})", "F1"],
                [598, "Media URL      : url | media_url (Link langsung foto/gambar/dokumen publik)", "F1"],
                [584, "Device/Sender  : device_id | sender (Opsional, otomatis memilih device aktif)", "F1"],
            ]],
            [556, "3. INTEGRASI INSTAN SIPANDA2 (TANPA UBAH KODE)", [
                [540, "1. Buka menu Admin Sipanda2 -> Pengaturan Sekolah -> F. WA Gateway Integration", "F1"],
                [526, "2. WA Gateway Target URL : https://nyautwa.asr-desain.my.id/send-message", "F2"],
                [512, "3. WA Token / API Key    : Masukkan API Key tenant dari menu API Keys NyautWa", "F1"],
                [498, "4. WA Sender Utama       : Masukkan nomor WA yang tersambung di NyautWa", "F1"],
                [484, "5. Klik Simpan. Seluruh notifikasi tagihan, presensi, & MBG langsung terkirim!", "F1"],
            ]],
            [456, "4. CONTOH KODE & WEBHOOK", [
                [440, "PHP cURL: curl_setopt(CURLOPT_POSTFIELDS, json_encode(['to'=>'0812...','text'=>'Halo']));", "F1"],
                [426, "Laravel : Http::withToken('<KEY>')->post('.../api/v1/messages', ['to'=>'...','text'=>'...']);", "F1"],
                [412, "Node.js : axios.post('.../api/v1/messages', {to:'...', text:'...'}, {headers:{Authorization:'...'}});", "F1"],
                [398, "Webhook : Daftarkan URL Webhook di dashboard untuk event masuk & laporan terkirim/read.", "F1"],
            ]],
        ];

        foreach ($sections as [$boxY, $title, $items]) {
            $this->rect(40, (float) $boxY, 515, 20, 0.96, 0.97, 0.96);
            $this->text(45, (float) ($boxY + 6), $title, 10, "F2");
            foreach ($items as [$itemY, $text, $font]) { $this->text(50, (float) $itemY, $text, 9, $font); }
        }

        $this->rect(40, 50, 515, 1, 0.89, 0.91, 0.90);
        $this->text(40, 38, "Dokumen resmi NyautWa SaaS Gateway - Dicetak otomatis untuk referensi integrasi klien.", 8, "F1", 0.41, 0.46, 0.44);
        $this->text(490, 38, "Halaman 1 / 1", 8, "F1", 0.41, 0.46, 0.44);
        return $this->buildPdf();
    }


    private function buildPdf(): string {
        $this->newPage();
        $count = count($this->pages);
        $kids = array_map(fn($i) => (5 + ($i * 2)) . " 0 R", range(0, $count - 1));
        $out = "%PDF-1.4\n";
        $offsets = [
            1 => strlen($out), 2 => strlen($out) + 48,
            3 => strlen($out) + 115, 4 => strlen($out) + 195
        ];
        $out .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";
        $out .= "2 0 obj\n<< /Type /Pages /Kids [" . implode(' ', $kids) . "] /Count {$count} >>\nendobj\n";
        $out .= "3 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";
        $out .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n";

        for ($i = 0; $i < $count; $i++) {
            $pObj = 5 + ($i * 2); $cObj = 6 + ($i * 2);
            $offsets[$pObj] = strlen($out);
            $out .= "{$pObj} 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595.28 841.89] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents {$cObj} 0 R >>\nendobj\n";
            $len = strlen($this->pages[$i]);
            $offsets[$cObj] = strlen($out);
            $out .= "{$cObj} 0 obj\n<< /Length {$len} >>\nstream\n" . $this->pages[$i] . "\nendstream\nendobj\n";
        }

        $xref = strlen($out); $total = 4 + ($count * 2);
        $out .= "xref\n0 " . ($total + 1) . "\n0000000000 65535 f \n";
        for ($i = 1; $i <= $total; $i++) { $out .= sprintf("%010d 00000 n \n", $offsets[$i]); }
        return $out . "trailer\n<< /Size " . ($total + 1) . " /Root 1 0 R >>\nstartxref\n{$xref}\n%%EOF\n";
    }
}

