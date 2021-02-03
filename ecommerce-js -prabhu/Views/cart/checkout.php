<?php
// require_once('includes/session_start.php');
// require( 'includes/db_con.php' );
// require( 'includes/utils.php' );

// require 'vendor/autoload.php';//important to load all functions of razorpay

// $total=0;
// if( !empty( $_SESSION['cart_session'] ) ){
//     foreach( $_SESSION['cart_session'] as $item ){
//         $total = $total + $item['price'];   
//     }
// }
//from paisa to Rs not Rs to paisa
// $total_converted_to_paisa = $info['total_price']*100;

// use Razorpay\Api\Api;

// $api_secret = 'CeYZDwwPBzIDKHg46D4dxjsk';
// $api_key = 'rzp_test_XYdu6Yc7w5HAcz';
// $api = new Api($api_key, $api_secret);

// $txn_no = rand(10,1000);

// $query = [
//     'receipt' => $txn_no,
//     'amount' => $total_converted_to_paisa,
//     'currency' => 'INR',
// ];

// $order = $api->order->create( $query );
// dd($order);exit;


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
    #total{
        margin-bottom:40px;
    }
    </style>
</head>

<body>

    <?php include(project_root.'includes/main_page_navbar.php');?>
    <div class="container">
        <div class="single-cell">
            <h2 class="font-italic" id="product-title">
                Checkout
            </h2>
        </div>

        <form id="order-form" action="routes.php?route=order-process" method="post">
            <input type="hidden" name="payment_id" id="payment_id" value="" >
            <input type="hidden" name="txn_no" value="<?php echo $info['txn_no']; ?>" >
            <div class="row">
                <div class="col-md-4">
                    <label for="">Name <span class="text-danger">*</span> </label>
                    <input type="text" name="name" id="name" required >
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="">Email <span class="text-danger">*</span> </label>
                    <input type="text" name="email" id="email" required >
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="">Phone <span class="text-danger">*</span> </label>
                    <input type="text" name="phone" id="phone" required >
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="">Delivery Address <span class="text-danger">*</span> </label>
                    <input type="text" name="address" id="address" required >
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                <button type="button" id="rzp-button1" class="btn btn-primary" >Confirm and Pay Now</button>
                </div>
            </div>
        </form>

        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

        <script>
            let order_form = document.getElementById('order-form');
            var options = {
                "key": '<?php echo $info['api_key']; ?>', // Enter the Key ID generated from the Dashboard
                "amount": <?php echo $info['total_converted_to_paisa']; ?>, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "INR",
                "name": "ABC Limited",
                "description": "Test Transaction",
                "image": "https://example.com/your_logo",
                "order_id": "<?php echo $info['order']->id; ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response){
                    console.log( response );
                    document.getElementById('payment_id').value = response.razorpay_payment_id;

                    order_form.submit();
                    // console.log("Payment Id: "+response.razorpay_payment_id);
                    // console.log("Order Id: "+r   esponse.razorpay_order_id);
                    // console.log("Signature: "+response.razorpay_signature)
                },
                "prefill": {
                    "name": document.getElementById('name').value,
                    "email": document.getElementById('email').value,
                    "contact": document.getElementById('phone').value
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response){
                     alert(response.error.code);
                    // alert(response.error.description);
                    // alert(response.error.source);
                    // alert(response.error.step);
                    // alert(response.error.reason);
                    // alert(response.error.metadata.order_id);
                    // alert(response.error.metadata.payment_id);
            });
            document.getElementById('rzp-button1').onclick = function(e){
                e.preventDefault();
                if( order_form.checkValidity() ){
                    rzp1.open();
                } else {
                    alert("Fill * marked fields.")
                }
            }
            </script>

        
    </div>
</body>

</html>