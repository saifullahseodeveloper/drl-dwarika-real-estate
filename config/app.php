<?php
declare(strict_types=1);

/**
 * Application Configuration
 * DRL Dwarika Real Estate LLC
 */
return [
    'name'        => 'DRL Dwarika Real Estate LLC',
    'tagline'     => 'Opening Doors To Prosperity',
    'url'         => getenv('APP_URL') ?: 'http://localhost:4173',
    'env'         => getenv('APP_ENV') ?: 'production',
    'currency'    => 'AED',
    'timezone'    => 'Asia/Dubai',
    'locale'      => 'en',
    
    // Official Business Contacts
    'contact'     => [
        'phone'       => '+971 50 123 4567',
        'whatsapp'    => '+971501234567',
        'email'       => 'info@dwarikarealestate.ae',
        'address'     => 'Office 702, Prime Tower, Business Bay, Dubai, United Arab Emirates',
        'city'        => 'Dubai',
        'country'     => 'United Arab Emirates',
        'rera_orn'    => '29482',
        'dld_license' => '1092831',
    ],

    // Stats as featured on homepage
    'stats'       => [
        'properties_sold'  => '100+',
        'happy_clients'    => '50+',
        'years_experience' => '5+',
    ],

    // Social Media Links
    'social'      => [
        'facebook'  => 'https://facebook.com/dwarikarealestate',
        'instagram' => 'https://instagram.com/dwarikarealestate',
        'linkedin'  => 'https://linkedin.com/company/dwarikarealestate',
        'youtube'   => 'https://youtube.com/@dwarikarealestate',
    ]
];
