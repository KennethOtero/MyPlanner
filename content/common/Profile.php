<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Profile</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="shortcut icon" type="image/x-icon" href="../../images/tab_logo.png" />
</head>
<body>
    <?php 
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['txtName'])) {
            $_SESSION['txtName'] = "";
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

            if ($conn) {
                // Get Profile data
                $intUserID = $_SESSION['intUserID'];
                $query = "SELECT strName, strEmail, strSecurity, strPassword FROM TUsers WHERE intUserID = $intUserID";
                $result = mysqli_query($conn, $query);
                $row = mysqli_fetch_assoc($result);
                $Name = $row['strName'];
                $Email = $row['strEmail'];
                $Security = $row['strSecurity'];
                $Password = $row['strPassword'];
            }
        } catch (Exception $e) {
            echo $e;
        }
    ?>

    <div class="container">
        <div class="UpdateProfile">
            <p>UPDATE PROFILE</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form id="frmUpdate" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Name</span>
                    <input type="text" name="txtName" id="txtName" value="<?php echo $Name;?>" class="form_data" required>
                    <span id="NameError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Email</span>
                    <input type="email" name="txtEmail" id="txtEmail" value="<?php echo $Email;?>" class="form_data" required>
                    <span id="EmailError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Password</span>
                    <input type="password" name="txtPassword" id="txtPassword" class="form_data" value="<?php echo $Password;?>" required>
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <span id="PasswordError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Confirm Password</span>
                    <input type="password" name="txtConfirm" id="txtConfirm" class="form_data" required>
                    <i class="bi bi-eye-slash" id="toggleConfirm"></i>
                    <span id="ConfirmError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <span class="details">Security: What City Were You Born In?</span>
                    <input type="text" name="txtSecurity" id="txtSecurity" value="<?php echo $Security?>" class="form_data" required>
                    <span id="SecurityError" class="text-danger"></span>
                </div>
                <div class="fields">
                    <input type="submit" name="btnSubmit" id="btnSubmit" value="Update Profile">
                </div>
            </form>
        </div>
    </div>

    <script src="../../scripts/navbar.js"></script>
    <script src="../../scripts/UpdateProfile.js"></script>
</body>
</html>