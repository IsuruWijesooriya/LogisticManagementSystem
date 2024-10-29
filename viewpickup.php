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
        &emsp;<button class="button" onclick="window.location.href='pickup.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <div class="container">
        <button class="bttn" style="background: #086A7E;" onclick="window.location.href='ongoingp.php'"><center><b>Ongoing Pickup</b></center></button>
    </div>
    <div class="container">
    <button class="bttn" style="background: #7E0808;" onclick="window.location.href='unbegunp.php'"><center><b>Unbegun Pickup</b></center></button>
    </div>
    <div class="container">
    <button class="bttn" style="background: #0A7E08;" onclick="window.location.href='finishedp.php'"><center><b>Finished Pickup</b></center></button>
    </div>
    </main>
</body>