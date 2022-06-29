<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Add A Course</title>
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/addcourse.css">
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
            <a href="../index.php" class="nav-branding">MY PLANNER</a>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">Home</a>
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

            if ($conn) {
                // Get course ID
                $intCourseID = $_GET['ID'];

                // Get course data
                $query = "SELECT * FROM TCourses WHERE intCourseID = $intCourseID";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    // Get course data for form
                    $row = mysqli_fetch_assoc($result);
                    $CourseNumber = $row['strCourseNumber'];
                    $CourseName = $row['strCourse'];
                    $Instructor = $row['strInstructor'];
                    $Monday = $row['blnMonday'];
                    $Tuesday = $row['blnTuesday'];
                    $Wednesday = $row['blnWednesday'];
                    $Thursday = $row['blnThursday'];
                    $Friday = $row['blnFriday'];
                    $dtmStart = $row['dtmStart'];
                    $dtmEnd = $row['dtmEnd'];

                    // Check if days are checked
                    if ($Monday == 1) {
                        $MondayChecked = "checked";
                    } else {
                        $MondayChecked = "";
                    }
                    if ($Tuesday == 1) {
                        $TuesdayChecked = "checked";
                    } else {
                        $TuesdayChecked = "";
                    }
                    if ($Wednesday == 1) {
                        $WednesdayChecked = "checked";
                    } else {
                        $WednesdayChecked = "";
                    }
                    if ($Thursday == 1) {
                        $ThursdayChecked = "checked";
                    } else {
                        $ThursdayChecked = "";
                    }
                    if ($Friday == 1) {
                        $FridayChecked = "checked";
                    } else {
                        $FridayChecked = "";
                    }
                }
            } else {
                $CourseNumber = "";
                $CourseName = "";
                $Instructor = "";
                $MondayChecked = "";
                $TuesdayChecked = "";
                $WednesdayChecked = "";
                $ThursdayChecked = "";
                $FridayChecked = "";
                $dtmStart = "";
                $dtmEnd = "";
            }
        } catch(Exception $e) {
            echo $e;
        }
    ?>

    <div class="container">
        <div class="AddCourse">
            <p>UPDATE COURSE</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form id="frmCourse" onsubmit="return ajax()" method="post">
                <div class="fields">
                    <span class="details">Course Number</span>
                    <input type="text" name="txtNumber" id="txtNumber" class="form_data" value="<?php echo $CourseNumber;?>" required>
                    <span id="NumberError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Course Name</span>
                    <input type="text" name="txtCourse" id="txtCourse" class="form_data" value="<?php echo $CourseName;?>" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Instructor Name</span>
                    <input type="text" name="txtInstructor" id="txtInstructor" class="form_data" value="<?php echo $Instructor;?>" required>
                    <span id="InstructorError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Pick Course Days</span>
                    <ul class="switches">
                        <li>
                            <label for="chkMonday" class="check">Monday
                                <input type="checkbox" class="days" id="chkMonday" value="Monday" <?php echo $MondayChecked;?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkTuesday" class="check">Tuesday
                                <input type="checkbox" class="days" id="chkTuesday" value="Tuesday" <?php echo $TuesdayChecked;?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkWednesday" class="check">Wednesday
                                <input type="checkbox" class="days" id="chkWednesday" value="Wednesday" <?php echo $WednesdayChecked;?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkThursday" class="check">Thursday
                                <input type="checkbox" class="days" id="chkThursday" value="Thursday" <?php echo $ThursdayChecked;?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkFriday" class="check">Friday
                                <input type="checkbox" name="check_list[]" id="chkFriday" value="Friday" <?php echo $FridayChecked;?>>
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    </ul>
                    <span id="DaysError" class="text-danger"></span> 
                </div>
                <div class="fields">
                    <span class="details">Start Time</span>
                    <input type="time" name="dtmStart" id="dtmStart" class="form_data" value="<?php echo $dtmStart;?>" required>
                    <span id="StartError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">End Time</span>
                    <input type="time" name="dtmEnd" id="dtmEnd" class="form_data" value="<?php echo $dtmEnd;?>" required>
                    <span id="EndError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Update Course"></input>
                </div>
                <div class="Add">
                    <a href="#" onclick="return deleteCourse()">Delete Course</a>
                </div>
            </form>
        </div>
    </div>

    <div class="footer">
        <h3>My Planner</h3>
        <ul>
            <li>Kenneth Otero</li>
            <li>May 10, 2022</li>
            <li>Version 1.0</li>
        </ul>
    </div>

    <script src="../scripts/navbar.js"></script>        
    <script src="../scripts/UpdateCourse.js"></script>
</body>
</html>