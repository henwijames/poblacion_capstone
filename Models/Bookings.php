<?php

class Bookings
{
    private $conn;
    public $id;
    public $user_id;
    public $check_in;
    public $booking_status;
    public $created_at;
    public $total_amount;
    public $landlord_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function findById($id)
    {
        $query = "SELECT * FROM bookings WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array
    }

    public function verifyInquiry($inquiryId)
    {
        $query = "UPDATE bookings SET booking_status = 'verified' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $inquiryId);
        return $stmt->execute();
    }
}
