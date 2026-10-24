<?php
require __DIR__ . '/../config/bootstrap.php';
$user = require_login();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { http_response_code(404); exit('Tidak ditemukan.'); }

// Cek KEPEMILIKAN di server (anti IDOR): user lain tidak bisa mengganti ?id=
$st = db()->prepare('SELECT stored_name, original_name, mime FROM files WHERE id = :id AND user_id = :uid');
$st->execute([':id' => $id, ':uid' => $user['id']]);
$file = $st->fetch();

$path = $file ? BASE_PATH . '/storage/uploads/' . $file['stored_name'] : '';
if (!$file || !is_file($path)) { http_response_code(404); exit('Tidak ditemukan.'); }

header('Content-Type: ' . $file['mime']);
header('Content-Length: ' . filesize($path));
header('Content-Disposition: attachment; filename="' . rawurlencode($file['original_name']) . '"');
readfile($path);
