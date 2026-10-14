<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Lead extends Model
{
    protected static string $table = 'enquiries';

    public static function create(array $data): int
    {
        $db = self::db();
        $sql = "INSERT INTO enquiries (property_id, service_id, name, email, phone, subject, message, status, ip_address)
                VALUES (:property_id, :service_id, :name, :email, :phone, :subject, :message, :status, :ip_address)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'property_id' => !empty($data['property_id']) ? (int)$data['property_id'] : null,
            'service_id'  => !empty($data['service_id']) ? (int)$data['service_id'] : null,
            'name'        => trim($data['name'] ?? ''),
            'email'       => trim($data['email'] ?? ''),
            'phone'       => trim($data['phone'] ?? ''),
            'subject'     => trim($data['subject'] ?? 'Website Inquiry'),
            'message'     => trim($data['message'] ?? ''),
            'status'      => 'new',
            'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);
        return (int)$db->lastInsertId();
    }

    public static function getRecentWithDetails(int $limit = 10, ?string $status = null): array
    {
        $db = self::db();
        $sql = "SELECT e.*, p.title as property_title, p.slug as property_slug, s.title as service_title
                FROM enquiries e
                LEFT JOIN properties p ON e.property_id = p.id
                LEFT JOIN services s ON e.service_id = s.id";
        if ($status !== null && $status !== '') {
            $sql .= " WHERE e.status = :status";
        }
        $sql .= " ORDER BY e.created_at DESC LIMIT :limit";
        $stmt = $db->prepare($sql);
        if ($status !== null && $status !== '') {
            $stmt->bindValue(':status', $status);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function updateStatus(int $id, string $status, ?string $adminNotes = null): bool
    {
        $sql = "UPDATE enquiries SET status = :status, admin_notes = :notes WHERE id = :id";
        $stmt = self::db()->prepare($sql);
        return $stmt->execute([
            'id'     => $id,
            'status' => $status,
            'notes'  => $adminNotes
        ]);
    }
}
