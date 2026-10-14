<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\Service;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index(): void
    {
        $featuredProperties = Property::getFeatured(6);
        $locations = Location::all('name ASC');
        $propertyTypes = PropertyType::all('sort_order ASC');
        $services = Service::getActive();
        $testimonials = Testimonial::getFeatured();

        $this->render('frontend/home', [
            'meta_title'       => 'DRL Dwarika Real Estate LLC | Opening Doors To Prosperity | Dubai Real Estate',
            'meta_description' => 'Find your dream luxury home in Dubai with DRL Dwarika Real Estate LLC. Explore exclusive villas in Dubai Hills, Downtown apartments, and JVC townhouses.',
            'canonical_url'    => 'https://dwarikarealestate.ae/',
            'featuredProperties' => $featuredProperties,
            'locations'        => $locations,
            'propertyTypes'    => $propertyTypes,
            'services'         => $services,
            'testimonials'     => $testimonials,
            'activeNav'        => 'home'
        ]);
    }
}
