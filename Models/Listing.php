<?php
class Listing
{
    private $conn;
    public $id;
    public $listing_name;
    public $address;
    public $bedrooms;
    public $bathrooms;
    public $amenities;
    public $utilities;
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
        $query = "INSERT INTO listings (listing_name, address, bedrooms, bathrooms, sqft, rent, description, amenities, utilities, property_type, user_id, payment_options) VALUES (:listing_name, :address, :bedrooms, :bathrooms, :sqft, :rent, :description, :amenities, :utilities, :property_type, :user_id, :payment_options)";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':listing_name', $this->listing_name);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':bedrooms', $this->bedrooms);
        $stmt->bindParam(':bathrooms', $this->bathrooms);
        $stmt->bindParam(':sqft', $this->sqft);
        $stmt->bindParam(':rent', $this->rent);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':amenities', json_encode($this->amenities)); // Convert array to JSON
        $stmt->bindParam(':utilities', json_encode($this->utilities)); // Convert array to JSON
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
            listing_name = :listing_name,
            address = :address,
            bedrooms = :bedrooms,
            bathrooms = :bathrooms,
            amenities = :amenities,
            utilities = :utilities,
            sqft = :sqft,
            payment_options = :payment_options,
            description = :description
          WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters for listing data
        $stmt->bindParam(':property_type', $data['property_type']);
        $stmt->bindParam(':listing_name', $data['listing_name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':bedrooms', $data['bedrooms'], PDO::PARAM_INT);
        $stmt->bindParam(':bathrooms', $data['bathrooms'], PDO::PARAM_INT);

        // Fix for passing by reference: Assign to variables first
        $amenities = json_encode($data['amenities']);
        $utilities = json_encode($data['utilities']);
        $payment_options = json_encode($data['payment_options']);

        $stmt->bindParam(':amenities', $amenities);
        $stmt->bindParam(':utilities', $utilities);
        $stmt->bindParam(':payment_options', $payment_options);

        $stmt->bindParam(':sqft', $data['sqft'], PDO::PARAM_INT);
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

    public function updateQrPayment($landlordId, $qrPayment)
    {
        $query = "UPDATE landlords SET mode_of_payment = :qr_payment WHERE id = :landlord_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':qr_payment', $qrPayment);
        $stmt->bindParam(':landlord_id', $landlordId);

        return $stmt->execute();
    }

    // Update the listing occupancy status (0 = not occupied, 1 = occupied)
    public function updateOccupancyStatus($listing_id)
    {
        $query = "UPDATE listings SET status = 'not occupied' WHERE id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id);

        return $stmt->execute();
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

    public function getListingsByLandlord($user_id)
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

    public function getReviewsByListingId($listing_id)
    {
        $query = "SELECT r.rating, r.review_message, r.created_at, t.first_name AS tenant_name
                  FROM reviews r
                  JOIN tenants t ON r.user_id = t.id
                  WHERE r.listing_id = :listing_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':listing_id', $listing_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
