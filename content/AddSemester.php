<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Add Semester</title>
    <link rel="stylesheet" href="../styles/home.css">
    <link rel="stylesheet" href="../styles/editsemester.css">
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

    <div class="container">
        <div class="EditSemester">
            <p>ADD A SEMESTERS</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form name="frmEdit" id="frmEdit" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Enter Semester</span>
                    <select name="cboSemesters" id="cboSemesters" class="form_data" required>
                        <option value="0" selected>Choose Semester</option>
                        <option value="Spring">Spring</option>
                        <option value="Summer">Summer</option>
                        <option value="Fall">Fall</option>
                    </select>
                    <span id="SemesterError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Enter Year</span>
                    <input type="text" name="txtYear" id="txtYear" max-length="4" class="form_data" required>
                    <span id="YearError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Enter Start Date</span>
                    <input type="datetime-local" name="dtmStart" id="dtmStart" class="form_data" required>
                    <span id="StartError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Enter End Date</span>
                    <input type="datetime-local" name="dtmEnd" id="dtmEnd" class="form_data" required>
                    <span id="EndError" class="text-danger"></span>
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Choose Semester">
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
    <script src="../scripts/AddSemester.js"></script>
</body>
</html>