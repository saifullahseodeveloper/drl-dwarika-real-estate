<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Lead;

class DashboardController extends Controller
{
    public function index(): void
    {
        $totalProps = Property::count();
        $publishedProps = Property::count("status = 'published'");
        $draftProps = Property::count("status = 'draft'");
        $soldProps = Property::count("status = 'sold'");
        $totalLeads = Lead::count();
        $newLeads = Lead::count("status = 'new'");

        $recentLeads = Lead::getRecentWithDetails(5);
        $recentProps = Property::search([], 1, 5, 'newest');

        $this->render('admin/dashboard/index', [
            'meta_title'     => 'Dashboard | DRL Dwarika Admin',
            'totalProps'     => $totalProps,
            'publishedProps' => $publishedProps,
            'draftProps'     => $draftProps,
            'soldProps'      => $soldProps,
            'totalLeads'     => $totalLeads,
            'newLeads'       => $newLeads,
            'recentLeads'    => $recentLeads,
            'recentProps'    => $recentProps['items'],
            'activeNav'      => 'dashboard'
        ], 'layouts/admin');
    }
}
