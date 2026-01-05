<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $bio = $conn->real_escape_string($_POST['bio']);

   
    $update_sql = "UPDATE users SET username='$username', email='$email', bio='$bio' WHERE id=$user_id";

    if ($conn->query($update_sql) === TRUE) {
        $success_message = "Profile updated successfully!";
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    
    if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
        if ($_POST['new_password'] === $_POST['confirm_password']) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $password_sql = "UPDATE users SET password='$new_password' WHERE id=$user_id";

            if ($conn->query($password_sql) === TRUE) {
                $success_message .= " Password updated successfully!";
            } else {
                $error_message .= " Error updating password: " . $conn->error;
            }
        } else {
            $error_message .= " Passwords do not match.";
        }
    }
}


$user_query = "SELECT username, email, bio FROM users WHERE id=$user_id";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Online Therapy Platform</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <h1>User Profile</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
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

        <form action="profile.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio"><?php echo $user['bio']; ?></textarea>

            <h2>Change Password</h2>
            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password">

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <button type="submit">Update Profile</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>
</body>

</html>