<?php


$user_id = $_SESSION['id'];

if(!isset($user_id)){
   header('location:login.php');
}
$conn = $db->con;

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

   if(mysqli_num_rows($select_message) > 0){
      $message[] = 'message sent already!';
   }else{
      mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
      $message[] = 'message sent successfully!';
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
            <h1 class="module-title font-alt text-center mb-0">Contact us</h1>
          </div>
        </div>
      </div>
    </section>
    
  </div>
  <!-- <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div> -->
</main>

<br>

<section class="contact wow fadeInUp">

   <form action="" method="post">
      <h3>say something!</h3>
      <input type="text" name="name" required placeholder="enter your name" class="box">
      <input type="email" name="email" required placeholder="enter your email" class="box">
      <input type="number" name="number" required placeholder="enter your number" class="box">
      <textarea name="message" class="box" placeholder="enter your message" id="" cols="30" rows="10"></textarea>
      <input type="submit" value="send message" name="send" class="btn btn-info rounded-pill py-4 px-md-5 font-alt">
   </form>

</section>
<br>