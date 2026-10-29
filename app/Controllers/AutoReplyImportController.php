<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use App\Services\AutoReplyImportService;

class AutoReplyImportController {
    public function __construct(
        private AuthService $auth = new AuthService(),
        private AutoReplyImportService $importer = new AutoReplyImportService()
    ) {}

    private function requireAuth(): string {
        if (!$this->auth->check()) { Response::redirect('/login'); return ''; }
        return $this->auth->tenantId();
    }

    public function downloadTemplate(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;

        $fmt = strtolower((string) ($request->input('format', 'xlsx')));
        $filename = $fmt === 'csv' ? 'template_autoreply.csv' : 'template_autoreply.xlsx';
        $path = __DIR__ . '/../../public/templates/' . $filename;

        if (!file_exists($path)) {
            require_once __DIR__ . '/../../scripts/generate_template_xlsx.php';
        }

        $ctype = $fmt === 'csv' ? 'text/csv; charset=UTF-8' : 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $ctype);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }

    public function import(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId || !$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi tidak sah atau kedaluwarsa.', '/autoreplies');
            return;
        }

        $file = $_FILES['file'] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            Response::withFlash('error', 'Silakan pilih berkas spreadsheet (Excel .xlsx atau .csv) untuk diunggah.', '/autoreplies');
            return;
        }

        $ext = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        if (!in_array($ext, ['xlsx', 'csv', 'xls'], true)) {
            Response::withFlash('error', 'Format berkas tidak didukung. Harap gunakan format .xlsx atau .csv.', '/autoreplies');
            return;
        }

        $deviceId = $request->input('device_id') ?: null;
        $res = $this->importer->import($tenantId, $deviceId, $file['tmp_name']);

        if (!$res['success']) {
            Response::withFlash('error', $res['message'] ?? 'Gagal memproses data impor.', '/autoreplies');
            return;
        }

        $msg = "Impor selesai! Berhasil menambahkan {$res['imported']} aturan baru dan memperbarui {$res['updated']} aturan.";
        if (!empty($res['errors'])) {
            $msg .= " (Catatan: " . count($res['errors']) . " baris dilewati karena format tidak lengkap).";
        }
        Response::withFlash('success', $msg, '/autoreplies');
    }
}
