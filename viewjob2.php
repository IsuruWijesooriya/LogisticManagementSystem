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
    <link rel="stylesheet" href="style/table.css">
    <link rel="icon" type="image/x-icon" href="src/favicon.ico">
    <title>Hayleys Tracking System</title>
</head>

<body>
    <div style="background: #A7A7A7;">
        <header class="font"><center><b>Warehouse Tracking System</center></b></header>
        <center><button class="button" onclick="window.location.href='logout.php'"><b>Logout</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <center>
    <div class="popup-content"  style="min-width: 500px;">
    <div class="container" style="background: white">
        <div class="box form-box">
        <header><center>Job Details</center></header>
            <form action="" method="post">
                <div class="field input">
                    <label for="id"><b><pre>ID</pre></b></label>
                    <input type="text" name="id" id="id" readonly>
                </div>

                <div class="field input">
                    <label for="description"><b><pre>Description</pre></b></label>
                    <textarea name="description" id="description" style="height:100px;" readonly></textarea>
                </div>

                <div class="field input">
                    <label for="date"><b><pre>Created Date</pre></b></label>
                    <input type="date" name="date" id="date"readonly>
                </div>

                <div class="field input">
                    <label for="time"><b><pre>Created Time</pre></b></label>
                    <input type="time" name="time" id="time"readonly>
                </div>

                <div class="field input">
                    <label for="atime"><b><pre>Accepted Time</pre></b></label>
                    <input type="time" name="atime" id="atime"readonly>
                </div>

                <div class="field input">
                    <label for="ftime"><b><pre>Finished Time</pre></b></label>
                    <input type="time" name="ftime" id="ftime"readonly>
                </div>

                <div class="field input">
                    <label for="name"><b><pre>Employee Name</pre></b></label>
                    <input type="text" name="name" id="name" readonly>
                </div>

                <div class="field input">
                    <label for="number"><b><pre>Mobile Number</pre></b></label>
                    <input type="text" name="number" id="number" readonly>
                </div>

                <div class="field input">
                    <label for="admin"><b><pre>Posted By</pre></b></label>
                    <input type="text" name="admin" id="admin" readonly>
                </div>

            </form>
        </div>
    </div>
    </div>
    <?php
    $id3 = $_GET['id'];
    echo '<script>';
    echo 'document.getElementById("id").value = "' . $id3 . '";';
    echo '</script>';
    $s="SELECT * FROM shipping WHERE id='$id3'";
    $result3 = $con->query($s);
    $row3 = $result3->fetch_assoc();

    $description = $row3['description'];
    echo '<script>';
    echo 'document.getElementById("description").value = "' . $description . '";';
    echo '</script>';

    $cdate = $row3['date'];
    echo '<script>';
    echo 'document.getElementById("date").value = "' . $cdate . '";';
    echo '</script>';

    $ctime = $row3['time'];
    echo '<script>';
    echo 'document.getElementById("time").value = "' . $ctime . '";';
    echo '</script>';

    $stime = $row3['starttime'];
    echo '<script>';
    echo 'document.getElementById("atime").value = "' . $stime . '";';
    echo '</script>';

    $etime = $row3['endtime'];
    echo '<script>';
    echo 'document.getElementById("ftime").value = "' . $etime . '";';
    echo '</script>';

    $user = $row3['user'];

    if($user == "Currently Unavailable"){
        echo '<script>';
        echo 'document.getElementById("name").value = "' . $user . '";';
        echo 'document.getElementById("number").value = "' . $user . '";';
        echo '</script>';
    }else{
    $s1="SELECT * FROM users WHERE fullname='$user'";
    $result1 = $con->query($s1);
    $row1 = $result1->fetch_assoc();

    $fname = $row1['fullname'];
    echo '<script>';
    echo 'document.getElementById("name").value = "' . $fname . '";';
    echo '</script>';

    $number = $row1['number'];
    echo '<script>';
    echo 'document.getElementById("number").value = "' . $number . '";';
    echo '</script>';
    }

    $admin = $row3['admin'];
    $s2="SELECT * FROM users WHERE id='$admin'";
    $result2 = $con->query($s2);
    $row2 = $result2->fetch_assoc();

    $fname1 = $row2['fullname'];
    echo '<script>';
    echo 'document.getElementById("admin").value = "' . $fname1 . '";';
    echo '</script>';

    ?>
    </center>
    </main>
</body>