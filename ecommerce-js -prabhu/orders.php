<?php 
require( 'includes/db_con.php' );

$query = $con->query( "SELECT orders.order_id, orders.user_id, orders.name, orders.email, orders.phone, orders.address, orders.txn_no, orders.txn_status, orders.payment_id, orders.date_of_order, users.user_name FROM `orders` LEFT JOIN users on users.user_id=orders.user_id" );

$list = [];
if( $query->num_rows ){
    while( $row = $query->fetch_assoc() ){

        // sum of item price
        $price = $con->query( "SELECT SUM(price) as price FROM order_items WHERE order_id=".$row['order_id'] )->fetch_assoc()['price'];

        // var_dump( $price );exit;
        $row['total_price'] = $price;
        array_push( $list, $row );
       
    }
} 

// var_dump( $list );exit;

// $order="INSERT INTO order_items(order_id, product_id, qty, rate, price) VALUES(?, ?, ?, ?, ?);";
// $o_id="123";
// $p_id="12";
// $q="123";
// $r="134";
// $pr="1234";

// $stmt=$con->prepare($order);
// $stmt->bind_param("ddddd",$o_id,$p_id,$q,$r,$pr);
// var_dump($stmt->execute());exit;                                        


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>

<body>

    <?php include( __DIR__.'/includes/top_menu.php' ); ?>
    
  

    <div class="container">
        <hr>
    <h3>Orders</h3>
    <hr>
        <table id="tbl" class="table table-bordered">
            <thead>
                <tr>
                    <th>Order Info</th>
                    <th>Payment Info</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach( $list as $k => $item ){ ?>
                    <tr>
                        
                        <td>
                            <?php echo $item['name']; ?>
                        </td>
                        
                        <td>
                            <?php echo $item['txn_no']; ?> / <?php echo $item['txn_status']; ?>
                        </td>
                        
                        <td>
                            <?php echo ( !empty( $item['total_price'] ) )? $item['total_price'] : 0; ?>
                        </td>
                        
                        <td>
                        <a href="order_details.php?order_id=<?php echo $item['order_id']; ?>" class="btn btn-info">Show</a>
                        </td>
                       
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>



    <script>

    $(document).ready(function() {
        $('#tbl').DataTable();
    });
    </script>
</body>

</html>