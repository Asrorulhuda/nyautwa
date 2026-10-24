<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\AuthService;
use App\Services\ContactService;

class ContactController {
    private AuthService $auth;
    private ContactService $service;

    public function __construct() {
        $this->auth = new AuthService();
        $this->service = new ContactService();
    }

    private function requireAuth(): string {
        if (!$this->auth->check()) {
            Response::redirect('/login');
            return '';
        }
        return $this->auth->tenantId();
    }

    public function index(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        $tagId = $request->input('tag');
        View::render('contacts/index', [
            'title' => 'Buku Kontak (Phonebook)',
            'contacts' => $this->service->getContacts($tenantId, $tagId ?: null),
            'tags' => $this->service->getTags($tenantId),
            'activeTag' => $tagId,
        ], 'app');
    }

    public function create(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi kedaluwarsa.', '/contacts');
            return;
        }

        $name = trim((string) $request->input('name', ''));
        $phone = trim((string) $request->input('phone', ''));
        if (empty($name) || empty($phone)) {
            Response::withFlash('error', 'Nama dan nomor telepon wajib diisi.', '/contacts');
            return;
        }

        $this->service->createContact($tenantId, [
            'name' => $name,
            'phone' => $phone,
            'email' => $request->input('email'),
            'notes' => $request->input('notes'),
            'tag_id' => $request->input('tag_id'),
        ]);

        Response::withFlash('success', "Kontak '{$name}' berhasil disimpan.", '/contacts');
    }

    public function createTag(Request $request): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if ($request->validateCsrf()) {
            $name = trim((string) $request->input('name', ''));
            $color = (string) $request->input('color', '#16A36A');
            if (!empty($name)) {
                $this->service->createTag($tenantId, $name, $color);
                Response::withFlash('success', "Tag '{$name}' berhasil dibuat.", '/contacts');
                return;
            }
        }
        Response::redirect('/contacts');
    }

    public function delete(Request $request, string $id): void {
        $tenantId = $this->requireAuth();
        if (!$tenantId) return;
        if ($request->validateCsrf()) {
            $this->service->deleteContact($id, $tenantId);
            Response::withFlash('success', 'Kontak berhasil dihapus.', '/contacts');
            return;
        }
        Response::redirect('/contacts');
    }
}
