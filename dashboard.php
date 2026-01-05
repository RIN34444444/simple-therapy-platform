<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'db_connection.php';

$user_id = $_SESSION['user_id'];
$user_query = "SELECT username FROM users WHERE id = $user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();


$sessions_query = "SELECT s.*, t.name as therapist_name 
                   FROM sessions s 
                   JOIN therapists t ON s.therapist_id = t.id 
                   WHERE s.user_id = $user_id AND s.date >= CURDATE() 
                   ORDER BY s.date, s.time";
$sessions_result = $conn->query($sessions_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Welcome, <?php echo $user['username']; ?>!</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="find-therapist.php">Find a Therapist</a></li>
                    <li><a href="questionnaire.php">Questionnaire</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="about-us.html">About Us</a></li>
                    <!-- Conditional Login/Logout Link -->
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else : ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <section id="upcoming-sessions">
                <h2>Upcoming Sessions</h2>
                <?php if ($sessions_result->num_rows > 0) : ?>
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Therapist</th>
                        </tr>
                        <?php while ($session = $sessions_result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $session['date']; ?></td>
                                <td><?php echo $session['time']; ?></td>
                                <td><?php echo $session['therapist_name']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                <?php else : ?>
                    <p>You have no upcoming sessions.</p>
                <?php endif; ?>
            </section>

            <section id="quick-links">
                <h2>Quick Links</h2>
                <div class="card">
                    <h3>Find a Therapist</h3>
                    <p>Search for therapists and book a session.</p>
                    <a href="find-therapist.php">Find a Therapist</a>
                </div>
                <div class="card">
                    <h3>Daily Questionnaire</h3>
                    <p>Track your mood and progress with our daily questionnaire.</p>
                    <a href="questionnaire.php">Take Questionnaire</a>
                </div>
            </section>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>