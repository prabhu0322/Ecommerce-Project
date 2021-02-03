<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

   
    

<style>
    
    /* .form-width{
      width:50%;
    } */
    .container{
      width:50%;
    }
</style>
</head>
<body>

    <div class="text-center">
        <img src="https://www.freelogodesign.org/file/app/client/thumb/008b2331-3cd9-4a0a-a749-2f85207b9783_200x200.png?1608279500778"
            class="rounded" alt="..." width="100px" height="100px">
            <p class="fw-bold">Login here...</p>
    </div>


    <div class="container">   
       <div class="form-width">
          <form action="login_check.php" method="post">
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="pass">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
              </div>
              <center><button type="submit" class="btn btn-primary">Login</button></center>
            </form>
       </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>