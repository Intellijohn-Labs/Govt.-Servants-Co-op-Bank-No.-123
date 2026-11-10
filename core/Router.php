<?php
declare(strict_types=1);

namespace Core;

/**
 * Lightweight, fast Router with regex parameter matching,
 * route groups, middleware pipelines, and named reverse routing.
 */
class Router
{
    private array $routes = [];
    private array $namedRoutes = [];
    private array $groupStack = [];

    public function get(string $path, array|callable $handler, array $middleware = [], ?string $name = null): self
    {
        return $this->addRoute(['GET', 'HEAD'], $path, $handler, $middleware, $name);
    }

    public function post(string $path, array|callable $handler, array $middleware = [], ?string $name = null): self
    {
        return $this->addRoute(['POST'], $path, $handler, $middleware, $name);
    }

    public function match(array $methods, string $path, array|callable $handler, array $middleware = [], ?string $name = null): self
    {
        return $this->addRoute(array_map('strtoupper', $methods), $path, $handler, $middleware, $name);
    }

    public function group(array $attributes, callable $callback): void
    {
        $this->groupStack[] = $attributes;
        $callback($this);
        array_pop($this->groupStack);
    }

    private function addRoute(array $methods, string $path, array|callable $handler, array $middleware = [], ?string $name = null): self
    {
        $prefix = '';
        $groupMiddleware = [];

        foreach ($this->groupStack as $group) {
            if (!empty($group['prefix'])) {
                $prefix .= '/' . trim($group['prefix'], '/');
            }
            if (!empty($group['middleware'])) {
                $groupMiddleware = array_merge($groupMiddleware, (array)$group['middleware']);
            }
        }

        $fullPath = rtrim($prefix, '/') . '/' . ltrim($path, '/');
        if ($fullPath !== '/') {
            $fullPath = rtrim($fullPath, '/');
        }

        $allMiddleware = array_merge($groupMiddleware, $middleware);

        $route = [
            'methods' => $methods,
            'path' => $fullPath,
            'pattern' => $this->compilePattern($fullPath),
            'handler' => $handler,
            'middleware' => $allMiddleware,
            'name' => $name
        ];

        $this->routes[] = $route;

        if ($name) {
            $this->namedRoutes[$name] = $fullPath;
        }

        return $this;
    }

    private function compilePattern(string $path): string
    {
        // Replace {param:regex} or {param} with regex capture groups
        $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)(?::([^\}]+))?\}/', function ($matches) {
            $name = $matches[1];
            $regex = isset($matches[2]) ? $matches[2] : '[^/]+';
            return '(?P<' . $name . '>' . $regex . ')';
        }, $path);

        return '#^' . $pattern . '$#u';
    }

    public function dispatch(Request $request): Response
    {
        $uri = $request->path();
        $method = $request->method();

        foreach ($this->routes as $route) {
            if (!in_array($method, $route['methods'], true)) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Execute middleware pipeline
                return $this->runMiddlewarePipeline($route['middleware'], $request, function ($req) use ($route, $params) {
                    return $this->executeHandler($route['handler'], $req, $params);
                });
            }
        }

        // Check if route exists with different method (405 Method Not Allowed)
        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $uri)) {
                $response = new Response();
                return $response->status(405)->json([
                    'error' => 'Method Not Allowed',
                    'allowed' => $route['methods']
                ]);
            }
        }

        // 404 Not Found
        $response = new Response();
        return $response->status(404)->view('errors/404', [
            'title' => __('404 - Page Not Found', '404 - പേജ് കണ്ടെത്താനായില്ല')
        ]);
    }

    private function runMiddlewarePipeline(array $middlewareList, Request $request, callable $destination): Response
    {
        $pipeline = array_reduce(
            array_reverse($middlewareList),
            function ($next, $middleware) {
                return function ($req) use ($next, $middleware) {
                    if (is_string($middleware)) {
                        $instance = new $middleware();
                        return $instance->handle($req, $next);
                    }
                    if (is_callable($middleware)) {
                        return $middleware($req, $next);
                    }
                    return $next($req);
                };
            },
            $destination
        );

        return $pipeline($request);
    }

    private function executeHandler(array|callable $handler, Request $request, array $params): Response
    {
        if (is_callable($handler)) {
            $result = call_user_func($handler, $request, ...array_values($params));
        } elseif (is_array($handler) && count($handler) === 2) {
            [$controllerClass, $method] = $handler;
            if (!class_exists($controllerClass)) {
                throw new \RuntimeException("Controller {$controllerClass} not found");
            }
            $controller = new $controllerClass();
            if (!method_exists($controller, $method)) {
                throw new \RuntimeException("Method {$method} on {$controllerClass} not found");
            }
            $result = $controller->$method($request, ...array_values($params));
        } else {
            throw new \InvalidArgumentException("Invalid route handler");
        }

        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            $res = new Response();
            return $res->html($result);
        }

        if (is_array($result)) {
            $res = new Response();
            return $res->json($result);
        }

        return new Response();
    }

    public function url(string $name, array $params = [], string $lang = ''): string
    {
        if (!isset($this->namedRoutes[$name])) {
            return '/' . ($lang ? $lang . '/' : '') . ltrim($name, '/');
        }

        $path = $this->namedRoutes[$name];
        foreach ($params as $key => $value) {
            $path = str_replace('{' . $key . '}', (string)$value, $path);
        }

        // Clean any unreplaced patterns
        $path = preg_replace('/\{[a-zA-Z0-9_]+\}/', '', $path);

        if ($lang && $lang !== 'en') {
            return '/' . $lang . ($path === '/' ? '' : $path);
        }

        return $path;
    }
}
