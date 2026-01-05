<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$therapist_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($therapist_id > 0) {
    $sql = "DELETE FROM therapists WHERE id = $therapist_id";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Therapist deleted successfully!";
    } else {
        $error_message = "Error deleting therapist: " . $conn->error;
    }
} else {
    $error_message = "Invalid therapist ID.";
}

$conn->close();


$status = isset($success_message) ? "success" : "error";
$message = isset($success_message) ? $success_message : $error_message;
header("Location: admin.php?status=$status&message=" . urlencode($message));
exit();
?>