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
        &emsp;<button class="button" onclick="window.location.href='startedputaway.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <div style="overflow-x:auto; overflow-y:auto;">
    <center>
    <form action="" method="post">
        <div class="search">
            <label for="sku"><b>SKU Code:</b></label>
            <input type="text" name="sku" id="sku" autocomplete="off">&emsp;
            <button type="submit" class="button" name="search" id="search"><b>Search</b></button>&emsp;&emsp;&emsp;
            <button type="submit" class="button" name="end" id="end" style="background: #DA0C0C;"><b>End Task</b></button>
        </div>
    <br>

    <table id="table">
    <tr>
        <th>Location</th>
        <th>SKU Code</th>
        <th>Description</th>
        <th>Status</th>
    </tr>
    <?php
    if(isset($_POST['search'])){
    $sku = trim($_POST['sku']);
    $id3 = $_GET['id'];
    if (!empty($sku)) {
    $sql1 = "SELECT * FROM putawaydetails WHERE skucode = '$sku' AND  putawayid = '$id3'";
    $result1 = $con->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $location1 = $row1['location'];
        $skucode1 = $row1['skucode'];
        $description1 = $row1['description'];
        $lotno1 = $row1['lotno'];
        $st1 = $row1['st'];
        $uom1 = $row1['uom'];
        $expqty1 = $row1['expqty'];
        $confqty1 = $row1['confqty'];
        $sqty1 = $row1['sqty'];
        $cf1 = $row1['confirm'];
        ?>
        <tr>
        <td><?php echo $location1; ?></td>
        <td><?php echo $skucode1; ?></td>
        <td><?php echo $description1; ?></td>
        <td><button type="button" class="tbtn" id="<?php echo $skucode1; ?>" onclick="startTask(<?php echo $id3 . ', \'' . $skucode1 . '\''; ?>)">Start</button></td>
        </tr>
        <?php 
        if ($cf1 == 1) {
            ?>
            <script>
                document.getElementById("<?php echo $skucode1; ?>").style.backgroundColor = '#9f07b3';
                document.getElementById("<?php echo $skucode1; ?>").innerHTML = 'Started';
            </script>
        <?php

        }
        if ($confqty1 == $sqty1) {
            ?>
            <script>
                
                document.getElementById("<?php echo $skucode1; ?>").style.backgroundColor = '#13a109';
                document.getElementById("<?php echo $skucode1; ?>").innerHTML = 'Completed';
            </script>
        <?php
        }
        }
    }else {
    $id3 = $_GET['id'];
    $sql3 = "SELECT * FROM putawaydetails WHERE putawayid = '$id3'";
    $result3 = $con->query($sql3);
    while ($row3 = $result3->fetch_assoc()) {
        $location = $row3['location'];
        $skucode = $row3['skucode'];
        $description = $row3['description'];
        $lotno = $row3['lotno'];
        $st = $row3['st'];
        $uom = $row3['uom'];
        $expqty = $row3['expqty'];
        $confqty = $row3['confqty'];
        $sqty = $row3['sqty'];
    $cf = $row3['confirm'];
    ?>
    <tr>
    <td><?php echo $location; ?></td>
    <td><?php echo $skucode; ?></td>
    <td><?php echo $description; ?></td>
    <td><button type="button" class="tbtn" id="<?php echo $skucode; ?>" onclick="startTask(<?php echo $id3 . ', \'' . $skucode . '\''; ?>)">Start</button></td>
    </tr>
    <?php 
    if ($cf == 1) {
        ?>
        <script>
            document.getElementById("<?php echo $skucode; ?>").style.backgroundColor = '#9f07b3';
            document.getElementById("<?php echo $skucode; ?>").innerHTML = 'Started';
        </script>
        <?php
    }
    if ($confqty == $sqty) {
        ?>
        <script>
            document.getElementById("<?php echo $skucode; ?>").style.backgroundColor = '#13a109';
            document.getElementById("<?php echo $skucode; ?>").innerHTML = 'Completed';
        </script>
    <?php
    }
    }
    }
    }
    ?>
    </table>
    </form>
    </center>
    </div>
    </main>
