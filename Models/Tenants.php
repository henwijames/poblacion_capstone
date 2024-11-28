<?php

class Tenants
{
    private $conn;
    private $table = 'tenants';

    public $id;
    public $fname;
    public $mname;
    public $lname;
    public $email;
    public $address;
    public $phone;
    public $validid;
    public $password;
    public $verification_code;
    public $verification_expires_at;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllTenants()
    {
        $query = "SELECT id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS tenant_name, first_name, address, account_status, validid, phone_number, email  FROM " . $this->table;
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function verifyTenant($tenantId)
    {
        $query = "UPDATE tenants SET account_status = 'verified' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $tenantId);
        return $stmt->execute();
    }
    public function declineTenant($tenantId)
    {
        $query = "UPDATE tenants SET account_status = 'declined' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $tenantId);
        return $stmt->execute();
    }

    public function savePermit($tenantId, $photoPath = null)
    {
        $query = 'UPDATE tenants 
        SET validid = :validid WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':validid', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':id', $tenantId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function blockTenant($tenantId)
    {
        $query = "UPDATE tenants SET account_status = 'banned' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $tenantId);
        return $stmt->execute();
    }

    public function getPendingTransactions($tenantId)
    {
        $query = "
    SELECT t.amount, t.reference_number, t.transaction_date, t.transaction_id, t.transaction_status, l.listing_name
    FROM transactions t
    JOIN listings l ON t.listing_id = l.id
    WHERE t.user_id = :tenant_id
    AND t.transaction_status = 'pending'  -- Added condition to filter by 'pending' status
    ORDER BY t.transaction_date DESC
";



        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tenant_id', $tenantId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return results as an associative array
    }
    public function getDeclinedTransactions($tenantId)
    {
        $query = "
    SELECT t.amount, t.reference_number, t.transaction_date, t.transaction_id, t.transaction_status, l.listing_name
    FROM transactions t
    JOIN listings l ON t.listing_id = l.id
    WHERE t.user_id = :tenant_id
    AND t.transaction_status = 'declined'  -- Added condition to filter by 'pending' status
    ORDER BY t.transaction_date DESC
";



        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tenant_id', $tenantId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return results as an associative array
    }
    public function getCompletedTransactions($tenantId)
    {
        $query = "
    SELECT t.amount, t.reference_number, t.transaction_date, t.transaction_id, t.transaction_status, l.listing_name
    FROM transactions t
    JOIN listings l ON t.listing_id = l.id
    WHERE t.user_id = :tenant_id
    AND t.transaction_status = 'completed'  -- Added condition to filter by 'pending' status
    ORDER BY t.transaction_date DESC
";



        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':tenant_id', $tenantId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Return results as an associative array
    }
    public function deleteBooking($bookingId)
    {
        $query = "DELETE FROM bookings WHERE id = :booking_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

        // Execute the query and check results
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true; // Successfully deleted
            } else {
                return false; // No rows affected, possibly invalid booking ID
            }
        } else {
            // Log detailed error information
            error_log("Delete query failed: " . json_encode($stmt->errorInfo()));
            return false;
        }
    }



    public function searchTenants($searchTerm)
    {
        $query = "SELECT * FROM tenants WHERE first_name LIKE :search OR last_name LIKE :search OR address LIKE :search OR account_status LIKE :search";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function checkEmailExists($email)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0; // Returns true if email exists
    }
    public function checkNumberExist($number)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE phone_number = :phone_number LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':phone_number', $number);
        $stmt->execute();

        return $stmt->rowCount() > 0; // Returns true if email exists
    }

    // Create a new tenant
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
              SET first_name=:fname, middle_name=:mname, last_name=:lname, email=:email, address=:address, phone_number=:phone, validid=:validid, password=:password, verification_code=:verification_code, verification_expires_at=:verification_expires_at";

        $stmt = $this->conn->prepare($query);

        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->mname = htmlspecialchars(strip_tags($this->mname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->validid = htmlspecialchars(strip_tags($this->validid));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->verification_code = htmlspecialchars(strip_tags($this->verification_code)); // Sanitize verification code
        $this->verification_expires_at = htmlspecialchars(strip_tags($this->verification_expires_at)); // Sanitize expiration time

        // Bind parameters
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':mname', $this->mname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':validid', $this->validid);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':verification_code', $this->verification_code); // Bind verification code
        $stmt->bindParam(':verification_expires_at', $this->verification_expires_at); // Bind expiration time


        // Execute query
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }

        return false;
    }

    public function findByEmail($email)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function findById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateTenant($tenantId, $data)
    {
        $query = 'UPDATE tenants 
            SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name,
                address = :address, profile_picture = :profile_picture
            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);

        // Bind the profile picture (it may be null if no new picture is uploaded)
        // Using ternary operator to ensure it isn't passed as null by reference
        $profilePicture = $data['profile_picture'] ?? null;
        $stmt->bindParam(':profile_picture', $profilePicture, PDO::PARAM_STR);

        $stmt->bindParam(':id', $tenantId, PDO::PARAM_INT);

        // Execute update
        if ($stmt->execute()) {
            return true;
        } else {
            // Print error information
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function smsVerCode($id, $data)
    {
        $query = "UPDATE tenants SET verification_code = :verification_code, verification_expires_at = :verification_expires_at WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':verification_code', $data['verification_code']);
        $stmt->bindParam(':verification_expires_at', $data['verification_expires_at']);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Database error: " . implode(" | ", $stmt->errorInfo()));
            return false;
        }
    }

    public function verifyPhoneNumber($id)
    {
        $query = "UPDATE tenants SET mobile_verified = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // In Tenants.php model

    public function insertEmailVerificationToken($email, $token)
    {
        // Check if a token already exists for this email
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM email_verification WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // Update the existing token
            $stmt = $this->conn->prepare("UPDATE email_verification SET token = :token, created_at = NOW() WHERE email = :email");
            $stmt->execute([':token' => $token, ':email' => $email]);
        } else {
            // Insert a new token
            $stmt = $this->conn->prepare("INSERT INTO email_verification (email, token, created_at) VALUES (:email, :token, NOW())");
            $stmt->execute([':email' => $email, ':token' => $token]);
        }
    }
    public function getEmailVerificationToken($email)
    {
        $query = "SELECT token. expires_at FROM email_verification  WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['verification_token'] : null;
    }

    public function deleteEmailVerificationToken($email)
    {
        // SQL query to delete the existing token for the landlord
        $query = "DELETE FROM email_verification WHERE email = :email";

        // Prepare the query
        $stmt = $this->conn->prepare($query);

        // Bind the email parameter to prevent SQL injection
        $stmt->bindParam(':email', $email);

        // Execute the query and return the result
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function getVerificationStatusByEmail($email)
    {
        $query = "SELECT email_verified, mobile_verified FROM tenants WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
