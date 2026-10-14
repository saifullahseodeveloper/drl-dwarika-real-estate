<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(): void
    {
        $services = Service::getActive();
        $this->render('frontend/services/index', [
            'meta_title'       => 'Real Estate Services in Dubai | DRL Dwarika Real Estate LLC',
            'meta_description' => 'Comprehensive real estate services in Dubai: Home Buying, Property Selling, Professional Consultancy, and High-Yield Investment Advisory.',
            'services'         => $services,
            'activeNav'        => 'services'
        ]);
    }

    public function show(string $slug): void
    {
        $service = Service::findBySlug($slug);
        if (!$service) {
            http_response_code(404);
            $this->render('frontend/errors/404', [
                'meta_title' => 'Service Not Found | DRL Dwarika Real Estate',
                'message'    => "We could not find the requested service."
            ]);
            return;
        }

        $allServices = Service::getActive();

        $this->render('frontend/services/show', [
            'service'          => $service,
            'allServices'      => $allServices,
            'meta_title'       => ($service['meta_title'] ?: $service['title']) . ' | DRL Dwarika Real Estate',
            'meta_description' => $service['meta_description'] ?: $service['short_desc'],
            'activeNav'        => 'services'
        ]);
    }
}
