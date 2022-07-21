<?php 
    try {
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

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
            // Get user info
            $intUserID = $_SESSION['intUserID'];
            $intAssignmentID = $_GET['ID'];

            // Get form data
            if ($_POST['rngSlider'] == NULL || $_POST['rngSlider'] == "") {
                $Completion = 0;
            } else {
                $Completion = $_POST['rngSlider'];
            }
            if ($Completion < 100) {
                // Assignment is unfinished
                $Status = 1;
            } else {
                // Assignment is complete
                $Status = 2;
            }
            $Course = trim($_POST['cboCourses']);
            $Assignment = trim($_POST['txtTitle']);
            $Details = trim($_POST['txtDetails']);

            // Format date for MySQL
            $Date = trim($_POST['dtmDate']);
            $Date = strtotime($Date);
            $Date = date('Y-m-d H:i:s', $Date);

            // Update reason
            $strModifiedReason = "User updated assignment";

            // Update assignment
            $query = "CALL uspUpdateAssignment($intAssignmentID, '$Assignment', '$Details', '$Date', $Status, $Completion, $Course, '$strModifiedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                // Display success
                echo 'Success';
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