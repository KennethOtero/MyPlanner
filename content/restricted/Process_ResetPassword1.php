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
            // Get form data
            $Email = trim($_POST['txtEmail']);
            $_SESSION['Email'] = $Email;

            // Check if email exists
            $query = "SELECT strEmail FROM TUsers WHERE strEmail = '$Email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // Set session email to correct email and move onto security question
                $_SESSION['Email'] = $Email;
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
