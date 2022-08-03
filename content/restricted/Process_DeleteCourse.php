<?php 
    try {
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        // Connect to DB
        include 'DB_Connection.php';
        $conn = OpenConnection();

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
        CloseConnection($conn);
    } catch(Exception $e) {

    }
?>