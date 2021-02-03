<?php
// require( 'includes/db_con.php' );
// require( 'includes/utils.php' );

// print_r( $_GET );
// exit;

// $id= ( !empty( $_GET['product_id'] ) )? $_GET['product_id'] : null;
// $query1="SELECT * FROM products WHERE product_id='$id' LIMIT 1";
// $query = $con->query( $query1 );
// // print_r($query);exit;
// $form = [];
// if( $query->num_rows ){
//     while( $row = $query->fetch_assoc() ){
//         $form = $row;
//     }
// } 

// $query = $con->query( "SELECT * FROM product_slides WHERE product_id=$id" );

// $slides = [];
// if($query){
    
//     if( $query->num_rows ){
//         while( $row = $query->fetch_assoc() ){
//             array_push( $slides, $row );
//         }
//     }
// }

// dd( $slides );
// print_r($form  );exit;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>create</title>


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <style>
    .form-title h2 {
        font-size: 25px;
        font-weight: bold;
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        margin-top: 16px;
    }



    .sub-btn,
    .btn {
        color: rgb(24, 24, 37);
        font-weight: bold;

    }

    .create-form {
        margin-left: 25%;
        width: 50%;

    }
    </style>
</head>

<body>
    <?php include( project_root.'/includes/top_menu.php' ); ?>



    <!-- form to create items in the bucket--------------------------- -->

    <div class="form-title">
        <h2>Add New Product</h2>
    </div>

    <div class="create-form">
        <form onsubmit="save_form( event, this )" action="routes.php?route=saveProduct" method="post"
            enctype="multipart/form-data">
            <input type="hidden" name="product_id"
                value="<?php echo ( !empty( $form['product_id'] ) )? $form['product_id'] : ''; ?>">
            <div class="form-group">
                <label for="formGroupExampleInput">Product Name</label>
                <input type="text" name="product_name" class="form-control" id="formGroupExampleInput"
                    placeholder="Product name..."
                    value="<?php echo ( !empty( $form['product_name'] ) )? $form['product_name'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="formGroupExampleInput">Product Cost</label>
                <input type="text" name="price" class="form-control" id="formGroupExampleInput"
                    placeholder="Product Cost..."
                    value="<?php echo ( !empty( $form['price'] ) )? $form['price'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="formGroupExampleInput">Product Description</label><br>
                <textarea class="form-control" name="product_description" id="exampleFormControlTextarea1"
                    placeholder="Type here..." rows="3"
                    required> <?php echo ( !empty( $form['product_description'] ) )? $form['product_description'] : ''; ?> </textarea>
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Product Image</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="file"
                    value="<?php echo ( !empty( $form['image'] ) )? $form['image'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile1">Product Slides</label>
                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="slides[]"
                    value="<?php echo ( !empty( $form['image'] ) )? $form['image'] : ''; ?>" multiple>
            </div>

            <hr>

            <h4>Slides</h4>

            <?php if( !empty(  $slides ) ){ ?>
            <div class="row">

                <?php foreach( $slides as $slide ){ ?>
                <div class="col-md-3" id="slide-<?php echo $slide['id'] ?>">
                    <img src="slides/<?php echo $slide['path'] ?>" alt="" class="img-thumbnail img-responsive">
                    <button type="button" onclick="remove_slide( '<?php echo $slide['id']; ?>' )">Remove</button>
                </div>

                <?php } ?>

            </div>
            <?php } else { ?>
            <p>Slides not found.</p>
            <?php } ?>

            <hr>

            <div class="sub-btn">
                <button type="submit" class="btn btn-light border border-dark"
                    id="sbt-btn">Add</button>
            </div>

        </form>

    </div>
    <p id="render-txt" style="text-align: center;"></p>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
    function save_form(event, form) {
        event.preventDefault();

        let form_data = new FormData();


        form_data.append('product_id', form.querySelector('input[name="product_id"]').value);
        form_data.append('product_name', form.querySelector('input[name="product_name"]').value);
        form_data.append('price', form.querySelector('input[name="price"]').value);
        form_data.append('product_description', form.querySelector('textarea[name="product_description"]').value);
        form_data.append('file', form.querySelector('input[name="file"]').files[0]);

        let slides = form.querySelector('input[name="slides[]"]');

        if (slides.files.length) {

            for (let index in slides.files) {
                console.log(slides.files[index]);
                form_data.append('slides[' + index + ']', slides.files[index]);
            }
        }

        // $('input[name="file"]')[0].files[0]

        $.ajax({
            "method": 'POST',
            "url": form.action,
            // "data" :{
            //     "product_name" : form.querySelector('input[name="product_name"]').value,
            //     "price" : form.querySelector('input[name="price"]').value,
            //     "product_description" : form.querySelector('textarea[name="product_description"]').value,
            // },
            "data": form_data,
            "processData": false, // tell jQuery not to process the data
            "contentType": false,
            "success": function(d) {
                console.log(d);
                let items = JSON.parse(d);

                if (items['msg']) {
                    toastr.info('Successfully added...');
                } else {
                    toastr.error('Something went wrong...');
                }
            }
        });
    }


    function remove_slide(id) {

        let cfn = confirm("Confirm to remove?");

        if (!cfn) {
            return;
        }

        $.ajax({
            "type": "GET",
            "url": "routes.php?route=ajax-remove-product-slide",
            "data": {
                "id": id
            },
            success: function(d) {
                let data = JSON.parse(d);

                if (data['success']) {
                    console.log("Successful");
                    document.getElementById('slide-' + id).remove();
                } else {
                    console.log("Failed");
                }
            }
        });
    }


    // document.getElementById('sbt-btn').addEventListener('click', function() {
    //     console.log("Product added successfully");
    //     var render_text = document.getElementById('render-txt');
    //     render_text.innerHTML = "Product Added Successfully";
    //     toastr.info("success");
    // });

    // $('#sbt-btn').on("click", function() {
    //     let valid = true;
    //     $('[required]').each(function() {
    //         if ($(this).is(':invalid') || !$(this).val()) valid = false;
    //     })
    //     if (!valid) toastr.error("fill all fields!");
    //     else toastr.info("successfully addeed!");
    // });




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

    <?php
// print_r( $_GET );
// exit;
    ?>

    // $(document).ready(function() {
    //     <?php if( isset( $_GET['success'] ) ){ ?>
    //         <?php if( $_GET['success'] == "1" ){ ?>
    //         toastr.info('<?php echo ( !empty( $_GET['msg'] ) )? $_GET['msg'] : ''; ?>');
    //         <?php } ?>
    //         <?php if( $_GET['success'] == "0" ){
    //         ?>
    //         toastr.error('<?php echo ( !empty( $_GET['msg'] ) )? $_GET['msg'] : ''; ?>');
    //         <?php
    //         } ?>
    //     <?php } ?>
    //     <?php } ?>
    // });
    </script>


</body>

</html>