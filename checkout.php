<!-- For Client -->
<?php
ob_start();
session_start();
if(isset($_SESSION['id'])){
$user_email = $_SESSION['email'];
$user_username = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];


}
require("function.php");
$conn = $db->con;


if(!isset($user_id)){
    header('location:login.php');
 }
 
 if(isset($_POST['order_btn'])){
 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'Số nhà '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city']);
    $placed_on = date('d-M-Y');
 
    $cart_total = 0;
    $cart_products[] = '';
 
    $cart_query = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
       while($cart_item = mysqli_fetch_assoc($cart_query)){
            $room_id = $cart_item['room_id'];
            $select_room = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
            $fetch_room = mysqli_fetch_assoc($select_room);

          $cart_products[] = $fetch_room['room_name'];
          $sub_total = ($cart_item['price']);
          $cart_total += $sub_total;
       }
    }
 
    $total_products = implode(', ',$cart_products);
 
    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' 
    AND email = '$email' AND method = '$method' AND address = '$address' 
    AND total_product = '$total_products' AND total_price = '$cart_total'") or die('query failed');
 
    if($cart_total == 0){
       $message[] = 'your cart is empty';
    }else{
       if(mysqli_num_rows($order_query) > 0){
          $message[] = 'order already placed!'; 
       }else{
          mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_product, total_price, place_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
          $message[] = 'order placed successfully!';

          $cart_query = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id'") or die('query failed');
            if(mysqli_num_rows($cart_query) > 0){
            while($cart_item = mysqli_fetch_assoc($cart_query)){
                $room_id = $cart_item['room_id'];
                //     $select_room = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
                //     $fetch_room = mysqli_fetch_assoc($select_room);

                // $cart_products[] = $fetch_room['room_name'];
                // $sub_total = ($cart_item['price']);
                // $cart_total += $sub_total;

                $select_prod_query = mysqli_query($conn, "SELECT * FROM `room_product` WHERE room_id = '$room_id' AND user_id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select_prod_query) > 0){
                    while($select_prod = mysqli_fetch_assoc($select_prod_query)){
                        $prod_id = $select_prod['product_id'];
                        $select_product = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$prod_id'") or die('query failed');
                        
                        $fetch_prod = mysqli_fetch_assoc($select_product);
                        $amount = $fetch_prod['amount'];
                        $update_amount = $amount - $select_prod['amount'];
                        if ($update_amount < 0){
                            $message[] = 'So luong san pham vuot qua hang trong kho';
                        }
                        else{
                            mysqli_query($conn, "UPDATE `product` SET amount = '$update_amount' WHERE id = '$prod_id'") or die('query failed');

                        }
                            
            
                    // $cart_products[] = $fetch_room['room_name'];
                    // $sub_total = ($cart_item['price']);
                    // $cart_total += $sub_total;
                            }
                        }


            }
            }


          mysqli_query($conn, "DELETE FROM `carts` WHERE user_id = '$user_id'") or die('query failed');

          


       }
    }
    
 }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karaoke</title>
    
    <!-- Booststrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <!-- Owl Carousel 2 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Tempusdominus -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.css" integrity="sha512-ClXpwbczwauhl7XC16/EFu3grIlYTpqTYOwqwAi7rNSqxmTqCpE8VS3ovG+qi61GoxSLnuomxzFXDNcPV1hvCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- animate: For wow -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.compat.min.css" integrity="sha512-b42SanD3pNHoihKwgABd18JUZ2g9j423/frxIP5/gtYgfBz/0nDHGdY/3hi+3JwhSckM3JLklQ/T6tJmV7mZEw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">


    <!-- Timelocate -->
    


