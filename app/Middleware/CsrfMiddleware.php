<?php
declare(strict_types=1);

namespace App\Middleware;

use Core\Csrf;
use Core\Request;
use Core\Response;
use Core\Session;

class CsrfMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            if (!Csrf::validate($request)) {
                if ($request->isAjax()) {
                    $response = new Response();
                    return $response->status(419)->json([
                        'success' => false,
                        'message' => __('Your session has expired. Please refresh the page and try again.', 'സെഷൻ കാലഹരണപ്പെട്ടു. ദയവായി പേജ് റീഫ്രഷ് ചെയ്യുക.')
                    ]);
                }

                Session::flash('error', __('Security token mismatch or expired session. Please try again.', 'സുരക്ഷാ ടോക്കൺ പൊരുത്തക്കേട്. ദയവായി വീണ്ടും ശ്രമിക്കുക.'));
                $response = new Response();
                return $response->redirect($request->rawPath());
            }
        }

        return $next($request);
    }
}
