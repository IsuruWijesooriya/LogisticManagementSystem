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
        &emsp;<button class="button" onclick="window.location.href='startedinbounds.php'"><b>Back</b></button>
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
        <th>REC NO</th>
        <th>SKU Code</th>
        <th>Name</th>
        <th>Start</th>
    </tr>
    <?php
    if(isset($_POST['search'])){
    $sku = trim($_POST['sku']);
    $id3 = $_GET['id'];
    if (!empty($sku)) {
    $sql1 = "SELECT * FROM inbounddetails WHERE skucode = '$sku' AND  inboundid = '$id3'";
    $result1 = $con->query($sql1);
    while ($row1 = $result1->fetch_assoc()) {
        $recno1 = $row1['recno'];
        $skucode1 = $row1['skucode'];
        $name1 = $row1['name'];
        $expqty1 = $row1['expqty'];
        $ap1 = $row1['ap'];
        $dm1 = $row1['dm'];
        $tolot1 = $row1['tolot'];
        $phyqty1 = $row1['phyqty'];
        $remark1 = $row1['remark'];
        $cf1 = $row1['confirm'];
        ?>
        <tr>
        <td><?php echo $recno1; ?></td>
        <td><?php echo $skucode1; ?></td>
        <td><?php echo $name1; ?></td>
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
        if ($expqty1 == $phyqty1) {
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
    $sql3 = "SELECT * FROM inbounddetails WHERE inboundid = '$id3'";
    $result3 = $con->query($sql3);
    while ($row3 = $result3->fetch_assoc()) {
    $recno = $row3['recno'];
    $skucode = $row3['skucode'];
    $name = $row3['name'];
    $expqty = $row3['expqty'];
    $ap = $row3['ap'];
    $dm = $row3['dm'];
    $tolot = $row3['tolot'];
    $phyqty = $row3['phyqty'];
    $remark = $row3['remark'];
    $cf = $row3['confirm'];
    ?>
    <tr>
    <td><?php echo $recno; ?></td>
    <td><?php echo $skucode; ?></td>
    <td><?php echo $name; ?></td>
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
    if ($expqty == $phyqty) {
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
                    <label for="expqty"><b><pre>EXPECTED QTY</pre></b></label>
                    <input type="text" name="expqty" id="expqty" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="ap"><b><pre>APPROVED</pre></b></label>
                    <input type="text" name="ap" id="ap" autocomplete="off" readonly>
                <center>
                <div style="display: inline;">
                    <input type="button" class="btn" name="minus" id="minus" value="-" style="width: 40%;" onclick="minus3(<?php echo $id3; ?>)">
                    <input type="button" class="btn" name="plus" id="plus" value="+"  style="width: 40%;" onclick="plus3(<?php echo $id3; ?>)">
                </div>
                </center>
                </div>

                <div class="field input">
                    <label for="dm"><b><pre>DAMAGED</pre></b></label>
                    <input type="text" name="dm" id="dm" autocomplete="off" readonly>
                <center>
                <div style="display: inline;">
                    <input type="button" class="btn" name="minus1" id="minus1" value="-" style="width: 40%;" onclick="minus4(<?php echo $id3; ?>)">
                    <input type="button" class="btn" name="plus1" id="plus1" value="+"  style="width: 40%;" onclick="plus4(<?php echo $id3; ?>)">
                </div>
                </center>
                </div>

                <div class="field input">
                    <label for="phyqty"><b><pre>PHYSICAL QTY</pre></b></label>
                    <input type="text" name="phyqty" id="phyqty" autocomplete="off" readonly>
                </div>

                <div class="field input">
                    <label for="tolot"><b><pre>TO LOT</pre></b></label>
                    <textarea type="text" name="tolot" id="tolot" autocomplete="off" onclick="tolot1(<?php echo $id3; ?>)"></textarea>
                </div>

                <div class="field input">
                    <label for="remark"><b><pre>Remark</pre></b></label>
                    <textarea type="text" name="remark" id="remark" autocomplete="off" onclick="remark1(<?php echo $id3; ?>)" style="height: 80px"></textarea>
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
        xhr.open("POST", "confirm.php", true);
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
        xhr.open("POST", "plus.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var ap2 = jsonResponse.ap2;
                document.getElementById("ap").value = ap2;
                var phyqty2 = jsonResponse.phyqty2;
                document.getElementById("phyqty").value = phyqty2;
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
        xhr.open("POST", "minus.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var ap2 = jsonResponse.ap2;
                document.getElementById("ap").value = ap2;
                var phyqty2 = jsonResponse.phyqty2;
                document.getElementById("phyqty").value = phyqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>
    <script>
    function plus4(id2) {
        var skuCode = document.getElementById('skucode').value;
        plus1(id2,skuCode);
    }
    function plus1(id2,id4) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "plus1.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var dm2 = jsonResponse.dm2;
                document.getElementById("dm").value = dm2;
                var phyqty2 = jsonResponse.phyqty2;
                document.getElementById("phyqty").value = phyqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>
    <script>
    function minus4(id2) {
        var skuCode = document.getElementById('skucode').value;
        minus1(id2,skuCode);
    }
    function minus1(id2,id4) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "minus1.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var dm2 = jsonResponse.dm2;
                document.getElementById("dm").value = dm2;
                var phyqty2 = jsonResponse.phyqty2;
                document.getElementById("phyqty").value = phyqty2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4);
    }
    </script>
    <script>
    function remark1(id2) {
    document.getElementById('remark').addEventListener('input', function() {
        var skuCode = document.getElementById('skucode').value;
        var remarktext = document.getElementById('remark').value;
        remark(id2,skuCode,remarktext);
    });
    }
    function remark(id2,id4,id6) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "remark.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var remark2 = jsonResponse.remark2;
                document.getElementById("remark").value = remark2;
            }
        };
        xhr.send("taskId=" + id2 + "&taskId1=" + id4 + "&taskId2=" + id6);
    }
    </script>

<script>
    function tolot1(id2) {
    document.getElementById('tolot').addEventListener('input', function() {
        var skuCode = document.getElementById('skucode').value;
        var tolottext = document.getElementById('tolot').value;
        tolot(id2,skuCode,tolottext);
    });
    }
    function tolot(id2,id4,id6) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "tolot.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                var tolot2 = jsonResponse.tolot2;
                document.getElementById("tolot").value = tolot2;
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
        $usql = "UPDATE `inbound` SET `confirm`='finished',`endtime`='$current_time' WHERE id = '$id3'";
        $uresult = $con->query($usql);
        echo "<script>window.location.href='inbound1.php'</script>";
    }
    ?>

    <script>
    function startTask(id, id1) {
    var view = document.getElementById("view");
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkitem.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var responseText = xhr.responseText;
                var jsonResponse = JSON.parse(responseText);
                
                var confirm2 = jsonResponse.confirm2;
                var expqty2 = jsonResponse.expqty2;
                var ap2 = jsonResponse.ap2;
                var dm2 = jsonResponse.dm2;
                var tolot2 = jsonResponse.tolot2;
                var phyqty2 = jsonResponse.phyqty2;
                var remark2 = jsonResponse.remark2;
                
                var currentSkucode = id1;

                document.getElementById("skucode").value = id1;
                document.getElementById("expqty").value = expqty2;
                document.getElementById("ap").value = ap2;
                document.getElementById("dm").value = dm2;
                document.getElementById("tolot").value = tolot2;
                document.getElementById("phyqty").value = phyqty2;
                document.getElementById("remark").value = remark2;
                if (confirm2 == 0) {
                document.getElementById("confirm").style.backgroundColor = 'rgba(76,68,182,0.808)';
                }else{
                document.getElementById("confirm").style.backgroundColor = '#13a109';
                document.getElementById(id3).style.backgroundColor = '#9f07b3';
                document.getElementById(id3).innerHTML = 'Started';
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