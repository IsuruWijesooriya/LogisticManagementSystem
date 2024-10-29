<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);
$name = $row['fullname'];

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    date_default_timezone_set('UTC');
    $current_time_utc = new DateTime();
    $current_time_utc->setTimezone(new DateTimeZone('Asia/Kolkata'));
    $current_time = $current_time_utc->format('H:i:s');
    $updateQuery = "UPDATE shipping SET confirm = 'ongoing', starttime = '$current_time', user = '$name' WHERE id = $taskId";

    $con->query($updateQuery);

    echo "Task $taskId started successfully";
} else {
    echo "Invalid request";
}
?>
