<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Staff</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/about.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../images/tab_logo.png" />
</head>
<body>
    <?php 
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        // Redirect if user is not logged in
        if ($_SESSION['blnLoggedIn'] == FALSE) {
            header('Location: Login.php');
        }
    ?>
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
        <p class="AboutTitle">STAFF</p>
        <p class="AboutText">
            Hi, my name is Kenneth Otero and I am currently the sole developer of My Planner. I am 22 years old and a current student at the University of Cincinnati
            majoring in Information Technology. I recently graduated from Cincinnati State with an Associate's in Information Systems, and I am currently putting those skills
            to work with the development of this website. 
            
            <br><br>
            At the bottom of the page there is a link to the GitHub repository for this project if you'd like to view the code for this site or if you'd like to see my other 
            projects.
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