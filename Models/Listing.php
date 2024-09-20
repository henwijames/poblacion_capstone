<?php
class Listing
{
    private $conn;
    public $id;
    public $address;
    public $bedrooms;
    public $bathrooms;
    public $amenities;
    public $sqft;
    public $rent;
    public $description;
    public $property_type;
    public $user_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new listing
    public function create()
    {
        // SQL query to insert listing data
        $query = "INSERT INTO listings (address, bedrooms, bathrooms, sqft, rent, description, amenities, property_type, user_id) VALUES (:address, :bedrooms, :bathrooms, :sqft, :rent, :description, :amenities, :property_type, :user_id)";

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
        $stmt->bindParam(':property_type', $this->property_type);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Return the ID of the newly created listing
        }

        return false; // Return false if insertion failed
    }
    public function updateListing($data)
    {
        $query = 'UPDATE listings SET 
                property_type = :property_type,
                address = :address,
                bedrooms = :bedrooms,
                bathrooms = :bathrooms,
                amenities = :amenities,
                sqft = :sqft,
                rent = :rent,
                description = :description
              WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $data['bathrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':amenities', json_encode($data['amenities']));
        $stmt->bindParam(':sqft', $data['sqft'], PDO::PARAM_INT);
        $stmt->bindParam(':rent', $data['rent'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        return $stmt->execute();
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

    public function getListingsByUser($user_id)
    {
        $query = "SELECT * FROM listings WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListingByID($id)
    {
        $query = "SELECT * FROM listings WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getImagesByListing($listingID)
    {
        $query = "SELECT image_path FROM listing_images WHERE listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listingID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch all image paths
    }
}
