<?php

use Controllers\BaseController;
use Razorpay\Api\Api;
use Models\BaseModel;
use Models\OrderModel;

class ProductController extends BaseController {


    public function index(  ){
    
        $info = [
            'product_list' => $this->prepareQuery( "SELECT * FROM products ORDER BY product_id DESC" ),
        ];

        return $info;
    }

    public function show( $product_id ){
    
        $info = [
            'form' => $this->db()->query( "SELECT * FROM products WHERE product_id='$product_id' LIMIT 1" )->fetch_assoc(),
        ];

        return $info;
    }

    public function ajaxOrders( $data ){

        // dd( $data);
    
        $info = [
            'draw' => $data['draw'],
            'data' => [],
            'total' => 0,
        ];

        $start = $data['start'];
        $length = $data['length'];
        $search = $data['search']['value'];
        // $search = 'mahesh';

        $q = new OrderModel(); 

        // dd( $q->select()-where( 'name', "LIKE", "'".$search."%'" )->where( 'email', "LIKE", "'".$search."%'" )->getQuery() ); 

        // dd($q->searchItem($search));exit;   
        $query = "SELECT * FROM orders WHERE name LIKE '$search%' OR email LIKE '$search%' ORDER BY order_id ASC";
        $append_limit = "";
        if( $length > -1 ){
            $append_limit = " LIMIT $start, $length";
        }
        
        // dd( $append_limit );
        // print_r($query);

        $info['data'] = $this->prepareQuery( $query.$append_limit );
        // dd($info['data']);
        foreach( $info['data'] as $k => $item ){
            $payment_id = $item["payment_id"];
            // $item['payment_content'] = $item['payment_id']." <button type='button' onclick='show_payment_info( ".'"'.$payment_id.'"'." )' >Show Payment Info</button> ";
            $item['payment_content'] =" <button type='button' class='btn btn-primary' onclick='show_payment_info( ".'"'.$payment_id.'"'." )' >Show Payment Info </button> ";

            $info['data'][$k] = $item;
            // dd($item);
        }

        $info['total'] = $this->prepareQuery( "SELECT COUNT(*) as count_rows FROM orders WHERE name LIKE '$search%' OR email LIKE '$search%' LIMIT 1" )[0]['count_rows'];
        // dd($info['total']);
        return $info;


    }

    public function removeSlide( $id ){
        $info = [
            'success' => false,
            'msg' => "Something went wrong.",
        ];

        $res = $this->db()->query( "DELETE FROM product_slides WHERE id=$id" );

        if( $res ){
            $info['success'] = true;
        }

        return $info;
    }

    public function create($data){
        $info = [
            'success' => false,
            'msg' => "something went wrong",
        ];
        // dd( $_FILES['slides'] );

        if(isset($_FILES['file']['name']) && !empty($_FILES['file']['name']) ){

            $file_ext = explode('.', $_FILES['file']['name'])[1];
            $img = "new_file_".rand(0,100).".".$file_ext;
            $result = move_uploaded_file($_FILES['file']['tmp_name'],"uploads/".$img);
            //to check if fileuplaoded successfully
            if($result){
                $file_name = $img;
            }
        }

        $slides_arr = [];
        $slide_name= null;
        if( isset( $_FILES['slides']['tmp_name'] ) && !empty( $_FILES['slides']['tmp_name'] ) ){

            foreach ( $_FILES['slides']['tmp_name'] as $key => $tmp_name ) {

                if( empty($tmp_name) ){
                    continue;
                }
                
                $slide_ext=explode('.', $_FILES['slides']['name'][$key] )[1];

                // dd(  $slide_ext );
            
                $img_slide = "slide_".rand(0,1000).".".$slide_ext;
        
                // dd( $img_slide );
                
                $result_slide=move_uploaded_file( $tmp_name, "slides/".$img_slide);
                //pushing slide into an array
                if($result_slide){
                    $slide_name = $img_slide;
                    array_push( $slides_arr, $slide_name );
                }
            }

        }

        // dd( $slides_arr );

        try {

            $this->db()->autocommit(FALSE);
            
            if( empty( $_POST['product_id'] ) ){
                //insert
                $statement = $this->db()->prepare("INSERT INTO products (product_name, price, product_description, image ) VALUES( ?, ?, ?, ? );");
                $statement->bind_param("sdss", $data['product_name'], $data['price'], $data['product_description'], $img);

            } else {
                //update

                $product = $this->db()->query("SELECT * FROM products WHERE product_id=".$_POST['product_id'])->fetch_assoc();

                // dd( $product );

                if( empty( $img ) ){
                    $img = $product['image'];
                }

                $statement = $this->db()->prepare("UPDATE products SET product_name=?, price=?, product_description=?, image=? WHERE product_id=?;");
                $statement->bind_param("sdssd", $data['product_name'], $data['price'], $data['product_description'], $img,  $_POST['product_id'] );    
            }
            
            $res = $statement->execute();

            $product_id = ( !empty( $_POST['product_id'] ) )? $_POST['product_id'] : $this->db()->insert_id;
            // dd( $product_id );
            foreach ( $slides_arr as $key => $slide ) {
                $statement1=$this->db()->prepare("INSERT INTO product_slides (product_id, path) VALUES( ?, ? );");
                $statement1->bind_param("ds",$product_id, $slide);
                $res1=$statement1->execute();
            }
            

            $info['success'] = true;
            $info['msg'] = "Saved successfully.";

            $this->db()->commit();
            
        } catch (\Throwable $ex) {
            $this->db()->rollback();
            $info['success'] = false;
        }

        
        return $info;

    }

    public function edit($product_id){


        $id= ( !empty( $product_id ) )? $product_id : null;
        $query1="SELECT * FROM products WHERE product_id='$id' LIMIT 1";
        $query = $this->db()->query( $query1 );
        // print_r($query);exit;
        $info = [
            'form' => [],
            'slides' => [],
        ];
        if( $query->num_rows ){
            while( $row = $query->fetch_assoc() ){
                $info['form'] = $row;
            }
        } 

        $query = $this->db()->query( "SELECT * FROM product_slides WHERE product_id=$id" );

        if($query){
            
            if( $query->num_rows ){
                while( $row = $query->fetch_assoc() ){
                    array_push( $info['slides'], $row );
                }
            }
        }

        return $info;
    }

    

    
    
}

?>