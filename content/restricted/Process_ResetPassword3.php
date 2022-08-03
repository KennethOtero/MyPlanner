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
            // Get email
            $Email = trim($_SESSION['Email']);

            // Get form data
            $Password = trim($_POST['txtPassword']);

            // Set update reason
            $strModifedReason = "User reset their password";

            // Update password
            $query = "CALL uspResetPassword('$Email', '$Password', '$strModifedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                // Successful password reset
                echo 'Success';
            } else {
                // Display error
                echo 'Failed';
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>