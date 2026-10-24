# Panduan Integrasi NyautWa REST API

Dokumen ini menjelaskan cara menghubungkan aplikasi eksternal (Website, SaaS, CRM, Kasir, atau Sistem Sekolah seperti **Sipanda**) ke gateway **NyautWa**.

---

## 1. Kredensial & URL Endpoint

- **Base URL Server**: `https://nyautwa.asr-desain.my.id`
- **Endpoint Kirim Pesan**: 
  - Standar REST: `POST /api/v1/messages`
  - Drop-in Alias: `POST /send-message` & `POST /send-media`
- **Autentikasi yang Didukung**:
  1. Header: `Authorization: Bearer <API_KEY>` (Direkomendasikan)
  2. Header: `X-Api-Key: <API_KEY>`
  3. Body POST / Query: `api_key=<API_KEY>` (Kompatibilitas aplikasi legacy)

---

## 2. Format Payload Kirim Pesan

NyautWa mendukung multi-format parameter sehingga sangat fleksibel:
- **Tujuan**: `to`, `phone`, `number`, atau `target` (Format: `08...`, `628...`, atau `+628...`)
- **Pesan**: `text`, `message`, `body`, atau `caption` (Mendukung Spintax `{Halo|Hai}`)
- **Media**: `url` atau `media_url` (Link gambar/dokumen yang bisa diakses publik)
- **Sender/Device (Opsional)**: `device_id` atau `sender` (Otomatis memilih device aktif jika kosong)

### Contoh Payload JSON:
```json
{
  "to": "081234567890",
  "text": "{Halo|Hai} Pesanan #1042 Anda sudah diproses."
}
```

### Contoh Payload Media Gambar:
```json
{
  "to": "081234567890",
  "caption": "Bukti Pembayaran Tagihan",
  "url": "https://domainanda.com/uploads/struk.jpg"
}
```

---

## 3. Integrasi Drop-In (Contoh: Sipanda2 / Gateway Fonnte / MPWA)

Jika aplikasi Anda sudah memiliki menu integrasi WA Gateway (seperti **Sipanda2**):
1. Buka menu **Pengaturan Sekolah / Pengaturan Gateway**.
2. Masukkan:
   - **Target URL**: `https://nyautwa.asr-desain.my.id/send-message`
   - **API Key / Token**: Masukkan API Key dari dashboard NyautWa.
   - **Sender**: Nomor WhatsApp Anda yang terhubung di NyautWa.
3. Simpan — **Selesai tanpa perlu mengubah source code aplikasi Anda.**

---

## 4. Contoh Kode Pemrograman

### A. PHP Native / cURL
```php
$data = ['to' => '081234567890', 'text' => 'Halo dari PHP!'];
$ch = curl_init('https://nyautwa.asr-desain.my.id/api/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer YOUR_API_KEY',
        'Content-Type: application/json'
    ]
]);
$res = curl_exec($ch);
curl_close($ch);
```

### B. Laravel (HTTP Client)
```php
$response = Http::withToken('YOUR_API_KEY')
    ->post('https://nyautwa.asr-desain.my.id/api/v1/messages', [
        'to' => '081234567890',
        'text' => 'Halo dari Laravel!'
    ]);
```

### C. Node.js (Axios)
```javascript
const axios = require('axios');
await axios.post('https://nyautwa.asr-desain.my.id/api/v1/messages', 
  { to: '081234567890', text: 'Halo dari Node.js!' },
  { headers: { 'Authorization': 'Bearer YOUR_API_KEY' } }
);
```

---

## 5. Webhook Notifikasi Masuk & Status Pengiriman
Daftarkan URL Webhook Anda di menu **API Keys** NyautWa. Setiap ada pesan masuk atau update status centang (delivered/read), NyautWa akan mengirimkan HTTP POST event ke URL Anda secara real-time.

