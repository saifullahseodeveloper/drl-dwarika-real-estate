<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Agent;

class AgentController extends Controller
{
    public function index(): void
    {
        $search = isset($_GET['search']) ? trim((string)$_GET['search']) : '';
        $specialization = isset($_GET['specialization']) ? trim((string)$_GET['specialization']) : 'all';
        $language = isset($_GET['language']) ? trim((string)$_GET['language']) : 'all';
        $location = isset($_GET['location']) ? trim((string)$_GET['location']) : 'all';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 24;

        $filters = [
            'search'         => $search,
            'specialization' => $specialization,
            'language'       => $language,
            'location'       => $location,
        ];

        $results = Agent::filter($filters, $page, $perPage);

        $availableSpecializations = [
            'all'         => 'All Specializations',
            'luxury'      => 'Luxury Properties',
            'residential' => 'Residential (Villas & Townhouses)',
            'commercial'  => 'Commercial Real Estate',
            'off-plan'    => 'Off-Plan & Investments',
            'rental'      => 'Rental & Leasing',
        ];

        $availableLanguages = [
            'all'     => 'All Languages',
            'English' => 'English',
            'Arabic'  => 'Arabic (العربية)',
            'Hindi'   => 'Hindi (हिन्दी)',
            'Urdu'    => 'Urdu (اردو)',
            'Russian' => 'Russian (Русский)',
            'French'  => 'French (Français)',
        ];

        $availableLocations = [
            'all'                          => 'All Dubai Communities',
            'Dubai Hills Estate'           => 'Dubai Hills Estate',
            'Downtown Dubai'               => 'Downtown Dubai',
            'Palm Jumeirah'                => 'Palm Jumeirah',
            'Business Bay'                 => 'Business Bay',
            'Jumeirah Village Circle (JVC)' => 'Jumeirah Village Circle (JVC)',
            'Dubai Creek Harbour'          => 'Dubai Creek Harbour',
        ];

        $this->render('frontend/agents/index', [
            'meta_title'              => 'Expert Real Estate Agents in Dubai | DRL Dwarika Real Estate LLC',
            'meta_description'        => 'Meet our licensed, multilingual Dubai real estate consultants and brokers. Specialized in luxury villas, Downtown apartments, commercial properties, and off-plan investments.',
            'canonical'               => 'https://dwarikarealestate.ae/agents',
            'agents'                  => $results['agents'],
            'total'                   => $results['total'],
            'currentPage'             => $results['current_page'],
            'lastPage'                => $results['last_page'],
            'filters'                 => $filters,
            'specializations'         => $availableSpecializations,
            'languages'               => $availableLanguages,
            'locations'               => $availableLocations,
            'activeNav'               => 'agents'
        ]);
    }

    public function show(string $slug): void
    {
        $agent = Agent::findBySlug($slug);
        if (!$agent) {
            http_response_code(404);
            $this->render('frontend/errors/404', [
                'meta_title' => 'Agent Not Found | DRL Dwarika Real Estate',
                'activeNav'  => 'agents'
            ]);
            return;
        }

        $assignedProperties = Agent::getAssignedProperties($agent['id'], 6);

        $this->render('frontend/agents/show', [
            'meta_title'         => "{$agent['name']} - {$agent['designation']} | DRL Dwarika Real Estate",
            'meta_description'   => "Contact {$agent['name']}, {$agent['designation']} at DRL Dwarika Real Estate LLC. Expert in Dubai luxury villas, apartments and investments.",
            'canonical'          => "https://dwarikarealestate.ae/agents/{$agent['slug']}",
            'agent'              => $agent,
            'assignedProperties' => $assignedProperties,
            'activeNav'          => 'agents'
        ]);
    }
}
