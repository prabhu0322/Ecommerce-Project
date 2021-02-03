<?php
// require_once('includes/session_start.php');
// require( 'includes/db_con.php' );


// $total=0;
//total amount calculation
// print_r($_SESSION['cart_session']['price']);exit;

// echo '<pre>';
// var_dump(($_SESSION['cart_session']));exit;
// echo '</pre>';
// if(isset($_SESSION['cart_session'][0])){
    
//     for($i=0 ; $i < count($_SESSION['cart_session']) ; $i++){
//      $total = $total + $_SESSION['cart_session'][$i]['price'];   
//     }
// }else{
//     $_SESSION['cart_session'] = $_SESSION['cart_session'] + array(null);
// }
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

    .single-cell>h2>a:hover {
        cursor: pointer;
        font-weight: bold;
        color: white; 
        
    }
    
    #coly:hover{
        color:cadetblue;
    }
    </style>
</head>

<body>


    <?php include( project_root.'includes/main_page_navbar.php');?>
    <div class="container">
        <div class="single-cell">
            <h2 class="font-italic" id="product-title">
                Your Cart | <a id="coly" onclick="empty_cart(event)">Empty Cart</a>
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
                <tbody id="cart-body">

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
                                    Rs.&nbsp<span id="total_price">0</span></h5>
                            </div>
                        </div>
                        <a href="routes.php?route=checkout" class="btn btn-info" style="margin-top:10px;">Check out</a>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <script>
    function empty_cart(event) {
        event.preventDefault();
        $.ajax({
            'type': "GET",
            'url': "routes.php?route=empty-cart",
            // 'url': event.target.href,
            'data': {},
            'success': function(d) {
                item = JSON.parse(d);

                if (item['success']) {

                    document.getElementById('cart-body').innerHTML = '';
                    document.getElementById('total_price').innerHTML = 0;

                    alert("Cart Emptied");
                } else {
                    alert("Something went wrong!.");
                }
            }


        });
    }

    function remove_item(product_id) {
        let cfn = confirm("Confirm to remove ?");

        if (!cfn) {
            return false;
        }

        $.ajax({
            'type': "GET",
            'url': "routes.php?route=ajax-remove-cart-item",
            'data': {
                'product_id': product_id
            },
            'success': function(d) {
                item = JSON.parse(d);

                if (item['success']) {

                    load_data();

                    // alert("Item removed");
                } else {
                    alert("Something went wrong!.");
                }
            }


        });
    }



    $('document').ready(function() {
        load_data();
    });

    function load_data() {
        $.ajax({
            'method': "GET",
            'url': "routes.php?route=ajax-carts",
            'data': {},
            'success': function(d) {
                console.log(d);
                let data = JSON.parse(d);
                let content = ``;

                if (data['items'].length) {
                    for (let item of data['items']) {
                        content += `

                        
                        <tr>
                            <td><img src="uploads/${item['image']}" alt="" style="width:100px;height:100px;"></td>
                            <td>${item['product_name']}</td>
                            <td>${item['rate']}</td>
                            <td><input type="number" min="1" value="${item['qty']}" oninput="update_item_qty( this.value, '${item['product_id']}' )" ></td>
                            <td>${item['price']}</td>
                            <td><button type="button" onclick="remove_item( '${item['product_id']}' )" class="btn btn-danger">Remove</button></td>
                        </tr>
                        
                        
                        `;
                    }
                } else {

                    content = `
                    <tr>
                            <td colspan="6" class="text-center">No products added to cart.</td>
                    </tr>
                    `;
                }

                document.getElementById('cart-body').innerHTML = content;
                document.getElementById('total_price').innerHTML = data['total_price'];

            },

        });
    }

    function update_item_qty(qty, product_id) {
        // console.log(qty);

        $.ajax({
            'type': "GET",
            'url': "routes.php?route=ajax-update-cart-item-qty",
            'data': {
                'qty': qty,
                'product_id': product_id
            },
            'success': function(d) {
                item = JSON.parse(d);

                if (item['success']) {

                    load_data();

                    // alert("Item updated");
                } else {
                    alert("Something went wrong!.");
                }
            }


        });
    }
    </script>
</body>

</html>