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
            // Get course ID
            $intCourseID = $_GET['ID'];

            // Get user ID
            $intUserID = $_SESSION['intUserID'];

            // Deletion reason
            $strModifiedReason = "User deleted course";

            $query = "CALL uspDeleteCourse($intCourseID, $intUserID, '$strModifiedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }
        
        // Close database connection
        $conn->close();
    } catch(Exception $e) {

    }
?>