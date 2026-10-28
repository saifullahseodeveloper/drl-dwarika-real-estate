<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Property;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\Service;
use App\Models\Agent;

class SeoController extends Controller
{
    public function sitemap(): void
    {
        $appConfig = require dirname(__DIR__, 2) . '/config/app.php';
        $baseUrl = rtrim($appConfig['url'], '/');

        $staticPages = [
            '/'                       => ['priority' => '1.0', 'changefreq' => 'daily'],
            '/about-us'               => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/founders'               => ['priority' => '0.8', 'changefreq' => 'monthly'],
            '/agents'                 => ['priority' => '0.9', 'changefreq' => 'weekly'],
            '/properties'             => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/properties/buy'         => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/properties/rent'        => ['priority' => '0.9', 'changefreq' => 'daily'],
            '/properties/off-plan'    => ['priority' => '0.9', 'changefreq' => 'weekly'],
            '/properties/commercial'  => ['priority' => '0.8', 'changefreq' => 'weekly'],
            '/services'               => ['priority' => '0.8', 'changefreq' => 'weekly'],
            '/testimonials'           => ['priority' => '0.7', 'changefreq' => 'monthly'],
            '/contact-us'             => ['priority' => '0.8', 'changefreq' => 'monthly'],
        ];

        // Fetch dynamic items
        $properties = Property::all("status = 'published'");
        $locations  = Location::all('name ASC');
        $types      = PropertyType::all('name ASC');
        $services   = Service::getActive();
        $agents     = Agent::getActive();

        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static routes
        foreach ($staticPages as $uri => $meta) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . $uri) . "</loc>\n";
            echo "    <changefreq>" . $meta['changefreq'] . "</changefreq>\n";
            echo "    <priority>" . $meta['priority'] . "</priority>\n";
            echo "  </url>\n";
        }

        // Properties
        foreach ($properties as $prop) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/property/' . $prop['slug']) . "</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($prop['updated_at'] ?? $prop['created_at'])) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.9</priority>\n";
            echo "  </url>\n";
        }

        // Locations
        foreach ($locations as $loc) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/locations/' . $loc['slug']) . "</loc>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        // Property Types
        foreach ($types as $type) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/property-types/' . $type['slug']) . "</loc>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        // Services
        foreach ($services as $srv) {
            echo "  <url>\n";
            echo "    <loc>" . htmlspecialchars($baseUrl . '/services/' . $srv['slug']) . "</loc>\n";
            echo "    <changefreq>monthly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        // Real Estate Agents
        foreach ($agents as $agent) {
            if (!empty($agent['slug'])) {
                echo "  <url>\n";
                echo "    <loc>" . htmlspecialchars($baseUrl . '/agents/' . $agent['slug']) . "</loc>\n";
                echo "    <changefreq>weekly</changefreq>\n";
                echo "    <priority>0.8</priority>\n";
                echo "  </url>\n";
            }
        }

        echo '</urlset>';
        exit;
    }

    public function robots(): void
    {
        $appConfig = require dirname(__DIR__, 2) . '/config/app.php';
        $baseUrl = rtrim($appConfig['url'], '/');

        header('Content-Type: text/plain; charset=utf-8');
        echo "User-agent: *\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /admin\n";
        echo "Allow: /\n\n";
        echo "Sitemap: " . $baseUrl . "/sitemap.xml\n";
        exit;
    }
}
