<?php
declare(strict_types=1);

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Database;
use Core\Validator;
use Core\Session;

class ContactController
{
    public function show(Request $request): Response
    {
        $branches = Database::fetchAll(
            "SELECT id, name_en, name_ml FROM branches WHERE client_slug = ? AND status = 'active' ORDER BY is_head_office DESC, sort_order ASC",
            [client_slug()]
        );

        $response = new Response();
        return $response->view('pages/contact', [
            'meta_title' => __('nav_contact'),
            'branches' => $branches,
            'errors' => Session::getFlash('form_errors', []),
        ]);
    }

    public function submit(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'website_hp' => 'honeypot',
            'name' => 'required|min:3|max:120',
            'phone' => 'required|phone',
            'email' => 'required|email|max:150',
            'subject' => 'required|min:3|max:150',
            'message' => 'required|min:10|max:2000',
        ]);

        if ($validator->fails()) {
            Session::set('_old_input', $request->all());
            Session::flash('form_errors', $validator->errors());
            Session::flash('error', $validator->firstError() ?? __('Please check your form inputs.', 'ദയവായി നൽകിയ വിവരങ്ങൾ പരിശോധിക്കുക.'));
            $response = new Response();
            return $response->redirect($request->rawPath());
        }

        $data = $validator->validated();
        $branchId = !empty($request->input('branch_id')) ? (int)$request->input('branch_id') : null;
        $category = $request->input('category', 'general');

        // Generate unique tracking reference: e.g. ENQ-202610-8A3F
        $trackingCode = 'ENQ-' . date('Ym') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 5));

        Database::execute(
            "INSERT INTO enquiries (client_slug, branch_id, tracking_code, name, email, phone, subject, category, message, status, ip_address, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', ?, NOW())",
            [
                client_slug(),
                $branchId,
                $trackingCode,
                $data['name'],
                $data['email'],
                $data['phone'],
                $data['subject'],
                $category,
                $data['message'],
                $request->ip()
            ]
        );

        Session::remove('_old_input');
        $successMsg = is_malayalam()
            ? "നിങ്ങളുടെ സന്ദേശം വിജയകരമായി രജിസ്റ്റർ ചെയ്തു. റഫറൻസ് കോഡ്: {$trackingCode}"
            : "Your enquiry has been successfully registered. Reference code: {$trackingCode}";

        Session::flash('success', $successMsg);

        $response = new Response();
        return $response->redirect($request->rawPath());
    }

    public function feedbackShow(Request $request): Response
    {
        $branches = Database::fetchAll(
            "SELECT id, name_en, name_ml FROM branches WHERE client_slug = ? AND status = 'active' ORDER BY is_head_office DESC, sort_order ASC",
            [client_slug()]
        );

        $response = new Response();
        return $response->view('pages/feedback', [
            'meta_title' => __('Customer Feedback', 'ഉപഭോക്തൃ അഭിപ്രായം'),
            'branches' => $branches,
        ]);
    }

    public function feedbackSubmit(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'website_hp' => 'honeypot',
            'name' => 'required|min:2|max:120',
            'comments' => 'required|min:5|max:2000',
        ]);

        if ($validator->fails()) {
            Session::flash('error', $validator->firstError());
            $response = new Response();
            return $response->redirect($request->rawPath());
        }

        $rating = max(1, min(5, (int)$request->input('rating', 5)));
        $branchId = !empty($request->input('branch_id')) ? (int)$request->input('branch_id') : null;

        Database::execute(
            "INSERT INTO feedback (client_slug, branch_id, name, email, phone, rating, category, comments, status, ip_address, created_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new', ?, NOW())",
            [
                client_slug(),
                $branchId,
                $request->input('name'),
                $request->input('email'),
                $request->input('phone'),
                $rating,
                $request->input('category', 'service'),
                $request->input('comments'),
                $request->ip()
            ]
        );

        Session::flash('success', __('Thank you for your valuable feedback! We appreciate your suggestions.', 'നിങ്ങളുടെ വിലയേറിയ അഭിപ്രായത്തിന് നന്ദി!'));

        $response = new Response();
        return $response->redirect($request->rawPath());
    }

    public function grievanceShow(Request $request): Response
    {
        $response = new Response();
        return $response->view('pages/grievance', [
            'meta_title' => __('nav_grievance'),
        ]);
    }
}
