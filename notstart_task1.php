<?php
include("db.php");

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    $updateQuery = "UPDATE shipping SET confirm = 'unbegun', starttime = '00:00:00', user = 'Currently Unavailable' WHERE id = $taskId";
    $con->query($updateQuery);

    echo "Task $taskId Closed successfully";
} else {
    echo "Invalid request";
}
?>
