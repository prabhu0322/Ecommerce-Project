<?php 
require( 'includes/db_con.php' );

$query = $con->query( "SELECT orders.order_id, orders.user_id, orders.name, orders.email, orders.phone, orders.address, orders.txn_no, orders.txn_status, orders.payment_id, orders.date_of_order, users.user_name FROM `orders` LEFT JOIN users on users.user_id=orders.user_id WHERE order_id='".$_GET['order_id']."' LIMIT 1" );

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

// ordered_items_display
// $products_sql = $conn->query("SELECT * FROM order_items WHERE order_id=".$_GET['order_id']);

$products_sql = "SELECT order_items.order_id, order_items.product_id, order_items.qty, order_items.rate, order_items.price, products.product_name, products.image FROM order_items 
INNER JOIN products on order_items.product_id = products.product_id WHERE order_id=".$_GET['order_id'];
 
$ordered_products =$con->query($products_sql);
// echo $products_sql;exit;
// var_dump($products_sql);exit;
$products = [];
if($ordered_products->num_rows){
    while($row=$ordered_products->fetch_assoc()){
        array_push($products,$row);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>backendOrders</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
    * {
        box-sizing: border-box;
    }

    .order-bar,
    .bar>ul>div>li {
        text-decoration: none;
        list-style-type: none;
    }

    .vertical-line {
        display: inline-block;
        border-left: 1px solid #ccc;
        margin: 0 10px;
        height: 30px;
        border-color: black;
        border-width: 2px;
    }

    .order-bar,
    .bar>ul {
        display: flex;
        padding-top: 20px;
        justify-content: left;
        align-items: left;
    }

    .navbar-item>ul {
        display: flex;
    }

    .navbar-item>ul>.navfield {
        list-style-type: none;
        margin-left: 20px;
    }

    .navbar-item>ul>.navfield>a {
        text-decoration: none;
        color: black;
    }

    .navbar-item>ul>.it1 {
        list-style-type: none;
    }

    .navbar-item>ul>.it1>a {
        text-decoration: none;
        color: black;
    }

    .col-lg-3,
    .col-md-6,
    .col-sm-12 {
        padding-right: 50px;
        padding-left: 50px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="order-bar">
            <div class="bar">
                <ul>
                    <div class="bar-item">
                        <li style="font-weight: bold;padding: 1px;color:blue;">
                            <h4>Order Information</h4>
                        </li>
                    </div>
                    <span class="vertical-line"></span>
                    <div class="bar-item">
                        <li>
                            <h5><a href="viewreciept.php"><span class="badge badge-secondary">view reciept</span></a>
                            </h5>
                        </li>
                    </div>
                    <span class="vertical-line"></span>
                    <div class="bar-item">
                        <li>
                            <h5><a href="viewreciept.php"><span class="badge badge-secondary">view user info</span></a>
                            </h5>
                        </li>
                    </div>

                </ul>
            </div>

        </div>
        <hr style="background-color:grey;">
    </div>

    <!----------------------------------------->


    <!-- <div class="navbar">
        <div class="container">
            <div class="navbar-item">
                <ul>
                    <li class="it1"><a href="#">General Info</a></li>
                    <li class="navfield"><a href="#">Change Payment Info</a></li>
                    <li class="navfield"><a href="#">Order notes</a></li>
                    <li class="navfield"><a href="#">Commission distribution</a></li>
                </ul>

            </div>
        </div>
    </div> -->
   
    <!-------------------------------------------->

    <div class="container">
        <div class="row">
            <?php foreach($list as $k=>$items) { ?>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="address">
                    <div class="address-title">
                        <h4>Address</h2>
                    </div>
                    <p><?php echo $items['address'] ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="address">
                    <div class="address-title">
                        <h4>Payment Details</h2>
                    </div>
                    <p>Payment ID:&nbsp<br><?php echo $items['payment_id'] ?></p>
                    <p>Transaction No:&nbsp<?php echo $items['txn_no'] ?></p>
                    <p>Transaction Status:&nbsp<?php echo $items['txn_status'] ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 ">
                <div class="address">
                    <div class="address-title">
                        <h4>Registered As</h4>
                    </div>
                    <p>Name:&nbsp<?php echo $items['name'] ?></p>
                    <p>Phone:&nbsp<?php echo $items['phone'] ?></p>
                    <p>Email:&nbsp<?php echo $items['email'] ?></p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 ">
                <div class="address">
                    <div class="address-title">
                        <h4>Amount Paid</h4>

                    </div>
                    <p>Rs.&nbsp<?php echo $items['total_price'] ?></p>
                </div>
            </div>
            <?php }?>
        </div>
        <hr style="background-color:grey;">
    </div>
    
    <!-- ordered items table ------------------>

   <div class="container">
        <h2>Ordered Items</h2>
       <hr style="background-color:grey;">
       
        <table class="table table-striped table-dark">
            <thead>
            <tr>
                <th scope="col">SL.NO</th>
                <th scope="col">Order Id</th>
                <th scope="col">Product Id</th>
                <th scope="col">Quantity</th>
                <th scope="col">Rate</th>
                <th scope="col">Price</th>
                <th scope="col">Product Name</th>
                <th scope="col">Image</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($products as $k => $item){  ?>
                <tr>
                    <td><?php echo $k+1 ?></td>
                    <td><?php echo $item["order_id"] ?></td>
                    <td><?php echo $item["product_id"] ?></td>
                    <td><?php echo $item["qty"] ?></td>
                    <td>Rs.<?php echo $item["rate"] ?></td>
                    <td>Rs.<?php echo $item["price"] ?></td>
                    <td><?php echo $item["product_name"] ?></td>
                    <td><img src="uploads/<?php echo $item['image']; ?>" alt="" style="width:100px;height:100px;" ></td>       
                </tr>
       
                <?php } ?>
       
            </tbody>
        </table>
       
   </div>







    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>