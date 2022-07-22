<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Planner | Edit Semesters</title>
    <link rel="stylesheet" href="../../styles/home.css">
    <link rel="stylesheet" href="../../styles/editsemester.css">
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

            // Get UserID
            $intUserID = $_SESSION['intUserID'];
        } catch (Exception $e) {
            echo $e;
        }
    ?>

    <div class="container">
        <div class="EditSemester">
            <p>EDIT SEMESTERS</p>
            <div class="fields">
                <span id="message"></span>
            </div>
            <form name="frmEdit" id="frmEdit" method="post" onsubmit="return ajax()">
                <div class="fields">
                    <span class="details">Select Current Semester</span>
                    <select name="cboSemesters" id="cboSemesters" class="form_data" required>
                        <option value="0">Select Semester</option>
                        <?php 
                            // Load semesters
                            if ($conn) {
                                $query =    "SELECT 
                                                TS.intSemesterID, 
                                                CONCAT(TS.strSemester,' ',TS.intYear) as Semester
                                            FROM 
                                                TSemesters as TS JOIN TUsers as TU
                                                    ON TS.intUserID = TU.intUserID
                                            WHERE
                                                TU.intUserID = $intUserID";
                                $result = mysqli_query($conn, $query);
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $intSemesterID = $row['intSemesterID'];
                                        $Semester = $row['Semester'];
                                        // Select the current semester
                                        if ($intSemesterID == $_SESSION['intSemesterID']) {
                                            echo 
                                            '
                                            <option value="'. $intSemesterID .'" selected>'. $Semester .'</option>
                                            ';
                                        } else {
                                            echo 
                                            '
                                            <option value="'. $intSemesterID .'">'. $Semester .'</option>
                                            ';
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                    <span id="SemesterError" class="text-danger"></span>
                </div>
                <input type="submit" name="btnSubmit" id="btnSubmit" value="Set As Current Semester">
                <div class="Add">
                    <a href="#" id="btnDelete" onclick="return deleteSemester()">Delete Selected Semester</a>
                </div>
                <div class="Add">
                    <a href="AddSemester.php">Add New Semester</a>
                </div>
            </form>
        </div>
    </div>

    <?php 
        // Close database connection
        $conn->close();
    ?>

    <script src="../../scripts/navbar.js"></script>
    <script src="../../scripts/EditSemester.js"></script>
</body>
</html>