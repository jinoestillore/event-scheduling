<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id']; // Get user_id from session (assuming you store user_id in session)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Schedule</title>
    <link rel="stylesheet" href="set-scheds.css">
</head>
<body>
    <div class="form-container">
        <a class="go-back" href="profile.php">&LongLeftArrow; Go back</a>
        <h1>Add Schedule</h1>
        <form action="create_sched.php" method="POST" class="form-box">
            <div class="form-group">
                <label for="event_title">Event Title:</label>
                <input type="text" id="event_title" name="event_title" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" required>
            </div>

            <div class="form-group">
                <label for="event_time">Event Time:</label>
                <input type="time" id="event_time" name="event_time" required>
            </div>

            <div class="form-group">
                <label for="event_location">Event Location:</label>
                <input type="text" id="event_location" name="event_location" required>
            </div>

            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <button type="submit" name="submit" class="submit-btn">Create Event</button>
        </form>
    </div>
</body>
</html>
