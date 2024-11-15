<?php
include '../../Controllers/Database.php';

class RentController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addTransaction($bookingId, $dueMonth, $rentAmount, $referenceNumber)
    {
        try {
            // Check if rent is already paid for this month
            $checkQuery = "SELECT * FROM rent WHERE id = :booking_id AND due_month = :due_month";
            $stmt = $this->db->prepare($checkQuery);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);
            $stmt->bindParam(':due_month', $dueMonth, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return [
                    'status' => 'error',
                    'message' => 'Rent for this month has already been paid.'
                ];
            }

            // Insert the transaction into the transactions table
            $insertQuery = "
                INSERT INTO transactions (user_id, landlord_id, listing_id, apartment_name, amount, transaction_date, reference_number, details, transaction_status)
                SELECT b.user_id, l.user_id AS landlord_id, b.listing_id, l.address AS apartment_name, :amount, NOW(), :reference_number, 'Paid', 'pending'
                FROM rent b
                JOIN listings l ON b.listing_id = l.id
                WHERE b.id = :booking_id
            ";
            $stmt = $this->db->prepare($insertQuery);
            $stmt->bindParam(':amount', $rentAmount, PDO::PARAM_STR);
            $stmt->bindParam(':reference_number', $referenceNumber, PDO::PARAM_STR);
            $stmt->bindParam(':booking_id', $bookingId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return [
                    'status' => 'success',
                    'message' => 'Payment recorded successfully.',
                    'redirect_url' => 'rent.php'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to record payment. Please try again.'
                ];
            }
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Database error: ' . $e->getMessage()
            ];
        }
    }
}

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $controller = new RentController();

    $bookingId = $_POST['booking_id'] ?? null;
    $dueMonth = $_POST['due_month'] ?? null;
    $rentAmount = $_POST['rent_amount'] ?? null;
    $referenceNumber = $_POST['reference'] ?? null;

    if ($bookingId && $dueMonth && $rentAmount && $referenceNumber) {
        $response = $controller->addTransaction($bookingId, $dueMonth, $rentAmount, $referenceNumber);
        echo json_encode($response);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid data. Please provide all required fields.'
        ]);
    }
}
