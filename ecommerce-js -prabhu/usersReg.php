<?php 

  require('includes/db_con.php' );


  $q1="INSERT INTO users (user_name, email, password) VALUES( ?, ?, ? );";
  $u_name = $_POST["user_name"];
  $u_email = $_POST["email"];
  $u_pass = $_POST["pass"];
  $statement=$con->prepare($q1);
  $statement->bind_param("sss",$u_name, $u_email, $u_pass);
  
  $res=$statement->execute();
 
        if($res){ 
            return header("Location:login.php?msg=Registered Successfully now login&success=1"); 
                }
        else{
          return header("Location:admin.php?msg=Registration Failed&success=0"); 
            }
     
 
        // $first_name =  $_REQUEST['user_name']; 
        // $u_email = $_REQUEST['email']; 
        // $pass=  $_REQUEST['pass']; 

        // // Performing insert query execution 
        // // here our table name is college 
        // $sql = "INSERT INTO users(user_name, email, password)  VALUES ('$first_name',  
        //     '$u_email','$pass')"; 
          
        // $res = $con->query($sql);

        // if($res){ 
        //     echo "<h3>data stored in a database successfully." 
        //         . " Please browse your localhost php my admin" 
        //         . " to view the updated data</h3>";  
        // }
        // else{
        //     echo "Something Went Wrong";
        // }



  



?>