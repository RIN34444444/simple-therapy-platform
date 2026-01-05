<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO therapists (name, email, specialization, bio, password) 
    VALUES ('$name', '$email', '$specialization', '$bio', '$password')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Therapist added successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Therapist - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Add New Therapist</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Back to Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php
        if (isset($success_message)) {
            echo "<p class='success'>$success_message</p>";
        }
        if (isset($error_message)) {
            echo "<p class='error'>$error_message</p>";
        }
        ?>

        <form action="add_therapist.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>


            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" required>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" required></textarea>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Add Therapist</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>
</body>
</html>