<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\ContactService;
use App\Services\DeviceService;

class ContactController {
    private AuthService $auth;
    private ContactService $service;
    private DeviceService $devices;

    public function __construct() {
        $this->auth = new AuthService();
        $this->service = new ContactService();
        $this->devices = new DeviceService();
    }

    private function requireAuth(): string {
        if (!$this->auth->check()) Response::redirect('/login');
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tid = $this->requireAuth();
        $tagId = $request->input('tag');
        View::render('contacts/index', [
            'title' => 'Buku Kontak (Phonebook)',
            'contacts' => $this->service->getContacts($tid, $tagId ?: null),
            'tags' => $this->service->getTags($tid),
            'devices' => $this->devices->getDevices($tid),
            'activeTag' => $tagId,
        ], 'app');
    }

    public function create(Request $request): void {
        $tid = $this->requireAuth();
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi kedaluwarsa.', '/contacts');
        $name = trim((string) $request->input('name', ''));
        $phone = trim((string) $request->input('phone', ''));
        if (empty($name) || empty($phone)) Response::withFlash('error', 'Nama dan nomor telepon wajib diisi.', '/contacts');

        $this->service->createContact($tid, [
            'name' => $name, 'phone' => $phone, 'email' => $request->input('email'),
            'notes' => $request->input('notes'), 'tag_id' => $request->input('tag_id'),
        ]);
        Response::withFlash('success', "Kontak '{$name}' berhasil disimpan.", '/contacts');
    }

    public function sync(Request $request): void {
        $tid = $this->requireAuth();
        if (!$request->validateCsrf()) Response::withFlash('error', 'Sesi kedaluwarsa.', '/contacts');
        $deviceId = (string) $request->input('device_id', '');
        if (empty($deviceId)) Response::withFlash('error', 'Pilih perangkat WhatsApp pengirim.', '/contacts');

        $res = $this->service->syncFromDevice($tid, $deviceId);
        if (!empty($res['success'])) {
            $msg = "Sinkronisasi berhasil! {$res['total']} kontak ditarik ({$res['personal']} nomor kontak, {$res['groups']} grup WhatsApp).";
            Response::withFlash('success', $msg, '/contacts');
        } else {
            Response::withFlash('error', $res['error'] ?? 'Gagal menyinkronkan kontak dari perangkat.', '/contacts');
        }
    }

    public function createTag(Request $request): void {
        $tid = $this->requireAuth();
        if ($request->validateCsrf()) {
            $name = trim((string) $request->input('name', ''));
            if (!empty($name)) {
                $this->service->createTag($tid, $name, (string) $request->input('color', '#16A36A'));
                Response::withFlash('success', "Tag '{$name}' berhasil dibuat.", '/contacts');
            }
        }
        Response::redirect('/contacts');
    }

    public function delete(Request $request, ?string $id = null): void {
        $tid = $this->requireAuth();
        $id = $id ?? (string) $request->input('id', '');
        if ($request->validateCsrf() && !empty($id)) {
            $this->service->deleteContact($id, $tid);
            Response::withFlash('success', 'Kontak berhasil dihapus.', '/contacts');
        }
        Response::redirect('/contacts');
    }
}
