<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['taskId']) && isset($_POST['taskId1'])) {
    $taskId = $_POST['taskId'];
    $taskId1 = $_POST['taskId1'];
    $usql = "UPDATE `inbounddetails` SET `confirm`='1' WHERE skucode = '$taskId1' AND  inboundid = '$taskId'";
    $uresult = $con->query($usql);

    $sql2 = "SELECT * FROM inbounddetails WHERE skucode = '$taskId1' AND  inboundid = '$taskId'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $response = array(
        'confirm2' => $row2['confirm']
    );

    echo json_encode($response);
}
?>