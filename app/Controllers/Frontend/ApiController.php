<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Location;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Blog;
use App\Models\Agent;
use App\Models\Founder;

class ApiController extends Controller
{
    /**
     * Live knowledge base endpoint for Noor AI Property Concierge.
     * Always returns real-time published properties, articles/blogs, active locations, services, and company settings.
     * When any property or blog is added, edited, or deleted, this endpoint immediately reflects the change.
     */
    public function chatbotKnowledge(): void
    {
        header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('Expires: 0');

        $props = Property::allPublished();
        $locations = Location::all('name ASC');
        $services = Service::all('sort_order ASC');
        $settings = SiteSetting::getAllFormatted();
        $blogs = Blog::allPublished();
        $agents = Agent::allActive();
        $founders = Founder::all('sort_order ASC');

        $formattedProps = array_map(function($p) use ($locations) {
            $locName = 'Dubai';
            foreach ($locations as $loc) {
                if ($loc['id'] == ($p['location_id'] ?? null)) {
                    $locName = $loc['name'];
                    break;
                }
            }

            return [
                'id'              => (int)$p['id'],
                'title'           => $p['title'],
                'slug'            => $p['slug'],
                'reference_code'  => $p['reference_code'] ?? '',
                'price'           => (int)$p['price'],
                'priceFormatted'  => ($p['currency'] ?? 'AED') . ' ' . number_format((float)$p['price']),
                'currency'        => $p['currency'] ?? 'AED',
                'bedrooms'        => (int)($p['bedrooms'] ?? 0),
                'bathrooms'       => (int)($p['bathrooms'] ?? 0),
                'area_sqft'       => (int)($p['area_sqft'] ?? 0),
                'listing_type'    => $p['listing_type'] ?? 'sale',
                'location'        => $locName,
                'featured_image'  => $p['featured_image'] ?? '/assets/images/apartment-downtown.jpg',
                'badge'           => !empty($p['is_featured']) ? 'Featured' : ($p['listing_type'] === 'off-plan' ? 'Off-Plan' : 'Verified'),
                'rera_permit'     => $p['rera_permit'] ?? 'DLD-VERIFIED',
                'description'     => $p['description'] ?? ''
            ];
        }, $props);

        $formattedBlogs = array_map(function($b) {
            return [
                'id'             => (int)$b['id'],
                'title'          => $b['title'],
                'slug'           => $b['slug'],
                'category'       => $b['category'] ?? 'Market Insights',
                'author'         => $b['author'] ?? 'DRL Research Team',
                'published_at'   => $b['published_at'] ?? date('Y-m-d'),
                'excerpt'        => $b['excerpt'] ?? '',
                'content'        => $b['content'] ?? '',
                'featured_image' => $b['featured_image'] ?? '/assets/images/villa-dubai-hills.jpg',
                'tags'           => is_string($b['tags'] ?? null) ? json_decode($b['tags'], true) : ($b['tags'] ?? [])
            ];
        }, $blogs);

        $this->jsonResponse([
            'success'     => true,
            'updated_at'  => date('c'),
            'properties'  => $formattedProps,
            'blogs'       => $formattedBlogs,
            'locations'   => $locations,
            'services'    => $services,
            'agents'      => $agents,
            'founders'    => $founders,
            'settings'    => [
                'site_name'        => $settings['site_name'] ?? 'DRL Dwarika Real Estate LLC',
                'company_phone'    => $settings['company_phone'] ?? '+971 542202920',
                'company_whatsapp' => $settings['company_whatsapp'] ?? '971542202920',
                'company_email'    => $settings['company_email'] ?? 'admin@dwarikarealestate.ae',
                'company_address'  => $settings['company_address'] ?? 'Port Saeed, Deira, Dubai, UAE',
                'rera_orn'         => $settings['rera_orn'] ?? '29482'
            ]
        ]);
    }
}
