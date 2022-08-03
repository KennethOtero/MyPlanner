<?php
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Get UserID
    $intUserID = $_SESSION['intUserID'];

    // Get form data
    $Name = trim($_POST['txtName']);
    $Email = trim($_POST['txtEmail']);
    $Password = trim($_POST['txtPassword']);
    $Security = trim($_POST['txtSecurity']);
    $_SESSION['txtName'] = $Name;
    $_SESSION['txtEmail'] = $Email;
    $_SESSION['txtSecurity'] = $Security;
    $_SESSION['txtPassword'] = $Password;

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
            // Update reason
            $strModifiedReason = "User updated their profile";
            
            // Update profile
            $query = "CALL uspUpdateUser($intUserID, '$Name', '$Email', '$Password', '$Security', '$strModifiedReason')";
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
