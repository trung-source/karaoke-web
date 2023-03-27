
<?php
ob_start();
session_start();
if(isset($_SESSION['id'])){
$user_email = $_SESSION['email'];
$user_username = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];


}

if(!isset($user_id)){
    header('location:login.php');
 }


require("function.php");
$conn = $db->con;
$total = 0;
$i = 0;


if(isset($_POST['delete-cart-submit'])){

    $user_id = $_SESSION['id'];
    $delete_id = $_POST['del-cart-id'];
//    print_r($delete_id);
    
mysqli_query($conn, "DELETE FROM `carts` WHERE room_id = '$delete_id' AND user_id = $user_id") or die('query failed');
header('location:bill.php');
 
    // mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price', type = '$update_type', amount = '$update_amount' WHERE id = '$update_p_id'") or die('query failed');
  
 
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
                            <a href="index.php" class="nav-item nav-link">Home</a>
                            <a href="about.php" class="nav-item nav-link">About</a>
                            <!-- <a href="service.php" class="nav-item nav-link">Dịch vụ</a> -->
                            <a href="room.php" class="nav-item nav-link">Phòng hát</a>
                            <!-- NHAN VIEN -->
                            <?php
                            if(isset($user_id) && ($user_type == "nhanvien" || $user_type == "admin")){

                            ?>
                            <div class="nav-item dropdown">
                                <a href="admin_room.php" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Quản lý</a>
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
                        <!-- rounded-pill: lam tron khung; fas: font awesome; -->
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
                                
                                
                                $result = mysqli_query($conn,$sql) or die('query failed'); // your custom function like using pdo or mysqli

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
                            <!-- Shopping cart section  -->
                <section id="cart" class="py-3">
                    <div class="container-fluid w-75">
                        <h1 class="font-alt">Shopping Cart</h1>

                        <!--  shopping cart items   -->
                            <div class="row">
                                <div class="col-sm-9">


                                <?php


$sql  = "SELECT
*
FROM
carts
WHERE user_id = $user_id
";


$result = mysqli_query($conn,$sql) or die('query failed'); // your custom function like using pdo or mysqli
$fetch_room_1 = [];
$room_id = '';
foreach($result as $cart)
    {
        $room_id = $cart['room_id'];
    
        $select_room = mysqli_query($conn,"SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
        // array_push($md_array["cuisine"],$newdata);
        // print_r($select_products);

        while( $row = mysqli_fetch_assoc($select_room)){ 
            $fetch_room_1[] = $row;
        }      

        // print_r($fetch_room_1);

    }
    
    $select_room = mysqli_query($conn,"SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
    
    if(mysqli_num_rows($select_room) > 0){
                                ?>
                                <?php foreach($fetch_room_1 as $fetch_rooms){ ?>
                                    <!-- cart item -->
                                    
                                        <div class="row border-top py-3 mt-3 wow fadeInUp">
                                            <div class="col-sm-2">
                                                <img src="./assets/room/<?php echo $fetch_rooms['room_type'].'/'; echo $fetch_rooms['room_image']; ?>" style="height: 150px;" alt="cart1" class="img-fluid">
                                            </div>
                                            <div class="col-sm-8">
                                          
                                                <a href="booking.php?book=<?php echo $fetch_rooms['id'] ?>">
                                                <h5 class="font-alt text-danger font-size-20"><?php echo $fetch_rooms['room_name'] ?></h5>

                                                </a>
                                                <!-- <small>by Samsung</small> -->
                                                <!-- product rating -->
                                                <div class="d-flex">
                                                    <div class="rating text-warning font-size-12">
                                                        <span><i class="fas fa-star"></i></span>
                                                        <span><i class="fas fa-star"></i></span>
                                                        <span><i class="fas fa-star"></i></span>
                                                        <span><i class="fas fa-star"></i></span>
                                                        <span><i class="far fa-star"></i></span>
                                                      </div>
                                                      <a href="#" class="px-2 font-rale font-size-14"><?php echo(rand(300,2000)) ?> ratings</a>
                                                </div>
                                                <!--  !product rating-->
                                                <div class="text-primary">
                                                 
                                                    <?php 
                                                    $total_room = 0;

                                                    $user_id = $_SESSION['id'];
                                                    $room_id = $fetch_rooms['id'];
                                                    $select_room_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = '$user_id' and room_id = '$room_id'") or die('query failed');
                                                    $fetch_cart = mysqli_fetch_assoc($select_room_cart);
                                                    $hours_check = intval(substr($fetch_cart['time'], 0, 2));
                                                    $mins_check = intval(substr($fetch_cart['time'], 3, 2));
                                                    $sec_check = intval(substr($fetch_cart['time'], 6, 2));
                                                    $rent_time = $hours_check + $mins_check/60 + $sec_check/3600
                                                    ?>
                                                    <h4>Regitation time: <?php echo $fetch_cart['reg_date'] ?></h4>
                                                    <h5>Rent time: <?php echo $fetch_cart['time'] ?></h5>
                                                </div>

                                                <!-- product qty -->
                                                    <div class="qty d-flex pt-1">   
                                                        <h3 class="text-info px-3 border-right font-alt">Giá phòng: <?php echo $fetch_rooms['room_price']*$rent_time ?>K</h3>   
                                                        <?php 

                                                        $total = $total + $fetch_rooms['room_price']*$rent_time;
                                                        $total_room = $total_room + $fetch_rooms['room_price']*$rent_time;

                                                        
                                                        ?>             
                                                        <form method='post'>
                                                            <input type="hidden" value="<?php echo $fetch_rooms['id'] ?? 0;?>" name="del-cart-id">
                                                            <button type="submit" name="delete-cart-submit" class="btn font-alt text-danger px-3">Delete</button>
                                                        </form>
                                                        <!-- <button type="submit" class="btn font-baloo text-danger">Save for Later</button> -->
                                                    </div>
                                                <!-- !product qty -->

                                            </div>

                                           
                                        </div>
                                    <!-- !cart item -->
                                    <?php
         
 
         include("template/_product_room_cart.php");
                                    $i = $i + 1;
         ?>
          <div class="col-sm-8 text-right wow fadeInUp pb-5">
                    <div class="font-size-20 text-success font-baloo">
                        <h2 class="product_price">Tổng giá phòng: <?php echo $total_room ?>K</h2>
                    </div>
                </div>

         <?php
    $user_id = $_SESSION['id'];
    $room_id = $fetch_rooms['id'];
   mysqli_query($conn, "UPDATE `carts` SET price = '$total_room' WHERE room_id = '$room_id' and user_id = '$user_id' ") or die('query failed');

        }
         ?>
                                    <?php
      }else{
         echo '<h3 class="font-alt text-center text-danger py-5">no room added yet!</h3>';
      }
      ?>
                                </div>
                                <!-- subtotal section-->
                                <div class="col-sm-3 wow fadeInUp">
                                    <div class="sub-total border text-center mt-2">
                                        <h6 class="font-size-12 font-rale text-success py-3"><i class="fas fa-check"></i> Đơn đặt hàng</h6>
                                        <div class="border-top py-4">
                                            <h5 class="font-baloo font-size-20">Tổng cộng (<?php echo count($fetch_room_1)?> phòng):&nbsp; <span class="text-danger"><span class="text-danger" id="deal-price"><?php echo ($total) ?? '0' ?>K</span> </span> </h5>
                                            <a href="room.php" class="btn btn-primary mt-3">Xem phòng khác</a>
                                            
                                            <a href="checkout.php" class="btn btn-warning mt-3 <?php echo ($total > 1)?'':'disabled'; ?>">Đặt phòng</a>
                                            
                                            <!-- <form method="POST">
                                                <input type="hidden" name="total_price" value="<?php echo $total; ?>">

                                                <button type="submit" name="order-cart" class="btn btn-warning mt-3">Đặt phòng</button>

                                            </form> -->
                                    
                                        </div>
                                    </div>
                                </div>
                                <!-- !subtotal section-->
                            </div>
                        <!--  !shopping cart items   -->
                    </div>
                </section>
            <!-- !Shopping cart section  -->
<?php 
if(isset($_GET['book'])){
    $book_id = $_GET['book'];
    $book_image_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$book_id'") or die('query failed');
    $fetch_room = mysqli_fetch_assoc($book_image_query);
    if(isset($fetch_room)){
    // unlink('assets/room/'.$fetch_book['room_type'].'/'.$fetch_book['room_image']);
    ?>

        

    <!-- start #main-site -->
    <main id="main-site">
        
        <!-- <div style="background-image: url('assets/sections/section-4.jpg'); 
            background-size: cover; height:480px; padding-top:80px;">
            </div>
            <section class="module bg-dark-30"  data-background="assets/sections/section-4.jpg"> 
              <div class="container">
                <div class="row">
                    
                  <div class="col-sm-6 col-sm-offset-3">
                    <h1 class="module-title font-alt mb-0">Booking</h1>
                  </div>
                </div>
              </div>
            </section>
             -->
            <!-- Page Header Start -->
    <div class="container-fluid page-header mb-5 p-0 wow fadeIn" style="background-image: url(assets/sections/section-4.jpg);">
        <div class="container-fluid page-header-inner py-5">
            <div class="container text-center pb-5">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Booking</h1>
            </div>
        </div>
    </div>
    <!-- Page Header End -->
        
        

            <!-- Rooms -->
        <section id="room" class="py-3">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="./assets/room/<?php echo $fetch_room['room_type'].'/'; echo $fetch_room['room_image']; ?>" alt="room" class="img-fluid img-fill-3">
                        <div class="form-row pt-4 font-size-16 font-baloo">
                            <div class="col">
                                <button type="submit" class="btn btn-danger form-control">Đặt chỗ</button>
                            </div>

                            <!-- <div class="col">
                                <button type="submit" class="btn btn-warning form-control"></button>
                            </div> -->

                        </div>
                    </div>

                    <div class="col-sm-6 py-5">
                        <h5 class="font-baloo font-size-20">Phòng <?php echo $fetch_room['room_name'] ;?></h5>
                        <div class="d-flex">
                            <div class="rating text-warning font-size-12">
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="fas fa-star"></i></span>
                                <span><i class="far fa-star"></i></span>
                            </div>
                            <a href="#" class="px-2 font-rale font-size-14">20,534 ratings | 1000+ answered questions</a>
                        </div>
                        <hr class="m-0">


                        <!-- room price -->
                        <table class="my-3">
                            <tr class="font-rale font-size-16">
                                <td>Giá Phòng:   </td>
                                <td class="font-size-20 text-danger"><span><?php echo $fetch_room['room_price'].' ' ; ?> K/h</span></td>
                            </tr>
  
                   
                   


                        </table>
                        <!-- !room price -->



                        <!-- policy -->
                        <div id="policy">
                            <div class="d-flex">
                                <div class="return text-center mr-5">
                                    <div class="font-size-20 my-2 color-second">
                                        <span class="fas fa-music border p-3 rounded-pill"></span>
                                    </div>
                                    <a href="#" class="font-rale font-size-12">Dàn Loa <br>Khủng</a>
                                </div>

                                <div class="return text-center mr-5">
                                    <div class="font-size-20 my-2 color-second">
                                        <span class="fas fa-desktop border p-3 rounded-pill"></span>
                                    </div>
                                    <a href="#" class="font-rale font-size-12">2 Màn Hình  <br>77 Inch Full HD</a>
                                </div>

                                <div class="return text-center mr-5">
                                    <div class="font-size-20 my-2 color-second">
                                        <span class="fas fa-check-double border p-3 rounded-pill"></span>
                                    </div>
                                    <a href="#" class="font-rale font-size-12">Dịch Vụ <br>Tận Tình</a>
                                </div>


                            </div>
                        </div>

                        <!-- !policy -->
                        <hr>


                        <!-- size -->
                        <div class="size my-3">
                            <h6 class="font-baloo font-size-20">Tình Trạng:</h6>
                            <?php 
                            if ($fetch_room['cond'] == 'empty'){
                            ?>
                            
                                <div class="mx-5 font-size-20 text-success font-alt"> <span><i class="fas fa-calendar-check"></i></span><span> Phòng Hiện Trống</span></td>                         
                                </div>
                            <?php
                            }else
                            {
                                ?>
                                
                            <div class="mx-5 font-size-20 text-danger font-alt"> <span><i class="fas fa-calendar-times"></i></span><span><?php echo $fetch_room['cond'].' ' ; ?></span></td>                         
                            </div>
                                <?php
                            }
                            ?>
                            <div class="col-md-6 mt-2">
                                        <div class="form-floating time" id="date3" data-target-input="nearest">
                                            <label for="checkin">Check In</label>
                                            <input type="text" class="form-control datetimepicker-input" id="checkin" placeholder="Check In" data-target="#date3" data-toggle="datetimepicker" />
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-floating time" id="date4" data-target-input="nearest">
                                            <label for="checkout">Check Out</label>
                                            <input type="text" class="form-control datetimepicker-input" id="checkout" placeholder="Check Out" data-target="#date4" data-toggle="datetimepicker" />
                                            
                                        </div>
                            
                        </div>

                        <!-- !size -->

                        


                    </div>


                    
                    
                </div>
                <div class="col-12">
                        <h3 class="font-alt">room Description</h3>
                        <hr>
                        <p class="font-size-20 font-rale"><?php echo $fetch_room['room_desc'].' ' ; ?></p>
                        

                    </div>
            </div>
        </section>
        <?php
                    
                    include("template/_product_in_room.php");
                 

                    ?>

        <!-- !rooms -->


    
<?php
    // mysqli_query($conn, "DELETE FROM `room` WHERE id = '$book_id'") or die('query failed');
    }
    // header('location:booking.php');
 }
 ?>

<?php


// Product
// include("template/_all_product.php");

// video
include("template/_video.php");

// vip room
include("template/_room_vip.php");




// normal room
include("template/_room_normal.php");

// review
include("template/_review.php");

// blogs
include("template/_blogs.php");


// FOOTER
include("template/footer.php");



?>