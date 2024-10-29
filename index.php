<?php 
   session_start();
   include("db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/index.css">
    <link rel="icon" type="image/x-icon" href="src/favicon.ico">
    <title>Hayleys Tracking System</title>
</head>

<body>
    <div class="container">
        <div class="box">
        <img src="src/logo.jpg">
        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php 
              if(isset($_POST['submit'])){
                $username = mysqli_real_escape_string($con,$_POST['username']);
                $password = mysqli_real_escape_string($con,$_POST['password']);
                $pass = sha1($password);
                $result = mysqli_query($con,"SELECT * FROM users WHERE username='$username' AND Password='$pass' ") or die("Select Error");
                $row = mysqli_fetch_assoc($result);
                if(is_array($row) && !empty($row)){
                    $id = $row['id'];
                    $privilege = $row['privilege'];
                    $_SESSION['valid'] = $row['username'];
                    $_SESSION['id'] = $id;
                    if(isset($_SESSION['valid'])){  
                    if($privilege == "Admin"){
                        header("Location: home.php");
                    }else if($privilege == "User"){
                        header("Location: home1.php");
                    }
                    }
                }else{
                    echo "<div class='message'>
                      <p><b><center>Wrong Username or Password</center></b></p>
                       </div> ";
                   echo "<a href='index.php'><center><button class='btn'>Go Back</button></center>";
                }
                
              }else{

            ?>
            <header><center>Login</center></header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username"><b><pre>Username</pre></b></label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password"><b><pre>Password</pre></b></label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
            </form>
        </div>
        <?php 
        } 
        ?>
    </div>
</body>
</html>