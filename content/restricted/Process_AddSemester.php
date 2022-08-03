<?php
    try {
        // Start session
        if (!isset($_SESSION)) {
            session_start();
        }

        // MySQL Connection variables                        
        $servername = "localhost";
        $username = "id19362852_myplannerko";
        $password = "6Q3Q|FZA}ue0^D=[";
        $database = "id19362852_myplannerdb";

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn) {
            // Get user ID
            $intUserID = $_SESSION['intUserID'];

            // Get form data
            $strSemester = trim($_POST['cboSemesters']);
            $intYear = trim($_POST['txtYear']);
            $StartDate = trim($_POST['dtmStart']);
            $EndDate = trim($_POST['dtmEnd']);

            // Set output for semester ID
            $query = "SET @intSemesterID = 0";
            $result = mysqli_query($conn, $query);

            // Clear result set
            while ($conn->more_results()) {
                $conn->next_result();
                if ($res = $conn->store_result()) {
                    $res->free();
                }
            }

            // Add semester into DB
            $query = "CALL uspAddSemester('$strSemester', $intYear, '$StartDate', '$EndDate', $intUserID, @intSemesterID)";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Clear result set
                while ($conn->more_results()) {
                    $conn->next_result();
                    if ($res = $conn->store_result()) {
                        $res->free();
                    }
                }

                // Get new SemesterID and set it to the active semester
                $query = "SELECT @intSemesterID AS intSemesterID";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['intSemesterID'] = $row['intSemesterID'];
                    echo 'Success';
                } else {
                    echo 'Failed';
                }
            } else {
                echo 'Failed';
            }
        }

        // Close database connection
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
?>
