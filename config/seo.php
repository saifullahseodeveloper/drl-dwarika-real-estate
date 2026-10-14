<?php
declare(strict_types=1);

/**
 * Technical SEO Configuration & Metadata Schema
 */
return [
    'default_title'       => 'DRL Dwarika Real Estate LLC | Opening Doors To Prosperity | Dubai Real Estate',
    'title_separator'     => ' | ',
    'site_name'           => 'DRL Dwarika Real Estate LLC',
    'default_description' => 'Dwarika Real Estate LLC is a premier Dubai real estate brokerage offering luxury villas, apartments, townhouses, and investment advisory in Dubai, UAE.',
    'default_keywords'    => 'Dubai real estate, luxury villas Dubai, apartments for sale Dubai, Downtown Dubai, Dubai Hills Estate, JVC properties, off plan Dubai, property investment UAE',
    'default_image'       => '/assets/images/design-reference.jpg',
    'twitter_handle'      => '@dwarikarealestate',
    'robots_default'      => 'index, follow',

    // Structured Data Organization defaults
    'organization' => [
        '@context'    => 'https://schema.org',
        '@type'       => 'RealEstateAgent',
        'name'        => 'DRL Dwarika Real Estate LLC',
        'legalName'   => 'DRL Dwarika Real Estate LLC',
        'url'         => 'https://dwarikarealestate.ae',
        'logo'        => 'https://dwarikarealestate.ae/assets/images/logo.png',
        'image'       => 'https://dwarikarealestate.ae/assets/images/design-reference.jpg',
        'description' => 'Premier Dubai real estate brokerage assisting clients in buying, selling, and investing in luxury UAE properties.',
        'telephone'   => '+971501234567',
        'email'       => 'info@dwarikarealestate.ae',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Office 702, Prime Tower, Business Bay',
            'addressLocality' => 'Dubai',
            'addressRegion'   => 'Dubai',
            'postalCode'      => '00000',
            'addressCountry'  => 'AE'
        ],
        'geo'         => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => 25.1856,
            'longitude' => 55.2678
        ],
        'priceRange'  => 'AED 1,000,000 - 50,000,000'
    ]
];
