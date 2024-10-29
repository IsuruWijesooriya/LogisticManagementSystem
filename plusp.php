<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['taskId']) && isset($_POST['taskId1'])) {
    $taskId = $_POST['taskId'];
    $taskId1 = $_POST['taskId1'];

    $sql2 = "SELECT * FROM pickupdetails WHERE skucode = '$taskId1' AND  pickupid = '$taskId'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $ap5 = $row2['pqty'];
    $apn = $ap5 +1;
    $usql = "UPDATE `pickupdetails` SET `pqty`='$apn' WHERE skucode = '$taskId1' AND pickupid = '$taskId'";
    $uresult = $con->query($usql);
    $sql3 = "SELECT * FROM pickupdetails WHERE skucode = '$taskId1' AND  pickupid = '$taskId'";
    $result3 = $con->query($sql3);
    $row3 = $result3->fetch_assoc();
    $response = array(
        'pqty2' => $row3['pqty']
    );

    echo json_encode($response);
}
?>