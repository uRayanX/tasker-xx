<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Validate form fields
    $errors = [];
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // If there are no errors, insert data into the database
    if (empty($errors)) {
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "tasker";
    
        $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Check if username already exists
        $checkUsername = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $checkUsername->bind_param("s", $username);
        $checkUsername->execute();
        $checkUsername->store_result();
    
        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();
    
        if ($checkUsername->num_rows > 0) {
            $errors[] = "Username already exists";
        } elseif ($checkEmail->num_rows > 0) {
            $errors[] = "Email already exists";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters";
        } else {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert data into the table
            $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
    
            if ($stmt->execute()) {
                header("Location: regisdone.html");
            } else {
                echo "Error: " . $stmt->error;
            }
    
            $stmt->close();
        }
    
        $checkUsername->close();
        $checkEmail->close();
        $conn->close();
    }
    
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
    
    else {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
    }
}
?>