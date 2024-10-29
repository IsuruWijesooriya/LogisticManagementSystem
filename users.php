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
            <button class="bttn" id ="adduser" style="background: #7E0808;"><center><b>Add User</b></center></button>
        </div>
        <div class="container">
            <button class="bttn" id ="deluser" style="background: #7E5108;"><center><b>Delete User</b></center></button>
        </div>
        <div class="container">
            <button class="bttn" id ="viewuser" onclick="location.href='viewuser.php'" style="background: #087E0C;"><center><b>View User</b></center></button>
        </div>
    </main>
</body>


<div id="add" class="popup">
    <div class="popup-content"  style="min-width: 300px;">
    <div class="container" style="background: white">
        <div class="box form-box">
        <header><center>Add Users</center></header>
            <form action="" method="post">
                <div class="field input">
                    <label for="id"><b><pre>ID</pre></b></label>
                    <input type="text" name="id" id="id" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="fullname"><b><pre>Full Name</pre></b></label>
                    <input type="text" name="fullname" id="fullname" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="dob"><b><pre>Date of Birth</pre></b></label>
                    <input type="date" name="dob" id="dob" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="number"><b><pre>Mobile Number</pre></b></label>
                    <input type="text" name="number" id="number" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="address"><b><pre>Address</pre></b></label>
                    <input type="text" name="address" id="address" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="username"><b><pre>Username</pre></b></label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password"><b><pre>Password</pre></b></label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="privilege"><b><pre>Privilege</pre></b></label>
                    <select type="text" name="privilege" id="privilege" required>
                        <option value=""></option>
                        <option value="Admin">Admin</option>
                        <option value="User">User</option>
                    </select>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Add" required>
                </div>
            </form>
        </div>
    </div>
    </div>   
</div>

<?php 
if(isset($_POST['submit'])){
    $id1 = trim($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $dob = ($_POST['dob']);
    $address = trim($_POST['address']);
    $number = trim($_POST['number']);
    $privilege = ($_POST['privilege']);
    $username = trim($_POST['username']);
    $pass = trim($_POST['password']);
    $password = sha1($pass);
    
    $isValid = true;

    if($isValid){
      $insertSQL = "INSERT INTO `users`(`id`, `fullname`, `dob`, `number`, `address`, `username`, `password`, `privilege`) VALUES (?,?,?,?,?,?,?,?)";
      $stmt = $con->prepare($insertSQL);
      $stmt->bind_param("ssssssss",$id1,$fullname,$dob,$number,$address,$username,$password,$privilege);
      $stmt->execute();
      $stmt->close();
      echo '<script>alert("User Added successfully.")</script>';
      echo '<script>window.location.href = "users.php";</script>';
    }
}
?>

<div id="del" class="popup">
    <div class="popup-content"  style="min-width: 300px;">
    <div class="container" style="background: white">
        <div class="box form-box">
        <header><center>Delete Users</center></header>
            <form action="" method="post">
                <div class="field input">
                    <label for="id"><b><pre>ID</pre></b></label>
                    <input type="text" name="id1" id="id1" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="delete" value="Delete" required>
                </div>
            </form>
        </div>
    </div>
    </div>   
</div>

<?php 
if(isset($_POST['delete'])){
    $id2 = trim($_POST['id1']);
    
    $isValid = true;

    if($isValid){
      $delSQL = "UPDATE `users` SET `username` = NULL, `password` = NULL WHERE id = $id2";
      $stmt = $con->prepare($delSQL);
      $stmt->execute();
      $stmt->close();
      echo '<script>alert("User Deleted successfully.")</script>';
    }
}
?>

<script>
    adduser.addEventListener("click", function () {
        add.classList.add("show");
    });
    window.addEventListener("click", function (event) {
        if (event.target == add) {
            add.classList.remove("show");
        }
    });
</script>

<script>
    deluser.addEventListener("click", function () {
            del.classList.add("show");
    });
    window.addEventListener("click", function (event) {
        if (event.target == del) {
            del.classList.remove("show");
        }
    });
</script>