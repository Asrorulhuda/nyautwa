<?php

declare(strict_types=1);

namespace App\Services;

class AutoReplyMediaService {
    public const IMAGE_EXTS = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    public const DOC_EXTS = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', 'txt', 'csv'];

    public static function upload(?array $file, string $type): ?array {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $origName = basename((string) ($file['name'] ?? 'file'));
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
        $allowed = ($type === 'image') ? self::IMAGE_EXTS : self::DOC_EXTS;

        if (!in_array($ext, $allowed, true)) {
            throw new \InvalidArgumentException("Format file .{$ext} tidak didukung untuk tipe {$type}.");
        }

        $uploadDir = dirname(__DIR__, 2) . '/public/uploads/autoreplies';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $safeName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $destPath = $uploadDir . '/' . $safeName;

        if (!move_uploaded_file((string) $file['tmp_name'], $destPath)) {
            throw new \RuntimeException('Gagal memindahkan file yang diunggah ke server.');
        }

        $httpHost = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $fullUrl = $protocol . $httpHost . url('/uploads/autoreplies/' . $safeName);

        return [
            'url' => $fullUrl,
            'filename' => $origName,
            'mimetype' => (string) ($file['type'] ?? 'application/octet-stream'),
            'path' => $destPath,
        ];
    }
}
