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
                <td colspan="4">Sign In To View Courses</td>
            </tr>
            <style>
                .SignIn { 
                    text-align: center;
                }
            </style>
            ';
            return;
        }

        // Connect to DB
        // Since this is an included file from the index.php, using include again
        // will cause problems. Solution: use an absolute path to DB_Connection.php with __DIR__
        require_once __DIR__ . '/../restricted/DB_Connection.php';
        $conn = OpenConnection();

        if ($conn) {
            // Query
            $intUserID = $_SESSION['intUserID'];
            if (!isset($_SESSION['intSemesterID'])) {
                $intSemesterID = 0;
            } else {
                $intSemesterID = $_SESSION['intSemesterID'];
            }
            $query = "CALL uspCurrentCourses($intUserID, $intSemesterID)";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                // Get data
                $CourseNumber = $row['strCourseNumber'];
                $Course = $row['strCourse'];
                $Instructor = $row['strInstructor'];
                $intCourseID = $row['intCourseID'];

                // Display courses
                echo 
                '
                <tr>
                    <td><a href="content/common/UpdateCourse.php?ID='. $intCourseID .'">'. $CourseNumber .'</a></td>
                    <td>'. $Course .'</td>
                    <td>'. $Instructor .'</td>
                </tr>
                ';
            }
        }

        // Close database connection
        CloseConnection($conn);
    } catch (Exception $e) {
        echo $e;
    }
?>