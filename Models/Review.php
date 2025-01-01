<?php
class Review
{
    private $conn;
    private $table_name = "reviews";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function submitReview($user_id, $listing_id, $rating, $message)
    {
        $query = "INSERT INTO reviews (user_id, listing_id, rating, review_message) VALUES (:user_id, :listing_id, :rating, :review_message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':listing_id', $listing_id);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':review_message', $message);

        return $stmt->execute();
    }
}
