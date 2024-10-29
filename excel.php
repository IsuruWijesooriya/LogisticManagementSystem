<?php
session_start();

include("db.php");
if(!isset($_SESSION['valid'])){
 header("Location: index.php");
}
$id = $_SESSION['id'];
$result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'") or die("Select Error");
$row = mysqli_fetch_assoc($result);

$id3 = $_GET['id'];

$selectedColumns = array('recno', 'skucode', 'name', 'expqty', 'ap', 'dm', 'tolot', 'phyqty', 'remark');

$sql1 = "SELECT " . implode(", ", $selectedColumns) . " FROM inbounddetails WHERE inboundid='$id3'";

$result1 = $con->query($sql1);

$csvFile = fopen('php://temp', 'w');

fputcsv($csvFile, $selectedColumns);

while ($row1 = $result1->fetch_assoc()) {
    $rowData = array();
    foreach ($selectedColumns as $columnName) {
        $rowData[] = $row1[$columnName];
    }
    fputcsv($csvFile, $rowData);
}

$result0 = mysqli_query($con,"SELECT * FROM inbound WHERE id='$id3'");
$row0 = mysqli_fetch_assoc($result0);
$des = $row0['description'];

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $des . ' Inbound.csv"');

rewind($csvFile);
fpassthru($csvFile);

fclose($csvFile);

$con->close();
?>