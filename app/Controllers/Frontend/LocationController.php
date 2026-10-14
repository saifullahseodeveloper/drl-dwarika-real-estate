<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Location;
use App\Models\Property;

class LocationController extends Controller
{
    public function show(string $slug): void
    {
        $location = Location::findBySlug($slug);
        if (!$location) {
            http_response_code(404);
            $this->render('frontend/errors/404', [
                'meta_title' => 'Location Not Found | DRL Dwarika Real Estate',
                'message'    => "We could not find the requested location community."
            ]);
            return;
        }

        $properties = Property::search(['location' => $location['id']], 1, 12);
        $allLocations = Location::all('name ASC');

        $this->render('frontend/locations/show', [
            'location'         => $location,
            'properties'       => $properties['items'],
            'total'            => $properties['total'],
            'allLocations'     => $allLocations,
            'meta_title'       => ($location['meta_title'] ?: "Properties for Sale & Rent in {$location['name']}") . ' | DRL Dwarika',
            'meta_description' => $location['meta_description'] ?: $location['description'],
            'activeNav'        => 'locations'
        ]);
    }
}
