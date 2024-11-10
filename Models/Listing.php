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
    public $payment_options;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create new listing
    public function create()
    {
        // SQL query to insert listing data
        $query = "INSERT INTO listings (address, bedrooms, bathrooms, sqft, rent, description, amenities, property_type, user_id, payment_options) VALUES (:address, :bedrooms, :bathrooms, :sqft, :rent, :description, :amenities, :property_type, :user_id, :payment_options)";

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
        $stmt->bindParam(':payment_options', json_encode($this->payment_options));

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
            payment_options = :payment_options,
            description = :description
          WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters for listing data
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $data['bathrooms'], PDO::PARAM_INT);

        // Fix for passing by reference: Assign to variables first
        $amenities = json_encode($data['amenities']);
        $payment_options = json_encode($data['payment_options']);

        $stmt->bindParam(':amenities', $amenities);
        $stmt->bindParam(':payment_options', $payment_options);

        $stmt->bindParam(':sqft', $data['sqft'], PDO::PARAM_INT);
        $stmt->bindParam(':rent', $data['rent'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

        // Execute the query to update the listing details
        $listingUpdated = $stmt->execute();

        // Check if there are images to update
        if ($uploadedImages && $listingUpdated) {
            // Logic to handle uploaded images (e.g., save, replace, or delete images)
            $this->uploadImages($uploadedImages, $data['id']);
        }

        return $listingUpdated;
    }




    // Save listing images
    public function saveImages($data, $uploadedImages)
    {
        // Ensure $data is an array and has the 'id' key
        if (!is_array($data) || !isset($data['id'])) {
            throw new InvalidArgumentException('Invalid data provided. Listing ID is required.');
        }

        // Get the listing ID from the data
        $listing_id = $data['id'];

        // Prepare SQL to insert images
        $query = 'INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)';
        $stmt = $this->conn->prepare($query);

        foreach ($uploadedImages as $image) {
            // Bind parameters
            $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
            $stmt->bindParam(':image_path', $image);

            // Execute the query for each image
            if (!$stmt->execute()) {
                // Output error information for debugging
                $error = $stmt->errorInfo();
                var_dump($error);
                return false; // Return false if any insert fails
            }
        }

        return true; // Successfully saved images
    }

    public function searchListings($priceFilter = '')
    {
        // Base SQL query
        $query = "SELECT * FROM " . "listings" . " WHERE status = 'not occupied'";

        // Add price filter if provided
        if ($priceFilter) {
            $query .= " " . $priceFilter; // price filter is an SQL snippet passed from the controller
        }

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        // Check if any records were returned
        if ($stmt->rowCount() > 0) {
            // Fetch all results
            $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $listings; // Return the fetched listings
        }

        // Return empty array if no listings found
        return [];
    }


    public function getListingsByUser($user_id)
    {
        $query = "SELECT * FROM listings WHERE user_id = :user_id AND status = 'not occupied'";
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

    public function getAllApartmentListings()
    {
        $query = "SELECT l.*, ln.property_name 
          FROM listings l
          LEFT JOIN landlords ln ON l.user_id = ln.id 
          WHERE l.status = 'not occupied' and l.property_type  = 'apartment'";
        // Assuming landlord_id is in the listings table
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllEstablishmentListings()
    {
        $query = "SELECT l.*, ln.property_name 
          FROM listings l
          LEFT JOIN landlords ln ON l.user_id = ln.id 
          WHERE l.status = 'not occupied' and l.property_type  = 'business establishment'";
        // Assuming landlord_id is in the listings table
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
                // Define the upload path, ensure this directory exists
                $newFilePath = "uploads/" . basename($fileName);
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    // Store image path in the database
                    $query = "INSERT INTO listing_images (listing_id, image_path) VALUES (:listing_id, :image_path)";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
                    $stmt->bindParam(':image_path', $newFilePath); // Use the file path for the database
                    $stmt->execute();
                    $uploadedImages[] = $newFilePath; // Store the file path for further use
                }
            }
        }
        return $uploadedImages;
    }
}
