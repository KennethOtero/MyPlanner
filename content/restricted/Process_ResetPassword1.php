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
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>
