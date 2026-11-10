<?php
declare(strict_types=1);

namespace App\Middleware;

use Core\Auth;
use Core\Request;
use Core\Response;
use Core\Session;

class RoleMiddleware
{
    private array $allowedRoles;

    public function __construct(string|array $roles = ['super_admin', 'admin'])
    {
        $this->allowedRoles = (array)$roles;
    }

    public function handle(Request $request, callable $next): Response
    {
        if (!Auth::check()) {
            $response = new Response();
            return $response->redirect('/admin/login');
        }

        if (!Auth::hasRole($this->allowedRoles)) {
            Session::flash('error', __('You do not have permission to access this resource.', 'ഈ വിവരങ്ങൾ കാണാനുള്ള അനുമതി നിങ്ങൾക്കില്ല.'));
            $response = new Response();
            return $response->status(403)->view('errors/403', [
                'title' => __('403 - Forbidden', '403 - പ്രവേശന അനുമതിയില്ല')
            ], 'admin');
        }

        return $next($request);
    }
}
