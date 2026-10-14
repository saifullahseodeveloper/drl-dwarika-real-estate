<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;
use App\Models\Lead;

class LeadController extends Controller
{
    public function index(): void
    {
        $status = $_GET['status'] ?? null;
        $leads = Lead::getRecentWithDetails(50, $status);

        $this->render('admin/leads/index', [
            'meta_title' => 'Customer Inquiries & Leads | DRL Dwarika Admin',
            'leads'      => $leads,
            'status'     => $status,
            'activeNav'  => 'leads'
        ], 'layouts/admin');
    }

    public function updateStatus(string $id): void
    {
        $this->validateCsrf();
        $status = $_POST['status'] ?? 'new';
        $notes = trim($_POST['admin_notes'] ?? '');

        Lead::updateStatus((int)$id, $status, $notes);
        Session::flash('success', "Lead status updated to {$status}.");
        $this->redirect('/admin/leads');
    }
}
