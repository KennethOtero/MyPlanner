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
            $Course = trim($_POST['cboCourses']);
            $Date = trim($_POST['dtmDate']);
            $Assignment = trim($_POST['txtTitle']);
            $Details = trim($_POST['txtDetails']);

            // Format datetime to insert into MySQL correctly
            $Date = strtotime($Date);
            $Date = date('Y-m-d H:i:s', $Date);

            // Add course
            $query = "CALL uspAddAssignment('$Assignment', '$Details', '$Date', 1, $Course, @intAssignmentID)";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo 'Success';
            } else {
                echo 'Failed';
            }
        }

        // Close DB connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>