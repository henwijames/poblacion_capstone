<?php
class Rent
{
    private $conn;
    private $table_name = "rent";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Delete rent record based on listing_id
    public function deleteRentByListing($listing_id)
    {
        $query = "DELETE FROM rent WHERE listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id);

        return $stmt->execute();
    }
}
