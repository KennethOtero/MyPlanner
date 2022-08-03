<?php 
    // Create the DB connection
    function OpenConnection() {
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

        // Return connection status
        return $conn;
    }

    // Close the DB connection. 
    // Accepts the connection variable $conn
    function CloseConnection($conn) {
        // Close the database connection
        $conn->close();
    }
?>