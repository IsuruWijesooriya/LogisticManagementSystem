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
        &emsp;<button class="button" onclick="window.location.href='startedshippings.php'"><b>Back</b></button>
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
        <th>Issue NO</th>
        <th>SKU Code</th>
        <th>Customer Code</th>
        <th>Status</th>
    </tr>
    <?php
    if(isset($_POST['search'])){
    $sku = trim($_POST['sku']);
    $id3 = $_GET['id'];
    if (!empty($sku)) {
    $sql1 = "SELECT * FROM shippingdetails WHERE skucode = '$sku' AND  shippingid = '$id3'";
    $result1 = $con->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $issdate1 = $row1['issdate'];
        $skucode1 = $row1['skucode'];
        $issno1 = $row1['issno'];
        $reclsstypecode1 = $row1['reclsstypecode'];
        $custcode1 = $row1['custcode'];
        $prodstatuscode1 = $row1['prodstatuscode'];
        $locationcode1 = $row1['locationcode'];
        $orderqty1 = $row1['orderqty'];
        $rqty1 = $row1['rqty'];
        $cf1 = $row1['confirm'];
        ?>
        <tr>
        <td><?php echo $issno1; ?></td>
        <td><?php echo $skucode1; ?></td>
        <td><?php echo $custcode1; ?></td>
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
        if ($orderqty1 == $rqty1) {
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
    $sql3 = "SELECT * FROM shippingdetails WHERE shippingid = '$id3'";
    $result3 = $con->query($sql3);
    while ($row3 = $result3->fetch_assoc()) {
    $issdate = $row3['issdate'];
    $skucode = $row3['skucode'];
    $issno = $row3['issno'];
    $reclsstypecode = $row3['reclsstypecode'];
    $custcode = $row3['custcode'];
    $prodstatuscode = $row3['prodstatuscode'];
    $locationcode = $row3['locationcode'];
    $orderqty = $row3['orderqty'];
    $rqty = $row3['rqty'];
    $cf = $row3['confirm'];
    ?>
    <tr>
    <td><?php echo $issno; ?></td>
    <td><?php echo $skucode; ?></td>
    <td><?php echo $custcode; ?></td>
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
    if ($orderqty == $rqty) {
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
                    <label for="odrqty"><b><pre>Ordered QTY</pre></b></label>
                    <input type="text" name="odrqty" id="odrqty" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="rqty"><b><pre>Recieved QTY</pre></b></label>
                    <input type="text" name="rqty" id="rqty" autocomplete="off" readonly>
                <center>
                <div style="display: inline;">
                    <input type="button" class="btn" name="minus" id="minus" value="-" style="width: 40%;" onclick="minus3(<?php echo $id3; ?>)">
                    <input type="button" class="btn" name="plus" id="plus" value="+"  style="width: 40%;" onclick="plus3(<?php echo $id3; ?>)">
                </div>
                </center>
                </div>
                
                <div class="field input">
                    <label for="locationcode"><b><pre>Location Code</pre></b></label>
                    <textarea type="text" name="locationcode" id="locationcode" autocomplete="off" onclick="remark1(<?php echo $id3; ?>)" style="height: 80px"></textarea>
                </div>

                <div class="field input">
                    <label for="reclsstypecode"><b><pre>Re Class Type Code</pre></b></label>
                    <input type="text" name="reclsstypecode" id="reclsstypecode" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="prodstatuscode"><b><pre>Product Status Code</pre></b></label>
                    <input type="text" name="prodstatuscode" id="prodstatuscode" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="issdate"><b><pre>Issued Date</pre></b></label>
                    <input type="text" name="issdate" id="issdate" autocomplete="off" readonly>
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
        xhr.open("POST", "confirms.php", true);
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
        xhr.open("POST", "pluss.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var rqty2 = jsonResponse.rqty2;
                document.getElementById("rqty").value = rqty2;
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
        xhr.open("POST", "minuss.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var rqty2 = jsonResponse.rqty2;
                document.getElementById("rqty").value = rqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>
    <script>
    function remark1(id2) {
    document.getElementById('locationcode').addEventListener('input', function() {
        var skuCode = document.getElementById('skucode').value;
        var remarktext = document.getElementById('locationcode').value;
        remark(id2,skuCode,remarktext);
    });
    }
    function remark(id2,id4,id6) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "locationcode.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var locationcode2 = jsonResponse.locationcode2;
                document.getElementById("locationcode").value = locationcode2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4 + "&taskId2=" + id6);
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
        $usql = "UPDATE `shipping` SET `confirm`='finished',`endtime`='$current_time' WHERE id = '$id3'";
        $uresult = $con->query($usql);
        echo "<script>window.location.href='shipping1.php'</script>";
    }
    ?>

    <script>
    function startTask(id, id1) {
    var view = document.getElementById("view");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkitems.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                
                var confirm2 = jsonResponse.confirm2;
                var odrqty2 = jsonResponse.odrqty2;
                var issdate2 = jsonResponse.issdate2;
                var reclsstypecode2 = jsonResponse.reclsstypecode2;
                var locationcode2 = jsonResponse.locationcode2;
                var rqty2 = jsonResponse.rqty2;
                var prodstatuscode2 = jsonResponse.prodstatuscode2;
                
                var currentSkucode = id1;

                document.getElementById("skucode").value = id1;
                document.getElementById("odrqty").value = odrqty2;
                document.getElementById("issdate").value = issdate2;
                document.getElementById("reclsstypecode").value = reclsstypecode2;
                document.getElementById("locationcode").value = locationcode2;
                document.getElementById("rqty").value = rqty2;
                document.getElementById("prodstatuscode").value = prodstatuscode2;
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