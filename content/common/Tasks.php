<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Tasks</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/tasks.css">
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

    <?php 
        try {
            // MySQL Connection variables                        
            $servername = "localhost";
            $username = "root";
            $password = "CPDM-OteroK";
            $database = "dbsql";
            
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $database);
            
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

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
        <div class="upcoming">
            <p>Unfinished Assignments</p>
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
        <div class="AddTask">
            <a href="AddTask.php">Create An Assignment</a>
            <a href="EditSemester.php">Edit Semesters</a>
            <a href="AddCourse.php">Add A Course</a>
        </div>
    </div>
    

    <div class="container">
        <div class="finished">
        <p>Finished Assignments</p>
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
                        // MySQL Connection variables                        
                        $servername = "localhost";
                        $username = "root";
                        $password = "CPDM-OteroK";
                        $database = "dbsql";
                        
                        // Create connection
                        $conn = mysqli_connect($servername, $username, $password, $database);
                        
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

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
        $conn->close();
    ?>

    <div class="footer">
        <h3>My Planner</h3>
        <ul>
            <li>Kenneth Otero</li>
            <li>May 10, 2022</li>
            <li>Version 1.0</li>
        </ul>
    </div>

    <script src="../../scripts/navbar.js"></script>
</body>
</html>
