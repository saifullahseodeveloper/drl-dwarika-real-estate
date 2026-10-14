<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Models\Agent;
use PDO;

class AgentController extends Controller
{
    public function index(): void
    {
        $agents = Agent::all('sort_order ASC, id ASC');
        $this->render('admin/agents/index', [
            'title'     => 'Agents Management',
            'agents'    => $agents,
            'activeNav' => 'agents'
        ], 'layouts/admin');
    }

    public function create(): void
    {
        $this->render('admin/agents/edit', [
            'title'     => 'Add New Agent',
            'agent'     => null,
            'activeNav' => 'agents'
        ], 'layouts/admin');
    }

    public function store(): void
    {
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
        $designation = trim($_POST['designation'] ?? '');
        $rera = trim($_POST['rera_brn'] ?? '');
        $experience = trim($_POST['experience'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $whatsapp = trim($_POST['whatsapp'] ?? '') ?: preg_replace('/[^0-9]/', '', $phone);
        $photo = trim($_POST['photo_url'] ?? '') ?: '/assets/images/agents/omar-farooq.jpg';
        $shortBio = trim($_POST['short_bio'] ?? '');
        $fullBio = trim($_POST['full_bio'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        $languages = array_filter(array_map('trim', explode(',', $_POST['languages'] ?? '')));
        $specializations = array_filter(array_map('trim', explode(',', $_POST['specializations'] ?? '')));
        $locations = array_filter(array_map('trim', explode(',', $_POST['locations'] ?? '')));

        $sql = "INSERT INTO agents (name, slug, designation, rera_brn, experience, photo_url, email, phone, whatsapp, short_bio, full_bio, languages, specializations, locations, status, sort_order)
                VALUES (:name, :slug, :designation, :rera, :experience, :photo, :email, :phone, :whatsapp, :short_bio, :full_bio, :languages, :specializations, :locations, :status, :sort_order)";
        
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'name'            => $name,
            'slug'            => $slug,
            'designation'     => $designation,
            'rera'            => $rera,
            'experience'      => $experience,
            'photo'           => $photo,
            'email'           => $email,
            'phone'           => $phone,
            'whatsapp'        => $whatsapp,
            'short_bio'       => $shortBio,
            'full_bio'        => $fullBio,
            'languages'       => json_encode(array_values($languages)),
            'specializations' => json_encode(array_values($specializations)),
            'locations'       => json_encode(array_values($locations)),
            'status'          => $status,
            'sort_order'      => $sortOrder,
        ]);

        $this->redirect('/admin/agents');
    }

    public function edit(string|int $id): void
    {
        $id = (int)$id;
        $agent = Agent::find($id);
        if (!$agent) {
            $this->redirect('/admin/agents');
        }

        $this->render('admin/agents/edit', [
            'title'     => 'Edit Agent: ' . $agent['name'],
            'agent'     => $agent,
            'activeNav' => 'agents'
        ], 'layouts/admin');
    }

    public function update(string|int $id): void
    {
        $id = (int)$id;
        $this->validateCsrf();

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
        $designation = trim($_POST['designation'] ?? '');
        $rera = trim($_POST['rera_brn'] ?? '');
        $experience = trim($_POST['experience'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $whatsapp = trim($_POST['whatsapp'] ?? '') ?: preg_replace('/[^0-9]/', '', $phone);
        $photo = trim($_POST['photo_url'] ?? '');
        $shortBio = trim($_POST['short_bio'] ?? '');
        $fullBio = trim($_POST['full_bio'] ?? '');
        $status = $_POST['status'] ?? 'active';
        $sortOrder = (int)($_POST['sort_order'] ?? 0);

        $languages = array_filter(array_map('trim', explode(',', $_POST['languages'] ?? '')));
        $specializations = array_filter(array_map('trim', explode(',', $_POST['specializations'] ?? '')));
        $locations = array_filter(array_map('trim', explode(',', $_POST['locations'] ?? '')));

        $sql = "UPDATE agents SET 
                name = :name, slug = :slug, designation = :designation, rera_brn = :rera,
                experience = :experience, photo_url = :photo, email = :email, phone = :phone,
                whatsapp = :whatsapp, short_bio = :short_bio, full_bio = :full_bio,
                languages = :languages, specializations = :specializations, locations = :locations,
                status = :status, sort_order = :sort_order
                WHERE id = :id";
        
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id'              => $id,
            'name'            => $name,
            'slug'            => $slug,
            'designation'     => $designation,
            'rera'            => $rera,
            'experience'      => $experience,
            'photo'           => $photo,
            'email'           => $email,
            'phone'           => $phone,
            'whatsapp'        => $whatsapp,
            'short_bio'       => $shortBio,
            'full_bio'        => $fullBio,
            'languages'       => json_encode(array_values($languages)),
            'specializations' => json_encode(array_values($specializations)),
            'locations'       => json_encode(array_values($locations)),
            'status'          => $status,
            'sort_order'      => $sortOrder,
        ]);

        $this->redirect('/admin/agents');
    }

    public function delete(string|int $id): void
    {
        $id = (int)$id;
        $this->validateCsrf();
        $db = \App\Core\Database::getConnection();
        $stmt = $db->prepare("DELETE FROM agents WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $this->redirect('/admin/agents');
    }
}
