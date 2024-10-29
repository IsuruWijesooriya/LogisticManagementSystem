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
    <link rel="stylesheet" href="style/home.css">
    <link rel="icon" type="image/x-icon" href="src/favicon.ico">
    <title>Hayleys Tracking System</title>
</head>

<body>
    <div style="background: #A7A7A7;">
        <header class="font"><center><b>Warehouse Tracking System</center></b></header>
        <center><button class="button" onclick="window.location.href='logout.php'"><b>Logout</b></button></center><br>
    </div>
    <br>
    <main>
    <div class="container">
        <button class="btn" style="background: #7E0808;" onclick="window.location.href='inbound1.php'"><center><b>Inbound</b></center></button>
    </div>
    <div class="container">
        <button class="btn" style="background: #7E5108;" onclick="window.location.href='putaway1.php'"><center><b>Put Away</b></center></button>
    </div>
    <div class="container">
        <button class="btn" style="background: #087E0C;" onclick="window.location.href='pickup1.php'"><center><b>Pickup</b></center></button>
    </div>
    <div class="container">
        <button class="btn" style="background: #080C7E;" onclick="window.location.href='shipping1.php'"><center><b>Shipping</b></center></button>
    </div>
    </main>
</body>