<?php


$user_id = $_SESSION['id'];

if(!isset($user_id)){
   header('location:login.php');
}
$conn = $db->con;



if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:message.php');
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
            <!-- <h1 class="module-title font-alt text-center mb-0">Contact us</h1> -->
          </div>
        </div>
      </div>
    </section>
    
  </div>
  <!-- <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div> -->
</main>

<br>

<h1 class="title font-alt text-center wow flipInX">Messages</h1>

<section class="placed-orders wow fadeInUp">


   <div class="box-container">
   <?php
      $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
      if(mysqli_num_rows($select_message) > 0){
         while($fetch_message = mysqli_fetch_assoc($select_message)){
      
   ?>
   <div class="box">
      <p> user id : <span><?php echo $fetch_message['user_id']; ?></span> </p>
      <p> name : <span><?php echo $fetch_message['name']; ?></span> </p>
      <p> number : <span><?php echo $fetch_message['number']; ?></span> </p>
      <p> email : <span><?php echo $fetch_message['email']; ?></span> </p>
      <p> message : <span><?php echo $fetch_message['message']; ?></span> </p>
      <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="btn btn-sm btn-danger rounded py-2 px-4 font-alt bg-danger">delete message</a>
   </div>
   <?php
      };
   }else{
      echo '<br>';
         echo '<h1 class="text-danger text-center font-alt">You have no messages</h1>';
        echo '<br>';
   }
   ?>
   </div>

</section>
<br>