<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Therapy Platform - Home</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Online Therapy Platform</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="find-therapist.php">Find a Therapist</a></li>
                <li><a href="questionnaire.php">Questionnaire</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="about-us.html">About Us</a></li>
                
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php else : ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <section id="home">
            <h2>Welcome to Our Online Therapy Platform</h2>
            <p>Your mental health is our priority. Connect with the best therapists online.</p>
        </section>

        <section id="reviews">
            <h2>Client Reviews</h2>
            <div class="review">
                <img src="images/georgina.jpeg" alt="georgina">
                <h3>Georgina Kamau</h3>
                <p>Therapy type: Drugs and alcohol counselling</p>
                <p>"The therapist recommended to me by the platform was the best I have ever come across. After a few sessions, I began to feel like myself again and I have shown progress. I feel free and like I can breathe and live my life again."</p>
            </div>
            <div class="review">
                <img src="images/patricia.jpeg" alt="Patricia Lelgut">
                <h3>Patricia Lelgut</h3>
                <p>Therapy type: Stress, anxiety</p>
                <p>"The platform has made my life easier since I attended my sessions online. The therapists maintain their professionalism while still making you feel comfortable enough to share your problems."</p>
            </div>
            <div class="review">
                <img src="images/chepkoech .jpeg" alt="John Chepkoech">
                <h3>John Chepkoech</h3>
                <p>Therapy type: Depression</p>
                <p>"As a youth who has struggled with mental health for a while and never finding a proper counsellor, this platform is the best thing to ever happen since it has given me the best therapist who is professional yet understanding, leading to a significant improvement in my mental health."</p>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Online Therapy Platform. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>