<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;

class SeoController extends Controller
{
    public function index(): void
    {
        $this->render('admin/seo/index', [
            'meta_title' => 'Technical SEO & Metadata Management | DRL Dwarika Admin',
            'activeNav'  => 'seo'
        ], 'layouts/admin');
    }
}
