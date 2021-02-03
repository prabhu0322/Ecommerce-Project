<?php
require_once('includes/session_start.php');
require( 'includes/db_con.php' );

$product_id = $_GET['product_id'];

// check if cart_session exists
if( empty( $_SESSION['cart_session'] ) ){
    $_SESSION['cart_session'] = [];
}


// check if product id exists in cart
$does_exists_in_cart = false;
if( !empty( $_SESSION['cart_session'] ) ){
    foreach ( $_SESSION['cart_session'] as $key => $item ) {
        if( $item['product_id'] == $product_id ){
            $does_exists_in_cart = true;
        }
    }
}

if( $does_exists_in_cart ){
    return header("Location:product_show.php?product_id=".$product_id."&msg=Product already exists in cart&success=0");
}

$product = [];
$d = $con->query( "SELECT * FROM products WHERE product_id=".$product_id." LIMIT 1" )->fetch_assoc();

if( $d ){
    $product = [
        'product_id' => $d['product_id'],
        'product_name' => $d['product_name'],
        'rate' => $d['price'],
        'qty' => ( $_POST['qty'] > 1 )? $_POST['qty'] : 1,
        'image' => $d['image'],
        'price' => 0,
    ];

    $product['price'] = $product['rate']*$product['qty'];
    array_push( $_SESSION['cart_session'], $product );

    return header("Location:cart.php?msg=Product successfully added to cart&success=1");
} else {
    return header("Location:product_show.php?product_id=".$product_id."&msg=Product does not exists&success=0");
}



