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
        &emsp;<button class="button" onclick="window.location.href='putaway1.php'"><b>Back</b></button>
        </center><br>
    </div>
    <br>
    <main>
    <div class="container">
    <center>
    <table id="table">
    <tr>
        <th>ID</th>
        <th>Description</th>
        <th>View</th>
    </tr>
    <?php 
    include("db.php");

    $state2="unbegun";
    $sql3 = "SELECT * FROM putaway WHERE confirm = '$state2'";
    $result3 = $con->query($sql3);
    while ($row3 = $result3->fetch_assoc()) {
    $id3 = $row3['id'];
    $description2 = $row3['description'];
    ?>
    <tr>
    <td><?php echo $id3; ?></td>
    <td><?php echo $description2; ?></td>
    <td><button class="tbtn" id="<?php echo $id3; ?>" onclick="startTask(<?php echo $id3; ?>)">Start</button></td>
    </tr>
    <?php 
    }
    ?>
    </table>
    </center>
    </div>
    </main>
</body>

<script>
var activeTaskId = null;

function startTask(id) {
    var button = document.getElementById(id);
    
    if (button.classList.contains('started')) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "notstart_task3.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
            }
        };
        xhr.send("taskId=" + id);
        button.classList.remove('started');
        button.style.backgroundColor = 'rgba(76,68,182,0.808)';
        button.innerHTML = 'Start';
        activeTaskId = null;

    } else {
        if (activeTaskId !== null) {
            var activeButton = document.getElementById(activeTaskId);
            alert('Please complete the current task before starting another one.');
            return;
        }

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "start_task3.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert(xhr.responseText);
            }
        };
        xhr.send("taskId=" + id);

        button.classList.add('started');
        button.style.backgroundColor = '#13a109';
        button.innerHTML = 'Started';
        activeTaskId = id;
    }
}
    </script>