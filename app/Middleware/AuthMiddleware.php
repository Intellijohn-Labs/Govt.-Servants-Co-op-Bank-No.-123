<?php
declare(strict_types=1);

namespace App\Middleware;

use Core\Auth;
use Core\Request;
use Core\Response;
use Core\Session;

class AuthMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (!Auth::check()) {
            Session::flash('error', __('Please login to access this page.', 'ഈ പേജ് ആക്സസ് ചെയ്യാൻ ദയവായി ലോഗിൻ ചെയ്യുക.'));
            $response = new Response();
            return $response->redirect('/admin/login');
        }

        return $next($request);
    }
}
