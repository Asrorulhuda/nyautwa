<?php

declare(strict_types=1);

require dirname(__DIR__) . '/bootstrap.php';

use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Csrf;
use App\Controllers\AutoReplyController;
use App\Services\AutoReplyService;

Response::$preventExit = true;

echo "=== Pengujian Komprehensif Alur Auto-Reply ===\n";

try {
    // 1. Setup mock tenant & device
    $tenantId = 'tenant_ar_' . bin2hex(random_bytes(4));
    Database::query("INSERT INTO tenants (id, name, plan_id, status) VALUES (:id, 'Tenant AutoReply Test', 'starter', 'active')", ['id' => $tenantId]);

    $devId = 'dev_ar_' . bin2hex(random_bytes(4));
    Database::query("INSERT INTO devices (id, tenant_id, label, status, session_ref) VALUES (:id, :tid, 'Node CS Utama', 'connected', 'sess_ar_test')", ['id' => $devId, 'tid' => $tenantId]);

    // Setup session
    $_SESSION['tenant_id'] = $tenantId;
    $_SESSION['user_id'] = 'user_test_ar';
    $csrfToken = Csrf::token();

    // 2. Test Controller Create with CSRF & Device
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = [
        '_csrf_token' => $csrfToken,
        'device_id' => $devId,
        'keyword' => 'menu',
        'match_type' => 'contain',
        'type' => 'text',
        'response' => 'Halo! Ini daftar menu dan harga kami.',
        'media_url' => '',
        'delay_seconds' => '2'
    ];
    $_GET = [];

    $controller = new AutoReplyController();
    $request = new Request();
    $controller->create($request);

    assert(isset($_SESSION['flash_success']), 'Flash success harus diset saat tambah aturan berhasil');
    echo "1. Create AutoReply via Controller: PASS\n";

    // 3. Test Service getAll & Verify Device join
    $service = new AutoReplyService();
    $replies = $service->getAll($tenantId);
    assert(count($replies) === 1, 'Harus ada 1 auto-reply tersimpan');
    assert($replies[0]['keyword'] === 'menu', 'Keyword harus sesuai');
    assert($replies[0]['device_label'] === 'Node CS Utama', 'Device label harus ter-join');
    assert($replies[0]['status'] === 'active', 'Status awal harus active');
    $replyId = $replies[0]['id'];
    echo "2. Fetch AutoReply with Device Label: PASS\n";

    // 4. Test Controller Toggle
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_POST = [];
    $controller->toggle(new Request(), $replyId);
    $repliesAfterToggle = $service->getAll($tenantId);
    assert($repliesAfterToggle[0]['status'] === 'inactive', 'Status harus menjadi inactive setelah di-toggle');
    echo "3. Toggle AutoReply Status: PASS\n";

    // 5. Test Controller Delete with CSRF
    $_SERVER['REQUEST_METHOD'] = 'POST';
    $_POST = ['_csrf_token' => $csrfToken];
    $controller->delete(new Request(), $replyId);
    $repliesAfterDelete = $service->getAll($tenantId);
    assert(count($repliesAfterDelete) === 0, 'Auto-reply harus terhapus');
    echo "4. Delete AutoReply with CSRF: PASS\n";

    // Cleanup
    Database::query("DELETE FROM autoreplies WHERE tenant_id = :id", ['id' => $tenantId]);
    Database::query("DELETE FROM devices WHERE tenant_id = :id", ['id' => $tenantId]);
    Database::query("DELETE FROM tenants WHERE id = :id", ['id' => $tenantId]);

    echo "SEMUA PENGUJIAN ALUR AUTO-REPLY BERHASIL 100%!\n";
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}
