<?php
declare(strict_types=1);

/**
 * Application Configuration
 * DRL Dwarika Real Estate L.L.C
 */
return [
    'name'        => 'DRL Dwarika Real Estate L.L.C',
    'tagline'     => 'Opening Doors To Prosperity',
    'url'         => getenv('APP_URL') ?: 'http://localhost:4173',
    'env'         => getenv('APP_ENV') ?: 'production',
    'currency'    => 'AED',
    'timezone'    => 'Asia/Dubai',
    'locale'      => 'en',

    // Official Business Contacts
    'contact'     => [
        'phone'           => '+971 542202920',
        'whatsapp'        => '+971542202920',
        'whatsapp_link'   => 'https://wa.me/971542202920',
        'email'           => 'admin@dwarikarealestate.ae',
        'notify_email'    => 'admin@dwarikarealestate.ae',
        'address'         => 'Office No. 65-0, El Shaye - 4, 28th Street, Port Saeed, Deira Dubai, UAE',
        'city'            => 'Dubai',
        'country'         => 'United Arab Emirates',
        'working_hours'   => 'Mon – Sat: 10:00 AM – 7:00 PM',
        'rera_orn'        => '63750',
        'ded_license'     => '1637547',
        'vat_trn'         => '105555721700003',
        'google_maps'     => '',   // To be provided
    ],

    // Stats as featured on homepage
    'stats'       => [
        'properties_sold'  => '100+',
        'happy_clients'    => '50+',
        'years_experience' => '5+',
    ],

    // Social Media Links (update when handles are available)
    'social'      => [
        'facebook'  => '',
        'instagram' => '',
        'linkedin'  => '',
        'youtube'   => '',
        'tiktok'    => '',
    ],
];
