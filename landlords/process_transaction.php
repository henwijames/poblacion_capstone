<?php
session_start();
require_once '../Controllers/Database.php';
require '../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable('D:\xampp\htdocs\Poblacion');
try {
    $dotenv->load();
} catch (Exception $e) {
    die('Failed to load .env file: ' . $e->getMessage());
}

$database = new Database();
$db = $database->getConnection();

$action = $_POST['action'] ?? null;
$transaction_id = $_POST['transaction_id'] ?? null;

if ($action && $transaction_id) {
    // Determine new transaction status
    $status = $action === 'verify' ? 'completed' : 'declined';

    try {
        // Begin transaction
        $db->beginTransaction();

        // Update transaction status
        $query = "UPDATE transactions SET transaction_status = :status WHERE transaction_id = :transaction_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':transaction_id', $transaction_id);
        $stmt->execute();

        // Only update rent's due_month if action is 'verify'
        if ($action === 'verify') {
            // Fetch the listing_id and user_id from the transaction
            $transactionQuery = "SELECT listing_id, user_id FROM transactions WHERE transaction_id = :transaction_id";
            $transactionStmt = $db->prepare($transactionQuery);
            $transactionStmt->bindParam(':transaction_id', $transaction_id);
            $transactionStmt->execute();
            $transaction = $transactionStmt->fetch(PDO::FETCH_ASSOC);

            if ($transaction) {
                $listing_id = $transaction['listing_id'];
                $tenant_id = $transaction['user_id'];

                // Fetch the rent details based on listing_id and tenant_id
                $rentQuery = "SELECT rent_date, due_month FROM rent WHERE listing_id = :listing_id AND user_id = :tenant_id";
                $rentStmt = $db->prepare($rentQuery);
                $rentStmt->bindParam(':listing_id', $listing_id);
                $rentStmt->bindParam(':tenant_id', $tenant_id);
                $rentStmt->execute();
                $rent = $rentStmt->fetch(PDO::FETCH_ASSOC);

                if ($rent) {
                    $rent_date = $rent['rent_date'];
                    $due_month = $rent['due_month'];

                    // If due_month is NULL, set it to rent_date + 1 month
                    if ($due_month === null) {
                        $new_due_month = date('Y-m-d', strtotime("+1 month", strtotime($rent_date)));
                    } else {
                        // If due_month is not NULL, add 1 month to it
                        $new_due_month = date('Y-m-d', strtotime("+1 month", strtotime($due_month)));
                    }

                    // Update rent table with the new due_month
                    $updateRentQuery = "UPDATE rent SET due_month = :new_due_month WHERE listing_id = :listing_id AND user_id = :tenant_id";
                    $updateRentStmt = $db->prepare($updateRentQuery);
                    $updateRentStmt->bindParam(':new_due_month', $new_due_month);
                    $updateRentStmt->bindParam(':listing_id', $listing_id);
                    $updateRentStmt->bindParam(':tenant_id', $tenant_id);
                    $updateRentStmt->execute();
                }
            }
        }

        // Commit transaction
        $db->commit();
        $_SESSION['success_message'] = "Transaction has been $status successfully.";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $db->rollBack();
        $_SESSION['error_message'] = "Failed to update transaction: " . $e->getMessage();
    }
}

header('Location: tenants');
exit();
