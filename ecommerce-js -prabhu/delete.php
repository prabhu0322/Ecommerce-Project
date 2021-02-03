<?php 
      require( 'includes/db_con.php' );



    $id=$_GET['product_id'];
    $del="DELETE FROM products WHERE product_id='$id'";

    $res=$con->query($del);

    // print_r($res);

    if($res){
        return header("Location:list-products.php?msg=success&sucess=1");
    }
    else{
        return header("Location:list-products.php?msg=delete failed&sucess=0");
    }



?>