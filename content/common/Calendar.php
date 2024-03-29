<?php
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Redirect if user is not logged in
    if ($_SESSION['blnLoggedIn'] == FALSE) {
        header('Location: Login.php');
    }

    // Connect to DB
    include '../restricted/DB_Connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Schedule</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/calendar.css">
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

    <?php 
        try {
            // Connect to DB
            $conn = OpenConnection();

            if ($conn) {
                // Get user ID
                $intUserID = $_SESSION['intUserID'];
            }
        } catch(Exception $e) {
            echo $e;
        }
    ?>

    <div class="container">
        <div class="Days">
            <p class="Title">Monday</p>
            <?php 
                // Get monday courses
                $query = "SELECT strCourse, dtmStart, dtmEnd FROM TCourses WHERE intUserID = $intUserID AND blnMonday = 1 ORDER BY dtmStart";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Variables
                        $CourseName = $row['strCourse'];
                        $dtmStart = $row['dtmStart'];
                        $dtmEnd = $row['dtmEnd'];

                        // Format dates
                        $dtmStart = date("g:i A", strtotime($dtmStart));
                        $dtmEnd = date("g:i A", strtotime($dtmEnd));

                        // Print courses
                        echo 
                        '
                        <div class="class">
                            <p class="Date">'. $dtmStart .' - '. $dtmEnd .'</p>
                            <p class="Name">'. $CourseName .'</p>
                        </div>
                        ';
                    }
                } else {
                    echo 
                    '
                    <p class="Error">No Classes</p>
                    ';
                }
            ?>
        </div>
        <div class="Days">
            <p class="Title">Tuesday</p>
            <?php 
                // Get tuesday courses
                $query = "SELECT strCourse, dtmStart, dtmEnd FROM TCourses WHERE intUserID = $intUserID AND blnTuesday = 1 ORDER BY dtmStart";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Variables
                        $CourseName = $row['strCourse'];
                        $dtmStart = $row['dtmStart'];
                        $dtmEnd = $row['dtmEnd'];

                        // Format dates
                        $dtmStart = date("g:i A", strtotime($dtmStart));
                        $dtmEnd = date("g:i A", strtotime($dtmEnd));

                        // Print courses
                        echo 
                        '
                        <div class="class">
                            <p class="Date">'. $dtmStart .' - '. $dtmEnd .'</p>
                            <p class="Name">'. $CourseName .'</p>
                        </div>
                        ';
                    }
                } else {
                    echo 
                    '
                    <p class="Error">No Classes</p>
                    ';
                }
            ?>
        </div>
        <div class="Days">
            <p class="Title">Wednesday</p>
            <?php 
                // Get wednesday courses
                $query = "SELECT strCourse, dtmStart, dtmEnd FROM TCourses WHERE intUserID = $intUserID AND blnWednesday = 1 ORDER BY dtmStart";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Variables
                        $CourseName = $row['strCourse'];
                        $dtmStart = $row['dtmStart'];
                        $dtmEnd = $row['dtmEnd'];

                        // Format dates
                        $dtmStart = date("g:i A", strtotime($dtmStart));
                        $dtmEnd = date("g:i A", strtotime($dtmEnd));

                        // Print courses
                        echo 
                        '
                        <div class="class">
                            <p class="Date">'. $dtmStart .' - '. $dtmEnd .'</p>
                            <p class="Name">'. $CourseName .'</p>
                        </div>
                        ';
                    }
                } else {
                    echo 
                    '
                    <p class="Error">No Classes</p>
                    ';
                }
            ?>
        </div>
        <div class="Days">
            <p class="Title">Thursday</p>
            <?php 
                // Get thursday courses
                $query = "SELECT strCourse, dtmStart, dtmEnd FROM TCourses WHERE intUserID = $intUserID AND blnThursday = 1 ORDER BY dtmStart";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Variables
                        $CourseName = $row['strCourse'];
                        $dtmStart = $row['dtmStart'];
                        $dtmEnd = $row['dtmEnd'];

                        // Format dates
                        $dtmStart = date("g:i A", strtotime($dtmStart));
                        $dtmEnd = date("g:i A", strtotime($dtmEnd));

                        // Print courses
                        echo 
                        '
                        <div class="class">
                            <p class="Date">'. $dtmStart .' - '. $dtmEnd .'</p>
                            <p class="Name">'. $CourseName .'</p>
                        </div>
                        ';
                    }
                } else {
                    echo 
                    '
                    <p class="Error">No Classes</p>
                    ';
                }
            ?>
        </div>
        <div class="Days">
            <p class="Title">Friday</p>
            <?php 
                // Get friday courses
                $query = "SELECT strCourse, dtmStart, dtmEnd FROM TCourses WHERE intUserID = $intUserID AND blnFriday = 1 ORDER BY dtmStart";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Variables
                        $CourseName = $row['strCourse'];
                        $dtmStart = $row['dtmStart'];
                        $dtmEnd = $row['dtmEnd'];

                        // Format dates
                        $dtmStart = date("g:i A", strtotime($dtmStart));
                        $dtmEnd = date("g:i A", strtotime($dtmEnd));

                        // Print courses
                        echo 
                        '
                        <div class="class">
                            <p class="Date">'. $dtmStart .' - '. $dtmEnd .'</p>
                            <p class="Name">'. $CourseName .'</p>
                        </div>
                        ';
                    }
                } else {
                    echo 
                    '
                    <p class="Error">No Classes</p>
                    ';
                }
            ?>
        </div>
    </div>

    <?php 
        // Close database connection
        CloseConnection($conn);
    ?>

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