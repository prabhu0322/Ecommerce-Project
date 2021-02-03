<?php
// require_once('includes/session_start.php');
// require( 'includes/db_con.php' );


// $total=0;
//total amount calculation
// print_r($_SESSION['cart_session']['price']);exit;


// if( !empty( $_SESSION['cart_session'] ) ){
//     foreach( $_SESSION['cart_session'] as $item ){
//         $total = $total + $item['price'];   
//     }
// }

// var_dump($_SESSION['cart_session']);exit;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>


    <style>
    .tbl {
        margin-top: 20px;
    }

    .single-cell h2 {
        text-align: left;
        padding-top: 19px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        padding-bottom: 19px;
    }

    #total {
        margin-bottom: 40px;
    }
    </style>
</head>

<body>


    <?php include(__DIR__.'/includes/main_page_navbar.php');?>
    <div class="container">
        <div class="single-cell">
            <h2 class="font-italic" id="product-title">
                Your Cart | <a href="empty_cart_items.php">Empty Cart</a>
            </h2>
        </div>

        <div class="tbl">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if( !empty( $info['items'] ) ){ ?>
                    <?php foreach( $info['items'] as $k => $item ){ ?>
                    <tr>
                        <td><img src="uploads/<?php echo $item['image']; ?>" alt="" style="width:100px;height:100px;"></td>
                        <td><?php echo $item['product_name'];  ?></td>
                        <td><?php echo $item['rate'];  ?></td>
                        <td><?php echo $item['qty'];  ?></td>
                        <td><?php echo $item['price'];  ?></td>
                        <td><a href="cart_item_delete.php?product_id=<?php echo $item['product_id']; ?>"
                                class="btn btn-danger">Remove</a></td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="6" class="text-center">No products added to cart.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

    <!---------------------------------->
    <div class="container" id="total">

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total Amount</h5>
                        <div class="row">
                            <div class="col-lg-6">
                                <h5>Total</h5>
                            </div>
                            <div class="col-lg-6">

                                <h5 class="font-weight-bold text-danger" style="margin-left: 20px;">
                                    Rs.&nbsp<?php echo $info['total_price']; ?></h5>
                            </div>
                        </div>
                        <a href="routes.php?route=checkout" class="btn btn-info" style="margin-top:10px;">Check out</a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>