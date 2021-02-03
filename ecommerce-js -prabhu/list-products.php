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
    <title>Products List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owl-carousel/owl.theme.default.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

   
    <style>
        .container {
            margin-top: 30px;
        }
    </style>
</head>

<body>

   <!--  -->

   <?php include( __DIR__.'/includes/top_menu.php' ); ?>
   


    
    <!-- owl-carousel--------------------- -->
    <div class="products-carousel-container">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <h4>1</h4>
                </div>
                <div class="item">
                    <h4>2</h4>
                </div>
                <div class="item">
                    <h4>3</h4>
                </div>
                <div class="item">
                    <h4>4</h4>
                </div>
                <div class="item">
                    <h4>5</h4>
                </div>
                <div class="item">
                    <h4>6</h4>
                </div>
                <div class="item">
                    <h4>7</h4>
                </div>      
            </div>
    </div>

    <!-- list table--------------------------------- -->
    <div class="container">
        <h3></h3>

        <table id="orders-table" class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">SL.NO</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $list as $k => $item ){ ?>
                    <tr>
                        <td><?php echo $k+1; ?></td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td><?php echo $item['product_description']; ?></td>
                        <td><?php echo $item['price']; ?></td>
                        <td><img src="uploads/<?php echo $item['image']; ?>" alt="" style="width:100px;" ></td>
                        <td>
                            <a href="routes.php?route=product-edit&product_id=<?php echo $item['product_id']; ?>" class="btn btn-info">Edit</a>
                           <!-- <button type="button" onclick = "edit('<?php echo $item['product_id'] ?>')" class="btn btn-info">Edit</button> -->
                        </td>
                        <td>
                            <a href="delete.php?product_id=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- scripts--------- -->

    <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="owl-carousel/owl.carousel.min.js"></script>

    
    
    <!------------------------------------------------>


    <script>
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }



        

        //this is of no use here........

        let orders_table = document.querySelector('#orders-table');
        //  let count_orders = document.querySelector('#count-orders'); 

        function render_orders_table() {

            var ctx = '';
            var counter = 1;
            for (var index in orders) {
                ctx += '<tr>';
                ctx += '<td>' + counter + '</td>';
                ctx += '<td>' + orders[index]['name'] + '</td>';
                ctx += '<td>' + orders[index]['amount'] + '</td>';
                ctx += '<td><button type="button" onclick="toastr_show()" >action</button></td>';
                ctx += '</tr>';

                counter++;
            }


            //     count_orders.innerText = orders.length;

            console.log(ctx);

            orders_table.querySelector('tbody').innerHTML = ctx;

        }

        // render_orders_table();

            $(document).ready(function () {
                $('#orders-table').DataTable();
            });

        function toastr_show(){
            toastr.success("product added successfully");
        }

        $(document).ready(function() {
        <?php if( isset( $_GET['success'] ) ){ ?>
            <?php if( $_GET['success'] == "1" ){ ?>
            toastr.info('<?php echo ( !empty( $_GET['msg'] ) )? $_GET['msg'] : ''; ?>');
            <?php } ?>
            <?php if( $_GET['success'] == "0" ){
            ?>
            toastr.error('<?php echo ( !empty( $_GET['msg'] ) )? $_GET['msg'] : ''; ?>');
            <?php
            } ?>
        <?php } ?>
    });
        // $('.owl-carousel').owlCarousel({
        //     loop: true,
        //     margin: 10,

        //     responsive: {
        //         0: {
        //             items: 1
        //         },
        //         600: {
        //             items: 3
        //         },
        //         1000: {
        //             items: 5
        //         }
        //     }
        // });


      

    </script>
</body>

</html>