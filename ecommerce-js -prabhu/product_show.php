<?php 
    require( 'includes/db_con.php' );

    $query = $con->query( "SELECT * FROM products WHERE product_id='".$_GET['product_id']."' LIMIT 1" );
    
    $form = [];
    if( $query->num_rows ){
        while( $row = $query->fetch_assoc() ){
            $form = $row;
        }
    } 
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <!----fancy box---->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>


    <style>
    #carouselExampleIndicators,
    .carousel-inner,
    .carousel-inner img {

        height: 400px;
    }

    .single-cell h2 {
        text-align: center;
        padding-top: 19px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        padding-bottom: 19px;
        margin: 0px 50px 0px 50px;

    }

    /* .col-lg-3, .col-md-6, .col-sm-12{
            padding-bottom: 15px;
            
        } */
    .item-card {

        display: flex;
        align-items: center;
        justify-content: center;
        padding-bottom: 20px;

    }

    .card>a>img {
        height: 250px;
        object-fit: cover;
        width: 100%;

    }

    @media only screen and (min-width:400px) and (max-width:600px) {

        #carouselExampleIndicators,
        .carousel-inner,
        .carousel-inner img {
            height: 250px;
        }

    }

    #product-title {
        margin-left: 90px;
        margin-top: 20px;
        font-weight: bold;
        font-size: 27px;
    }

    #marg {
        padding-left: 50px;
    }

    #price_back {
        width: fit-content;
    }
    </style>

</head>

<body>
    <?php include(__DIR__.'/includes/main_page_navbar.php');?>
    <div class="single-cell">
        <p class="font-weight-light" id="product-title">Product Details</p>
    </div>

    <!-- sub title----------- -->

    <div class="single-cell">
        <p class="font-italic text-info" id="product-title"><?php echo $form['product_name']; ?></p>
    </div>

    <!----product cards-->

    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="item-card">
                    <div class="card" style="width: 18rem;">
                        <a data-fancybox="gallery" href="uploads/<?php echo $form['image']; ?>">
                            <img src="uploads/<?php echo $form['image']; ?>" class="card-img-top" alt="..."></a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $form['product_name']; ?></h5>
                            <p class="card-text"><?php echo $form['product_description']; ?></p>
                            <p class="card-text"><?php echo $form['price']; ?></p>
                        </div>
                    </div>
                </div>
            </div> -->


            <div class="col-lg-4 col-md-6 col-sm-12">
                <a data-fancybox="gallery" href="uploads/<?php echo $form['image']; ?>">
                    <img src="uploads/<?php echo $form['image']; ?>" width="200" height="380"
                        class="card-img-top border border-dark" alt="..."></a>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12" id="marg">
                <h5 class="card-title"><?php echo $form['product_name']; ?></h5>
                <p class="card-text"><?php echo $form['product_description']; ?></p>
                <p class="card-text bg-warning" id="price_back">Rs.&nbsp<?php echo $form['price']; ?></p>
                <form action="routes.php?route=add-to-cart&product_id=<?php echo $form['product_id']; ?>" method="post">
                    <label for="">QTY:&nbsp&nbsp</label><input class="border border-info" type="number" name="qty"
                        style="width:40px;" value="1" min="1">
                    <br>
                    <input type="submit" class="btn btn-light font-weight-bold border border-info" value="Add to Cart">
                </form>

            </div>

        </div>
    </div>


    <!-- Footer -->
    <!-- <footer class="page-footer font-small blue">

        
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
        </div>


    </footer> -->
    <!-- Footer -->
    <!-- scripts -->

    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

</body>

</html>