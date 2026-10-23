<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class View {
    public static function render(string $view, array $data = [], ?string $layout = 'app'): void {
        $viewPath = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $view) . '.php';

        if (!file_exists($viewPath)) {
            throw new RuntimeException("View file tidak ditemukan: $viewPath");
        }

        // Extract variables for view
        extract($data, EXTR_SKIP);

        // Flash message helpers
        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        $flashWarning = $_SESSION['flash_warning'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error'], $_SESSION['flash_warning']);

        $old = $_SESSION['old_inputs'] ?? [];
        unset($_SESSION['old_inputs']);

        // Start capturing view output
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if ($layout === null) {
            echo $content;
            return;
        }

        $layoutPath = dirname(__DIR__) . '/Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutPath)) {
            throw new RuntimeException("Layout file tidak ditemukan: $layoutPath");
        }

        require $layoutPath;
    }

    public static function partial(string $partial, array $data = []): void {
        $partialPath = dirname(__DIR__) . '/Views/' . str_replace('.', '/', $partial) . '.php';
        if (file_exists($partialPath)) {
            extract($data, EXTR_SKIP);
            require $partialPath;
        }
    }

    public static function e(mixed $value): string {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
    }

    public static function old(string $key, mixed $default = ''): mixed {
        return $_SESSION['old_inputs'][$key] ?? $default;
    }
}
