<?php
require_once('includes/session_start.php');

$product_id = $_GET['product_id'];

// check if cart_session exists
if( empty( $_SESSION['cart_session'] ) ){
    $_SESSION['cart_session'] = [];
}


// check if product id exists in cart
if( !empty( $_SESSION['cart_session'] ) ){
    foreach ( $_SESSION['cart_session'] as $key => $item ) {
        if( $item['product_id'] == $product_id ){
            unset( $_SESSION['cart_session'][$key] );
            // $_SESSION['cart_session'][$key]=0;

        }
    }
}


return header("Location:routes.php?route=carts&msg=Product removed from cart&success=1");
//unset is used to clear the data existing in array
?>