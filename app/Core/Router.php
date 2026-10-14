<?php
declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function get(string $path, string|callable $handler, array $middlewares = []): self
    {
        return $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, string|callable $handler, array $middlewares = []): self
    {
        return $this->addRoute('POST', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, string|callable $handler, array $middlewares = []): self
    {
        $this->routes[] = [
            'method'      => $method,
            'path'        => '/' . trim($path, '/'),
            'handler'     => $handler,
            'middlewares' => $middlewares
        ];
        return $this;
    }

    public function dispatch(string $method, string $uri): void
    {
        $parsedUri = parse_url($uri, PHP_URL_PATH);
        $cleanUri = '/' . trim($parsedUri, '/');
        if ($cleanUri === '//') {
            $cleanUri = '/';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            // Convert route pattern {slug} to regex
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $cleanUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Execute route middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $this->runMiddleware($middleware);
                }

                // Execute handler
                if (is_callable($route['handler'])) {
                    call_user_func_array($route['handler'], $params);
                    return;
                }

                if (is_string($route['handler']) && str_contains($route['handler'], '@')) {
                    [$controllerName, $action] = explode('@', $route['handler']);
                    $controllerClass = "App\\Controllers\\" . $controllerName;
                    if (!class_exists($controllerClass)) {
                        $this->render404("Controller {$controllerClass} not found");
                        return;
                    }
                    $controllerInstance = new $controllerClass();
                    if (!method_exists($controllerInstance, $action)) {
                        $this->render404("Action {$action} not found on controller {$controllerClass}");
                        return;
                    }
                    call_user_func_array([$controllerInstance, $action], $params);
                    return;
                }
            }
        }

        $this->render404("Route {$method} {$cleanUri} not found");
    }

    private function runMiddleware(string $middleware): void
    {
        if ($middleware === 'auth') {
            Session::start();
            if (!Session::has('admin_user')) {
                header('Location: /admin/login');
                exit;
            }
        }
    }

    private function render404(string $message = 'Page Not Found'): void
    {
        http_response_code(404);
        try {
            echo View::render('frontend/errors/404', [
                'meta_title' => '404 - Page Not Found | DRL Dwarika Real Estate LLC',
                'message'    => $message
            ], 'layouts/main');
        } catch (\Throwable $e) {
            echo "<h1>404 - Page Not Found</h1><p>" . htmlspecialchars($message) . "</p>";
        }
    }
}
