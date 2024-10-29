<?php
session_start();
include("db.php");
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['taskId']) && isset($_POST['taskId1'])) {
    $taskId = $_POST['taskId'];
    $taskId1 = $_POST['taskId1'];

    $sql2 = "SELECT * FROM putawaydetails WHERE skucode = '$taskId1' AND  putawayid = '$taskId'";
    $result2 = $con->query($sql2);
    $row2 = $result2->fetch_assoc();
    $response = array(
        'confirm2' => $row2['confirm'],
        'expqty2' => $row2['expqty'],
        'sqty2' => $row2['sqty'],
        'confqty2' => $row2['confqty'],
        'lotno2' => $row2['lotno'],
        'st2' => $row2['st'],
        'uom2' => $row2['uom']
    );

    echo json_encode($response);
}
?>