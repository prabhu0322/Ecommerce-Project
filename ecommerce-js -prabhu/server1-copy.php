<?php 
    require( 'includes/db_con.php' );
    require( 'includes/utils.php' );
    
    // dd( $_FILES );
    
    
    $p_name=$_POST['product_name'];
    $p_price=$_POST['price'];
    $p_desc=$_POST['product_description'];
    $product_id = $_POST['product_id'];
    
    $file_name = null;

    if( isset( $_FILES['file']['name'] ) && !empty( $_FILES['file']['name'] ) ){
        
        $file_ext=explode('.',$_FILES["file"]["name"])[1];
    
        $img = "new_file_".rand(0,100).".".$file_ext;
        
        $result=move_uploaded_file($_FILES["file"]["tmp_name"],"uploads/".$img);
        //to check if file uploaded successfully
        if($result){
            $file_name = $img;
        }

    }

    // dd( $_FILES );

    // if( isset( $_FILES['slides']['name'] ) && !empty( $_FILES['slides']['name'] ) ){
        
    //     $slide_ext=explode('.',$_FILES["slides"]["name"][0])[1];

    //     // dd(  $slide_ext );
    
    //     $img_slide = "slide_".rand(0,100).".".$file_ext;

    //     // dd( $img_slide );
        
    //     $result_slide=move_uploaded_file($_FILES["slides"]["tmp_name"][0], "slides/".$img_slide);
    //     //to check if file uploaded successfully
    //     if($result_slide){
    //         $slide_name = $img_slide;
    //     }

    //     dd( $slide_name );

    // }


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

    $updateSlide=[];
    $arr=[];
    if(!empty($product_id)){
        //update slides

        $slides = $con->query("SELECT * FROM product_slides WHERE product_id=".$product_id);
        
        if($slides->num_rows){
            while($row = $slides->fetch_assoc()){
                array_push($updateSlide,$row);
            }
        }
        // dd($updateSlide);
        if(!empty($slides)){
            if(is_null($slide_name)){
                foreach($updateSlide as $k=>$s){

                    $slide_name = $s['path'];
                    // dd($s['path']);exit;
                    array_push($arr, $slide_name);
                }
                // dd($arr);exit;
            }
        }
    }
    
    if( !empty( $product_id ) ){
        // update

        // first select product from database
        $product = $con->query( "SELECT * FROM products WHERE product_id=".$product_id." LIMIT 1" )->fetch_assoc();
        // $product = $con->query( "SELECT * FROM products WHERE product_id=1111 LIMIT 1" )->fetch_assoc();

        if( !empty( $product ) ){

            if( is_null( $file_name )  ){
                $file_name = $product['image'];
            }

            // var_dump( $product['image']  );exit;
            
            $statement=$con->prepare("UPDATE products SET product_name=?, price=?, product_description=?, image=? WHERE product_id=".$product_id);
            $statement->bind_param("sdss",$p_name, $p_price, $p_desc, $file_name);

        } else {

            echo "Invalid product selected";
            exit;
        }
        
        

    } else {
        // insert
        $statement=$con->prepare("INSERT INTO products (product_name, price, product_description, image ) VALUES( ?, ?, ?, ? );");
       
        $statement->bind_param("sdss",$p_name, $p_price, $p_desc, $img);
        
    }

    $res=$statement->execute();
    
    $product_id = ( empty( $product_id ) )? $con->insert_id : $product_id;
    // dd( $slides_arr );

    foreach ( $slides_arr as $key => $slide ) {
        # code...
        $statement1=$con->prepare("INSERT INTO product_slides (product_id, path) VALUES( ?, ? );");
        $statement1->bind_param("ds",$product_id, $slide);
        $res1=$statement1->execute();
    }
    
    // var_dump( $res1 );exit;
    if( $res ){
        return header("Location:create.php?msg=Successful&success=1");
    } else {
        return header("Location:create.php?msg=Something went wrong&success=0");
    }

    // var_dump( $res );exit;
?>


