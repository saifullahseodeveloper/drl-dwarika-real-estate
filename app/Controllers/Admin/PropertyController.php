<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Models\Property;
use App\Models\Location;
use App\Models\PropertyType;
use App\Models\Amenity;
use PDO;

class PropertyController extends Controller
{
    public function index(): void
    {
        $status = $_GET['status'] ?? '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        
        $filters = [];
        if (!empty($status)) {
            $filters['status'] = $status;
        }

        $properties = Property::search($filters, $page, 15, 'newest');
        
        $this->render('admin/properties/index', [
            'meta_title'  => 'Manage Properties | DRL Dwarika Admin',
            'properties'  => $properties['items'],
            'total'       => $properties['total'],
            'page'        => $properties['page'],
            'totalPages'  => $properties['total_pages'],
            'status'      => $status,
            'activeNav'   => 'properties'
        ], 'layouts/admin');
    }

    public function create(): void
    {
        $locations = Location::all('name ASC');
        $types = PropertyType::all('name ASC');
        $amenities = Amenity::all('name ASC');
        $agents = \App\Models\Agent::all('name ASC');

        $this->render('admin/properties/create', [
            'meta_title'  => 'Add New Property | DRL Dwarika Admin',
            'locations'   => $locations,
            'types'       => $types,
            'amenities'   => $amenities,
            'agents'      => $agents,
            'activeNav'   => 'properties'
        ], 'layouts/admin');
    }

    public function store(): void
    {
        $this->validateCsrf();

        $title = trim($_POST['title'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $locationId = (int)($_POST['location_id'] ?? 0);
        $typeId = (int)($_POST['property_type_id'] ?? 0);
        $listingType = $_POST['listing_type'] ?? 'sale';
        $status = $_POST['status'] ?? 'published';
        $bedrooms = (int)($_POST['bedrooms'] ?? 0);
        $bathrooms = (int)($_POST['bathrooms'] ?? 0);
        $area = (float)($_POST['area_sqft'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $featuredImage = trim($_POST['featured_image'] ?? '/assets/images/villa-dubai-hills.jpg');
        $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;
        $address = trim($_POST['address'] ?? '');
        $reraPermit = trim($_POST['rera_permit'] ?? '');
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDesc = trim($_POST['meta_description'] ?? '');

        // Generate unique slug
        $slug = $this->generateUniqueSlug($title);
        $refCode = 'DRL-' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $title), 0, 3)) . '-' . rand(100, 999);

        $agentId = !empty($_POST['agent_id']) ? (int)$_POST['agent_id'] : null;

        $db = Database::getConnection();
        $sql = "INSERT INTO properties (title, slug, reference_code, description, price, currency, bedrooms, bathrooms, area_sqft, listing_type, property_type_id, location_id, agent_id, address, status, is_featured, featured_image, rera_permit, meta_title, meta_description)
                VALUES (:title, :slug, :ref, :desc, :price, 'AED', :beds, :baths, :area, :listing_type, :type_id, :loc_id, :agent_id, :addr, :status, :is_featured, :img, :rera, :m_title, :m_desc)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'title'        => $title,
            'slug'         => $slug,
            'ref'          => $refCode,
            'desc'         => $description,
            'price'        => $price,
            'beds'         => $bedrooms,
            'baths'        => $bathrooms,
            'area'         => $area,
            'listing_type' => $listingType,
            'type_id'      => $typeId,
            'loc_id'       => $locationId,
            'agent_id'     => $agentId,
            'addr'         => $address,
            'status'       => $status,
            'is_featured'  => $isFeatured,
            'img'          => $featuredImage,
            'rera'         => $reraPermit,
            'm_title'      => $metaTitle,
            'm_desc'       => $metaDesc
        ]);

        $propId = (int)$db->lastInsertId();

        // Attach selected amenities
        if (!empty($_POST['amenities']) && is_array($_POST['amenities'])) {
            $aStmt = $db->prepare("INSERT INTO property_amenities (property_id, amenity_id) VALUES (:pid, :aid)");
            foreach ($_POST['amenities'] as $aid) {
                $aStmt->execute(['pid' => $propId, 'aid' => (int)$aid]);
            }
        }

