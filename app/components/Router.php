<?php

namespace App\Components;

class Router
{
    private string $defaultHomePage;
    private string $defaultMethod;

    public function __construct()
    {
        $this->defaultHomePage = $_ENV['DEFAULT_PAGE'] ?? 'home';
        $this->defaultMethod = $_ENV['DEFAULT_METHOD'] ?? 'get';
    }

    public function run(): void
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $httpMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $params = $this->extractParams($requestUri);

        $page = $params['page'] ?? $this->defaultHomePage;

        // URL can optionally provide a controller method (e.g. /page/method).
        // If not provided, we'll call the controller method matching the HTTP verb (e.g. get/post).
        $action = $params['method'] ?? '';

        $id = $params['id'] ?? null;

        $this->handlePage($page, $action, $id, $httpMethod, $params);
    }

    private function handlePage(string $page, string $action, $id, string $httpMethod, array $params): void
    {
        $publicPathController = dirname(__DIR__) . "/endpoints/public/pages/$page/Controller.php";
        $privatePathController = dirname(__DIR__) . "/endpoints/private/pages/$page/Controller.php";

        $isAdmin = (($params['admin'] ?? null) === 'admin');

        if ($isAdmin) {
            $templatePath = dirname(__DIR__) . "/endpoints/private/template/index.php";
            $controllerPath = $privatePathController;
            $isSecured = true;
        } else {
            $templatePath = dirname(__DIR__) . "/endpoints/public/template/index.php";
            $controllerPath = $publicPathController;
            $isSecured = false;
        }

        if ($isSecured && !$this->isAuthenticated()) {
            $next = $_SERVER['REQUEST_URI'] ?? '/admin/posts';
            header('Location: /login?next=' . rawurlencode($next));
            return;
        }

        $this->invokeController($controllerPath, $action, $id, strtolower($httpMethod), $templatePath);
    }

    private function invokeController(string $controllerPath, string $action, $id, string $method, string $templatePath): void
    {
        if (!file_exists($controllerPath)) {
            http_response_code(404);
            include_once dirname(__DIR__) . "/endpoints/public/pages/404/index.php";
            return;
        }

        include_once $controllerPath;

        if (!class_exists('Controller')) {
            http_response_code(500);
            echo '500 Internal Server Error: Controller class not found.';
            return;
        }

        $controller = new \Controller();

        // If a method isn't provided, fall back to the HTTP method.
        $call = $action ?: $method;

        if (method_exists($controller, $call)) {
            $controller->{$call}($id, $method, $templatePath);
            return;
        }

        http_response_code(404);
        echo '404 Action Not Found';
    }

    private function extractParams(string $requestUri): array
    {
        $parts = explode('/', trim($requestUri, '/'));

        if (($parts[0] ?? '') === 'admin') {
            if (empty($parts[1])) {
                $parts[1] = $this->defaultHomePage;
            }

            return [
                'page' => $parts[1] ?? null,
                'method' => $parts[2] ?? null,
                'id' => $parts[3] ?? null,
                'admin' => $parts[0] ?? null,
            ];
        }

        if (empty($parts[0])) {
            $parts[0] = $this->defaultHomePage;
        }

        return [
            'page' => $parts[0] ?? null,
            'method' => $parts[1] ?? null,
            'id' => $parts[2] ?? null,
            'admin' => $parts[3] ?? null,
        ];
    }

    private function isAuthenticated(): bool
    {
        return isset($_SESSION['user']);
    }
}
