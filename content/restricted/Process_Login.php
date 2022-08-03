<?php 
    try {
        // Start the session
        if (!isset($_SESSION)) {
            session_start();
        }

        // Get form data
        $Email = trim($_POST['txtEmail']);
        $Password = trim($_POST['txtPassword']);
        $_SESSION['txtEmail'] = $Email;
        $_SESSION['txtPassword'] = $Password;

        // Connect to DB
        include 'DB_Connection.php';
        $conn = OpenConnection();

        if ($conn) {
            // Check if email exists
            $query = "CALL uspLoggedIn('$Email', '$Password')";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Get data
                $row = mysqli_fetch_assoc($result);
                $_SESSION['txtEmail'] = $row['strEmail'];
                $_SESSION['intUserID'] = $row['intUserID'];

                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                }

                // Get current semester
                $intUserID = $_SESSION['intUserID'];
                $query = "SELECT intCurrentSemester FROM TUsers WHERE intUserID = $intUserID";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['intSemesterID'] = $row['intCurrentSemester'];
                } else {
                    // Clear result set
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }

                    // Get max semester ID as default
                    $query = "SELECT MAX(intSemesterID) as Semester FROM TSemesters WHERE intUserID = ". $_SESSION['intUserID'] ."";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['intSemesterID'] = $row['Semester'];
                    }
                }

                // User is logged in
                $_SESSION['blnLoggedIn'] = TRUE;

                // Print success message for AJAX
                echo "Success";
            } else {
                // Login failed
                $_SESSION['blnLoggedIn'] = FALSE;

                // Print error message for AJAX
                echo "Failed";
            }
        }

        // Close database connection
        CloseConnection($conn);

    } catch (Exception $e) {
        echo $e;
    }
?>