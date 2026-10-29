<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;

class LegalController {
    private function getSettings(): array {
        return (new \App\Services\LandingSettingsService())->getAll();
    }

    public function terms(Request $request): void {
        View::render('pages/legal/terms', [
            'title' => 'Syarat & Ketentuan Layanan — NyautWa',
            'settings' => $this->getSettings(),
        ], 'landing');
    }

    public function privacy(Request $request): void {
        View::render('pages/legal/privacy', [
            'title' => 'Kebijakan Privasi & Keamanan Data — NyautWa',
            'settings' => $this->getSettings(),
        ], 'landing');
    }

    public function sla(Request $request): void {
        View::render('pages/legal/sla', [
            'title' => 'Jaminan Layanan (SLA) & Uptime 99.9% — NyautWa',
            'settings' => $this->getSettings(),
        ], 'landing');
    }

    public function contact(Request $request): void {
        View::render('pages/legal/contact', [
            'title' => 'Hubungi Support & Layanan Bantuan — NyautWa',
            'settings' => $this->getSettings(),
        ], 'landing');
    }

    public function submitContact(Request $request): void {
        if (!$request->validateCsrf()) {
            Response::withFlash('error', 'Sesi form Anda telah kedaluwarsa. Silakan muat ulang halaman.', '/contact');
            return;
        }

        $name = trim((string) $request->input('name', ''));
        $email = trim((string) $request->input('email', ''));
        $subject = trim((string) $request->input('subject', ''));
        $message = trim((string) $request->input('message', ''));

        if (empty($name) || empty($email) || empty($message)) {
            Response::withFlash('error', 'Nama, email, dan pesan wajib diisi.', '/contact', [
                'name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message
            ]);
            return;
        }

        Response::withFlash(
            'success',
            'Terima kasih! Pesan dan tiket konsultasi Anda berhasil dikirim ke tim support NyautWa. Tim kami akan menghubungi Anda dalam waktu 1x24 jam kerja.',
            '/contact'
        );
    }
}
