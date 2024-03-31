<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>status</title>
    <link rel="stylesheet" href="test.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="input-group">
            <p>
                <?php if (isset($user)) : ?>

            <div class="header">
                <h2>Welcome</h2>
            </div>
            <div class="nameholder">
                Hello: <?= htmlspecialchars($user["username"]) ?>
            </div>

            <p>
            <p>
                <a href="add_task.php">
                    <button class="add-task-btn">Add Task</button>
                </a>
                <a href="get_tasks.php">
                    <button class="view-task-btn">View Task</button>
                </a>
            </p>
        </p>

            <p>

            <p><a href="logout.php">Log out</a></p>

        <?php else : ?>
            <div class="header">
                <h2>Welcome to Tasker</h2>
            </div>
            <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        <?php endif; ?>
        </p>
        </div>
    </div>
    <script src="index.js"></script>
</body>

</html>