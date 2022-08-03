<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get form data
    $intSemesterID = trim($_POST['cboSemesters']);

    // Get userID
    $intUserID = $_SESSION['intUserID'];

    // Delete the currently selected semester
    try {
        // Connect to DB
        include 'DB_Connection.php';
        $conn = OpenConnection();

        if ($conn) {
            // Deletion reason
            $strModifiedReason = "User deleted semester";
            
            // Delete the semester
            $query = "CALL uspDeleteSemester($intSemesterID, $intUserID, '$strModifiedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>