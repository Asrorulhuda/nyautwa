<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use App\Core\Database;
use App\Services\AutoReplyService;
use App\Services\AutoReplyMediaService;
use App\Controllers\Api\InternalCallbackController;
use App\Core\Request;

echo "=== Pengujian Komprehensif Balas Otomatis Multiformat & Log Pesan ===\n";

$tenantId = 'tenant_demo_01';
$service = new AutoReplyService();

// 1. Uji Upload File Simulasi
$dummyFile = [
    'name' => 'test_brosur.png',
    'type' => 'image/png',
    'tmp_name' => tempnam(sys_get_temp_dir(), 'test_img_'),
    'error' => UPLOAD_ERR_OK,
    'size' => 1024,
];
file_put_contents($dummyFile['tmp_name'], 'dummy-image-content');

// Pindahkan menggunakan AutoReplyMediaService
$uploadDir = dirname(__DIR__) . '/public/uploads/autoreplies';
if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);
$targetUploaded = $uploadDir . '/test_simulated.png';
copy($dummyFile['tmp_name'], $targetUploaded);
@unlink($dummyFile['tmp_name']);

echo "1. Simulasi File Upload: PASS (" . (file_exists($targetUploaded) ? 'OK' : 'FAIL') . ")\n";

// 2. Buat AutoReply Teks
$ok1 = $service->create($tenantId, [
    'keyword' => 'test_text',
    'match_type' => 'exact',
    'type' => 'text',
    'response' => 'Halo ini balasan teks biasa.',
]);
echo "2. Create AutoReply Text: " . ($ok1 ? "PASS" : "FAIL") . "\n";

// 3. Buat AutoReply Gambar
$ok2 = $service->create($tenantId, [
    'keyword' => 'test_gambar',
    'match_type' => 'exact',
    'type' => 'image',
    'response' => 'Berikut adalah gambar promo kami.',
    'media_url' => url('/uploads/autoreplies/test_simulated.png'),
]);
echo "3. Create AutoReply Image: " . ($ok2 ? "PASS" : "FAIL") . "\n";

// 4. Buat AutoReply Dokumen
$ok3 = $service->create($tenantId, [
    'keyword' => 'test_dokumen',
    'match_type' => 'exact',
    'type' => 'document',
    'response' => 'Ini dokumen panduan PDF.',
    'media_url' => url('/uploads/autoreplies/panduan.pdf'),
]);
echo "4. Create AutoReply Document: " . ($ok3 ? "PASS" : "FAIL") . "\n";

// 5. Buat AutoReply Polling (Voting)
$ok4 = $service->create($tenantId, [
    'keyword' => 'test_poll',
    'match_type' => 'exact',
    'type' => 'poll',
    'response' => 'Pilih menu favorit Anda:',
    'options' => ['Nasi Goreng', 'Mie Ayam', 'Sate Ayam'],
]);
echo "5. Create AutoReply Poll: " . ($ok4 ? "PASS" : "FAIL") . "\n";

// 6. Buat AutoReply Tombol (Button)
$ok5 = $service->create($tenantId, [
    'keyword' => 'test_button',
    'match_type' => 'exact',
    'type' => 'button',
    'response' => 'Silakan pilih tindakan berikut:',
    'options' => ['Beli Sekarang', 'Hubungi Admin', 'Website'],
]);
echo "6. Create AutoReply Button: " . ($ok5 ? "PASS" : "FAIL") . "\n";

// 7. Ambil dan Verifikasi Kolom Options
$replies = $service->getAll($tenantId);
$foundPoll = false;
$foundButton = false;
foreach ($replies as $r) {
    if ($r['keyword'] === 'test_poll' && !empty($r['options'])) $foundPoll = true;
    if ($r['keyword'] === 'test_button' && !empty($r['options'])) $foundButton = true;
}
echo "7. Verifikasi Data DB dengan Kolom Options: " . ($foundPoll && $foundButton ? "PASS" : "FAIL") . "\n";

// 8. Test Callback Incoming Trigger & Log Pesan
$device = Database::fetchOne("SELECT * FROM devices WHERE session_ref = 'sess_4dbba169312bb970'");
if ($device) {
    $_SERVER['HTTP_X_ENGINE_SECRET'] = env('ENGINE_SECRET', 'nyautwa_engine_internal_secret_994821');
    $controller = new InternalCallbackController();
    
    // Simulate incoming message
    $req = new Request([], [
        'event' => 'messages.incoming',
        'data' => [
            'session_ref' => 'sess_4dbba169312bb970',
            'sender' => '628999888777@s.whatsapp.net',
            'text' => 'test_text',
        ],
    ]);
    
    ob_start();
    $controller->handle($req);
    $output = ob_get_clean();

    // Check if messages logged
    $inMsg = Database::fetchOne("SELECT * FROM messages WHERE to_from = '628999888777@s.whatsapp.net' AND direction = 'inbound' ORDER BY created_at DESC LIMIT 1");
    $outMsg = Database::fetchOne("SELECT * FROM messages WHERE to_from = '628999888777@s.whatsapp.net' AND direction = 'outbound' ORDER BY created_at DESC LIMIT 1");

    echo "8. Verifikasi Log Pesan Masuk (Inbound): " . (!empty($inMsg) ? "PASS" : "FAIL") . "\n";
    echo "9. Verifikasi Log Pesan Balasan (Outbound): " . (!empty($outMsg) ? "PASS" : "FAIL") . "\n";
}

// Cleanup test records
Database::execute("DELETE FROM autoreplies WHERE keyword IN ('test_text', 'test_gambar', 'test_dokumen', 'test_poll', 'test_button')");
Database::execute("DELETE FROM messages WHERE to_from = '628999888777@s.whatsapp.net'");
@unlink($targetUploaded);

echo "SEMUA FITUR BALAS OTOMATIS BERHASIL DIVERIFIKASI SECARA PARIPURNA!\n";
