<?php

use Controllers\BaseController;
use Razorpay\Api\Api;

class CartController extends BaseController {

    public function index(  ){
        
        $info = [
            'items' => [],
            // 'items' => (!empty( $_SESSION['cart_session'] )  )? $_SESSION['cart_session'] : [],
            'count' => 0,
            'total_price' => 0,
        ];

        $info['count'] = count( $info['items'] );

        if( !empty( $_SESSION['cart_session'] ) ){

            foreach( $_SESSION['cart_session'] as $item ){
                array_push( $info['items'], $item );
                $info['total_price'] = $info['total_price'] + $item['price'];
            }
    
            $_SESSION['cart_session'] = $info['items'];
        } else {
            $_SESSION['cart_session'] = [];
        }
    
        return $info;
        
    }

    public function checkoutPrepare(){
        $info = $this->index();
        $info['api_key'] = razorpay_api_key;
        $api_secret = razorpay_api_secret;
        
        // $info['api_key'] = "rzp_live_5OvghP1MyHCTEP";
        // $api_secret = 'AvcWNIrMrriMv80f92yULd8R';


        $info['total_converted_to_paisa'] = $info['total_price']*100;
        // $info['total_converted_to_paisa'] = 1*100;

// dd( $info );
        
        $api = new Api( $info['api_key'], $api_secret);

        $info['txn_no'] = rand(10,1000);

        $query = [
            'receipt' => $info['txn_no'],
            'amount' => $info['total_converted_to_paisa'],
            'currency' => 'INR',
        ];

        $info['order'] = $api->order->create( $query );

        return $info;
    }


// add item to carttttttttttttttttttttttttt

    public function pushItem( $item = [] ){

        $info = [
            'success' => false,
            'msg' => "Something went wrong",
            'does_exists_in_cart' => false,
            'item' => [],
        ];

        if( empty( $_SESSION['cart_session'] ) ){
            $_SESSION['cart_session'] = [];
        }

        $product_id = $item['product_id'];

        // check if product id exists in cart
        if( !empty( $_SESSION['cart_session'] ) ){
            foreach ( $_SESSION['cart_session'] as $key => $item ) {
                if( $item['product_id'] == $product_id ){
                    $info['does_exists_in_cart'] = true;
                }
            }
        }

        if( !$info['does_exists_in_cart'] ){
            $product = [];
            $d = $this->db()->query( "SELECT * FROM products WHERE product_id=".$product_id." LIMIT 1" )->fetch_assoc();

            if( $d ){
                $product = [
                    'product_id' => $d['product_id'],
                    'product_name' => $d['product_name'],
                    'rate' => $d['price'],
                    'qty' => ( $item['qty'] > 1 )? $item['qty'] : 1,
                    'image' => $d['image'],
                    'price' => 0,
                ];

                $product['price'] = $product['rate']*$product['qty'];
                array_push( $_SESSION['cart_session'], $product );

                $info['success'] = true;
                $info['item'] = $product;
                $info['msg'] = "Successfully added to cart.";
            }
        } else {
            $info['msg'] = "Product already exists in cart";
        }

        return $info;
    }

    public function removeItem( $product_id ){

        $info = [
            'success' => true,
        ];

        // check if product id exists in cart
        if( !empty( $_SESSION['cart_session'] ) ){
            foreach ( $_SESSION['cart_session'] as $key => $item ) {
                if( $item['product_id'] == $product_id ){
                    unset( $_SESSION['cart_session'][$key] );
                }
            }
        }

        return $info;
    }


    public function updateItem( $qty, $product_id ){

        $info = [
            'success' => true,
        ];
        // dd( $_SESSION['cart_session'] );

        // check if product id exists in cart
        if( !empty( $_SESSION['cart_session'] ) ){
            foreach ( $_SESSION['cart_session'] as $key => $item ) {
                if( $item['product_id'] == $product_id ){
                    $_SESSION['cart_session'][$key]['qty'] = $qty;
                    $_SESSION['cart_session'][$key]['price'] = $item['rate']*$qty;
                }
            }
        }

        return $info;
    }
}