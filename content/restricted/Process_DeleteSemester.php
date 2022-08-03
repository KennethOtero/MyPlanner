<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get form data
    $intSemesterID = trim($_POST['cboSemesters']);

    // Get userID
    $intUserID = $_SESSION['intUserID'];

    // Insert into DB currently selected semester
    try {
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
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
?>