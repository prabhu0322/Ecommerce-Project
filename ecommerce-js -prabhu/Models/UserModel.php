<?php
namespace Models;

use Models\BaseModel;
use Models\OrderItemModel;

class UserModel extends BaseModel {

    protected $table = "users";
    protected $primaryKey = "user_id";
    protected $fillables = [ "user_name", "email", "password" ];
    
}