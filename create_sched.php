<?php
require 'config.php'; // Database connection

session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["submit"])) {
    $user_id = $_POST["user_id"];
    $event_title = mysqli_real_escape_string($conn, $_POST["event_title"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $event_date = $_POST["event_date"];
    $event_time = $_POST["event_time"];
    $event_location = mysqli_real_escape_string($conn, $_POST["event_location"]);

    // Insert event details into sched table
    $query = "INSERT INTO `sched` (user_id, event_title, description, event_date, event_time, event_location)
              VALUES ('$user_id', '$event_title', '$description', '$event_date', '$event_time', '$event_location')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Event created successfully!'); window.location.href = 'homepage.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>
