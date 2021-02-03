
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
                <!-- <tr>
                    <th>Order Info</th>
                    <th>Payment Info</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr> -->
            </thead>
            <tbody>

            </tbody>
        </table>


        <!-- Button trigger modal -->
        <div class="modal fade" id="payment-info-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal-body">
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        

    </div>


 
    <script>
    $(document).ready(function() {
        $('#tbl').DataTable({
            "oLanguage": {
                "sProcessing": "Please wait",
            },
            "pagingType": "simple_numbers",
            "paging": true,
            "scrollY": 400,
            "lengthMenu": [
                [2, 10, 25, 50, -1], // value
                ["Only Two", "Only Ten", "Only Twenty Five", "Only Fifty", "Show All"], // title
            ],
            "processing": true,
            "serverSide": true, 
            "ordering": false,
            "ajax": {
                "type": "GET",
                "url": "routes.php?route=ajax-orders",
                "data": function(d) {
                    
                },
                "dataFilter": function(d) {
                    var json = JSON.parse(d);

                    json.draw = json.draw;
                    json.recordsTotal = json.total;
                    json.total = json.total;
                    json.data = json.data;
                    return JSON.stringify(json);
                }
            },
            "columns": [{
                    "title": "Order Info",
                    "data": "name",
                    "name": "name",
                    "visible": true,
                    "searchable": true,
                },
                {
                    "title": "Email",
                    "data": "email",
                    "name": "email",
                    "visible": true,
                    "searchable": true,
                },
                {
                    "title": "Phone",
                    "data": "phone",
                    "name": "phone",
                    "visible": true,
                    "searchable": true,
                },
                {
                    "title": "Payment Info",
                    "data": "payment_id",
                    "name": "payment_id",
                    "visible": true,
                    "searchable": true,
                },
                {
                    "title": "Payment Info",
                    "data": "payment_content",
                    "name": "payment_content",
                    "visible": true,
                    "searchable": true,
                },
            ]
        });
    });

    // function show_payment_info(payment_id) {
    //    $.ajax({
    //         "type" :'GET',
    //          "url" : 'routes.php?route=ajax-payment-info',
    //          "data" : {
    //             payment_id:payment_id
    //          },
    //          "success" : function(d){
    //              let item = JSON.parse(d);
    //              console.log(item);
    //             let content = JSON.stringify(item['payment_info'], null, 2);
           
    //             document.getElementById('modal-body').innerHTML = content;

    //             $('#payment-info-modal').modal('show');
    //          }
              

    //    });
    // }

    function show_payment_info(payment_id){
        $.ajax({
            "type":"GET",
            "url": "routes.php?route=ajax-payment-info",
            "data":{
                payment_id:payment_id
            },
            "success" : function(d){
                let item = JSON.parse(d);
                let content = JSON.stringify(item['payment_info'], null, 2);
                document.getElementById('modal-body').innerHTML = content;
                $('#payment-info-modal').modal('show');//popping up modal through jquery 'show','close', 'hide'
            }
        });
    }

    </script>
</body>

</html>