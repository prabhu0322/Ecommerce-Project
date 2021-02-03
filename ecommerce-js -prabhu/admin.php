<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    .container {
        padding-right:200px;
        padding-left:200px;
    }
    .text-right{
        float:right;
        font-family:fantasy;
       
    }

    .text-right > a > small{
        color:cornflowerblue;
    }
    .btn{
        background-color:cornflowerblue;
    }
    .font-weight-bolder{
        color:cornflowerblue;
        padding-left:15px;
    }
    </style>

</head>

<body>

    <div class="container">
        <div class="text-center">
            <img src="https://www.freelogodesign.org/file/app/client/thumb/008b2331-3cd9-4a0a-a749-2f85207b9783_200x200.png?1608279500778"
                class="rounded" alt="..." width="100px" height="100px">
                <p class="font-weight-bolder">Register here...</p>
        </div>
        <form action="usersReg.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="exampleInput1" for="exampleCheck1">Name</label>
                <input type="text" class="form-control" id="exampleCheck1" name="user_name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="confirm_pass">
            </div>
            <div>
            <center><button type="submit" class="btn">Submit</button></center>
            </div>
            <div class="text-right">
            <a href="login.php"><small class="">Already a user?Login.</small></a>
            </div>
        </form>
    </div>
</body>

</html>