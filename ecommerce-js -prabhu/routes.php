<?php

require_once( dirname(__FILE__).'/includes/session_start.php');

define( 'project_root', __DIR__."/" );
define( 'view_root', 'Views/' );
define( 'razorpay_api_key', 'rzp_test_XYdu6Yc7w5HAcz' );
define( 'razorpay_api_secret', 'CeYZDwwPBzIDKHg46D4dxjsk' );

// var_dump(__DIR__);exit;

require_once( dirname(__FILE__).'/Controllers/BaseController.php');
require_once( dirname(__FILE__).'/Controllers/CartController.php');

require( dirname(__FILE__).'/Models/BaseModel.php');
require( dirname(__FILE__).'/Models/OrderModel.php');
require( dirname(__FILE__).'/Models/OrderItemModel.php');
require( dirname(__FILE__).'/Models/UserModel.php');

require_once( dirname(__FILE__).'/vendor/autoload.php');
require( 'includes/db_con.php' );
require( 'includes/utils.php' );
require( 'includes/user_authenticate.php' );


$route = ( !empty( $_GET['route'] ) )? $_GET['route'] : null;


if( $route == "unauthenticated" ){
    include( view_root.'unauthenticated.php' );
}

if( $route == "carts" ){
    include( view_root.'cart/cartList.php' );
}

if( $route == "ajax-carts" ){
    $info = ( new CartController() )->index();
    echo json_encode( $info );
    
}

if( $route == "ajax-remove-cart-item" ){
    $info = ( new CartController() )->removeItem( $_GET['product_id'] );
    echo json_encode( $info );
}

if( $route == "ajax-update-cart-item-qty" ){
    $info = ( new CartController() )->updateItem( $_GET['qty'], $_GET['product_id'] );
    echo json_encode( $info );
}

if( $route == "ajax-add-to-cart" ){
    
    $item = [
        'product_id' => $_GET['product_id'],
        'qty' => $_POST['qty'],
    ];
    
    $info = ( new CartController() )->pushItem( $item );

    echo json_encode( $info );
}

if( $route == "checkout" ){
    
    $info = ( new CartController() )->checkoutPrepare();
    
    include( view_root.'cart/checkout.php' );
}

if( $route == "order-process" ){
  
    require_once( dirname(__FILE__).'/Controllers/OrderController.php');

    $info = ( new OrderController() )->process();
    // dd($info);

    if( $info['success'] ){
        return header("Location:main-page.php?success=1&msg=".$info['msg']);
    } else {
        return header("Location:main-page.php?success=0&msg=".$info['msg']);
    }
}

if( $route == "product-show" ){
    include( view_root.'products/show.php' );
}
//you should create seperate routes to first get the data in json format and then to display that data
if( $route == "ajax-product-show" ){
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');

    $info = ( new ProductController() )->show( $_GET['product_id'] );

    
    echo json_encode($info);
}

if($route == "empty-cart"){
    $_SESSION['cart_session'] = [];
    echo json_encode(['success' => true]);
    // return header("Location:routes.php?route=carts&msg=Cart Cleared&success=1");
}
//loading main-page using ajax
if($route == "ajax-load-main-page-data"){
    
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');

    $info = ( new ProductController() )->index( );


    echo json_encode( $info );
    
}
//customizing data table using ajax data table options
if($route == "ajax-orders"){
    
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');

    $data = $_GET; 

    // var_dump( $data );exit;

    $info = ( new ProductController() )->ajaxOrders( $data );

    echo json_encode( $info );
    
}

if($route == "ajax-payment-info"){
    
    require_once( dirname(__FILE__).'/Controllers/OrderController.php');


    // var_dump( $data );exit;

   $info = ( new OrderController() ) -> paymentInfo($_GET['payment_id']);
   echo json_encode($info);
    
}

if($route == "ajax-remove-product-slide"){
    
   require_once( dirname(__FILE__).'/Controllers/ProductController.php');

   $info = ( new ProductController() )->removeSlide($_GET['id']);
   echo json_encode($info);
    
}


if($route == "createProduct"){
    
    include( view_root.'products/create.php' );
     
  
}
if($route == "saveProduct"){
    
    
     
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');
    $data = $_POST;
    // dd($data);exit;
    $info = ( new ProductController() )->create($data);
   
    echo json_encode($info);
    // echo $info;exit;
}
if($route == "product-edit"){
    
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');
 
    $info = ( new ProductController() )->edit($_GET['product_id']);

    $form = $info['form'];
    $slides = $info['slides'];
   
    include( view_root.'products/create.php' );
     
 }

 if($route == "recentOrders"){
    require_once( dirname(__FILE__).'/Controllers/OrderController.php');
 
    $info = ( new OrderController() )->getRecentOrders();
    // dd($info);
    echo json_encode($info);


 }
 if($route == "getCarouselImages"){
    require_once( dirname(__FILE__).'/Controllers/ProductController.php');
 
    $info = ( new ProductController() )->index();
    // dd($info);exit;
    echo json_encode($info);


 }



?>