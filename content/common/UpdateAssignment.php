<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
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
    <title>My Planner | Update Assignment</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/updateassignment.css">
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

            // Get user info
            $intUserID = $_SESSION['intUserID'];
            $intSemesterID = $_SESSION['intSemesterID'];
            
            // Get assignment info
            $intAssignmentID = $_GET['ID'];

            // Get assignment info
            $result = mysqli_query($conn, "SELECT 
                                                DATE_FORMAT(TA.dtmDueDate, '%Y-%m-%dT%H:%i') AS dtmDueDate,
                                                TA.strAssignment,
                                                TA.strDetails,
                                                TA.intStatusID,
                                                TA.intCourseID,
                                                TA.intProgress
                                            FROM 
                                                TAssignments as TA JOIN TCourses as TC
                                                    ON TA.intCourseID = TC.intCourseID
                                                JOIN TUsers as TU
                                                    ON TU.intUserID = TC.intUserID
                                            WHERE 
                                                TU.intUserID = $intUserID AND TA.intAssignmentID = $intAssignmentID");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $dtmDueDate = $row['dtmDueDate'];
                $strAssignment = $row['strAssignment'];
                $strDetails = $row['strDetails'];
                $Status = $row['intStatusID'];
                $intProgress = $row['intProgress'];
                $CourseID = $row['intCourseID'];

                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                }
            }
        } catch (Exception $e) {
            echo $e;
        }
    ?>
    
    <div class="container">
        <div class="AddTask">
            <p>UPDATE ASSIGNMENT</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form name="frmTask" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <div class="slidecontainer">
                        <span class="details" id="range">Assignment Completion: <span id="output"></span>%</span>
                        <input type="range" name="rngSlider" min="0" max="100" value="<?php echo $intProgress;?>" class="slider" id="slider">
                    </div>
                </div>
                <div class="fields">
                    <span class="details">Course</span>
                    <select id="cboCourses" name="cboCourses" class="form_data" required>
                        <option value="0">Choose Course</option>
                        <?php 
                            // Get current courses
                            $query = "CALL uspCurrentCourses($intUserID, $intSemesterID)";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $intCourseID = $row['intCourseID'];
                                $Course = $row['strCourse'];
                                if ($intCourseID == $CourseID) {
                                    echo 
                                    '
                                    <option value="'. $intCourseID .'" selected>'. $Course .'</option>
                                    ';
                                } else {
                                    echo 
                                    '
                                    <option value="'. $intCourseID .'">'. $Course .'</option>
                                    ';
                                }
                            }
                        ?>
                    </select>
                    <span id="CourseError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Due Date</span>
                    <input type="datetime-local" name="dtmDate" id="dtmDate" value="<?php echo $dtmDueDate;?>" class="form_data" required>
                    <span id="DateError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Assignment Name</span>
                    <input type="text" name="txtTitle" id="txtTitle" value="<?php echo $strAssignment;?>" class="form_data" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="detals">Details</span>
                    <textarea name="txtDetails" id="txtDetails" max-length="1000" class="form_data" ><?php echo $strDetails;?></textarea>
                    <span id="DetailsError" class="text-danger"></span>
                </div>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Update Assignment">
                <div class="Add">
                    <a href="#" onclick="return deleteAssignment()">Delete Assignment</a>
                </div>
            </form>
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
    <script src="../../scripts/UpdateAssignment.js?ID=<?php echo $intAssignmentID?>"></script>
</body>
</html>