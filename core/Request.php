<?php
declare(strict_types=1);

namespace Core;

/**
 * Encapsulates the HTTP Request with sanitization,
 * language prefix resolution, inputs, headers and file handling.
 */
class Request
{
    private string $method;
    private string $path;
    private string $rawPath;
    private ?string $lang = null;
    private array $get;
    private array $post;
    private array $files;
    private array $server;
    private array $headers;

    public function __construct(
        array $get = [],
        array $post = [],
        array $files = [],
        array $server = []
    ) {
        $this->get = $get ?: $_GET;
        $this->post = $post ?: $_POST;
        $this->files = $files ?: $_FILES;
        $this->server = $server ?: $_SERVER;

        $this->method = $this->determineMethod();
        $this->parseUri();
        $this->headers = $this->extractHeaders();
    }

    public static function capture(): self
    {
        return new self($_GET, $_POST, $_FILES, $_SERVER);
    }

    private function determineMethod(): string
    {
        $method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');

        if ($method === 'POST' && isset($this->post['_method'])) {
            $override = strtoupper((string)$this->post['_method']);
            if (in_array($override, ['PUT', 'PATCH', 'DELETE'], true)) {
                return $override;
            }
        }

        return $method;
    }

    private function parseUri(): void
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Remove base path if application is running in a subfolder
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        $baseDir = dirname($scriptName);
        if ($baseDir !== '/' && $baseDir !== '\\' && str_starts_with($path, $baseDir)) {
            $path = substr($path, strlen($baseDir));
        }

        $path = '/' . trim($path, '/');
        $this->rawPath = $path === '' ? '/' : $path;

        // Extract language prefix if present (e.g. /ml or /en)
        $segments = explode('/', trim($this->rawPath, '/'));
        if (!empty($segments[0]) && in_array($segments[0], ['ml', 'en'], true)) {
            $this->lang = $segments[0];
            array_shift($segments);
            $this->path = '/' . implode('/', $segments);
        } else {
            $this->lang = null;
            $this->path = $this->rawPath;
        }

        if ($this->path === '') {
            $this->path = '/';
        }
    }

    private function extractHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', strtolower(substr($key, 5)));
                $headers[$name] = $value;
            } elseif (in_array($key, ['CONTENT_TYPE', 'CONTENT_LENGTH'], true)) {
                $name = str_replace('_', '-', strtolower($key));
                $headers[$name] = $value;
            }
        }
        return $headers;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function isMethod(string $method): bool
    {
        return strtoupper($method) === $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function rawPath(): string
    {
        return $this->rawPath;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $default;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post);
    }

    public function header(string $name, ?string $default = null): ?string
    {
        $name = strtolower($name);
        return $this->headers[$name] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $header = $this->header('authorization');
        if ($header && preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    public function isAjax(): bool
    {
        return strtolower($this->header('x-requested-with', '')) === 'xmlhttprequest'
            || str_contains($this->header('accept', ''), 'application/json');
    }

    public function isSecure(): bool
    {
        return (!empty($this->server['HTTPS']) && $this->server['HTTPS'] !== 'off')
            || ($this->server['SERVER_PORT'] ?? '') == 443
            || strtolower($this->header('x-forwarded-proto', '')) === 'https';
    }

    public function ip(): string
    {
        $forwarded = $this->header('x-forwarded-for');
        if ($forwarded) {
            $parts = explode(',', $forwarded);
            return trim($parts[0]);
        }
        return $this->server['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public function file(string $name): ?array
    {
        if (isset($this->files[$name]) && $this->files[$name]['error'] !== UPLOAD_ERR_NO_FILE) {
            return $this->files[$name];
        }
        return null;
    }
}
