<?php
ob_start();
session_start();

$conn = $db->con;


if($_SERVER['REQUEST_METHOD']=='POST'){
if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['username']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['re-password']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'User already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         header('location:login_register.php');
      }
   }

}
if(isset($_POST['submit2'])){

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

  $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');
  
  if(mysqli_num_rows($select_users) > 0){

     $row = mysqli_fetch_assoc($select_users);
     $_SESSION['user_type'] = $row['user_type'];
    //  $userid = $_SESSION['id'];
    //  mysqli_query($conn, "DELETE FROM `room_product` WHERE user_id = '$userid' ") or die('query failed');
     
     if($row['user_type'] == 'admin'){

        $_SESSION['username'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];
        header('location:index.php');
    

     }elseif($row['user_type'] == 'user'){

        $_SESSION['username'] = $row['name'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['id'] = $row['id'];

        header('location:index.php');
  


     }elseif($row['user_type'] == 'nhanvien'){

      $_SESSION['username'] = $row['name'];
      $_SESSION['email'] = $row['email'];
      $_SESSION['id'] = $row['id'];

      header('location:index.php');

   }

  }else{
     $message2[] = 'incorrect email or password!';
  }

}




}

?>



<!-- login register -->


<main id="main-site">
<div class="main" id="login_register">
    <!--First section-->
    <div class="wow flipInX" style="background-image: url('assets/2.jpg'); 
    background-size: cover; height:480px; padding-top:80px;">
    </div>
    <section class="module bg-dark-30 wow fadeInUp" data-wow-delay="0.1s"  data-background="assets/2.jpg"> 
      <div class="container">
        <div class="row">
            
          <div class="col-sm-6 col-sm-offset-3">
            <h1 class="module-title font-alt mb-0">Login-Register</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="module wow fadeInUp" data-wow-delay="0.2s">
      <div class="container">
        <div class="row">
          <div class="col-sm-5 col-sm-offset-1 mb-sm-40">
            <h4 class="font-alt">Login</h4>
                            <?php
                if(isset($message2)){
                  foreach($message2 as $message2){
                      echo '
                      <div class="message">
                        <span class="font-alt text-danger">'.$message2.'</span>
                        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                      </div>
                      ';
                  }
                }
                ?>
            <hr class="divider-w mb-10">
            <form method="post" class="form">
              <div class="form-group">
                <input class="form-control" id="email" type="email" name="email" placeholder="Email"/>
              </div>
              <div class="form-group">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password"/>
              </div>
              <div class="form-group">

                <button name="submit2" class="btn btn-outline-danger" type="submit">Login</button>

              </div>
              <div class="form-group"><a href="">Forgot Password?</a></div>
            </form>
          </div>
          <div class="col-sm-5">
            <h4 class="font-alt">Register</h4>
       
        
            <?php
          if(isset($message)){
           
            foreach($message as $message){
                echo '
                <div class="message">
                  <span class="font-alt text-danger">'.$message.'</span>
                  <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                </div>
                ';
            }
            
}


?>

            <hr class="divider-w mb-10">
            <form class="form" method="post">
              <div class="form-group">
                <input class="form-control" id="E-mail" type="email" name="email" placeholder="Email"/>
              </div>
              <div class="form-group">
                <input class="form-control" id="username" type="text" name="username" placeholder="Username"/>
              </div>
              <div class="form-group">
                <input class="form-control" id="password" type="password" name="password" placeholder="Password"/>
              </div>
              <div class="form-group">
                <input class="form-control" id="re-password" type="password" name="re-password" placeholder="Re-enter Password"/>
              </div>
              <input class="form-control" id="re-password" type="password" name="re-password" placeholder="Re-enter Password"/>
              <!-- <input type="hidden" name="book-room-price" value="<?php echo $fetch_room['room_price']; ?>"> -->

              <select name="user_type" class="form-group box-all">
                <option value="user">user</option>
                <option value="admin">nhanvien</option>
                <option value="admin">admin</option>
              </select>
              <div class="form-group">
                <button class="btn btn-outline-info font-size-16" name="submit" type="submit">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>