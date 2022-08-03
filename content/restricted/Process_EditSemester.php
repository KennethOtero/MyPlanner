<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get form data
    $intSemesterID = trim($_POST['cboSemesters']);

    // Get userID
    $intUserID = $_SESSION['intUserID'];

    try {
        // Connect to DB
        include 'DB_Connection.php';
        $conn = OpenConnection();

        if ($conn) {
            // Set the new active semester
            $query = "CALL uspActiveSemester($intSemesterID, $intUserID)";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $_SESSION['intSemesterID'] = $intSemesterID;
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