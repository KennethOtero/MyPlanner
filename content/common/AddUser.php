<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Create an Account</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/adduser.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
        if (!isset($_SESSION['Name']) || !isset($_SESSION['Email']) || !isset($_SESSION['Password']) 
            || !isset($_SESSION['Security']) || !isset($_SESSION['Semester']) || !isset($_SESSION['Year'])) {
            $Name = "";
            $Email = "";
            $Password = "";
            $Security = "";
            $Semester = "";
            $Year = "";
        } else {
            $Name = $_SESSION['Name'];
            $Email = $_SESSION['Email'];
            $Password = $_SESSION['Password'];
            $Security = $_SESSION['Security'];
            $Semester = $_SESSION['Semester'];
            $Year = $_SESSION['Year'];
        }
    ?>

    <div class="container">
        <div class="register">
            <p>CREATE AN ACCOUNT</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form id="frmRegister" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Name:</span>
                    <input type="text" name="txtName" id="txtName" value="<?php echo $Name;?>" class="form_data" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Email:</span>
                    <input type="email" name="txtEmail" id="txtEmail" value="<?php echo $Email;?>" class="form_data" required>
                    <span id="EmailError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Password:</span>
                    <input type="password" name="txtPassword" id="txtPassword" value="<?php echo $Password;?>" class="form_data" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <span id="PasswordError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Confirm Password:</span>
                    <input type="password" name="txtConfirm" id="txtConfirm" value="<?php echo $Password;?>" class="form_data" required>
                    <i class="bi bi-eye-slash" id="toggleConfirm"></i>
                    <span id="ConfirmError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Security Question: What City Were You Born In?</span>
                    <input type="text" name="txtSecurity" id="txtSecurity" value="<?php echo $Security;?>" class="form_data" required>
                    <span id="SecurityError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <div class="semester">
                        <p>Add Semester</p>
                        <span class="details">Choose Semester:</span>
                        <select class="form_data" id="cboSemesters" name="cboSemesters">
                            <option value="0">Choose Semester</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                            <option value="Fall">Fall</option>
                        </select>
                        <span id="SemesterError" class="text-danger"></span>
                    </div>
                </div>
                <div class="fields">
                    <div class="semester">
                        <span class="details">Enter Semester Year:</span>
                        <input type="text" name="txtYear" id="txtYear" max-length="4" value="<?php echo $Year;?>" class="form_data" required>
                        <span id="YearError" class="text-danger"></span>
                        <input type="submit" name="btnSubmit" id="btnSubmit" value="Register">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../../scripts/navbar.js"></script>
    <script src="../../scripts/AddUser.js"></script>
</body>
</html>