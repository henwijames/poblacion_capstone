<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Ensure this path is correct
use Dotenv\Dotenv;

// Specify the path to your .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
// Change __DIR__ if your .env is in another directory

// Load the .env file and check for success
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}
// Check if the environment variable is set
if (!$_ENV['DB_DATABASE']) {
    die("DB_DATABSE is not set in the environment variables.");
}

class Database
{
    private $host = "localhost";
    private $db_name; // Make sure this is set to your database name
    private $username = "root"; // Your database username
    private $password = ""; // Your database password
    public $conn;

    public function __construct()
    {
        // Assign the database name from the environment variable
        $this->db_name = $_ENV['DB_DATABASE'];
    }

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
