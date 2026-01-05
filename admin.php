<?php
session_start();
require_once 'db_connection.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


$users_query = "SELECT * FROM users WHERE user_role != 'admin'";
$users_result = $conn->query($users_query);


$therapists_query = "SELECT * FROM therapists";
$therapists_result = $conn->query($therapists_query);


$total_users = $conn->query("SELECT COUNT(*) as count FROM users WHERE user_role != 'admin'")->fetch_assoc()['count'];
$total_therapists = $conn->query("SELECT COUNT(*) as count FROM therapists")->fetch_assoc()['count'];
$total_sessions = $conn->query("SELECT COUNT(*) as count FROM sessions")->fetch_assoc()['count'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="#users">Manage Users</a></li>
                <li><a href="#therapists">Manage Therapists</a></li>
                <li><a href="#reports">View Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="users">
            <h2>Manage Users</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                <?php while ($user = $users_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['username']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                        <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </section>

        <section id="therapists">
            <h2>Manage Therapists</h2>
            <a href="add_therapist.php">Add New Therapist</a>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Actions</th>
                </tr>
                <?php while ($therapist = $therapists_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $therapist['id']; ?></td>
                    <td><?php echo $therapist['name']; ?></td>
                    <td><?php echo $therapist['specialization']; ?></td>
                    <td>
                        <a href="edit_therapist.php?id=<?php echo $therapist['id']; ?>">Edit</a>
                        <a href="delete_therapist.php?id=<?php echo $therapist['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </section>

        <section id="reports">
            <h2>Reports</h2>
            <div class="report-card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="report-card">
                <h3>Total Therapists</h3>
                <p><?php echo $total_therapists; ?></p>
            </div>
            <div class="report-card">
                <h3>Total Sessions</h3>
                <p><?php echo $total_sessions; ?></p>
            </div>
            <a href="detailed_reports.php">View Detailed Reports</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>
</body>
</html>