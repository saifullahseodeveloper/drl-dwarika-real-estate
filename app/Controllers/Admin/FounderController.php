<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Founder;

class FounderController extends Controller
{
    public function index(): void
    {
        $founders = Founder::getAll();
        $this->render('admin/founders/index', [
            'title'     => 'Founders & Leadership Profiles',
            'founders'  => $founders,
            'activeNav' => 'founders'
        ], 'layouts/admin');
    }

    public function edit(string|int $id): void
    {
        $id = (int)$id;
        $founder = Founder::find($id);
        if (!$founder) {
            $this->redirect('/admin/founders');
        }

        $this->render('admin/founders/edit', [
            'title'     => 'Edit Leadership Profile: ' . $founder['designation'],
            'founder'   => $founder,
            'activeNav' => 'founders'
        ], 'layouts/admin');
    }

    public function update(string|int $id): void
    {
        $id = (int)$id;
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $designation = trim($_POST['designation'] ?? '');
        $photo = trim($_POST['photo_url'] ?? '');
        $shortBio = trim($_POST['short_bio'] ?? '');
        $fullBio = trim($_POST['full_bio'] ?? '');
        $background = trim($_POST['background'] ?? '');
        $leadershipAreas = trim($_POST['leadership_areas'] ?? '');
        $quote = trim($_POST['quote'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $linkedin = trim($_POST['linkedin_url'] ?? '');
        $status = $_POST['status'] ?? 'draft';
        $missingFields = trim($_POST['missing_fields'] ?? '');

        $sql = "UPDATE founders SET 
                name = :name, designation = :designation, photo_url = :photo,
                short_bio = :short_bio, full_bio = :full_bio, background = :background,
                leadership_areas = :leadership_areas, quote = :quote, email = :email,
                phone = :phone, linkedin_url = :linkedin, status = :status,
                missing_fields = :missing_fields
                WHERE id = :id";
        
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id'               => $id,
            'name'             => $name,
            'designation'      => $designation,
            'photo'            => $photo,
            'short_bio'        => $shortBio,
            'full_bio'         => $fullBio,
            'background'       => $background,
            'leadership_areas' => $leadershipAreas,
            'quote'            => $quote,
            'email'            => $email,
            'phone'            => $phone,
            'linkedin'         => $linkedin,
            'status'           => $status,
            'missing_fields'   => $missingFields,
        ]);

        $this->redirect('/admin/founders');
    }
}
