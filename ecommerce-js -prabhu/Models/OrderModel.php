<?php
namespace Models;

use Models\BaseModel;
use Models\OrderItemModel;
use Models\UserModel;

class OrderModel extends BaseModel {
    

    protected $table = "orders";
    protected $primaryKey = "order_id";
    protected $fillables = [ "user_id", "name", "email", "phone", "address", "delivery_status", "delivery_desc", "txn_no", "txn_status", "payment_id", "date_of_order" ];
    
    public function items(){        
        return ( new OrderItemModel() )->select()->where( 'order_id', '=', $this->attributes['order_id'] )->orderBy('order_item_id', 'DESC')->get()->getQueryResults();
    }

    public function user(){        
        return ( new UserModel() )->select()->where( 'user_id', '=', $this->attributes['user_id'] )->first();
    }
    public function searchItem( $search){
        $searchQuery = $this->select()->where('name', 'LIKE', "'".$search."%'" )->get()->getQueryResults();
        return $searchQuery;
        
    }
}

// SELECT * FROM orders WHERE name LIKE '$search%' OR email LIKE '$search%' ORDER BY order_id ASC