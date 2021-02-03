<?php 
require('includes/session_start.php');
require('includes/db_con.php');
require('includes/utils.php');

$query = "SELECT * FROM users WHERE email = '".$_POST['email']."' AND password = '".$_POST['pass']."' LIMIT 1 ";

$res = $con->query($query);


if($res->num_rows){
    $user = $res->fetch_assoc();
    $_SESSION['logged_user'] = $user;
    if($user['role'] == "USER"){
        
        return header("Location:main-page.php?msg=Login Successful&success=1"); 
    }else if($user['role'] == "ADMIN"){

        return header("Location:dashboard.php?msg=Login Successful&success=1"); 
    }
}else{
    return header("Location:login.php?msg=Login Failed&success=0"); 
}

?>