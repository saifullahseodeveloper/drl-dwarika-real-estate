<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Location;

class ContentController extends Controller
{
    public function services(): void
    {
        $services = Service::all('sort_order ASC');
        $this->render('admin/services/index', [
            'meta_title' => 'Manage Services | DRL Dwarika Admin',
            'services'   => $services,
            'activeNav'  => 'services'
        ], 'layouts/admin');
    }

    public function testimonials(): void
    {
        $testimonials = Testimonial::all('sort_order ASC');
        $this->render('admin/testimonials/index', [
            'meta_title'   => 'Manage Testimonials | DRL Dwarika Admin',
            'testimonials' => $testimonials,
            'activeNav'    => 'testimonials'
        ], 'layouts/admin');
    }

    public function locations(): void
    {
        $locations = Location::all('name ASC');
        $this->render('admin/locations/index', [
            'meta_title' => 'Manage Locations | DRL Dwarika Admin',
            'locations'  => $locations,
            'activeNav'  => 'locations'
        ], 'layouts/admin');
    }
}
