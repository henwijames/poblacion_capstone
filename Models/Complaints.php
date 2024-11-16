<?php
class Complaints
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getComplaintsByTenant($tenantId)
    {
        $query = "
            SELECT message, created_at
            FROM complaints
            WHERE user_id = :tenant_id
            ORDER BY created_at DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tenant_id', $tenantId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
