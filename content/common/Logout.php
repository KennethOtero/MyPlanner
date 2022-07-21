<?php 
    // Start the session
    if (!isset($_SESSION)) {
        session_start();
    }

    // Set session login variables to false (log out)
    $_SESSION['blnLoggedIn'] = false;

    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect back to homepage
    header('Location: ../index.php');
?>