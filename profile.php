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
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Email not found';

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
    <title>Profile Information</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <header class="header">
        <h1>Plan Scheduler</h1>
        <nav class="nav">
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="#" style="color: black; text-shadow: 1px 1px 3px violet">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="main-container">
        <div class="profile-section">
            <h1>PROFILE INFORMATION</h1>
            <img src="uploads/<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" class="profile-pic">
            <p class="title">Username: <?php echo $username; ?></p>
            <p class="title">Email: <?php echo $email; ?></p></p>
        </div>

        <div class="schedule-section" id="scheduleSection">
        <div class="sched-box-row">
            <h2>Your Schedule</h2>
            <a href="set-schedules.php" class="set-sched">+ New Schedule</a>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <table class="plan-table">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                            <td><?php echo htmlspecialchars(stripslashes($row['description'])); ?></td>
                            <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_time']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_location']); ?></td>
                            <td class="action-btn">
                                <a href="edit-schedule.php?sched_id=<?php echo $row['sched_id']; ?>" class="edit-button">Edit</a>
                                <a href="delete-schedule.php?sched_id=<?php echo $row['sched_id']; ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this schedule?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No events found. <a href="set-schedule.php">Add an event</a>.</p>
        <?php endif; ?>
    </div>
    </div>
</body>
</html>
