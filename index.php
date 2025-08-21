<?php

include 'config.php';

session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

// Retrieve the username and profile picture from the session
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
$profilePic = isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'default.jpg';

$userId = $_SESSION['user_id']; // Assume user ID is stored in the session
$query = "SELECT * FROM sched WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Scheduler</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <header class="header">
     <h1>Plan Scheduler</h1>
        <nav class="nav">
          <ul>
            <li><a href="#" style="color: black; text-shadow: 1px 1px 3px violet">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </nav>
    </header>

    <section class="introduction">
      <div class="opening">
        <div class="animatedTyping">
          <h1 class="title">Organize Your Plans Easily</h1>
        </div>
         <p style="font-weight: bold;">Welcome to Plan Scheduler</p>
         <p class="subtitle" style="font-size: 20px; font-style: italic; margin-top:3px;">Create, organize, and manage your plans with ease.</p>

         <p class="second-sub" style="font-size: 17px; margin: 130px 0 9px 0;">Keep track of every detail, all in one place.</p>
         <a href="profile.php" class="cta">Get Started</a>
      </div>
    </section>

   
    
</body>
</html>