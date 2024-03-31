<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM users
                    WHERE username = '%s'",
                   $mysqli->real_escape_string($_POST["username"]));
    
    $result = $mysqli->query($sql);
    
    $users = $result->fetch_assoc();
    
    if ($users) {
        
        if (password_verify($_POST["password"], $users["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $users["id"];
            
            header("Location: index.php");
            exit;
        }
    }else {
        $is_invalid = true;
    }
}

if ($is_invalid) {
    echo "Invalid username or password";
}


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="login.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    </head>
    <body>
        <b
        <div class="container">
            <div class="header">
                <h2>Log In to <br>Your Account</h2>
            </div>
            <p>
            <form method="post">
                <div class="input-group">
                    <input type="text" placeholder="Username" name="username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" name="password" required>
                </div>
                <div class="input-group">
                    <button type="submit" class="btn" name="login_user">Log In</button>
                </div>
                <div style="text-align: center;">
                <?php
                    if ($is_invalid) {
                        echo "<p style='color: red;'>Invalid username or password</p>";
                    }
                ?>
                </div>
                <div style="text-align: center;">
                <p class = "SignUp">
                    Not yet a member? <br> <a href="signup.html">Sign Up</a>
                </p>
                </div>
            </form>
        </div>
    </body>
</html>

