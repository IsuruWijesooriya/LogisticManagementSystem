<?php 
   session_start();

   include("db.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
   $id = $_SESSION['id'];
   $result = mysqli_query($con,"SELECT * FROM users WHERE id='$id'") or die("Select Error");
   $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/inbound.css">
    <link rel="icon" type="image/x-icon" href="src/favicon.ico">
    <title>Hayleys Tracking System</title>
</head>

<body>
    <div style="background: #A7A7A7;">
        <header class="font"><center><b>Warehouse Tracking System</center></b></header>
        <center><button class="button" onclick="window.location.href='logout.php'"><b>Logout</b></button>
        &emsp;<button class="button" onclick="window.location.href='home1.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <div class="container">
        <center><button class="bttn" style="background: #087E73;" onclick="window.location.href='startedshippings.php'"><center><b>Started Shipping</b></center></button></center>
    </div>
    <div class="container">
        <center><button class="bttn" style="background: #087E0A;" onclick="window.location.href='newshippings.php'"><center><b>New Shippings</b></center></button></center>
    </div>
    </main>
</body>