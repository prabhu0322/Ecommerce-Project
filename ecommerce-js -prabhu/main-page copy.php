<?php 
    require( 'includes/db_con.php' );


    $query = $con->query( "SELECT * FROM products" );
    
    $list = [];
    if( $query->num_rows ){
        while( $row = $query->fetch_assoc() ){
            array_push( $list, $row );
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

    .col-lg-3:hover{
        background-color:antiquewhite;
        border-radius:10px;
        }
    .item-card {

        display: flex;
        align-items: center;
        justify-content: center;
        padding-bottom: 20px;

    }

    .card>a>img {
        height: 250px;
        object-fit: revert;
        width: 100%;

    }
    
    @media only screen and (min-width:400px) and (max-width:600px) {

        #carouselExampleIndicators,
        .carousel-inner,
        .carousel-inner img {
            height: 250px;
            width:100%;
        }

    }
    </style>

</head>

<body>
    <?php include(__DIR__.'/includes/main_page_navbar.php');?>

    <!-- carousel---------------------- -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>

        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://cdn.shopclues.com/images/banners/EOSS_akb_10Dec_W.jpg" class="d-block w-100"
                    alt="tech">
            </div>
            <div class="carousel-item">
                <img src="https://cdn.shopclues.com/images/banners/2-5Banner_10Dec_W_sfm.jpg" class="d-block w-100"
                    alt="tech">
            </div>
            <div class="carousel-item">
                <img src="https://cdn.shopclues.com/images/banners/intel_w_rk_0810.jpg" class="d-block w-100"
                    alt="tech">
            </div>
            <div class="carousel-item">
                <img src="https://cdn.shopclues.com/images/banners/InductionCookTop_13thDec_W1.jpg"
                    class="d-block w-100" alt="tech">
            </div>
            <div class="carousel-item">
                <img src="https://cdn.shopclues.com/images/banners/Q10_9Dec_W.jpg" class="d-block w-100" alt="tech">
            </div>
            <div class="carousel-item">
                <img src="http://lwwindiapvtltd.com/public/storage/files/22-10-2020__07-18-19__PM__18956.jpeg"
                    class="d-block w-100" alt="tech">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>



    <!-- sub title----------- -->
    <div class="single-cell">
        <h2><span style="color: rgb(0, 0, 0);">Collections</span></h2>
    </div>

    <!----product cards-->

    <div class="container">
        <div class="row">
            <?php foreach( $list as $k => $item ){ ?>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="item-card">
                    <div class="card" style="width: 18rem;">
                        <a data-fancybox="gallery"
                            href="uploads/<?php echo $item['image']; ?>">
                            <img src="uploads/<?php echo $item['image']; ?>" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body">
                            <h5 title="<?php echo $item['product_name']; ?>" class="card-title"><?php echo (strlen($item['product_name']))>20? substr($item['product_name'],0,15)."...":$item['product_name']; ?></h5>
                            <p title="<?php echo $item['product_description']; ?>" class="card-text"><?php echo ( strlen( $item['product_description'] ) > 23 )? substr( $item['product_description'], 0, 20 )."..." : $item['product_description']; ?></p>
                            <p class="card-text"><?php echo $item['price']; ?></p>
                            <a href="routes.php?route=product-show&product_id=<?php echo $item['product_id']; ?>" class="btn btn-primary">view details</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

        </div>
    </div>

    <!-- footer--------- -->
    <!-- Footer -->
    <footer class="page-footer font-small blue">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
            <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
        </div>
        <!-- Copyright -->

    </footer>
    <!-- Footer -->
    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

</body>

</html>