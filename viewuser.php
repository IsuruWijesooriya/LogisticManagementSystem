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
    <link rel="stylesheet" href="style/users.css">
    <link rel="stylesheet" href="style/table.css">
    <link rel="stylesheet" href="style/radio.css">
    <link rel="icon" type="image/x-icon" href="src/favicon.ico">
    <title>Hayleys Tracking System</title>
</head>

<body>
    <div style="background: #A7A7A7;">
        <header class="font"><center><b>Warehouse Tracking System</center></b></header>
        <center><button class="button" onclick="window.location.href='logout.php'"><b>Logout</b></button>
        &emsp;<button class="button" onclick="window.location.href='users.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <header class="head"><center>View Users</center></header>
    <br>
    <main>
    <div style="overflow-x:auto; overflow-y:auto;">
    <form action="" enctype="multipart/form-data" method="post">
        <center>
        <div class="radio-container">
        <label for="radioButton1" value="1">
        <input type="radio" name="p" id="radioButton1" checked>
        <strong>Admins</strong>
        </label>

        <label for="radioButton2" value="2">
        <input type="radio" name="p" id="radioButton2">
        <strong>Users</strong>
        </label>

        </div>

        <div class="admin" id="admin">
        <table id="table">
            <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Date Of Birth</th>
            <th>Mobile Number</th>
            <th>Address</th>
            </tr>
            <?php
            $s="SELECT * FROM users WHERE privilege='Admin'";
            $result3 = $con->query($s);
            while($row3 = $result3->fetch_assoc()){
                $id1 = $row3['id'];
                $fullname = $row3['fullname'];
                $dob = $row3['dob'];
                $number = $row3['number'];
                $address = $row3['address'];
                echo "<tr>";
                echo "<td>$id1</td>";
                echo "<td>$fullname</td>";
                echo "<td>$dob</td>";
                echo "<td>$number</td>";
                echo "<td>$address</td>";
                echo "</tr>";
            }
            ?>
        </table>
        </div>
        <div class="user" id="user">
        <table id="table">
            <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Date Of Birth</th>
            <th>Mobile Number</th>
            <th>Address</th>
            </tr>
            <?php
            $s1="SELECT * FROM users WHERE privilege='User'";
            $result1 = $con->query($s1);
            while($row1 = $result1->fetch_assoc()){
                $id2 = $row1['id'];
                $fullname2 = $row1['fullname'];
                $dob2 = $row1['dob'];
                $number2 = $row1['number'];
                $address2 = $row1['address'];
                echo "<tr>";
                echo "<td>$id2</td>";
                echo "<td>$fullname2</td>";
                echo "<td>$dob2</td>";
                echo "<td>$number2</td>";
                echo "<td>$address2</td>";
                echo "</tr>";
            }
            ?>
        </table>
        </div>
        </center>
    </form>
    </div>
    </main>
</body>

<script>
var radioButton1 = document.getElementById("radioButton1");
var radioButton2 = document.getElementById("radioButton2");
var admin = document.getElementById("admin");
var user = document.getElementById("user");

function showDetailsBasedOnRadioState() {
  if (radioButton1.checked) {
    user.style.display = "none";
    admin.style.display = "block";
  } else if (radioButton2.checked) {
    user.style.display = "block";
    admin.style.display = "none";
  }
}

setInterval(showDetailsBasedOnRadioState, 100);

</script>