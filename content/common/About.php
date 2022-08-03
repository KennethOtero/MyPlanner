<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | About</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/about.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../images/tab_logo.png" />
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="../../index.php" class="nav-branding">MY PLANNER</a>
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item">
                    <a href="../../index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="Tasks.php" class="nav-link">Tasks</a>
                </li>
                <li class="nav-item">
                    <a href="Calendar.php" class="nav-link">Schedule</a>
                </li>
                <?php 
                    // Create login session variables and set to false
                    if (!isset($_SESSION['blnLoggedIn'])) {
                        $_SESSION['blnLoggedIn'] = false;
                    }

                    if ($_SESSION['blnLoggedIn'] == TRUE) {
                        echo 
                        '
                        <li class="nav-item">
                            <a href="Profile.php" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="Logout.php" class="nav-link">Log Out</a>
                        </li>
                        ';
                    } else {
                        echo 
                        '
                        <li class="nav-item">
                            <a href="Login.php" class="nav-link">Sign In</a>
                        </li>
                        ';
                    }
                ?>
            </ul>
            <button id="hamburger" class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
        </nav>
    </header>

    <div class="AboutContent">
        <p class="AboutTitle">ABOUT</p>
        <p class="Subtitle">My Planner's Purpose:</p>
        <p class="AboutText">
            My Planner is a personal project that allows users to keep track of their schoolwork. 
            I wanted to create this mainly as a way to stay on top of my assignments in the purest way possible, with the simplicity that an app like this provides. 
            If you'd like to know more about myself, then visit our <a href="Staff.php">staff page.</a>             
        </p>
        <p class="Subtitle">My Planner Functionality:</p>
        <p class="AboutText">
            How does it work? Well, users can start by creating an account in My Planner. Upon account creation, users have to choose their starting semester 
            (Spring, Summer, Fall) along with the year. 
            After doing so, users can create their courses and assignments for said courses. 
            On the homepage, users can see all of their assignments that are due in the next 30 days. 
            The tasks page is brains of the site, allowing users to edit assignments to show completion status, edit their contents, 
            as well as create/edit more courses and semesters. The schedule page shows all of the user's classes throughout the week (Mon-Fri) for the current semester. 
            If a day has more than one class, those classes are ordered by their start time. 
        </p>
        <p class="Subtitle">Technical Details</p>
        <p class="AboutText">
            My Planner utilizes the skillset I learned while pursuing my Associates degree and also some tech I had to learn while creating this project.
            My Planner uses AJAX and PHP to interact with a MySQL database without refreshing the page, allowing for a better user experience as the page doesn't have to be reloaded
            or sent somewhere else. The database that My Planner runs on has full auditing, allowing devs to track sensitive information and any other database changes.
            My Planner doesn't utilize any frameworks and was created in pure JavaScript, PHP, MySQL, CSS, and HTML. 
            View the code on <a href="https://github.com/KennethOtero/MyPlanner" target="_blank">GitHub</a>!
        </p>
        <p class="Subtitle">The Road Ahead:</p>
        <p class="AboutText"> 
            For the future, it would be nice to have a mobile version My Planner as well as a more in-depth calendar system
            and the introduction of email and/or push-notifications.
        </p>
    </div>

    <div class="footer">
        <p class="FooterTitle">MY PLANNER</p>
        <ul class="FooterLinks">
            <li><a href="../common/About.php">ABOUT</a></li>
            <li><a href="https://github.com/KennethOtero/MyPlanner" target="_blank">GITHUB</a></li>
            <li><a href="../common/Staff.php">STAFF</a></li>
        </ul>
    </div>

    <script src="../../scripts/navbar.js"></script>
</body>
</html>