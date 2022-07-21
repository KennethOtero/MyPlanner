<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Reset Password</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/resetpassword.css">
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

    <div class="container">
        <div class="resetpassword">
            <p>RESET PASSWORD</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form name="frmReset" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Enter New Password:</span>
                    <input type="password" name="txtPassword" id="txtPassword" class="form_data" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <span id="PasswordError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Confirm New Password:</span>
                    <input type="password" name="txtConfirm" id="txtConfirm" class="form_data" required>
                    <i class="bi bi-eye-slash" id="toggleConfirm"></i>
                    <span id="ConfirmError" class="text-danger"></span>
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Submit">
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

    <script src="../../scripts/navbar.js"></script>
    <script src="../../scripts/ResetPassword3.js"></script>
</body>
</html>