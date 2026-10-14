<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Testimonial;
use App\Models\Service;

class PageController extends Controller
{
    public function about(): void
    {
        $services = Service::getActive();
        $this->render('frontend/pages/about', [
            'meta_title'       => 'About Us | DRL Dwarika Real Estate LLC | Dubai Real Estate',
            'meta_description' => 'Learn about DRL Dwarika Real Estate LLC — your trusted real estate partner in Dubai. Building dreams, one property at a time with transparency and excellence.',
            'services'         => $services,
            'activeNav'        => 'about'
        ]);
    }

    public function contact(): void
    {
        $this->render('frontend/pages/contact', [
            'meta_title'       => 'Contact Us | DRL Dwarika Real Estate LLC Dubai',
            'meta_description' => 'Get in touch with DRL Dwarika Real Estate LLC. Visit our office in Business Bay, call +971 50 123 4567, or send us a message online.',
            'activeNav'        => 'contact'
        ]);
    }

    public function testimonials(): void
    {
        $testimonials = Testimonial::all('sort_order ASC, id ASC');
        $this->render('frontend/pages/testimonials', [
            'meta_title'       => 'Client Testimonials & Reviews | DRL Dwarika Real Estate LLC',
            'meta_description' => 'Read what our clients say about working with DRL Dwarika Real Estate LLC for buying, selling, and investing in Dubai real estate.',
            'testimonials'     => $testimonials,
            'activeNav'        => 'testimonials'
        ]);
    }
}
