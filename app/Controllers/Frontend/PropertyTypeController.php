<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\PropertyType;
use App\Models\Property;

class PropertyTypeController extends Controller
{
    public function show(string $slug): void
    {
        $type = PropertyType::findBySlug($slug);
        if (!$type) {
            http_response_code(404);
            $this->render('frontend/errors/404', [
                'meta_title' => 'Property Type Not Found | DRL Dwarika Real Estate',
                'message'    => "We could not find the requested property type."
            ]);
            return;
        }

        $properties = Property::search(['type' => $type['id']], 1, 12);
        $allTypes = PropertyType::all('sort_order ASC');

        $this->render('frontend/property-types/show', [
            'type'             => $type,
            'properties'       => $properties['items'],
            'total'            => $properties['total'],
            'allTypes'         => $allTypes,
            'meta_title'       => "Luxury {$type['name']}s for Sale & Rent in Dubai | DRL Dwarika",
            'meta_description' => "Explore premium {$type['name']} listings across Dubai. Find verified properties with DRL Dwarika Real Estate LLC.",
            'activeNav'        => 'properties'
        ]);
    }
}
