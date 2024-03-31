<?php
session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM tasks WHERE user_id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $tasks = $result->fetch_all(MYSQLI_ASSOC);
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>View Tasks</title>
</head>
<body>
    <h1>Your Tasks</h1>
    <?php if (!empty($tasks)): ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?php echo htmlspecialchars($task['task']); ?>
                    <a href="delete_task.php?id=<?php echo $task['id']; ?>">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no tasks.</p>
    <?php endif; ?>

    <a href="index.php">Homepage</a>
</body>
</html>