<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
</head>
<body>
<a href="index.php">Homepage</a>
<a href="get_tasks.php">View Tasks</a>
<p>
    <form method="POST" action="add_task.php">
        <input type="text" name="task" placeholder="Enter task">
        <button type="submit">Add</button>
    </form>
    <p>
</body>
</html>

<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM tasks
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $task = $_POST["task"];

    $sql = "INSERT INTO tasks (task, user_id)
            VALUES ('{$task}', {$_SESSION["user_id"]})";

    $result = $mysqli->query($sql);

    if ($result) {
        echo "Task added successfully";
    } else {
        echo "Error: " . $mysqli->error;
    }
}

?>