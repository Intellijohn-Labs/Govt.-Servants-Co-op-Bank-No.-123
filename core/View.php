<?php
declare(strict_types=1);

namespace Core;

/**
 * Native PHP View engine supporting layouts, partials,
 * section blocks/stacks, and automatic variable sharing.
 */
class View
{
    private string $viewsPath;
    private array $stacks = [];
    private string $currentStack = '';
    private static array $shared = [];

    public function __construct()
    {
        $this->viewsPath = dirname(__DIR__) . '/app/Views';
    }

    public static function share(string|array $key, mixed $value = null): void
    {
        if (is_array($key)) {
            self::$shared = array_merge(self::$shared, $key);
        } else {
            self::$shared[$key] = $value;
        }
    }

    public static function getShared(): array
    {
        return self::$shared;
    }

    public function render(string $template, array $data = [], ?string $layout = 'main'): string
    {
        $viewFile = $this->resolvePath($template);

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View template not found: {$template} ({$viewFile})");
        }

        $allData = array_merge(self::$shared, $data);
        extract($allData, EXTR_SKIP);

        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if ($layout === null) {
            return $content;
        }

        $layoutFile = $this->viewsPath . '/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new \RuntimeException("Layout not found: {$layoutFile}");
        }

        // Layout has access to all view data plus the rendered $content
        ob_start();
        include $layoutFile;
        return ob_get_clean();
    }

    public function partial(string $name, array $data = []): string
    {
        $partialFile = $this->viewsPath . '/partials/' . $name . '.php';

        if (!file_exists($partialFile)) {
            // Check if full path provided
            $alt = $this->resolvePath($name);
            if (file_exists($alt)) {
                $partialFile = $alt;
            } else {
                return "<!-- Partial not found: {$name} -->";
            }
        }

        $allData = array_merge(self::$shared, $data);
        extract($allData, EXTR_SKIP);

        ob_start();
        include $partialFile;
        return ob_get_clean();
    }

    private function resolvePath(string $template): string
    {
        if (str_starts_with($template, '/')) {
            return $template . '.php';
        }
        return $this->viewsPath . '/' . ltrim($template, '/') . '.php';
    }

    public function push(string $stack): void
    {
        $this->currentStack = $stack;
        ob_start();
    }

    public function endPush(): void
    {
        if ($this->currentStack === '') {
            return;
        }
        $content = ob_get_clean();
        $this->stacks[$this->currentStack][] = $content;
        $this->currentStack = '';
    }

    public function renderStack(string $stack): string
    {
        if (empty($this->stacks[$stack])) {
            return '';
        }
        return implode("\n", $this->stacks[$stack]);
    }
}
