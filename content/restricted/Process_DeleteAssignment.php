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
        CloseConnection($conn);
    } catch(Exception $e) {
        echo $e;
    }
?>