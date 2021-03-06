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
    <?php 
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }
    ?>
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
            <img src="images/bakaguya.jpg" class="OpeningImage" alt="OpeningImage">
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
            <p class="Date">UPDATE 07/21/2022</p>
            <ul>
                <li>Menu improvements</li>
                <li>File organization</li>
                <li>Revamped Homepage</li>
            </ul>
            <p class="Date">UPDATE 05/28/2022</p>
            <ul>
                <li>Allowed users to pick course days and times</li>
                <li>Allowed users to edit courses</li>
                <li>Allowed users to delete courses and assignments</li>
                <li>Added a schedule view for courses</li>
            </ul>
        </div>
        <div class="content">
            <p class="Title">ABOUT</p>
            <p class="AboutText">
                This website has been created by Kenneth Otero.
                This is a personal project and there are currently no plans to host
                the website yet.
                You can follow the development of the site <a href="https://github.com/KennethOtero/MyPlanner" target="_blank">here.</a>
            </p>
        </div>
    </div>

    <script src="scripts/navbar.js"></script>
</body>
</html>