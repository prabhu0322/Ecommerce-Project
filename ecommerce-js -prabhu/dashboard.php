<?php 
  require_once('includes/session_start.php');
  require_once('includes/user_authenticate.php');
  require_once('includes/db_con.php');
  require_once('includes/utils.php');



  $count = "SELECT COUNT(product_id) as count FROM products";
  $res = $con->query($count)->fetch_assoc();
  
  $order_count = "SELECT COUNT(order_id) as order_count FROM orders";
  $orders = $con->query($order_count)->fetch_assoc();

  $query =$con->query("SELECT * FROM products");

  $list = [];
  if($query->num_rows){
      while($row = $query->fetch_assoc()){
            array_push($list, $row);
      }
  }

//  dd($list);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="owl-carousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owl-carousel/owl.theme.default.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>






    <style>
    .inner {
        width: 100%;
        height: 150px;
        background-color: rgb(133, 192, 174);
        color: black;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    </style>


</head>

<body>

    <?php include( __DIR__.'/includes/top_menu.php' ); ?>


    <div class="container">
        <div class="row" style="padding:50px 0;">
            <div class="col-lg-6 col-md-6 col-sm-12 ">
                <div class="inner btn-btn-primary">
                    <h3>Products</h3>&nbsp&nbsp<span class="badge badge-light"
                        style="padding: 10px;"><?php echo $res['count'] ;?></span>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 ">
                <div class="inner btn-btn-primary">
                    <h3>Orders</h3>&nbsp&nbsp<span class="badge badge-light"
                        style="padding: 10px;"><?php echo $orders['order_count'];?></span>
                </div>
            </div>

        </div>
    </div>
    <!-- dashboard-products-------------------- -->

    <div class="container dashboard-products">
        <h2>Products</h2>

        <br>

        <div class="products-carousel-container">
            <div class="owl-carousel owl-theme" id="load_carousel">
            <!-- <?php// foreach($list as $item){?>
            <div class="item">
               
                <img src="uploads/<?php //echo $item['image']; ?>" alt="">
                
            </div>
            <?php //}?> -->
            </div>
        </div>

    </div>

    <!-- list table--------------------------------- -->
    <div class="container">
        <h3>Recent Orders</h3>

        <table id="orders-table" class="table table-bordered">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Order</th>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>
    </div>
    <!-- <script>
        function redirect(){
            document.getElementById('redi').innerHTML="Actions Page Missing!!!";
        }
    </script> -->

    <!-- modal------------------------- -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Error:Page not Found</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Action Page is missing!!!</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



    <!----------------------------------scripts-------------------------->
    <script src="http://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="owl-carousel/owl.carousel.min.js"></script>
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



    // var orders = [{
    //         "name": "Justin",
    //         "amount": 500,
    //     },
    //     {
    //         "name": "Sumit",
    //         "amount": 350,
    //     },
    //     {
    //         "name": "Prakash",
    //         "amount": 400,
    //     },
    //     {
    //         "name": "Kunal",
    //         "amount": 1500,
    //     },
    //     {
    //         "name": "Gagan",
    //         "amount": 1000,
    //     },
    //     {
    //         "name": "Gagan",
    //         "amount": 1000,
    //     },

    // ];

    // let orders_table = document.querySelector('#orders-table');
    // let count_orders = document.querySelector('#count-orders');

    // function render_orders_table() {

    //     var ctx = '';
    //     var counter = 1;
    //     for (var index in orders) {
    //         ctx += '<tr>';
    //         ctx += '<td>' + counter + '</td>';
    //         ctx += '<td>' + orders[index]['name'] + '</td>';
    //         ctx += '<td>' + orders[index]['amount'] + '</td>';
    //         ctx += '<td><button type="button" onclick="toastr_show()" >Show</button></td>';
    //         ctx += '</tr>';

    //         counter++;
    //     }


    //     count_orders.innerText = orders.length;

    //     console.log(ctx);

    //     orders_table.querySelector('tbody').innerHTML = ctx;

    // }

    //render_orders_table();




    function toastr_show() {
        toastr.success("Success message");
    }



    // $(document).ready(function() {
    //     $('#orders-table').DataTable();
    // });


    $(document).ready(function() {
        recentOrder();
        load_images();

    });



    function recentOrder() {
        $.ajax({
            "type": "GET",
            "url": "routes.php?route=recentOrders",
            "data": {},
            "success": function(d) {
                let items = JSON.parse(d);
                console.log(items);
                let content = ``;
                if (items['recent_orders'].length) {
                    for (let item of items['recent_orders']) {

                        content += `
                                    <tr>
                                    <td>${item['name']}</td>
                                    <td>${item['email']}</td>
                                    <td>${item['phone']}</td>
                                    <td>${item['date_of_order']}</td>
                                    </tr>
                                
                                `;

                    }
                }
                document.getElementById('tbody').innerHTML = content;
            },


        });
    }


    function load_images() {
        $.ajax({
            "type": "GET",
            "url": "routes.php?route=getCarouselImages",
            "data": {},
            "success": function(d) {
                let items = JSON.parse(d);
                console.log(items);
                let content = ``;
                if (items['product_list'].length) {
                    for (let item of items['product_list']) {
                        content += `

                        <div class="item">
                        <img src="uploads/${item['image']}" class="rounded img-thumbnail" height="100" width="100">
                        </div>
                        
                            `;
                    }
                }
                document.getElementById("load_carousel").innerHTML = content;

                init_product_carousel(); //we have to first initialise owl-carousel if we are displaying it through JS
            },


        });
    }


   
    function init_product_carousel(){
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            loop: true,
            nav: true,
            margin: 10,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                960: {
                    items: 5
                },
                1200: {
                    items: 6
                }
            }
        });
        owl.on('mousewheel', '.owl-stage', function(e) {
            if (e.deltaY > 0) {
                owl.trigger('next.owl');
            } else {
                owl.trigger('prev.owl');
            }
            e.preventDefault();
        });
    }
    </script>

</body>

</html>