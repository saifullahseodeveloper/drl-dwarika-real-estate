<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;

class ToolsController extends Controller
{
    public function index(): void
    {
        $this->render('admin/tools/index', [
            'meta_title' => 'Growth Tools & Calculators | DRL Dwarika Admin',
            'activeNav' => 'tools'
        ], 'layouts/admin');
    }
}
