<?php
require 'config.php';

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $email = $_POST["email"];

    // Handle file upload
    $profilePic = null;
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $uploadDir = 'uploads/'; // Directory where files will be uploaded
        $fileName = basename($_FILES['profile_pic']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        // Check if the file type is allowed
        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
                $profilePic = $fileName; // Store the file name to save in the database
            } else {
                echo "<script>alert('Error uploading the file.');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type. Please upload JPG, JPEG, PNG, or GIF files.');</script>";
        }
    }

    // Check for duplicate username or email
    $duplicate = mysqli_query($conn, "SELECT * FROM `users` WHERE username = '$username' OR email = '$email'");
    if (empty($username) || empty($email) || empty($password) || empty($cpassword)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
    } elseif (mysqli_num_rows($duplicate) > 0) {
        echo "<script>alert('Username or Email is already taken!'); window.history.back();</script>";
    } else {
        if ($password == $cpassword) {
            if (strlen($password) >= 9) {

                // Insert user data including profile picture path
                $query = "INSERT INTO `users` (username, password, email, profile_pic) VALUES ('$username', '$password', '$email', '$profilePic')";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['profile_pic'] = $profilePic;
                    echo "<script>alert('Registration Successful!'); window.location.href = 'login.php';</script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
                }
            } else {
                echo "<script>alert('Password should be at least 9 characters long!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Passwords do not match! Please re-enter.'); window.history.back();</script>";
        }
    }
}
?>
