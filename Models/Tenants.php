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
                address = :address, phone_number = :phone_number
            WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':first_name', $data['first_name'], PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $data['middle_name'], PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $data['last_name'], PDO::PARAM_STR);
        $stmt->bindParam(':address', $data['address'], PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $data['phone_number'], PDO::PARAM_STR);
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
    public function verifyPhoneNumber($id)
    {
        $query = "UPDATE tenants SET mobile_verified = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
