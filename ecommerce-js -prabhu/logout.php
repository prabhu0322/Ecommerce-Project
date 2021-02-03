<?php
    require( 'includes/session_start.php');
    $_SESSION['logged_user'] = null;
    
    return header("Location:main-page.php?msg=logged out&success=1");
?>