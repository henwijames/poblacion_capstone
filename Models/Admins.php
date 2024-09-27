<?php
class Admins
{
    private $conn;
    public $id;
    public $fname;
    public $mname;
    public $lname;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Method to find an admin by email
    public function create()
    {
        $query = "INSERT INTO admins SET first_name=:fname, middle_name=:mname, last_name=:lname, email=:email, password=:password";

        $stmt = $this->conn->prepare($query);

        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->mname = htmlspecialchars(strip_tags($this->mname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // Bind parameters
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':mname', $this->mname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
    public function findByEmail($email)
    {
        $query = "SELECT * FROM admins WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array
    }

    // Method to verify the password
    public function verifyPassword($inputPassword, $storedPassword)
    {
        return password_verify($inputPassword, $storedPassword);
    }
}
