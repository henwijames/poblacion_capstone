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
    public function updateListing($data, $uploadedImages = null)
    {
        // Update listing data query
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

        // Bind parameters for listing data
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $data['bathrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':amenities', json_encode($data['amenities']));
        $stmt->bindParam(':sqft', $data['sqft'], PDO::PARAM_INT);
        $stmt->bindParam(':rent', $data['rent'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        // Execute the query to update the listing details
        $listingUpdated = $stmt->execute();

        // Check if there are images to update
        if ($uploadedImages && $listingUpdated) {
            // Logic to handle uploaded images (e.g., save, replace, or delete images)
            $this->uploadImages($data['id'], $uploadedImages);
        }

        return $listingUpdated;
    }



    // Save listing images
    public function saveImages($data, $uploadedImages)
    {
        // Make sure you are passing the correct listing ID
        $listing_id = $data['id'];

        // Update the listing first (assuming you have an update function)
        if (!$this->updateListing($data)) {
            return false; // Exit if the listing update fails
        }

        // Prepare SQL to insert images
        $query = 'INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)';
        $stmt = $this->conn->prepare($query);

        foreach ($uploadedImages as $image) {
            // Bind parameters
            $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
            $stmt->bindParam(':image_path', $image);

            if (!$stmt->execute()) {
                return false; // Return false if any insert fails
            }
        }

        return true; // Successfully saved images
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

    public function getAllListings()
    {
        $query = "SELECT l.*, ln.property_name 
              FROM listings l
              LEFT JOIN landlords ln ON l.id = ln.id"; // Assuming landlord_id is in the listings table
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getImagesByListing($listingID)
    {
        $query = "SELECT image_path FROM listing_images WHERE listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listingID);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch all image paths
    }
    public function deleteImagesByListing($listing_id)
    {
        // Fetch the images from the database
        $query = "SELECT image_path FROM listing_images WHERE listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id);
        $stmt->execute();
        $images = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Delete images from the filesystem
        foreach ($images as $image) {
            $filePath = "uploads/" . $image['image_path']; // Adjust the path accordingly
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the file from the server
            }
        }

        // Delete images from the database
        $query = "DELETE FROM listing_images WHERE listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id);
        return $stmt->execute();
    }
    public function uploadImages($files, $listing_id)
    {
        $uploadedImages = [];
        foreach ($files['name'] as $index => $fileName) {
            $tmpFilePath = $files['tmp_name'][$index];
            if ($tmpFilePath) {
                $newFilePath = "uploads/" . basename($fileName); // Adjust the path
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    // Store image path in the database
                    $query = "INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':listing_id', $listing_id);
                    $stmt->bindParam(':image_path', $fileName);
                    $stmt->execute();
                    $uploadedImages[] = $fileName;
                }
            }
        }
        return $uploadedImages;
    }
}
