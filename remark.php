<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['taskId']) && isset($_POST['taskId1'])) {
    $taskId = $_POST['taskId'];
    $taskId1 = $_POST['taskId1'];
    $taskId2 = $_POST['taskId2'];

    $usql = "UPDATE `inbounddetails` SET `remark`='$taskId2' WHERE skucode = '$taskId1' AND inboundid = '$taskId'";
    $uresult = $con->query($usql);
    $sql3 = "SELECT * FROM inbounddetails WHERE skucode = '$taskId1' AND  inboundid = '$taskId'";
    $result3 = $con->query($sql3);
    $row3 = $result3->fetch_assoc();
    $response = array(
        'remark2' => $row3['remark']
    );

    echo json_encode($response);
}
?>