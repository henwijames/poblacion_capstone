<?php
class Listing
{
    private $conn;
    private $table = 'listings';

    // Listing properties
    public $id;
    public $address;
    public $bedrooms;
    public $bathrooms;
    public $amenities;
    public $sqft;
    public $rent;
    public $description;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new listing
    public function create()
    {
        // SQL query to insert listing data
        $query = "INSERT INTO listings (address, bedrooms, bathrooms, sqft, rent, description, amenities) VALUES (:address, :bedrooms, :bathrooms, :sqft, :rent, :description, :amenities)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':bedrooms', $this->bedrooms);
        $stmt->bindParam(':bathrooms', $this->bathrooms);
        $stmt->bindParam(':sqft', $this->sqft);
        $stmt->bindParam(':rent', $this->rent);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':amenities', json_encode($this->amenities)); // Convert array to JSON

        // Execute query
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Return the ID of the newly created listing
        }

        return false; // Return false if insertion failed
    }

    // Save listing images
    public function saveImages($listingID, $imagePaths)
    {
        $query = "INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)";
        $stmt = $this->conn->prepare($query);

        foreach ($imagePaths as $imagePath) {
            $stmt->bindParam(':listing_id', $listingID);
            $stmt->bindParam(':image_path', $imagePath);
            if (!$stmt->execute()) {
                return false; // Return false if any image fails to save
            }
        }

        return true;
    }
}