</body>
    <div id="view" class="popup">
    <div class="popup-content"  style="min-width: 300px;">
    <div class="container" style="background: white">
        <div class="box form-box">
        <header><center>Check Item</center></header>
            <form action="" method="post">
                <div class="field">
                <input type="button" class="btn" name="confirm" id="confirm" value="Confirm SKU" onclick="confirmSKU(<?php echo $id3; ?>)">
                </div>

                <div class="field input">
                    <label for="skucode"><b><pre>SKU Code</pre></b></label>
                    <input type="text" name="skucode" id="skucode" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="expqty"><b><pre>Expected QTY</pre></b></label>
                    <input type="text" name="expqty" id="expqty" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="confqty"><b><pre>Confirmed QTY</pre></b></label>
                    <input type="text" name="confqty" id="confqty" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="sqty"><b><pre>Stored QTY</pre></b></label>
                    <input type="text" name="sqty" id="sqty" autocomplete="off" readonly>
                <center>
                <div style="display: inline;">
                    <input type="button" class="btn" name="minus" id="minus" value="-" style="width: 40%;" onclick="minus3(<?php echo $id3; ?>)">
                    <input type="button" class="btn" name="plus" id="plus" value="+"  style="width: 40%;" onclick="plus3(<?php echo $id3; ?>)">
                </div>
                </center>
                </div>

                <div class="field input">
                    <label for="lotno"><b><pre>Lot No</pre></b></label>
                    <input type="text" name="lotno" id="lotno" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="st"><b><pre>Status</pre></b></label>
                    <input type="text" name="st" id="st" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="uom"><b><pre>UOM</pre></b></label>
                    <input type="text" name="uom" id="uom" autocomplete="off" readonly>
                </div>
            </form>
        </div>
    <script>
    function confirmSKU(id) {
        var skuCode = document.getElementById('skucode').value;
        confirm(id,skuCode);
    }
    function confirm(id,id3) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "confirma.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var confirm2 = jsonResponse.confirm2;
                if (confirm2 == 0) {
                document.getElementById("confirm").style.backgroundColor = 'rgba(76,68,182,0.808)';
                }else{
                document.getElementById("confirm").style.backgroundColor = '#13a109';
                document.getElementById(id3).style.backgroundColor = '#9f07b3';
                document.getElementById(id3).innerHTML = 'Started';
                }
            }
        };
        xhr.send("taskId=" + id + "&taskId1=" + id3);
    }
    </script>
    
    <script>
    function plus3(id2) {
        var skuCode = document.getElementById('skucode').value;
        plus(id2,skuCode);
    }
    function plus(id2,id4) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "plusa.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var sqty2 = jsonResponse.sqty2;
                document.getElementById("sqty").value = sqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>
    <script>
    function minus3(id2) {
        var skuCode = document.getElementById('skucode').value;
        minus(id2,skuCode);
    }
    function minus(id2,id4) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "minusa.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var sqty2 = jsonResponse.sqty2;
                document.getElementById("sqty").value = sqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>

    </div>
    </div>   
    </div>

    <?php
    if(isset($_POST['end'])){
        date_default_timezone_set('UTC');
        $current_time_utc = new DateTime();
        $current_time_utc->setTimezone(new DateTimeZone('Asia/Kolkata'));
        $current_time = $current_time_utc->format('H:i:s');
        $id3 = $_GET['id'];
        $usql = "UPDATE `putaway` SET `confirm`='finished',`endtime`='$current_time' WHERE id = '$id3'";
        $uresult = $con->query($usql);
        echo "<script>window.location.href='putaway1.php'</script>";
    }
    ?>

    <script>
    function startTask(id, id1) {
    var view = document.getElementById("view");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkitema.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                
                var confirm2 = jsonResponse.confirm2;
                var expqty2 = jsonResponse.expqty2;
                var sqty2 = jsonResponse.sqty2;
                var lotno2 = jsonResponse.lotno2;
                var st2 = jsonResponse.st2;
                var uom2 = jsonResponse.uom2;
                var confqty2 = jsonResponse.confqty2;
                
                var currentSkucode = id1;

                document.getElementById("skucode").value = id1;
                document.getElementById("expqty").value = expqty2;
                document.getElementById("sqty").value = sqty2;
                document.getElementById("lotno").value = lotno2;
                document.getElementById("st").value = st2;
                document.getElementById("uom").value = uom2;
                document.getElementById("confqty").value = confqty2;
                if (confirm2 == 0) {
                document.getElementById("confirm").style.backgroundColor = 'rgba(76,68,182,0.808)';
                }else{
                document.getElementById("confirm").style.backgroundColor = '#13a109';
                document.getElementById(id1).style.backgroundColor = '#9f07b3';
                document.getElementById(id1).innerHTML = 'Started';
                }

        }
    };
    xhr.send("taskId=" + id + "&taskId1=" + id1);
    view.classList.add("show");
    }
    window.addEventListener("click", function (event) {
        if (event.target == view) {
            view.classList.remove("show");
        }
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var table = document.getElementById("table");

        if (table.rows.length === 1) {
            reloadFunction();
        }
    });

    function reloadFunction() {
        document.getElementById("search").click();
    }
    </script>