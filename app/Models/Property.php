<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Property extends Model
{
    protected static string $table = 'properties';

    public static function search(array $filters = [], int $page = 1, int $perPage = 9, string $sort = 'newest'): array
    {
        $db = self::db();
        $conditions = ["p.status = 'published'"];
        $params = [];

        // Filter: Location (ID or slug)
        if (!empty($filters['location'])) {
            if (is_numeric($filters['location'])) {
                $conditions[] = "p.location_id = :location_id";
                $params['location_id'] = (int)$filters['location'];
            } else {
                $conditions[] = "l.slug = :location_slug";
                $params['location_slug'] = $filters['location'];
            }
        }

        // Filter: Property Type (ID or slug)
        if (!empty($filters['type'])) {
            if (is_numeric($filters['type'])) {
                $conditions[] = "p.property_type_id = :property_type_id";
                $params['property_type_id'] = (int)$filters['type'];
            } else {
                $conditions[] = "pt.slug = :type_slug";
                $params['type_slug'] = $filters['type'];
            }
        }

        // Filter: Listing Type (sale, rent, off-plan, commercial)
        if (!empty($filters['listing_type'])) {
            $conditions[] = "p.listing_type = :listing_type";
            $params['listing_type'] = $filters['listing_type'];
        }

        // Filter: Bedrooms
        if (!empty($filters['bedrooms'])) {
            if ($filters['bedrooms'] === '4+') {
                $conditions[] = "p.bedrooms >= 4";
            } else {
                $conditions[] = "p.bedrooms = :bedrooms";
                $params['bedrooms'] = (int)$filters['bedrooms'];
            }
        }

        // Filter: Min Price
        if (!empty($filters['min_price'])) {
            $conditions[] = "p.price >= :min_price";
            $params['min_price'] = (float)$filters['min_price'];
        }

        // Filter: Max Price
        if (!empty($filters['max_price'])) {
            $conditions[] = "p.price <= :max_price";
            $params['max_price'] = (float)$filters['max_price'];
        }

        // Filter: Keyword (title, reference code, address)
        if (!empty($filters['keyword'])) {
            $conditions[] = "(p.title LIKE :keyword OR p.reference_code LIKE :keyword OR p.address LIKE :keyword)";
            $params['keyword'] = '%' . $filters['keyword'] . '%';
        }

        $whereClause = implode(' AND ', $conditions);

        // Sorting
        $orderBy = match ($sort) {
            'price_asc'  => 'p.price ASC',
            'price_desc' => 'p.price DESC',
            'oldest'     => 'p.id ASC',
            default      => 'p.is_featured DESC, p.created_at DESC'
        };

        // Total count
        $countSql = "SELECT COUNT(*) as total 
                     FROM properties p
                     LEFT JOIN locations l ON p.location_id = l.id
                     LEFT JOIN property_types pt ON p.property_type_id = pt.id
                     WHERE {$whereClause}";
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        // Data query
        $offset = max(0, ($page - 1) * $perPage);
        $dataSql = "SELECT p.*, l.name as location_name, l.slug as location_slug, pt.name as type_name, pt.slug as type_slug
                    FROM properties p
                    LEFT JOIN locations l ON p.location_id = l.id
                    LEFT JOIN property_types pt ON p.property_type_id = pt.id
                    WHERE {$whereClause}
                    ORDER BY {$orderBy}
                    LIMIT {$perPage} OFFSET {$offset}";

        $stmt = $db->prepare($dataSql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        return [
            'items'       => $items,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $perPage,
            'total_pages' => ceil($total / $perPage)
        ];
    }

    public static function getFeatured(int $limit = 6): array
    {
        $db = self::db();
        $sql = "SELECT p.*, l.name as location_name, l.slug as location_slug, pt.name as type_name
                FROM properties p
                LEFT JOIN locations l ON p.location_id = l.id
                LEFT JOIN property_types pt ON p.property_type_id = pt.id
                WHERE p.status = 'published' AND p.is_featured = 1
                ORDER BY p.id ASC
                LIMIT :limit";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function findWithDetails(string $slug): ?array
    {
        $db = self::db();
        $sql = "SELECT p.*, l.name as location_name, l.slug as location_slug, l.city as location_city,
                       pt.name as type_name, pt.slug as type_slug,
                       ag.name as agent_name, ag.slug as agent_slug, ag.photo_url as agent_photo,
                       ag.designation as agent_designation, ag.phone as agent_phone, ag.whatsapp as agent_whatsapp,
                       ag.email as agent_email, ag.rera_brn as agent_rera
                FROM properties p
                LEFT JOIN locations l ON p.location_id = l.id
                LEFT JOIN property_types pt ON p.property_type_id = pt.id
                LEFT JOIN agents ag ON p.agent_id = ag.id
                WHERE p.slug = :slug LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        $property = $stmt->fetch();
        if (!$property) {
            return null;
        }

        // Fetch Amenities
        $amenitySql = "SELECT a.* FROM amenities a
                       INNER JOIN property_amenities pa ON a.id = pa.amenity_id
                       WHERE pa.property_id = :prop_id";
        $aStmt = $db->prepare($amenitySql);
        $aStmt->execute(['prop_id' => $property['id']]);
        $property['amenities'] = $aStmt->fetchAll();

        // Fetch Gallery Images
        $imgSql = "SELECT * FROM property_images WHERE property_id = :prop_id ORDER BY sort_order ASC, id ASC";
        $iStmt = $db->prepare($imgSql);
        $iStmt->execute(['prop_id' => $property['id']]);
        $property['gallery'] = $iStmt->fetchAll();

        return $property;
    }

    public static function getSimilar(int $excludeId, int $locationId, int $typeId, int $limit = 3): array
    {
        $db = self::db();
        $sql = "SELECT p.*, l.name as location_name, pt.name as type_name
                FROM properties p
                LEFT JOIN locations l ON p.location_id = l.id
                LEFT JOIN property_types pt ON p.property_type_id = pt.id
                WHERE p.status = 'published' 
                  AND p.id != :exclude_id 
                  AND (p.location_id = :location_id OR p.property_type_id = :type_id)
                ORDER BY p.is_featured DESC, p.created_at DESC
                LIMIT :limit";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':exclude_id', $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(':location_id', $locationId, PDO::PARAM_INT);
        $stmt->bindValue(':type_id', $typeId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
