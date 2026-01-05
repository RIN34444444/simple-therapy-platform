<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$therapist_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $bio = $conn->real_escape_string($_POST['bio']);

    $sql = "UPDATE therapists SET name='$name', email='$email', specialization='$specialization', bio='$bio'
     WHERE id=$therapist_id";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Therapist updated successfully!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$therapist_query = "SELECT * FROM therapists WHERE id = $therapist_id";
$therapist_result = $conn->query($therapist_query);
$therapist = $therapist_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Therapist - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Edit Therapist</h1>
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

        <form action="edit_therapist.php?id=<?php echo $therapist_id; ?>" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $therapist['name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $therapist['email']; ?>" required>

            <label for="specialization">Specialization:</label>
            <input type="text" id="specialization" name="specialization" value="<?php echo $therapist['specialization']; ?>" required>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" required><?php echo $therapist['bio']; ?></textarea>

            <button type="submit">Update Therapist</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>
</body>
</html>