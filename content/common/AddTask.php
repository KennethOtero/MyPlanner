<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Create Task</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/addtask.css">
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
            <a href="../../index.php" class="nav-branding">MY PLANNER</a>
            <ul class="nav-menu">
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
            <div class="hamburger" id="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
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
        } catch (Exception $e) {
            echo $e;
        }
    ?>

    <div class="container">
        <div class="AddTask">
            <p>CREATE AN ASSIGNMENT</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form id="frmTask" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Course</span>
                    <select id="cboCourses" name="cboCourses" class="form_data" required>
                        <option value="0">Choose Course</option>
                        <?php 
                            // Get courses
                            $intUserID = $_SESSION['intUserID'];
                            $intSemesterID = $_SESSION['intSemesterID'];
                            $query = "CALL uspCurrentCourses($intUserID, $intSemesterID)";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $intCourseID = $row['intCourseID'];
                                $Course = $row['strCourse'];
                                echo 
                                '
                                <option value="'. $intCourseID .'">'. $Course .'</option>
                                ';
                            }
                        ?>
                    </select>
                    <span id="CourseError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Due Date</span>
                    <input type="datetime-local" name="dtmDate" id="dtmDate" class="form_data" required>
                    <span id="DateError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Assignment Name</span>
                    <input type="text" name="txtTitle" id="txtTitle" class="form_data" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="detals">Details</span>
                    <textarea name="txtDetails" id="txtDetails" max-length="1000" class="form_data"></textarea>
                </div>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Create Assignment">
            </form>
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
    <script src="../../scripts/AddTask.js"></script>
</body>
</html>