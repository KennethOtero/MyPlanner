<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Sign In</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../images/tab_logo.png" />
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

                    if (!isset($_SESSION['txtEmail'])) {
                        $_SESSION['txtEmail'] = "";
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
        if (!isset($_SESSION['txtEmail']) || !isset($_SESSION['txtPassword'])) {
            $Email = "";
            $Password = "";
        } else {
            $Email = $_SESSION['txtEmail'];
            $Password = $_SESSION['txtPassword'];
        }
    ?>

    <div class="container">
        <div class="login">
            <p>SIGN IN</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form name="frmLogin" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Email</span>
                    <input type="email" name="txtEmail" id="txtEmail" class="form_data" value="<?php echo $Email;?>" required>
                    <span id="EmailError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Password</span>
                    <input type="password" name="txtPassword" id="txtPassword" class="form_data" value="<?php echo $Password;?>" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <span id="PasswordError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Sign In">
                </div>
                <div class="reset">
                    <a href="ResetPassword.php">Forgot Password?</a>
                </div>
                <div class="register">
                    <a href="AddUser.php">Register For an Account</a>
                </div>
            </form>
        </div>
    </div>

    <script src="../../scripts/navbar.js"></script>
    <script src="../../scripts/Login.js"></script>
</body>
</html>