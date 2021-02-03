<?php 
    

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

    
    $p_name=$_POST['product_name'];
    $p_price=$_POST['price'];
    $p_desc=$_POST['product_description'];

    if( !empty( $_POST['product_id'] ) ){
        // update

        // first select product from database
        $product = $con->query( "SELECT * FROM products WHERE product_id=".$_POST['product_id']." LIMIT 1" )->fetch_assoc();
        // $product = $con->query( "SELECT * FROM products WHERE product_id=1111 LIMIT 1" )->fetch_assoc();

        if( !empty( $product ) ){

            if( is_null( $file_name )  ){
                $file_name = $product['image'];
            }

            // var_dump( $product['image']  );exit;
            
            $statement=$con->prepare("UPDATE products SET product_name=?, price=?, product_description=?, image=? WHERE product_id=".$_POST['product_id']);
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

    if( $res ){
        return header("Location:create.php?msg=Successful&success=1");
    } else {
        return header("Location:create.php?msg=Something went wrong&success=0");
    }

    // var_dump( $res );exit;
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>server</title>
</head>
<body>
    <?php if($res){?>
    <div class="alert alert-success">
    Successful
    </div>
    <?php } else{?>
    
     <div class="alert alert-danger">
     Error
     </div>   
     <?php } ?>
</body>
</html> --> 

