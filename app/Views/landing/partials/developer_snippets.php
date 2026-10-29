<?php
$apiUrl = url('/api/v1/messages');
return [
    'curl' => [
        'name' => 'cURL',
        'badge' => 'Bash / CLI',
        'code' => <<<CURL
# Kirim pesan teks WhatsApp via NyautWa REST API
curl -X POST {$apiUrl} \\
  -H "Authorization: Bearer nyaut_live_948f2178ad99e120" \\
  -H "Content-Type: application/json" \\
  -d '{
    "phone": "6281234567890",
    "message": "Halo! Pesanan Anda #INV-9482 telah kami proses."
  }'
CURL
    ],
    'nodejs' => [
        'name' => 'Node.js', 'badge' => 'Node.js 18+ (Fetch)',
        'code' => <<<NODEJS
// Kirim pesan WhatsApp via Node.js
const res = await fetch('{$apiUrl}', {
  method: 'POST',
  headers: { 'Authorization': 'Bearer nyaut_live_948f2178ad99e120', 'Content-Type': 'application/json' },
  body: JSON.stringify({ phone: '6281234567890', message: 'Halo! Pesanan Anda telah kami proses.' })
});
const data = await res.json();
console.log('Respons Gateway:', data);
NODEJS
    ],
    'python' => [
        'name' => 'Python', 'badge' => 'Python 3 (Requests)',
        'code' => <<<PYTHON
# Kirim pesan WhatsApp via Python Requests
import requests

url = "{$apiUrl}"
headers = {"Authorization": "Bearer nyaut_live_948f2178ad99e120", "Content-Type": "application/json"}
payload = {"phone": "6281234567890", "message": "Halo! Pesanan Anda telah kami proses."}

res = requests.post(url, json=payload, headers=headers)
print("Respons:", res.json())
PYTHON
    ],
    'php' => [
        'name' => 'PHP', 'badge' => 'PHP 8.2+ (cURL)',
        'code' => <<<PHP
<?php
// Kirim pesan WhatsApp via PHP Native
\$ch = curl_init('{$apiUrl}');
curl_setopt_array(\$ch, [
    CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer nyaut_live_948f2178ad99e120',
        'Content-Type: application/json',
    ],
    CURLOPT_POSTFIELDS => json_encode([
        'phone' => '6281234567890',
        'message' => 'Halo! Pesanan Anda #INV-9482 telah kami proses.',
    ])
]);
\$res = curl_exec(\$ch);
curl_close(\$ch);
PHP
    ],
    'go' => [
        'name' => 'Go', 'badge' => 'Go (net/http)',
        'code' => <<<GO
// Kirim pesan WhatsApp via Golang
package main

import ("bytes"; "net/http")

func main() {
    url := "{$apiUrl}"
    payload := []byte(`{"phone":"6281234567890","message":"Halo dari NyautWa!"}`)
    req, _ := http.NewRequest("POST", url, bytes.NewBuffer(payload))
    req.Header.Set("Authorization", "Bearer nyaut_live_948f2178ad99e120")
    req.Header.Set("Content-Type", "application/json")
    client := &http.Client{}
    res, _ := client.Do(req)
    defer res.Body.Close()
}
GO
    ]
];
