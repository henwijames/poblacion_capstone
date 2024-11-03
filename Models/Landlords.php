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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET first_name=:fname, middle_name=:mname, last_name=:lname, email=:email, address=:address, property_name=:property_name, phone_number=:phone, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->mname = htmlspecialchars(strip_tags($this->mname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->property_name = htmlspecialchars(strip_tags($this->property_name));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Bind parameters
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':mname', $this->mname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':property_name', $this->property_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        if ($stmt->execute()) {
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
            address = :address, phone_number = :phone_number, email = :email, property_name = :property_name';

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
        $stmt->bindParam(':phone_number', $data['phone_number'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $data['email'], PDO::PARAM_STR);
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

    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }

    public function getAllLandlords()
    {
        $query = "SELECT id, first_name, middle_name, last_name, email, address, property_name, phone_number, profile_picture FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
