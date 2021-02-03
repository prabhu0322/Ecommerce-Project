<?php
require_once('includes/session_start.php');
require( 'includes/db_con.php' );
require( 'includes/utils.php' );

require 'vendor/autoload.php';

$data_of_order = date( 'Y-m-d' );
$user_id = (!empty ($_SESSION['logged_user'] ) )? $_SESSION['logged_user']['user_id']: 'NULL';
$sql = "INSERT INTO orders ( user_id ,name, email, phone, address, txn_no, txn_status, payment_id, date_of_order, delivery_status ) VALUES ( $user_id,'".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['address']."', '".$_POST['txn_no']."', 'success', '".$_POST['payment_id']."', '".$data_of_order."', 'pending'  ) ";
$query = $con->query( $sql );

dd( $con->error );

$order_id = $con->insert_id;

// get items from session
$items = $_SESSION['cart_session'];

if( !empty( $items ) ){
    foreach ( $items as $key => $item ) {
        $sql = "INSERT INTO order_items ( order_id, product_id, qty, rate, price ) VALUES ( '".$order_id."', '".$item['product_id']."', '".$item['qty']."', '".$item['rate']."', '".$item['price']."'  ) ";

        // dd( $sql );

        $con->query( $sql );
    }
}

// return header("Location:main-page.php?success=1&msg=Order Placed successfully.");
