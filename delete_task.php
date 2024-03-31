<?php
session_start();

if (isset($_SESSION["user_id"]) && isset($_GET['id'])) {

    $mysqli = new mysqli('localhost', 'root', '', 'tasker');

    $taskId = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $taskId, $_SESSION["user_id"]);
    $stmt->execute();

    header("Location: get_tasks.php");
}
?>