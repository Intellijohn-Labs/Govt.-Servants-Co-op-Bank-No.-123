<?php
declare(strict_types=1);

namespace Core;

/**
 * Handles HTTP response status, headers, cookies,
 * view rendering, JSON output, and redirection.
 */
class Response
{
    private int $statusCode = 200;
    private array $headers = [];
    private string $content = '';

    public function __construct(string $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function status(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function html(string $content): self
    {
        $this->content = $content;
        $this->header('Content-Type', 'text/html; charset=UTF-8');
        return $this;
    }

    public function json(mixed $data, int $statusCode = 200): self
    {
        $this->statusCode = $statusCode;
        $this->content = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $this->header('Content-Type', 'application/json; charset=UTF-8');
        return $this;
    }

    public function redirect(string $url, int $statusCode = 302): self
    {
        $this->statusCode = $statusCode;
        $this->header('Location', $url);
        return $this;
    }

    public function view(string $template, array $data = [], ?string $layout = 'main'): self
    {
        $view = new View();
        $this->content = $view->render($template, $data, $layout);
        $this->header('Content-Type', 'text/html; charset=UTF-8');
        return $this;
    }

    public function send(): void
    {
        if (!headers_sent()) {
            http_response_code($this->statusCode);

            // Default security headers
            if (!isset($this->headers['X-Frame-Options'])) {
                $this->headers['X-Frame-Options'] = 'SAMEORIGIN';
            }
            if (!isset($this->headers['X-Content-Type-Options'])) {
                $this->headers['X-Content-Type-Options'] = 'nosniff';
            }
            if (!isset($this->headers['Referrer-Policy'])) {
                $this->headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';
            }
            if (!isset($this->headers['Permissions-Policy'])) {
                $this->headers['Permissions-Policy'] = 'geolocation=(), camera=(), microphone=()';
            }

            foreach ($this->headers as $name => $value) {
                header("{$name}: {$value}", true);
            }
        }

        echo $this->content;
    }
}
