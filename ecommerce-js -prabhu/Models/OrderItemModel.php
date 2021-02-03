<?php
namespace Models;

use Models\BaseModel;

class OrderItemModel extends BaseModel {
    

    protected $table = "order_items";
    protected $primaryKey = "order_item_id";
    protected $fillables = [ "order_id", "product_id", "qty", "rate", "price" ];
    
    
}