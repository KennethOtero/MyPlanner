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
            $Name = trim($_POST['txtName']);
            $Email = trim($_POST['txtEmail']);
            $Password = trim($_POST['txtPassword']);
            $Security = trim($_POST['txtSecurity']);
            $Semester = trim($_POST['cboSemesters']);
            $Year = trim($_POST['txtYear']);

            // Session variables in case the user has to go back
            $_SESSION['Name'] = $Name;
            $_SESSION['Email'] = $Email;
            $_SESSION['Password'] = $Password;
            $_SESSION['Security'] = $Security;
            $_SESSION['Semester'] = $Semester;
            $_SESSION['Year'] = $Year;


            // Check if email exists
            $query = "SELECT strEmail FROM TUsers WHERE strEmail = '$Email'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // Display error
                echo 'Email Exists';

                // Exit script
                return;
            } else {
                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                }
            }

            // Set intUserID variable
            $result = mysqli_query($conn, "SET @intUserID = 0");
            $result = mysqli_query($conn, "SET @intSemesterID = 0");
            if ($result) {
                // Clear result set
                while($conn->more_results()){
                    $conn->next_result();
                    if($res = $conn->store_result())
                    {
                        $res->free(); 
                    }
                }

                // Add user
                $query = "CALL uspAddUser('$Name', '$Email', '$Password', '$Security', '$Semester', $Year, @intUserID, @intSemesterID)";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    // Clear result set
                    while($conn->more_results()){
                        $conn->next_result();
                        if($res = $conn->store_result())
                        {
                            $res->free(); 
                        }
                    }

                    // Get new intUserID
                    $query = "SELECT @intUserID AS intUserID, @intSemesterID as intSemesterID";
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        // Set global intUserID
                        $_SESSION['intUserID'] = $row['intUserID'];
                        $_SESSION['intSemesterID'] = $row['intSemesterID'];

                        // Log user in
                        $_SESSION['blnLoggedIn'] = TRUE;
                        echo 'Success';
                    } else {
                        // Display error
                        echo 'Failed to retrieve user data';
                    }
                } else {
                    // Display error
                    echo 'Failed to create user';
                }
            } else {
                // Display error
                echo 'Failed to create database variables';
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>