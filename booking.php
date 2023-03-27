
<?php
ob_start();
session_start();
if(isset($_SESSION['id'])){
$user_email = $_SESSION['email'];
$user_username = $_SESSION['username'];
$user_id = $_SESSION['id'];
$user_type = $_SESSION['user_type'];



}
$message = "";

require("function.php");
$conn = $db->con;

$moments = "";
$moment_time = "";



if(isset($_POST['room-book'])){

    $user_id = $_SESSION['id'];
    $room_book_id = $_POST['book-room-id'];
    $room_book_price = $_POST['book-room-price'];
    $room_book_time = $_POST['book-time'];
    $room_book_time_check = $_POST['book-time-check'];
    

    
    $date = substr($room_book_time, 0, 11);
    $years = intval(substr($room_book_time, 0, 4));
    $months = intval(substr($room_book_time, 5, 2));
    $days = intval(substr($room_book_time, 8, 2));
    $hours = intval(substr($room_book_time, 11, 2));
    $mins = intval(substr($room_book_time, 14, 2));


    $hours_check = intval(substr($room_book_time_check, 0, 2));
    $mins_check = intval(substr($room_book_time_check, 3, 2));
    $sec_check = intval(substr($room_book_time_check, 6, 2));




    // print_r("room_check ".$room_book_time_check );
    // print_r("\n".$hours_check.$mins_check.$sec_check);
    
    if($room_book_time != ""){
        $sql = "INSERT INTO `carts`(room_id, user_id,reg_date,time) VALUES('$room_book_id', '$user_id','$room_book_time','$room_book_time_check')";

   
    }else{
        $sql =  "INSERT INTO `carts`(room_id, user_id) VALUES('$room_book_id', '$user_id')";
    }
    
    // print_r("booktime ".var_dump($room_book_time) );

    // $test = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
    // $row = mysqli_fetch_assoc($test);
    // print_r("test ".var_dump($row['reg_date']));
    if (isset($room_book_id)){
    $check_occupied = mysqli_query($conn, "SELECT reg_date,time FROM `carts` where room_id = '$room_book_id' ORDER BY reg_date") or die('query failed');
    $moments = array();
    $moment_time = array();

    if(mysqli_num_rows($check_occupied) > 0){
        // $row = mysqli_fetch_assoc($check_occupied);
        $check = 0;
        while($row = mysqli_fetch_assoc($check_occupied)){
            // print_r($row);
            $reg_date = $row['reg_date'];
            $time = $row['time'];

            $moments[] = $reg_date;
            $moment_time[] = $time;

            
            $date_reg = (substr($reg_date, 0, 11));
            $years_reg = intval(substr($reg_date, 0, 4));
            $months_reg = intval(substr($reg_date, 5, 2));
            $days_reg = intval(substr($reg_date, 8, 2));
            $hours_reg = intval(substr($reg_date, 11, 2));
            $mins_reg = intval(substr($reg_date, 14, 2));
            // print_r($moments);
            // print_r(var_dump($date_reg));
            // print_r(var_dump($months_reg));
            // print_r(var_dump($days_reg));
            // print_r(var_dump($hours_reg));
            // print_r(var_dump($mins_reg));
            
            if ($date_reg == $date){
                $cond1 = $hours + $hours_check + $mins_check/60 + $sec_check/3600 > $hours_reg && $hours_reg >= $hours;
                $cond2 = $hours >= $hours_reg && $hours_reg + $hours_check + $mins_check/60 + $sec_check/3600 > $hours;




                if ($cond1 || $cond2){
                    
                    $message = "Phòng đã được thuê trong khoảng thời gian này: ".$room_book_time;
                    $check = 1;

                }
                else{
               
                    
                }
            }else{
            
                
            }
            
            

        }
        if ($check == 0){
            mysqli_query($conn, $sql) or die('query failed');

        }
        // print_r($moment);

        
    // mysqli_query($conn, $sql) or die('query failed');

        
    // print_r($check_occupied);
    }
    else{
    mysqli_query($conn, $sql) or die('query failed');
    // mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$room_id' and user_id = $user_id") or die('query failed');
    // header('location:bill.php');
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
                                    <a href="booking.php" class="dropdown-item active">Booking</a>
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

<?php 
if(isset($_GET['book'])){
    $book_id = $_GET['book'];
    $book_image_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$book_id'") or die('query failed');
    $fetch_room = mysqli_fetch_assoc($book_image_query);
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $curr_date = date("Y-m-d H:i:s");

    
    $date = substr($curr_date, 0, 11);
    // print_r($curr_date);

   
    // print_r(substr($curr_date, 11, 19));

    $years = intval(substr($curr_date, 0, 4));
    $months = intval(substr($curr_date, 5, 2));
    $days = intval(substr($curr_date, 8, 2));
    $hours = intval(substr($curr_date, 11, 2));
    $mins = intval(substr($curr_date, 14, 2));
    // print_r("bookid ".$room_book_id );
    // print_r("\n");
    // print_r(var_dump($hours));

    
  
    $sql1 = "UPDATE `room` SET cond = 'occupied' WHERE id = '$book_id'";
    $sql2 = "UPDATE `room` SET cond = 'empty' WHERE id = '$book_id'";

    if (isset($book_id)){
        $check = 0;

        $check_occupied = mysqli_query($conn, "SELECT reg_date,time FROM `carts` where room_id = '$book_id' ORDER BY reg_date") or die('query failed');
        // $check_occupied_time = mysqli_query($conn, "SELECT time FROM `carts` where room_id = '$book_id' ORDER BY reg_date") or die('query failed');
        
        if(mysqli_num_rows($check_occupied) > 0){
            // $row = mysqli_fetch_assoc($check_occupied);
            while($row = mysqli_fetch_assoc($check_occupied)){

                // print_r($row);
                $reg_date = $row['reg_date'];
                $check_occupied_time = $row['time'];
                // print_r(substr($reg_date, 11, 19).'   ');
                // $check_occupied_time = mysqli_query($conn, "SELECT time FROM `carts` where room_id = '$book_id' and reg_date = '$reg_date'") or die('query failed');
               
                $date_reg = (substr($reg_date, 0, 11));
                $years_reg = intval(substr($reg_date, 0, 4));
                $months_reg = intval(substr($reg_date, 5, 2));
                $days_reg = intval(substr($reg_date, 8, 2));
                $hours_reg = intval(substr($reg_date, 11, 2));
                $mins_reg = intval(substr($reg_date, 14, 2));
                // print_r(var_dump($date_reg));
                // print_r(var_dump($months_reg));
                // print_r(var_dump($days_reg));
                // print_r(var_dump($hours_reg));
                // print_r(var_dump($mins_reg));
                $hours_check = intval(substr($check_occupied_time, 0, 2));
                $mins_check = intval(substr($check_occupied_time, 3, 2));
                $sec_check = intval(substr($check_occupied_time, 6, 2));
                
                if ($date_reg == $date){
                    $cond1 = $hours + $hours_check + $mins_check/60 + $sec_check/3600 > $hours_reg && $hours_reg >= $hours;
                    $cond2 = $hours >= $hours_reg && $hours_reg + $hours_check + $mins_check/60 + $sec_check/3600 > $hours;
    
    
    
                    if ($cond1 || $cond2){
                        // print_r("TRUE");
                        
                        $check = 1;
    
                    }
                    else{
                   
                        
                    }
                }else{
                
                    
                }
                
                
    
            }
            if ($check == 0){
                mysqli_query($conn, $sql2) or die('query failed');
    
            }
            else{
                mysqli_query($conn, $sql1) or die('query failed');

            }
            // print_r($moment);
    
            
        // mysqli_query($conn, $sql) or die('query failed');
    
            
        // print_r($check_occupied);
        }
        else{
        // mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$room_id' and user_id = $user_id") or die('query failed');
        // header('location:bill.php');
        }
    }
    

    
  
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
                <form method="POST">
                <div class="row">
                    <div class="col-sm-6">
                        <img src="./assets/room/<?php echo $fetch_room['room_type'].'/'; echo $fetch_room['room_image']; ?>" alt="room" class="img-fluid img-fill-3">
                        <div class="form-row pt-4 font-size-16 font-baloo">
                            
                            <div class="col">
                                <input type="hidden" name="book-room-price" value="<?php echo $fetch_room['room_price']; ?>">
                                <input type="hidden" name="book-room-id" value="<?php echo $fetch_room['id']; ?>">
                                <button type="submit" name="room-book" class="btn btn-danger form-control">Đặt chỗ</button>
                                
                                
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
                            <!-- <h6 class="font-baloo font-size-20">Tình Trạng:</h6> -->
                           
                            <?php 
                            if ($fetch_room['cond'] == 'empty'){
                            ?>
                            
                                <!-- <div class="mx-5 font-size-20 text-success font-alt"> <span><i class="fas fa-calendar-check"></i></span><span> Phòng Hiện Trống</span></td>                         
                                </div> -->
                            <?php
                            }
                            else
                            {
                                ?>
                                
                            <!-- <div class="mx-5 font-size-20 text-danger font-alt"> <span><i class="fas fa-calendar-times"></i></span><span><?php echo $fetch_room['cond'].' ' ; ?></span></td>                         
                            </div> -->
                                <?php
                            }


                            if($message != ""){
                                ?>
                                <!-- <div class="mx-5 font-size-20 text-warning font-alt"> <span><i class="fas fa-calendar-times"></i></span><span> <?php echo $message ?></span></td>                         
                                </div> -->
                            <?php
                            }
                            ?>
                            
                            <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label for="checkin">Check In</label>

                                        <div class="input-group date" id="datetimepicker6" data-target-input="nearest">
                                            <input type="text" name="book-time" class="form-control datetimepicker-input" data-target="#datetimepicker6"/>
                                            <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                        <!-- <div class="input-group date" id="datetimepicker6" data-target-input="nearest">
                                            <input type="text" name="book-time" class="form-control datetimepicker-input" data-target="#datetimepicker6"/>
                                            <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <div id="date-picker-test" class="md-form md-outline input-with-post-icon datepicker">
                                        <input placeholder="Select date" type="text" id="input_value" class="form-control">
                                        <label for="input_value">Try me...</label>
                                        <i class="fas fa-calendar input-prefix" tabindex=0></i>
                                        </div>

                                        <p>
                                        Date output here
                                        </p>
                                     -->

                                  
                                        <label for="checkin">Check Out</label>

                                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                            <input type="text" name="book-time-check" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                            </div>
                                   
                            
                        </div>

                        <!-- !size -->

                        


                    </div>

                <?php
                
               
                ?>
                    
                    
                </div>
                </form>
                <div class="col-12">
                        <h3 class="font-alt">room Description</h3>
                        <hr>
                        <p class="font-size-20 font-rale"><?php echo $fetch_room['room_desc'].' ' ; ?></p>
                        

                    </div>
            </div>
        </section>
        <?php
        
        

                    
                    include("template/_product_in_room_test.php");
                 

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
include("template/_all_product.php");

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

<script type="text/javascript">

        var foo = <?php echo json_encode($moments); ?>;
        var tim = <?php echo json_encode($moment_time); ?>;

        console.log(tim)
        if (foo != ""){
        var foo1 = [];
        for (let x in foo) {
            foo[x];
            // alert(foo[x].substr(5,2));

            var year = Number(foo[x].substr(0,4));
            var month = Number(foo[x].substr(5,2));
            var day = Number(foo[x].substr(8,2));

            var year2 = Number(foo[x].substr(0,4));
            var month2 = Number(foo[x].substr(5,2));
            var day2 = Number(foo[x].substr(8,2));




            var s1 = Number(foo[x].substr(11,2))+Number(tim[x].substr(0,2));
            var s2 = Number(foo[x].substr(11,2))-Number(tim[x].substr(0,2));
            
            
            var min1 = Number(foo[x].substr(14,2))+Number(tim[x].substr(3,2));
            // var min2 = Number(foo[x].substr(14,2))-Number(tim[x].substr(3,2));

            var sec1 = Number(foo[x].substr(17,2))+Number(tim[x].substr(5,2));


            if (s1>=24){
                s1 = s1 -24;
                day = day + 1
                if (day>31){
                    month = month + 1
                    if (month>12){
                        year = year + 1
                    }
                }
                


            }
            else if(s1<0){
                s1 = 24+s1;

            }

            if (s2>=24){
                s2 = s2 -24;

                day2 = day2 + 1
                if (day2>31){
                    month2 = month2 + 1
                    if (month2>12){
                        year2 = year2 + 1
                    }
                }
                


            }
            else if(s2<0){
                s2 = 24 + s2;

            }


            if (min1>=60){
                min1 = min1 -60;

            }
            else if(min1<0){
                min1 = 60 + min1;

            }

            if (sec1>=60){
                sec1 = sec1 -60;

            }
            else if(sec1<0){
                sec1 = 60 + sec1;

            }
            
            if (day<10){
                    day = String(0) + String(day)
                }
                if (month<10){
                    month = String(0) + String(month)
                }

            if (day2<10){
                    day2 = String(0) + String(day2)
                }
                if (month2<10){
                    month2 = String(0) + String(month2)
            }

            


            s1 = s1.toString();
            s2 = s2.toString();

            min1 = s2.toString();
            sec1 = s2.toString();
            // console.log(foo[x].substring(13, 14))
            
            if (s1<10){
                s1 = String(0) + String(s1)
            }
            if (min1<10){
                min1 = String(0) + String(min1)
            }
            if (sec1<10){
                sec1 = String(0) + String(sec1)
            }


            if (s2<10){
                s2 = String(0) + String(s2)
            }
           


            foo1.push(year + foo[x].substring(4, 5) + month + foo[x].substring(4, 5) + day + foo[x].substring(4, 5) +
            s1 + 
            foo[x].substring(13, 14) + min1 + foo[x].substring(13, 14)+ sec1);
            // console.log(foo1)

            foo[x] = year2 + foo[x].substring(4, 5) + month2 + foo[x].substring(4, 5) + day2 + foo[x].substring(4, 5) + 
            s2 + 
            foo[x].substring(13, 14) + min1 + foo[x].substring(13, 14)+ sec1;
        }
            console.log(foo1);
            console.log(foo);

            
            var hold = new Array(foo.length)
            
            for (var i = 0; i < hold.length; i++) {
                hold[i] = new Array(2);

                hold[i][0]=moment(foo[i]);
                hold[i][1]=moment(foo1[i]);
                // hold[i].push(foo1[i]);
            }
            // if(hold[0] == [moment("2022-06-22 14:45"),moment("2022-06-22 18:45")] ){
            //     console.log("s");
            // }
            // console.log("TEST");
            // console.log(hold);
            // console.log([moment("2022-06-22 14:45"),moment("2022-06-22 18:45")]);
            
            // alert([moment("2022-06-22 8:40"),moment("2022-06-22 9:20")]);

        }
            
            $(function () {
                // var arr = [
                //     moment("2022-06-12 8:40"),
                //     moment("2022-06-12 9:20"),
                //     ];
                
                $('#datetimepicker6').datetimepicker({
                    // defaultDate: new Date(),
                    minDate : new Date(),
                    format: 'YYYY-MM-DD HH:mm:ss',
                    toolbarPlacement: 'top',
                    showClear: true, 
                    showClose: true,  
                    sideBySide: true,
                    disabledTimeIntervals: hold,
                    daysOfWeekDisabled: [0, 7],
                    stepping: 15,
                    enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 0, 1, 2, 3, 4],
                    // showOn: inp.hasClass("ui-date-picker-onfocus") ? "focus" : "button"
                    
                });


                $('#datetimepicker1').datetimepicker({
                    // defaultDate: new Date(),
                    // minDate : new Date(),
                    format: 'HH:mm:ss',
                    toolbarPlacement: 'top',
                    showClear: true, 
                    showClose: true,  
                    sideBySide: true,
                    // disabledTimeIntervals: hold,
                    // daysOfWeekDisabled: [0, 7],
                    stepping: 15,
                    enabledHours: [0,1,2,3,4,5],
            
                    
                });
                // alert(hold);
            });
            console.log("TETS");
            $('.datepicker').datetimepicker({
            format: 'yyyy/mm/dd',
            formatSubmit: 'yyyy/mm/dd',
            })
                
            $('.datepicker').on('change', function() {
            $('p').text($('#input_value').val())
            })
            console.log("TETS");




            // console.log(dat);
</script>




