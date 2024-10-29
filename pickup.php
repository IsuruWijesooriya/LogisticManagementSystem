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
        &emsp;<button class="button" onclick="window.location.href='home.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <div class="container">
        <center><button class="bttn" id ="addinbound" style="background: #087E73;"><center><b>Add Pickup</b></center></button></center>
    </div>
    <div class="container">
        <center><button class="bttn" style="background: #087E0A;" onclick="window.location.href='viewpickup.php'"><center><b>View Pickup</b></center></button></center>
    </div>
    </main>
</body>

<div id="add" class="popup">
    <div class="popup-content"  style="min-width: 300px;">
    <div class="container" style="background: white">
        <div class="box form-box">
        <header><center>Add Pickup</center></header>
            <form action="" method="post" enctype="multipart/form-data">
                
                <div class="field input">
                    <label for="id"><b><pre>ID</pre></b></label>
                    <input type="text" name="id" id="id" readonly>
                </div>

                <?php
                $result1 = mysqli_query($con,"SELECT COUNT(id) as count FROM pickup");
                $row1 = mysqli_fetch_assoc($result1);
                $x = $row1['count'] + 1;
                echo '<script>';
                echo 'document.getElementById("id").value = "' . $x . '";';
                echo '</script>';
                ?>

                <div class="field input">
                    <label for="description"><b><pre>Description</pre></b></label>
                    <input type="text" name="description" id="description" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for=""><b><pre>Import (*.csv only)</pre></b></label>
                    <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Add">
                </div>
            </form>
        </div>
    </div>
    </div>   
</div>

<?php 
if(isset($_POST['submit'])){
    $id1 = trim($_POST['id']);
    $description = trim($_POST['description']);
    $csvFile = $_FILES['csvFile']['tmp_name'];
       
    $isValid = true;

    if($isValid){
      $insertSQL = "INSERT INTO `pickup`(`id`, `description`, `admin`) VALUES (?,?,?)";
      $stmt = $con->prepare($insertSQL);
      $stmt->bind_param("sss",$id1,$description,$id);
      $stmt->execute();
      $stmt->close();
    }

    if (!empty($csvFile) && is_uploaded_file($csvFile)) {
        $handle = fopen($csvFile, 'r');

        while (($data = fgetcsv($handle)) !== false) {
            $stmt = $con->prepare("INSERT INTO pickupdetails (pickupid, location, skucode, description, caseno, lotno, st, uom, orderqty, confqty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssss", $id1, $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8]);
            $stmt->execute();
            $stmt->close();
        }
        fclose($handle);
    } else {
        echo "Please select a valid CSV file.";
    }

    $delSQL = "DELETE FROM `pickupdetails` WHERE caseno = 'CASE NO'";
    $stmt = $con->prepare($delSQL);
    $stmt->execute();
    $stmt->close();

    echo '<script>alert("Pickup Added successfully.")</script>';
    echo '<script>window.location.href = "pickup.php";</script>';
}
?>

<script>
    addinbound.addEventListener("click", function () {
        add.classList.add("show");
    });
    window.addEventListener("click", function (event) {
        if (event.target == add) {
            add.classList.remove("show");
        }
    });
</script>