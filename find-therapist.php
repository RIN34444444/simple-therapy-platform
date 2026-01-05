<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$specialization = isset($_GET['specialization']) ? $conn->real_escape_string($_GET['specialization']) : '';

$therapists_query = "SELECT * FROM therapists";
if (!empty($specialization)) {
    $therapists_query .= " WHERE specialization LIKE '%$specialization%'";
}

$therapists_result = $conn->query($therapists_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Therapist - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Find a Therapist</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form action="find-therapist.php" method="get">
            <label for="specialization">Search by Specialization:</label>
            <input type="text" id="specialization" name="specialization" value="<?php echo $specialization; ?>">
            <button type="submit">Search</button>
        </form>

        <section id="therapist-list">
            <?php while ($therapist = $therapists_result->fetch_assoc()): ?>
            <div class="therapist-card">
                <h2><?php echo $therapist['name']; ?></h2>
                <p><strong>Specialization:</strong> <?php echo $therapist['specialization']; ?></p>
                <p><?php echo $therapist['bio']; ?></p>
                <a href="book-session.php?therapist_id=<?php echo $therapist['id']; ?>">Book a Session</a>
            </div>
            <?php endwhile; ?>
        </section>
    </main