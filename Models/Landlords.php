<?php


class Landlords
{
    private $conn;
    private $table = 'landlords';

    public $id;
    public $fname;
    public $mname;
    public $lname;
    public $email;
    public $address;
    public $property_name;
    public $phone;
    public $password;
    public $verification_code;
    public $verification_expires_at;

    public function __construct($db)
    {
        $this->conn = $db;
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

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET first_name=:fname, middle_name=:mname, last_name=:lname, email=:email, address=:address, property_name=:property_name, phone_number=:phone, password=:password, verification_code=:verification_code, verification_expires_at=:verification_expires_at";

        $stmt = $this->conn->prepare($query);

        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->mname = htmlspecialchars(strip_tags($this->mname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->property_name = htmlspecialchars(strip_tags($this->property_name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->verification_code = htmlspecialchars(strip_tags($this->verification_code)); // Sanitize verification code
        $this->verification_expires_at = htmlspecialchars(strip_tags($this->verification_expires_at)); // Sanitize expiration time

        // Bind parameters
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':mname', $this->mname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':property_name', $this->property_name);
        $stmt->bindParam(':phone', $this->phone);
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
    public function updateLandlords($landlordId, $data, $photoPath = null)
    {
        $query = 'UPDATE landlords 
        SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name,
            address = :address, property_name = :property_name';

        if ($photoPath) {
            $query .= ', profile_picture = :profile_photo';
        }

        $query .= ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(':property_name', $data['property_name'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $landlordId, PDO::PARAM_INT);

        if ($photoPath) {
            $stmt->bindParam(':profile_photo', $photoPath, PDO::PARAM_STR);
        }

        // Execute update
        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }
    public function savePermit($landlordId, $photoPath = null)
    {
        $query = 'UPDATE landlords 
        SET permit = :permit WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':permit', $photoPath, PDO::PARAM_STR);
        $stmt->bindParam(':id', $landlordId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());
            return false;
        }
    }

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function getAllLandlords()
    {
        $query = "SELECT id, first_name, middle_name, last_name, email, address, property_name, phone_number, profile_picture, permit, account_status FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function verifyLandlord($landlordId)
    {
        $query = "UPDATE landlords SET account_status = 'verified' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $landlordId);
        return $stmt->execute();
    }

    public function searchLandlords($searchTerm)
    {
        $query = "SELECT * FROM landlords WHERE first_name LIKE :search OR last_name LIKE :search OR address LIKE :search OR account_status LIKE :search";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':search', '%' . $searchTerm . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verifyPhoneNumber($id)
    {
        $query = "UPDATE landlords SET mobile_verified = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

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

    public function getVerificationStatusByEmail($email)
    {
        $query = "SELECT email_verified, mobile_verified FROM landlords WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
}
