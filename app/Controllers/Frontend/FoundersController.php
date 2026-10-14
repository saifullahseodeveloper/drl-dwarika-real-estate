<?php
declare(strict_types=1);

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Founder;

class FoundersController extends Controller
{
    public function index(): void
    {
        $founders = Founder::getAll();

        $this->render('frontend/pages/founders', [
            'meta_title'       => 'Founders & Leadership | DRL Dwarika Real Estate LLC Dubai',
            'meta_description' => 'Discover the founders and executive leadership guiding DRL Dwarika Real Estate LLC. Anchored by transparency, regulatory mastery, and client prosperity across Dubai real estate.',
            'canonical'        => 'https://dwarikarealestate.ae/founders',
            'founders'         => $founders,
            'activeNav'        => 'founders'
        ]);
    }
}
