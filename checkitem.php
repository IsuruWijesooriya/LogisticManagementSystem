<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['taskId']) && isset($_POST['taskId1'])) {
    $taskId = $_POST['taskId'];
    $taskId1 = $_POST['taskId1'];

    $sql2 = "SELECT * FROM inbounddetails WHERE skucode = '$taskId1' AND  inboundid = '$taskId'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $response = array(
        'confirm2' => $row2['confirm'],
        'expqty2' => $row2['expqty'],
        'ap2' => $row2['ap'],
        'dm2' => $row2['dm'],
        'tolot2' => $row2['tolot'],
        'phyqty2' => $row2['phyqty'],
        'remark2' => $row2['remark']
    );

    echo json_encode($response);
}
?>