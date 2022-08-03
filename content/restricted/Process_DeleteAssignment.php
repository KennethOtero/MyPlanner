<?php 
    try {
        // Start the session
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
            // Get assignment ID
            $intAssignmentID = $_GET['ID'];

            // Delete reason
            $strModifiedReason = "User deleted assignment";

            // Delete assignment
            $query = "CALL uspDeleteAssignment($intAssignmentID, '$strModifiedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo 'Success';
            } else {
                echo 'Failed';
            }
        } else {
            echo 'Failed';
        }
        
        // Close database connection
        $conn->close();
    } catch(Exception $e) {
        echo $e;
    }
?>