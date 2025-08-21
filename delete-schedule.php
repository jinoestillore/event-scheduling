<?php
include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

// Check if sched_id is provided
if (!isset($_GET['sched_id'])) {
    echo "No event ID provided.";
    exit;
}

$schedId = $_GET['sched_id'];
$userId = $_SESSION['user_id']; // Get the logged-in user's ID

// Check if the event exists and belongs to the logged-in user
$query = "SELECT * FROM sched WHERE sched_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $schedId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// If the event is found
if ($result->num_rows === 1) {
    // Proceed with deleting the event
    $deleteQuery = "DELETE FROM sched WHERE sched_id = ? AND user_id = ?";
    $stmtDelete = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "ii", $schedId, $userId);

    if (mysqli_stmt_execute($stmtDelete)) {
        echo "<script>alert('Event deleted successfully!'); window.location.href = 'profile.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Event not found or you do not have permission to delete it.'); window.history.back();</script>";
}

mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtDelete);
mysqli_close($conn);
?>
