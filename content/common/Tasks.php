<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Redirect if user is not logged in
    if ($_SESSION['blnLoggedIn'] == FALSE) {
        header('Location: Login.php');
    }

    // Include DB connection
    include '../restricted/DB_Connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Tasks</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/tasks.css">
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

            // Get current semester
            if ($conn) {
                $intSemesterID = $_SESSION['intSemesterID'];
                $query = "SELECT CONCAT(strSemester,' ',intYear) as Semester FROM TSemesters WHERE intSemesterID = $intSemesterID";
                $result = mysqli_query($conn, $query);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $Semester = $row['Semester'];
                } else {
                    $Semester = "No Active Semester";
                }

                // Formatting
                $Semester = strtoupper($Semester);
            }
        } catch (Exception $e) {
            echo $e;
        }
    ?>

    <div class="semester">
        <p><?php echo $Semester;?></p>
    </div>

    <div class="container">
        <div class="AddTask">
            <a href="AddTask.php">Create an Assignment</a>
            <a href="EditSemester.php">Edit Semesters</a>
            <a href="AddCourse.php">Add a Course</a>
        </div>
    </div>

    <div class="container">
        <div class="upcoming">
            <p>UNFINISHED ASSIGNMENTS</p>
            <table id="UpcomingTable">
                <tr>
                    <th>Class</th>
                    <th>Assignment</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
                <?php 
                    // Load all unfinished assignments
                    try {
                        if ($conn) {
                            // Get unfinished assignments
                            $intUserID = $_SESSION['intUserID'];
                            $intSemesterID = $_SESSION['intSemesterID'];
                            $query = "CALL uspUnfinishedAssignments($intUserID, $intSemesterID)";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) <= 0) {
                                echo 
                                '
                                <tr>
                                    <td colspan="4" class="finished">No unfinished assignments</td>
                                </tr>
                                <style>
                                    .finished {
                                        text-align: center;
                                    }
                                </style>
                                ';
                            }

                            while ($row = mysqli_fetch_assoc($result)) {
                                // Get data
                                $Class = $row['strCourse'];
                                $Assignment = $row['strAssignment'];
                                $Date = strtotime($row["dtmDueDate"]);
                                $Date = date('m/d/Y', $Date);
                                $Status = $row['strStatus'];
                                $intAssignmentID = $row['intAssignmentID'];

                                // Display unfinished assignments
                                echo 
                                '
                                <tr>
                                    <td>'. $Class .'</td>
                                    <td>'. $Assignment .'</td>
                                    <td>'. $Date .'</td>
                                    <td><a href="UpdateAssignment.php?ID='. $intAssignmentID .'">'. $Status .'</a></td>
                                </tr>
                                ';
                            }
                        }
                    } catch (Exception $e) {
                        echo $e;
                    }
                ?>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="AllCourses">
            <p>COURSES THIS SEMESTER</p>
            <table id="AllCourses">
                <tr>
                    <th>Course Number</th>
                    <th>Course Name</th>
                    <th>Instructor</th>
                </tr>
                <?php 
                    // Connect to DB
                    $conn = OpenConnection();

                    if ($conn) {
                        // Query
                        $intUserID = $_SESSION['intUserID'];
                        if (!isset($_SESSION['intSemesterID'])) {
                            $intSemesterID = 0;
                        } else {
                            $intSemesterID = $_SESSION['intSemesterID'];
                        }
                        $query = "CALL uspCurrentCourses($intUserID, $intSemesterID)";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                            // Get data
                            $CourseNumber = $row['strCourseNumber'];
                            $Course = $row['strCourse'];
                            $Instructor = $row['strInstructor'];
                            $intCourseID = $row['intCourseID'];

                            // Display courses
                            echo 
                            '
                            <tr>
                                <td><a href="UpdateCourse.php?ID='. $intCourseID .'">'. $CourseNumber .'</a></td>
                                <td>'. $Course .'</td>
                                <td>'. $Instructor .'</td>
                            </tr>
                            ';
                        }
                    }
                ?>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="finished">
            <p>FINISHED ASSIGNMENTS</p>
            <table id="UpcomingTable">
                <tr>
                    <th>Class</th>
                    <th>Assignment</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
                <?php 
                    // Load all unfinished assignments
                    try {
                        // Connect to DB
                        $conn = OpenConnection();

                        if ($conn) {
                            // Get unfinished assignments
                            $query = "CALL uspFinishedAssignments($intUserID, $intSemesterID)";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) <= 0) {
                                echo 
                                '
                                <tr>
                                    <td colspan="4" class="finished">No finished assignments</td>
                                </tr>
                                <style>
                                    .finished {
                                        text-align: center;
                                    }
                                </style>
                                ';
                            }

                            while ($row = mysqli_fetch_assoc($result)) {
                                // Get data
                                $Class = $row['strCourse'];
                                $Assignment = $row['strAssignment'];
                                $Date = strtotime($row["dtmDueDate"]);
                                $Date = date('m/d/Y', $Date);
                                $Status = $row['strStatus'];
                                $intAssignmentID = $row['intAssignmentID'];

                                // Display finished assignments
                                echo 
                                '
                                <tr>
                                    <td>'. $Class .'</td>
                                    <td>'. $Assignment .'</td>
                                    <td>'. $Date .'</td>
                                    <td><a href="UpdateAssignment.php?ID='. $intAssignmentID .'">'. $Status .'</a></td>
                                </tr>
                                ';
                            }
                        }
                    } catch (Exception $e) {
                        echo $e;
                    }
                ?>
            </table>
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