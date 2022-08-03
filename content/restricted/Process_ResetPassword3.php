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
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
?>