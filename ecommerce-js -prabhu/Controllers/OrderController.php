<?php

use Controllers\BaseController;
use Razorpay\Api\Api;
use Models\BaseModel;
use Models\OrderModel;

class OrderController extends BaseController {


    public function process(){
        
        global $con;

        $info = [
            'success' => false,
            'msg' => "Something went wrong.",
        ];

        $data_of_order = date( 'Y-m-d' );
        $user_id = (!empty ($_SESSION['logged_user'] ) )? $_SESSION['logged_user']['user_id']: 'NULL';
        $sql = "INSERT INTO orders ( user_id ,name, email, phone, address, txn_no, txn_status, payment_id, date_of_order, delivery_status ) VALUES ( $user_id,'".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['address']."', '".$_POST['txn_no']."', 'success', '".$_POST['payment_id']."', '".$data_of_order."', 'pending'  ) ";

        // dd( [ $this->db() ] );

        $query = $this->db()->query( $sql );

        // dd( $this->db()->error );

        $order_id = $this->db()->insert_id;

        // dd( $order_id );

        // get items from session
        $items = $_SESSION['cart_session'];

        if( !empty( $items ) && !empty( $order_id ) ){
            foreach ( $items as $key => $item ) {
                $sql = "INSERT INTO order_items ( order_id, product_id, qty, rate, price ) VALUES ( '".$order_id."', '".$item['product_id']."', '".$item['qty']."', '".$item['rate']."', '".$item['price']."'  ) ";

                // dd( $sql );

                $this->db()->query( $sql );
            }

            $info['success'] = true;
            $info['msg'] = "Order Placed successfully";

        }

        return $info;
    }
    // public function paymentInfo($payment_id){
        
    //     $info = [
    //         'payment_info' => []
    //     ];

    //     $api = new Api( razorpay_api_key, razorpay_api_secret);
    //     $info['payment_info'] = $api->Payment->fetch( $payment_id )->toArray();

    //     return $info;

    // }
    public function paymentInfo($payment_id)
    {

        // var_dump(file_exists(project_root.'Models/BaseModel.php'));
        // exit;
        // dd( project_root.'Models/BaseModel.php' );
        // require_once( project_root.'Models/BaseModel.php');

        // C:\laragon\www\php_learn\ecommerce-js\Models\BaseModel.php
        $b = new OrderModel();
        $d = $b->select()->get()->getQueryResults();
    //     echo '<pre>';
    //    print_r($d[0]->items());
    //    echo '</pre>';
        // dd( $d[0]->user() );    
        // dd( $d[0]->items() );
        // dd($b->searchItem());
        // exit;
    
        
        $info = [
                    'payment_info' => []
                ];
        
        $api = new Api( razorpay_api_key, razorpay_api_secret);
        
        
        $info['payment_info'] = $api->Payment->fetch($payment_id)->toArray();

        return $info;
    }

    public function getRecentOrders(){
        $info = [
            'recent_orders' =>$this->prepareQuery( "SELECT * FROM orders ORDER BY order_id DESC LIMIT 5" )
        ];
        // dd($info);exit;

        return $info;

    }
}