        Session::flash('success', "Property '{$title}' added successfully!");
        $this->redirect('/admin/properties');
    }

    public function edit(string $id): void
    {
        $property = Property::findWithDetails($id);
        if (!$property) {
            // Try by ID
            $stmt = Database::getConnection()->prepare("SELECT * FROM properties WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $property = $stmt->fetch();
        }

        if (!$property) {
            Session::flash('error', 'Property not found.');
            $this->redirect('/admin/properties');
            return;
        }

        $locations = Location::all('name ASC');
        $types = PropertyType::all('name ASC');
        $amenities = Amenity::all('name ASC');
        $agents = \App\Models\Agent::all('name ASC');

        $this->render('admin/properties/edit', [
            'meta_title'  => 'Edit Property | DRL Dwarika Admin',
            'property'    => $property,
            'locations'   => $locations,
            'types'       => $types,
            'amenities'   => $amenities,
            'agents'      => $agents,
            'activeNav'   => 'properties'
        ], 'layouts/admin');
    }

    public function update(string $id): void
    {
        $this->validateCsrf();
        $db = Database::getConnection();

        $title = trim($_POST['title'] ?? '');
        $price = (float)($_POST['price'] ?? 0);
        $locationId = (int)($_POST['location_id'] ?? 0);
        $typeId = (int)($_POST['property_type_id'] ?? 0);
        $listingType = $_POST['listing_type'] ?? 'sale';
        $status = $_POST['status'] ?? 'published';
        $bedrooms = (int)($_POST['bedrooms'] ?? 0);
        $bathrooms = (int)($_POST['bathrooms'] ?? 0);
        $area = (float)($_POST['area_sqft'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $featuredImage = trim($_POST['featured_image'] ?? '');
        $isFeatured = !empty($_POST['is_featured']) ? 1 : 0;
        $address = trim($_POST['address'] ?? '');
        $reraPermit = trim($_POST['rera_permit'] ?? '');
        $metaTitle = trim($_POST['meta_title'] ?? '');
        $metaDesc = trim($_POST['meta_description'] ?? '');

        $agentId = !empty($_POST['agent_id']) ? (int)$_POST['agent_id'] : null;

        $sql = "UPDATE properties SET 
                title = :title, description = :desc, price = :price, bedrooms = :beds,
                bathrooms = :baths, area_sqft = :area, listing_type = :listing_type,
                property_type_id = :type_id, location_id = :loc_id, agent_id = :agent_id, address = :addr,
                status = :status, is_featured = :is_featured, featured_image = :img,
                rera_permit = :rera, meta_title = :m_title, meta_description = :m_desc
                WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id'           => $id,
            'title'        => $title,
            'desc'         => $description,
            'price'        => $price,
            'beds'         => $bedrooms,
            'baths'        => $bathrooms,
            'area'         => $area,
            'listing_type' => $listingType,
            'type_id'      => $typeId,
            'loc_id'       => $locationId,
            'agent_id'     => $agentId,
            'addr'         => $address,
            'status'       => $status,
            'is_featured'  => $isFeatured,
            'img'          => $featuredImage,
            'rera'         => $reraPermit,
            'm_title'      => $metaTitle,
            'm_desc'       => $metaDesc
        ]);

        Session::flash('success', "Property updated successfully!");
        $this->redirect('/admin/properties');
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();
        $db = Database::getConnection();
        $stmt = $db->prepare("DELETE FROM properties WHERE id = :id");
        $stmt->execute(['id' => $id]);
        Session::flash('success', "Property deleted successfully!");
        $this->redirect('/admin/properties');
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) as cnt FROM properties WHERE slug = :slug");
        $stmt->execute(['slug' => $slug]);
        if ((int)$stmt->fetch()['cnt'] > 0) {
            $slug .= '-' . rand(10, 99);
        }
        return $slug;
    }
}
