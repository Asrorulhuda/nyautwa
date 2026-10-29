<?php

declare(strict_types=1);

namespace App\Services;

class LogoUploadService {
    public static function handle(?array $file): ?string {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedExts = ['png', 'jpg', 'jpeg', 'webp', 'svg'];
        $ext = strtolower(pathinfo((string) ($file['name'] ?? ''), PATHINFO_EXTENSION));
        $size = (int) ($file['size'] ?? 0);

        if (!in_array($ext, $allowedExts, true) || $size > 2 * 1024 * 1024) {
            return null;
        }

        $uploadDir = dirname(__DIR__, 2) . '/public/uploads/logos';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $filename = 'logo_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $targetPath = $uploadDir . '/' . $filename;

        if (move_uploaded_file((string) $file['tmp_name'], $targetPath)) {
            return '/uploads/logos/' . $filename;
        }

        return null;
    }
}
