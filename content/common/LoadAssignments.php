<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Display errors
    if(TRUE) // toggle to false after debugging
    {
      ini_set( 'display_errors', 'true');
      error_reporting(-1);
    }

    try {
        if ($_SESSION['blnLoggedIn'] == FALSE) {
            echo 
            '
            <tr class="SignIn">
                <td colspan="4">Sign In To View Assignments</td>
            </tr>
            <style>
                .SignIn { 
                    text-align: center;
                }
            </style>
            ';
            return;
        }

        // MySQL Connection variables                        
        $servername = "localhost";
        $username = "root";
        $password = "CPDM-OteroK";
        $database = "dbsql";
        
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $database);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn) {
            // Get unfinished assignments
            $intUserID = $_SESSION['intUserID'];
            if (!isset($_SESSION['intSemesterID'])) {
                $intSemesterID = 0;
            } else {
                $intSemesterID = $_SESSION['intSemesterID'];
            }
            
            $query = "CALL uspMonthlyAssignments($intUserID, $intSemesterID)";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Get data
                    $Class = $row['strCourse'];
                    $Assignment = $row['strAssignment'];
                    $Date = strtotime($row["dtmDueDate"]);
                    $Date = date('m/d/Y', $Date);
                    $Status = $row['strStatus'];
                    $intAssignmentID = $row['intAssignmentID'];
    
                    // Display unfinished assignments
                    echo 
                    '
                    <tr>
                        <td>'. $Class .'</td>
                        <td>'. $Assignment .'</td>
                        <td>'. $Date .'</td>
                        <td><a href="content/common/UpdateAssignment.php?ID='. $intAssignmentID .'">'. $Status .'</a></td>
                    </tr>
                    ';
                }
            } else {
                // Display unfinished assignments
                echo 
                '
                <tr>
                    <td colspan="4" class="error">No assignments due this month</td>
                </tr>
                <style>
                    .error {
                        text-align: center;
                    }
                </style>
                ';
            }
        }

        // Close database connection
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
?>