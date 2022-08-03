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
            $Email = $_SESSION['Email'];

            // Get form data
            $Security = trim($_POST['txtSecurity']);

            // Make it case insensitive
            $Security = strtolower($Security);

            // Check for security question
            $query = "SELECT strSecurity FROM TUsers WHERE strEmail = '$Email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                // Make it case insensitive
                $strSecurity = strtolower($row['strSecurity']);

                // Check answer
                if ($strSecurity == $Security) {
                    // Display success
                    echo 'Success';
                } else {
                    // Display error
                    echo 'Failed';
                }
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>