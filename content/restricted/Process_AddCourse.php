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
            // Get user ID
            $intUserID = $_SESSION['intUserID'];

            // Get semester ID
            $intSemesterID = $_SESSION['intSemesterID'];

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

            // Add course 
            $query = "CALL uspAddCourse('$strCourse', '$strCourseNumber', '$strInstructor', $Monday, $Tuesday, $Wednesday, $Thursday, $Friday, 
                                        '$dtmStart', '$dtmEnd', $intSemesterID, $intUserID, @intCourseID)";
            $result = mysqli_query($conn, $query);
            if ($result) {
                echo "Success";
            } else {
                echo "Failed";
            }
        }
    } catch (Exception $e) {
        echo $e;
    }
?>