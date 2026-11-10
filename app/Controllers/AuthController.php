<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Auth;
use Core\Session;

class AuthController
{
    public function showLogin(Request $request): Response
    {
        if (Auth::check()) {
            $response = new Response();
            return $response->redirect('/admin');
        }

        $response = new Response();
        return $response->view('auth/login', [
            'meta_title' => __('Administrative Login', 'അഡ്മിൻ ലോഗിൻ'),
        ], 'main');
    }

    public function login(Request $request): Response
    {
        $username = trim((string)$request->input('username', ''));
        $password = (string)$request->input('password', '');

        if ($username === '' || $password === '') {
            Session::flash('error', __('Please enter both username/email and password.', 'യൂസർനെയിമും പാസ്‌വേഡും നൽകുക.'));
            $response = new Response();
            return $response->redirect('/admin/login');
        }

        if (Auth::attempt($username, $password)) {
            Session::flash('success', __('Welcome to the Administration Control Panel.', 'അഡ്മിനിസ്ട്രേഷൻ പാനലിലേക്ക് സ്വാഗതം.'));
            $response = new Response();
            return $response->redirect('/admin');
        }

        if (!Session::hasFlash('error')) {
            Session::flash('error', __('Invalid credentials. Please verify your username and password.', 'തെറ്റായ വിവരങ്ങൾ. ദയവായി പരിശോധിക്കുക.'));
        }

        $response = new Response();
        return $response->redirect('/admin/login');
    }

    public function logout(Request $request): Response
    {
        Auth::logout();
        Session::flash('success', __('You have been successfully logged out.', 'നിങ്ങൾ വിജയകരമായി ലോഗൗട്ട് ചെയ്തു.'));
        $response = new Response();
        return $response->redirect('/admin/login');
    }
}
