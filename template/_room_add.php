<?php



$admin_id = $_SESSION['id'];

if(!isset($admin_id)){
   header('location:index.php');
};

$conn = $db->con;

if(isset($_POST['add_room'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $type = $_POST['type'];
   $desc = $_POST['desc'];


   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/room/'.$type.'/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT room_name FROM `room` WHERE room_name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'room name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `room`(room_name, room_price, room_image, room_type, room_desc) VALUES('$name', '$price', '$image','$type','$desc')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'room added successfully!';
         }
      }else{
         $message[] = 'room could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   if(isset($fetch_delete_image)){
   unlink('assets/room/'.$fetch_delete_image['room_type'].'/'.$fetch_delete_image['room_image']);
   
   mysqli_query($conn, "DELETE FROM `room` WHERE id = '$delete_id'") or die('query failed');
   }
   header('location:admin_room.php');
}

if(isset($_POST['update_room'])){


   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_type = $_POST['update_type'];
   $update_desc = $_POST['update_desc'];


   mysqli_query($conn, "UPDATE `room` SET room_name = '$update_name', room_price = '$update_price', room_type = '$update_type', room_desc ='$update_desc' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'assets/room/'.$update_type.'/'.$update_image;
   $update_old_image = $_POST['update_old_image'];
   $update_old_type = $_POST['update_old_type'];


   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `room` SET room_image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('assets/room/'.$update_old_type.'/'.$update_old_image);
      }
   }

   header('location:admin_room.php');

}

?>

<!-- room CRUD section starts  -->

<section class="add-rooms wow fadeInUp">
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="font-alt">add room</h3>
      <input type="text" name="name" class="box" placeholder="enter room name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter room price" required>
      
      <input type="text" name="desc" class="box" placeholder="enter room description">
      <select name="type" class="form-group box">
                <option value="vip">VIP</option>
                <option value="normal">Phòng Thường</option>
      </select>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" class="btn btn-sm btn-primary rounded py-2 px-4 font-alt bg-warning text-danger" value="add room" name="add_room">
   </form>


</section>

<!-- room CRUD section ends -->

<!-- show room  -->

<section class="show-rooms">

   <div>

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `room`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            
      ?>
         <section id="phong-vip">
            <div class="container py-5 wow fadeInUp" data-wow-delay="0.5s">
                <h4 class="font-alt font-size-20">ALL ROOMS</h4>
                <hr>
                <!-- owl carousel -->
                <div class="owl-carousel owl-theme">
                  <?php while($fetch_products = mysqli_fetch_assoc($select_products)){ ?>


                    <!-- ITEM -->
                    <div class="item py-2">
                        <div class="room font-rale mr-2 img-fill-2">
                            <a href="booking.php?book=<?php echo $fetch_products['id']; ?>"><img src="./assets/room/<?php echo $fetch_products['room_type'].'/'; echo $fetch_products['room_image']; ?>" alt="room1" class="img-fluid"></a>
                            </div>
                            <div>
                            <div class="text-center">
                                <h6>Phòng <?php echo $fetch_products['room_name']?></h6>
                                <h6 class="font-alt">Loại: <?php echo $fetch_products['room_type']?></h6>

                                <!-- Them 5 sao -->
                                <div class="rating text-warning font-size-12">
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="fas fa-star"></i></span>
                                    <span><i class="far fa-star"></i></span>
                                </div>
                                <!-- Them gia va nut mua -->
                                <div class="price py-2">
                                    <span><?php echo $fetch_products['room_price']; ?>K</span>
                                </div>
                                <div class="d-flex justify-content-between mx-3">
                                    <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">Chi tiết</a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Đặt chỗ</a> -->
                                    <a href="admin_room.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">update</a>
                                    <a href="admin_room.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn btn btn-sm btn-warning rounded py-2 px-4" onclick="return confirm('delete this room?');">delete</a>
      
                                 </div>
                            </div>
                        </div>
                    </div>
                    <?php
         }
         ?>
                </div>
                

                <!-- owl carousel -->
            </div>
        </section>

      
         <?php
      }else{
         echo '<h3 class="font-alt text-center text-danger py-5">no room added yet!</h3>';
      }
      ?>
   </div>

</section>

<section class="edit-room-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_type" value="<?php echo $fetch_update['room_type']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['room_image']; ?>">
      <img src="assets/room/<?php echo $fetch_update['room_type'].'/'; echo $fetch_update['room_image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['room_name']; ?>" class="box" required placeholder="enter room name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['room_price']; ?>" min="0" class="box" required placeholder="enter room price">
      <input type="file" class="box" value="<?php echo "assets/room/".$fetch_update['room_type'].'/'; echo $fetch_update['room_image']; ?>" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <select name="update_type" class="form-group box font-alt">
                <option value="<?php echo $fetch_update['room_type']; ?>"><?php echo $fetch_update['room_type']; ?></option>
                <option value="vip">VIP</option>
                <option value="normal">NORMAL</option>
      </select>
      <input type="text" value="<?php echo $fetch_update['room_desc']; ?>" name="update_desc" class="box" placeholder="enter room description">
      <input type="submit" value="update" name="update_room" class="btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">
      <input type="reset" value="cancel" id="close-update" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-waring">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-room-form").style.display = "none";</script>';

      }
   ?>

</section>








