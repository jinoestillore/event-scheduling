<?php
include 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

// Retrieve user ID from session
$userId = $_SESSION['user_id'];

// Check if sched_id is provided
if (!isset($_GET['sched_id'])) {
    echo "No event ID provided.";
    exit;
}

$schedId = $_GET['sched_id'];

// Fetch the event details from the database
$query = "SELECT * FROM sched WHERE sched_id = ? AND user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $schedId, $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result->num_rows === 0) {
    echo "Event not found or you do not have permission to edit it.";
    exit;
}

$event = $result->fetch_assoc();

// Process form submission
if (isset($_POST["submit"])) {
    $eventTitle = mysqli_real_escape_string($conn, $_POST["event_title"]);
    $description = mysqli_real_escape_string($conn, $_POST["description"]);
    $eventDate = $_POST["event_date"];
    $eventTime = $_POST["event_time"];
    $eventLocation = mysqli_real_escape_string($conn, $_POST["event_location"]);

    // Update the event in the database
    $updateQuery = "UPDATE sched SET event_title = ?, description = ?, event_date = ?, event_time = ?, event_location = ? WHERE sched_id = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "sssssi", $eventTitle, $description, $eventDate, $eventTime, $eventLocation, $schedId);

    if (mysqli_stmt_execute($stmtUpdate)) {
        echo "<script>alert('Event updated successfully!'); window.location.href = 'homepage.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="set-scheds.css">
</head>
<body>
    <div class="form-container">
        <h1>Edit Schedule</h1>
        <form action="edit-schedule.php?sched_id=<?php echo $schedId; ?>" method="POST">
            <div class="form-group">
                <label for="event_title">Event Title:</label>
                <input type="text" id="event_title" name="event_title" value="<?php echo htmlspecialchars($event['event_title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars(stripslashes($event['description'])); ?></textarea>

            </div>

            <div class="form-group">
                <label for="event_date">Event Date:</label>
                <input type="date" id="event_date" name="event_date" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event_time">Event Time:</label>
                <input type="time" id="event_time" name="event_time" value="<?php echo htmlspecialchars($event['event_time']); ?>" required>
            </div>

            <div class="form-group"> 
                <label for="event_location">Event Location:</label>
                <input type="text" id="event_location" name="event_location" value="<?php echo htmlspecialchars($event['event_location']); ?>" required>
            </div class="form-group">

            <button type="submit" name="submit" class="update-btn">Update Event</button>
        </form>
        <br />
        <a href="profile.php" class="back-sched">Go back to the schedule</a>
    </div>
</body>
</html>
