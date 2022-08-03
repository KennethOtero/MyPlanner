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
            // Get user ID
            $intUserID = $_SESSION['intUserID'];

            // Get semester ID
            $intSemesterID = $_SESSION['intSemesterID'];

            // Get Course ID
            $intCourseID = $_GET['ID'];

            // Get form data
            $strCourse = trim($_POST['txtCourse']);
            $strCourseNumber = trim($_POST['txtNumber']);
            $strInstructor = trim($_POST['txtInstructor']);
            $dtmStart = trim($_POST['dtmStart']);
            $dtmEnd = trim($_POST['dtmEnd']);

            // Get days
            $Monday = $_POST['Monday'];
            $Tuesday = $_POST['Tuesday'];
            $Wednesday = $_POST['Wednesday'];
            $Thursday = $_POST['Thursday'];
            $Friday = $_POST['Friday'];

            // Update reason
            $strModifiedReason = "User updated course";

            // Add course 
            $query = "CALL uspUpdateCourse($intCourseID, '$strCourse', '$strCourseNumber', '$strInstructor', $Monday, $Tuesday, $Wednesday, $Thursday, $Friday, 
                                        '$dtmStart', '$dtmEnd', $intSemesterID, $intUserID, '$strModifiedReason')";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "Success";
            } else {
                echo "Failed";
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>