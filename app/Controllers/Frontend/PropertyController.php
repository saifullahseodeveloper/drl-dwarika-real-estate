<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Location;
use App\Models\PropertyType;

class PropertyController extends Controller
{
    public function index(): void
    {
        $this->filterListings([], 'All Properties for Sale & Rent in Dubai | DRL Dwarika', 'properties');
    }

    public function buy(): void
    {
        $this->filterListings(['listing_type' => 'sale'], 'Properties for Sale in Dubai | DRL Dwarika Real Estate', 'buy');
    }

    public function rent(): void
    {
        $this->filterListings(['listing_type' => 'rent'], 'Properties for Rent in Dubai | DRL Dwarika Real Estate', 'rent');
    }

    public function offPlan(): void
    {
        $this->filterListings(['listing_type' => 'off-plan'], 'Off-Plan Projects in Dubai | High Capital Growth | DRL Dwarika', 'off-plan');
    }

    public function commercial(): void
    {
        $this->filterListings(['listing_type' => 'commercial'], 'Commercial Properties & Offices in Dubai | DRL Dwarika', 'commercial');
    }

    private function filterListings(array $presetFilters, string $pageTitle, string $activeNav): void
    {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $filters = array_merge($presetFilters, [
            'location'     => $_GET['location'] ?? '',
            'type'         => $_GET['type'] ?? '',
            'listing_type' => $presetFilters['listing_type'] ?? ($_GET['listing_type'] ?? ''),
            'bedrooms'     => $_GET['bedrooms'] ?? '',
            'min_price'    => $_GET['min_price'] ?? '',
            'max_price'    => $_GET['max_price'] ?? '',
            'keyword'      => $_GET['q'] ?? '',
        ]);
        $sort = $_GET['sort'] ?? 'newest';

        $results = Property::search($filters, $page, 9, $sort);
        $locations = Location::all('name ASC');
        $propertyTypes = PropertyType::all('sort_order ASC');

        $this->render('frontend/properties/index', [
            'meta_title'       => $pageTitle . ' | DRL Dwarika',
            'meta_description' => 'Browse verified luxury listings in Dubai. Filter by location, budget, bedrooms, and property type with DRL Dwarika Real Estate LLC.',
            'properties'       => $results['items'],
            'total'            => $results['total'],
            'currentPage'      => $results['page'],
            'totalPages'       => $results['total_pages'],
            'locations'        => $locations,
            'propertyTypes'    => $propertyTypes,
            'filters'          => $filters,
            'currentSort'      => $sort,
            'pageTitle'        => $pageTitle,
            'activeNav'        => $activeNav
        ]);
    }

    public function show(string $slug): void
    {
        $property = Property::findWithDetails($slug);
        if (!$property) {
            http_response_code(404);
            $this->render('frontend/errors/404', [
                'meta_title' => 'Property Not Found | DRL Dwarika Real Estate',
                'message'    => "We could not find the property listing you were looking for."
            ]);
            return;
        }

        $similar = Property::getSimilar(
            (int)$property['id'],
            (int)$property['location_id'],
            (int)$property['property_type_id'],
            3
        );

        $this->render('frontend/properties/show', [
            'property'         => $property,
            'similar'          => $similar,
            'meta_title'       => ($property['meta_title'] ?: $property['title']) . ' | DRL Dwarika Real Estate',
            'meta_description' => $property['meta_description'] ?: substr(strip_tags($property['description']), 0, 160),
            'featured_image'   => $property['featured_image'],
            'activeNav'        => 'properties'
        ]);
    }
}
