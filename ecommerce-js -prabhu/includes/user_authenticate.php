<?php

// check authentication

function user_not_allowed_routes(){
    $route = (!empty($_GET['route'])?$_GET['route']:'');
    $routes = [
        'product-edit',
        'createProduct',
         'dashboard',
    ];

    $is_allowed = true;

    if( in_array( $route, $routes ) ){
        $is_allowed = false;
    }


    return $is_allowed;

}

function check_authentication(){
    $role = ( !empty( $_SESSION['logged_user'] ) )? $_SESSION['logged_user']['role'] : null;

    if( $role == "USER" ){
        if( !user_not_allowed_routes() ){
            return header("Location:routes.php?route=unauthenticated&success=0&msg=Users are not allowed to access this page.");
        }
    }
}

check_authentication();