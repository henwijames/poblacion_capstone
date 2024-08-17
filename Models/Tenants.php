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

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new tenant
    public function create()
    {
        $query = "INSERT INTO " . $this->table . " SET first_name=:fname, middle_name=:mname, last_name=:lname, email=:email, address=:address, phone_number=:phone, validid=:validid, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->mname = htmlspecialchars(strip_tags($this->mname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->validid = htmlspecialchars(strip_tags($this->validid));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Bind parameters
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':mname', $this->mname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':validid', $this->validid);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
