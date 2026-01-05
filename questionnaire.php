<?php
session_start();
require_once 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $mood = $conn->real_escape_string($_POST['mood']);
    $stress_level = (int)$_POST['stress_level'];
    $sleep_quality = (int)$_POST['sleep_quality'];
    $notes = $conn->real_escape_string($_POST['notes']);

    $sql = "INSERT INTO questionnaire_responses (user_id, mood, stress_level, sleep_quality, notes) 
    VALUES ($user_id, '$mood', $stress_level, $sleep_quality, '$notes')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Questionnaire submitted successfully!";
    } else {
        $error_message = "Error submitting questionnaire: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Questionnaire - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Daily Questionnaire</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
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

        <form action="questionnaire.php" method="post">
            <label for="mood">How would you describe your mood today?</label>
            <input type="text" id="mood" name="mood" required>

            <label for="stress_level">On a scale of 1-10, how stressed do you feel today?</label>
            <input type="range" id="stress_level" name="stress_level" min="1" max="10" required>
            <span id="stress_value">5</span> <!-- Display current value of stress_level -->

            <label for="sleep_quality">On a scale of 1-10, how would you rate your sleep quality last night?</label>
            <input type="range" id="sleep_quality" name="sleep_quality" min="1" max="10" required>
            <span id="sleep_value">5</span> <!-- Display current value of sleep_quality -->

            <label for="notes">Any additional notes or thoughts you'd like to share?</label>
            <textarea id="notes" name="notes"></textarea>

            <button type="submit">Submit Questionnaire</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>
</body>
<script src="script.js"></script>
</html>