</head>
<body>
    <!-- m-o:margin=0; justtify-content-between px4 py1: khoang cach cua bg; -->
    <!-- border-left: tao dai ngan cach phia ben trai; text-dark: doi mau chu -->
    <!-- start #header -->
    
    
    <!-- Header Start -->
    <div class="container-fluid bg-dark px-0 wow flipInX">
        <div class="row gx-0">
            <div class="col-lg-3 bg-dark d-none d-lg-block">
                <a href="index.php" class="navbar-brand w-100 h-100 m-0 p-0 d-flex align-items-center justify-content-center">
                    <h1 class="m-0 text-primary text-uppercase">Karaoke</h1>
                </a>
            </div>
            <div class="col-lg-9">
                <div class="row gx-0 bg-white d-none d-lg-flex">
                    <div class="col-lg-7 px-5 text-start">
                        <div class="h-100 d-inline-flex align-items-center py-2 me-4">
                            <i class="fa fa-envelope text-primary me-2"></i>
                            <p class="mb-0">info@example.com</p>
                        </div>
                        <div class="h-100 d-inline-flex align-items-center py-2">
                            <i class="fa fa-phone-alt text-primary me-2"></i>
                            <p class="mb-0">+012 345 6789</p>
                        </div>
                    </div>
                    <div class="col-lg-5 px-5 text-end">
                        <div class="d-inline-flex align-items-center py-2">
                            <a class="me-3" href="https://facebook.com/"><i class="fab fa-facebook-f"></i></a>
                            <a class="me-3" href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
                            <a class="me-3" href="https://linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                            <a class="me-3" href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                            <a class="" href="https://youtube.com/"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark p-3 p-lg-0">
                    <a href="index.php" class="navbar-brand d-block d-lg-none">
                        <h1 class="m-0 text-primary text-uppercase">Karaoke</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="index.php" class="nav-item nav-link ">Home</a>
                            <a href="about.php" class="nav-item nav-link">About</a>
                            <!-- <a href="service.php" class="nav-item nav-link">Dịch vụ</a> -->
                            <a href="room.php" class="nav-item nav-link">Phòng hát</a>
                            <!-- NHAN VIEN -->
                            <?php
                            if(isset($user_id) && ($user_type == "nhanvien" || $user_type == "admin")){

                            ?>
                            <div class="nav-item dropdown">
                                <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Quản lý</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="admin_product.php" class="dropdown-item">Quản lý hàng hóa</a>
                                    <a href="admin_room.php" class="dropdown-item">Quản lý phòng hát</a>
                                    <a href="admin_order.php" class="dropdown-item">Quản lý hóa đơn</a>

                                    <!-- ADMIN -->
                                    <?php
                                    if(isset($user_id) && $user_type == "admin"){

                                    ?>
                                    <a href="admin_page.php" class="dropdown-item">Báo cáo thống kê</a>
                                    <a href="admin_users.php" class="dropdown-item">Quản lý nhân viên</a>
                                    
                                    <?php }?>  

                                </div>
                            </div>
                            <a href="message.php" class="nav-item nav-link">Message</a>

                            <?php }?>
                            <!-- <div class="nav-item dropdown">
                                <a href="index.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="booking.php" class="dropdown-item">Booking</a>
                                    <a href="review.php" class="dropdown-item">Reviews</a>
                                </div>
                            </div> -->
                            <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <?php
                        if(isset($user_id)){
                        ?>
                            <a href="order.php" class="nav-item nav-link">Order</a>

                            <?php }
                            ?>

                        </div>
                        
                            
                        <?php
                        if(!isset($user_id)){
                        ?>
                        <a href="<?php echo "login_register.php" ?>" class=" btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block font-alt">Login Now <i class="fa fa-arrow-right ms-3"></i></a>
                        <?php }
                        else{
                            // $user = mysqli_query($db->con, "SELECT * FROM `users` WHERE id = '$user_id'") or die('query failed');
                            // $user = mysqli_fetch_assoc($user)
                        ?>
                        <form action="#" class="bg-info border-info btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block font-alt">
                            <a href="bill.php" class="py-2 rounded-pill color-primary-bg">
                                <span class="font-size-16 px-2 text-white"><i class="fas fa-shopping-cart"></i></span>
                                <span class="px-3 py-2 rounded-pill text-dark bg-light">
                                <?php
                                
                                $sql  = "SELECT
                                *
                                FROM
                                carts
                                WHERE user_id = $user_id
                                ";
                                
                                
                                $result = mysqli_query($db->con,$sql) or die('query failed'); // your custom function like using pdo or mysqli

                                $resultArray = array();
                        
                                // fetch product data one by one
                                while($item = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    $resultArray[] = $item;
                                }

                                echo count($resultArray);

                                ?>
                                </span>
                            </a>
                        </form>
                        <a href="<?php echo "logout.php" ?>" class="bg-danger border-danger color-red-bg btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block font-alt">Log Out</a>
                            <?php  
                            
                            ?>
                        <a href="<?php echo "index.php" ?>" class="btn btn-primary rounded-0 py-4 px-md-5 d-none d-lg-block font-alt">Welcome <?php echo $user_username ?></a>
                        <?php }?>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Header End -->

          
           <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->



    </header>
    <!-- !start #header -->



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
          </div>
        </div>
      </div>
    </section>
    
  </div>
  <div class="scroll-up"><a href="#totop"><i class="fa fa-angle-double-up"></i></a></div>
</main>
<section class="display-order wow fadeInUp">

   <?php  
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price']);
            $grand_total += $total_price;
    $room_id = $fetch_cart['room_id'];
    $select_room = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
    $fetch_room = mysqli_fetch_assoc($select_room)
   ?>

   <p> <?php echo $fetch_room['room_name']; ?> <span>(<?php echo $fetch_cart['price'].'K'; ?>)</span> </p>
   <?php
      }
   }else{
      echo '<p class="empty">your cart is empty</p>';
   }
   ?>
   <hr>
   <div class="grand-total"> Tổng cộng : <span><?php echo $grand_total; ?>K</span> </div>
<br>
   <hr>
</section>

<section class="checkout wow fadeInUp">

   <form action="" method="post">
      <h3 class="text-success">place your order</h3>
      <div class="flex">
         <div class="inputBox font-alt">
            <span>Tên của bạn :</span>
            <input type="text" name="name" required placeholder="enter your name">
         </div>
         <div class="inputBox font-alt">
            <span>Số điện thoại :</span>
            <input type="number" name="number" required placeholder="enter your number">
         </div>
         <div class="inputBox font-alt">
            <span>email :</span>
            <input type="email" name="email" required placeholder="enter your email">
         </div>
         <div class="inputBox font-alt">
            <span>Phương thức thanh toán :</span>
            <select name="method" class="box">
               <option value="cash">Tại quầy</option>
               <option value="credit card">credit card</option>
               <option value="paypal">paypal</option>
            </select>
         </div>
         <div class="inputBox font-alt">
            <span>Địa chỉ 01 :</span>
            <input type="number" min="0" name="flat" required placeholder="e.g. số nhà">
         </div>
         <div class="inputBox font-alt">
            <span>Địa chỉ 01 :</span>
            <input type="text" name="street" required placeholder="e.g. tên đường">
         </div>
         <div class="inputBox font-alt">
            <span>Quận, huyện :</span>
            <input type="text" name="city" required placeholder="e.g. Cầu Giấy">
         </div>
         <div class="inputBox font-alt">
            <span>Tỉnh :</span>
            <input type="text" name="state" required placeholder="e.g. Quảng Ninh">
         </div>
      </div>
      <div class="flex">
      <input type="submit" value="order now" class="btn btn-sm btn-primary rounded py-2 px-4 font-alt bg-warning text-danger" name="order_btn">
      </div>
    </form>

</section>


    <?php

    


    include("template/footer.php");

