<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$user_growth_query = "SELECT DATE(created_at) as date, COUNT(*) as count FROM users GROUP BY DATE(created_at) ORDER BY date";
$user_growth_result = $conn->query($user_growth_query);


$session_data_query = "SELECT DATE(date) as date, COUNT(*) as count FROM sessions GROUP BY DATE(date) ORDER BY date";
$session_data_result = $conn->query($session_data_query);


$mood_data_query = "SELECT DATE(created_at) as date, AVG(stress_level) as avg_stress, AVG(sleep_quality) as avg_sleep FROM questionnaire_responses GROUP BY DATE(created_at) ORDER BY date";
$mood_data_result = $conn->query($mood_data_query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed Reports - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Detailed Reports</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Back to Admin Dashboard</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="user-growth">
            <h2>User Growth</h2>
            <canvas id="userGrowthChart"></canvas>
        </section>

        <section id="session-data">
            <h2>Session Data</h2>
            <canvas id="sessionDataChart"></canvas>
        </section>

        <section id="mood-data">
            <h2>Average Mood Data</h2>
            <canvas id="moodDataChart"></canvas>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>

    <script>
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: [<?php while ($row = $user_growth_result->fetch_assoc()) echo "'".$row['date']."',"; ?>],
                datasets: [{
                    label: 'New Users',
                    data: [<?php $user_growth_result->data_seek(0); while ($row = $user_growth_result->fetch_assoc()) echo $row['count'].","; ?>],
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

       
        const sessionDataCtx = document.getElementById('sessionDataChart').getContext('2d');
        new Chart(sessionDataCtx, {
            type: 'bar',
            data: {
                labels: [<?php while ($row = $session_data_result->fetch_assoc()) echo "'".$row['date']."',"; ?>],
                datasets: [{
                    label: 'Number of Sessions',
                    data: [<?php $session_data_result->data_seek(0); while ($row = $session_data_result->fetch_assoc()) echo $row['count'].","; ?>],
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

      
        const moodDataCtx = document.getElementById('moodDataChart').getContext('2d');
        new Chart(moodDataCtx, {
            type: 'line',
            data: {
                labels: [<?php while ($row = $mood_data_result->fetch_assoc()) echo "'".$row['date']."',"; ?>],
                datasets: [{
                    label: 'Average Stress Level',
                    data: [<?php $mood_data_result->data_seek(0); while ($row = $mood_data_result->fetch_assoc()) echo $row['avg_stress'].","; ?>],
                    borderColor: 'rgb(255, 99, 132)',
                    tension: 0.1
                },
                {
                    label: 'Average Sleep Quality',
                    data: [<?php $mood_data_result->data_seek(0); while ($row = $mood_data_result->fetch_assoc()) echo $row['avg_sleep'].","; ?>],
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });
    </script>
</body>
</html>