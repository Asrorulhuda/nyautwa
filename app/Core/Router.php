<?php

declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes = [];
    private array $groupMiddleware = [];

    public function get(string $path, array|callable $handler, array $middleware = []): self {
        return $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array|callable $handler, array $middleware = []): self {
        return $this->add('POST', $path, $handler, $middleware);
    }

    public function put(string $path, array|callable $handler, array $middleware = []): self {
        return $this->add('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, array|callable $handler, array $middleware = []): self {
        return $this->add('DELETE', $path, $handler, $middleware);
    }

    public function group(array $attributes, callable $callback): void {
        $previousGroupMiddleware = $this->groupMiddleware;
        if (isset($attributes['middleware'])) {
            $middlewares = (array) $attributes['middleware'];
            $this->groupMiddleware = array_merge($this->groupMiddleware, $middlewares);
        }

        $callback($this);

        $this->groupMiddleware = $previousGroupMiddleware;
    }

    private function add(string $method, string $path, array|callable $handler, array $middleware = []): self {
        $allMiddleware = array_merge($this->groupMiddleware, $middleware);
        $regex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $regex = '#^' . $regex . '$#';

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'regex' => $regex,
            'handler' => $handler,
            'middleware' => $allMiddleware,
        ];
        return $this;
    }

    public function dispatch(Request $request): void {
        $method = $request->getMethod();
        $path = $request->getPath();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run middlewares
                foreach ($route['middleware'] as $mw) {
                    $mwInstance = is_string($mw) ? new $mw() : $mw;
                    $result = $mwInstance->handle($request);
                    if ($result === false) {
                        return; // Stopped by middleware
                    }
                }

                $handler = $route['handler'];
                if (is_callable($handler)) {
                    call_user_func($handler, $request, ...array_values($params));
                    return;
                }

                if (is_array($handler) && count($handler) === 2) {
                    [$class, $action] = $handler;
                    $controller = new $class();
                    $controller->$action($request, ...array_values($params));
                    return;
                }
            }
        }

        // 404 handler
        if ($request->isJson() || str_starts_with($path, '/api/')) {
            Response::json(['error' => 'Endpoint tidak ditemukan', 'path' => $path], 404);
        } else {
            http_response_code(404);
            View::render('errors/404', ['path' => $path], 'auth');
        }
    }
}
