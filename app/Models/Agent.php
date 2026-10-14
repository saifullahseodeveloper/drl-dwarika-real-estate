<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Agent extends Model
{
    protected static string $table = 'agents';

    public static function getActive(string $orderBy = 'sort_order ASC, id ASC'): array
    {
        $stmt = self::db()->query("SELECT * FROM " . static::$table . " WHERE status = 'active' ORDER BY " . $orderBy);
        $agents = $stmt->fetchAll();
        return array_map([self::class, 'formatAgent'], $agents);
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM " . static::$table . " WHERE slug = :slug AND status = 'active' LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        $agent = $stmt->fetch();
        return $agent ? self::formatAgent($agent) : null;
    }

    public static function filter(array $filters = [], int $page = 1, int $perPage = 6): array
    {
        $db = self::db();
        $conditions = ["status = 'active'"];
        $params = [];

        // Search by name
        if (!empty($filters['search'])) {
            $conditions[] = "(name LIKE :search OR designation LIKE :search OR short_bio LIKE :search)";
            $params['search'] = '%' . trim($filters['search']) . '%';
        }

        // Filter by specialization
        if (!empty($filters['specialization']) && $filters['specialization'] !== 'all') {
            $conditions[] = "JSON_CONTAINS(specializations, :spec)";
            $params['spec'] = json_encode($filters['specialization']);
        }

        // Filter by language
        if (!empty($filters['language']) && $filters['language'] !== 'all') {
            $conditions[] = "JSON_CONTAINS(languages, :lang)";
            $params['lang'] = json_encode($filters['language']);
        }

        // Filter by location
        if (!empty($filters['location']) && $filters['location'] !== 'all') {
            $conditions[] = "JSON_CONTAINS(locations, :loc)";
            $params['loc'] = json_encode($filters['location']);
        }

        $whereClause = implode(' AND ', $conditions);

        // Count total
        $countSql = "SELECT COUNT(*) as total FROM " . static::$table . " WHERE " . $whereClause;
        $countStmt = $db->prepare($countSql);
        $countStmt->execute($params);
        $total = (int)($countStmt->fetch()['total'] ?? 0);

        // Fetch paginated
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM " . static::$table . " WHERE " . $whereClause . " ORDER BY sort_order ASC, id ASC LIMIT :limit OFFSET :offset";
        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(':' . $k, $v);
        }
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $agents = array_map([self::class, 'formatAgent'], $stmt->fetchAll());

        return [
            'agents'       => $agents,
            'total'        => $total,
            'current_page' => $page,
            'per_page'     => $perPage,
            'last_page'    => (int)ceil($total / $perPage),
        ];
    }

    public static function getAssignedProperties(int $agentId, int $limit = 6): array
    {
        $db = self::db();
        $sql = "SELECT p.*, l.name as location_name, l.slug as location_slug, pt.name as type_name
                FROM properties p
                LEFT JOIN locations l ON p.location_id = l.id
                LEFT JOIN property_types pt ON p.property_type_id = pt.id
                WHERE p.agent_id = :agent_id AND p.status = 'published'
                ORDER BY p.is_featured DESC, p.id ASC
                LIMIT :limit";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':agent_id', $agentId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private static function formatAgent(array $agent): array
    {
        if (isset($agent['languages']) && is_string($agent['languages'])) {
            $agent['languages'] = json_decode($agent['languages'], true) ?: [];
        }
        if (isset($agent['specializations']) && is_string($agent['specializations'])) {
            $agent['specializations'] = json_decode($agent['specializations'], true) ?: [];
        }
        if (isset($agent['locations']) && is_string($agent['locations'])) {
            $agent['locations'] = json_decode($agent['locations'], true) ?: [];
        }
        return $agent;
    }
}
