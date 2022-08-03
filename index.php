<?php 
    // Start the session (This must be at the top of each file)
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
    <title>My Planner | Home</title>
    <link rel="stylesheet" href="styles/home.css">
    <link rel="shortcut icon" type="image/x-icon" href="images/tab_logo.png">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php" class="nav-branding">MY PLANNER</a>
            <ul class="nav-menu" id="nav-menu">
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="content/common/Tasks.php" class="nav-link">Tasks</a>
                </li>
                <li class="nav-item">
                    <a href="content/common/Calendar.php" class="nav-link">Schedule</a>
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
                            <a href="content/common/Profile.php" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="content/common/Logout.php" class="nav-link">Log Out</a>
                        </li>
                        ';
                    } else {
                        echo 
                        '
                        <li class="nav-item">
                            <a href="content/common/Login.php" class="nav-link">Sign In</a>
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
    
    <div class="OpeningContainer">
        <div class="OpeningContent">
            <p class="OpeningTitle">
                MY PLANNER
            </p>
            <p class="OpeningText">
                My Planner is here to assist you in your busy workload. 
                Create an account now and streamline your academic success!
            </p>
        </div>
        <div class="OpeningContent" id="OpeningImage">
            <img src="images/planner_image.jpg" class="OpeningImage" alt="OpeningImage">
        </div>
    </div>

    <div class="container">
        <div class="Upcoming">
            <p>DUE THIS MONTH</p>
            <table id="UpcomingTable">
                <tr>
                    <th>Class</th>
                    <th>Assignment</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
                <?php require "content/common/LoadAssignments.php";?>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="classes">
            <p>COURSES THIS SEMESTER</p>
            <table id="AllCourses">
                <tr>
                    <th>Course Number</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                </tr>
                <?php require "content/common/LoadCourses.php";?>
                <tr>
                    <td colspan="4" class="Add"><a href="content/common/AddCourse.php">Add A Course</a></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="ReleaseNotes">
        <div class="content">
            <p class="Title">MY PLANNER UPDATE NOTES</p>
            <p class="Date">UPDATE 08/03/2022</p>
            <ul>
                <li>New Footer</li>
                <li>New About and Staff pages</li>
                <li>My Planner is finally online!</li>
            </ul>
            <p class="Date">UPDATE 07/21/2022</p>
            <ul>
                <li>Menu improvements</li>
                <li>File organization</li>
                <li>Revamped Homepage</li>
            </ul>
        </div>
        <div class="content">
            <p class="Title">ABOUT</p>
            <p class="AboutText">
                Welcome to My Planner! This website is here to assist you in organizing and tracking your schoolwork. 
                Read more about My Planner's purpose <a href="content/common/About.php">here.</a>
            </p>
        </div>
    </div>

    <div class="footer">
        <p class="FooterTitle">MY PLANNER</p>
        <ul class="FooterLinks">
            <li><a href="content/common/About.php">ABOUT</a></li>
            <li><a href="https://github.com/KennethOtero/MyPlanner" target="_blank">GITHUB</a></li>
            <li><a href="content/common/Staff.php">STAFF</a></li>
        </ul>
    </div>

    <script src="scripts/navbar.js"></script>
</body>
</html>