<?php

require_once __DIR__ . '/../vendor/autoload.php'; 
use Dotenv\Dotenv;


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');



try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

if (!$_ENV['DB_DATABASE']) {
    die("DB_DATABSE is not set in the environment variables.");
}

class Database
{
    private $host = "localhost";
    private $db_name; 
    private $username = "root"; 
    private $password = ""; 
    public $conn;

    public function __construct()
    {
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
