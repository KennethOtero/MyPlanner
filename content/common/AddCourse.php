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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Add A Course</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/addcourse.css">
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

    <div class="container">
        <div class="AddCourse">
            <p>CREATE A COURSE</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form id="frmCourse" onsubmit="return ajax()" method="post">
                <div class="fields">
                    <span class="details">Course Number</span>
                    <input type="text" name="txtNumber" id="txtNumber" class="form_data" required>
                    <span id="NumberError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Course Name</span>
                    <input type="text" name="txtCourse" id="txtCourse" class="form_data" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Instructor Name</span>
                    <input type="text" name="txtInstructor" id="txtInstructor" class="form_data" required>
                    <span id="InstructorError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Pick Course Days</span>
                    <ul class="switches">
                        <li>
                            <label for="chkMonday" class="check">Monday
                                <input type="checkbox" class="days" id="chkMonday" value="Monday">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkTuesday" class="check">Tuesday
                                <input type="checkbox" class="days" id="chkTuesday" value="Tuesday">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkWednesday" class="check">Wednesday
                                <input type="checkbox" class="days" id="chkWednesday" value="Wednesday">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkThursday" class="check">Thursday
                                <input type="checkbox" class="days" id="chkThursday" value="Thursday">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                        <li>
                            <label for="chkFriday" class="check">Friday
                                <input type="checkbox" class="days" id="chkFriday" value="Friday">
                                <span class="checkmark"></span>
                            </label>
                        </li>
                    </ul>
                    <span id="DaysError" class="text-danger"></span> 
                </div>
                <div class="fields">
                    <span class="details">Start Time</span>
                    <input type="time" name="dtmStart" id="dtmStart" class="form_data">
                    <span id="StartError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">End Time</span>
                    <input type="time" name="dtmEnd" id="dtmEnd" class="form_data">
                    <span id="EndError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Create Course"></input>
                </div>
            </form>
        </div>
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
    <script src="../../scripts/AddCourse.js"></script>
</body>
</html>