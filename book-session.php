<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login2.php");
    exit();
}

$therapist_id = isset($_GET['therapist_id']) ? (int)$_GET['therapist_id'] : 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO sessions (user_id, therapist_id, date, time) VALUES ($user_id, $therapist_id, '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Session booked successfully!";
    } else {
        $error_message = "Error booking session: " . $conn->error;
        echo $conn->error;
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
    <title>Book a Session - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Book a Session with <?php echo $therapist['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="find-therapist.php">Back to Therapist List</a></li>
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

        <form action="book-session.php?therapist_id=<?php echo $therapist_id; ?>" method="post">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required>

            <button type="submit">Book Session</button>
        </form>
    </main>

    <footer>
        <div class="container">
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </div>
    </footer>
</body>
</html>