<?php
session_start();
require 'config.php'; // Database connection

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit;
}

if (isset($_POST['upload'])) {
    // Check if the user_id is set in the session
    if (!isset($_SESSION['user_id'])) {
        echo "User is not logged in.";
        exit;
    }
    
    $userId = $_SESSION['user_id']; // Get user ID from session
    $uploadDir = 'uploads/'; // Directory to store profile pictures
    $fileName = basename($_FILES['profile_pic']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow only certain file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
            // Use a prepared statement to safely update the profile picture
            $query = "UPDATE users SET profile_pic = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $fileName, $userId); // Bind parameters (string for file name, int for user_id)
                if (mysqli_stmt_execute($stmt)) {
                    $_SESSION['profile_pic'] = $fileName; // Update session variable
                    echo "Profile picture updated successfully!";
                } else {
                    echo "Error executing the query: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing the query: " . mysqli_error($conn);
            }
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type. Please upload JPG, JPEG, PNG, or GIF files.";
    }
}
?>
