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
   $amount = $_POST['amount'];


   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'assets/product/'.$type.'/'.$image;

   $select_product_name = mysqli_query($conn, "SELECT name FROM `product` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'product name already added';
   }else{
      $add_product_query = mysqli_query($conn, "INSERT INTO `product`(name, price, image, type, amount) VALUES('$name', '$price', '$image','$type','$amount')") or die('query failed');

      if($add_product_query){
         if($image_size > 2000000){
            $message[] = 'image size is too large';
         }else{
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'product added successfully!';
         }
      }else{
         $message[] = 'product could not be added!';
      }
   }
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_image_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
   if(isset($fetch_delete_image)){
   unlink('assets/product/'.$fetch_delete_image['type'].'/'.$fetch_delete_image['image']);
   
   mysqli_query($conn, "DELETE FROM `product` WHERE id = '$delete_id'") or die('query failed');
   }
   header('location:admin_product.php');
}

if(isset($_POST['update_room'])){


   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_type = $_POST['update_type'];
   $update_amount = $_POST['update_amount'];



   mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price', type = '$update_type', amount = '$update_amount' WHERE id = '$update_p_id'") or die('query failed');

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_folder = 'assets/product/'.$update_type.'/'.$update_image;
   $update_old_image = $_POST['update_old_image'];
   $update_old_type = $_POST['update_old_type'];


   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image file size is too large';
      }else{
         mysqli_query($conn, "UPDATE `product` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
         move_uploaded_file($update_image_tmp_name, $update_folder);
         unlink('assets/product/'.$update_old_type.'/'.$update_old_image);
      }
   }

   header('location:admin_product.php');

}

?>

<!-- room CRUD section starts  -->

<section class="add-rooms wow fadeInUp">
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="font-alt">add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="number" min="0" name="amount" class="box" placeholder="enter amount of product" required>
      <select name="type" class="form-group box">
                <option value="food">Đồ Ăn</option>
                <option value="drink">Đồ Uống</option>
                <option value="fruit">Hoa Quả</option>
      </select>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" class="btn btn-sm btn-primary rounded py-2 px-4 font-alt bg-warning text-danger" value="add product" name="add_room">
   </form>


</section>

<!-- room CRUD section ends -->

<!-- show room  -->

<section class="show-rooms">

   <div>

      <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            
      ?>
         <section id="phong-vip">
            <div class="container py-5 wow fadeInUp" data-wow-delay="0.5s">
                <h4 class="font-alt font-size-20">ALL PRODUCTS</h4>
                <hr>
                <!-- owl carousel -->
                <div class="owl-carousel owl-theme">
                  <?php while($fetch_products = mysqli_fetch_assoc($select_products)){ 
                     // print_r($fetch_products);
                     // print_r($select_products);
                     ?>
                     

                    <!-- ITEM -->
                    <div class="item py-2">
                        <div class="room font-alt mr-2 img-fill-3">
                            <a href="#"><img src="./assets/product/<?php echo $fetch_products['type'].'/'; echo $fetch_products['image']; ?>" alt="product1" class="img-fluid"></a>
                            </div>
                            <div>
                            <div class="text-center font-alt">
                              <br>
                                <h5><?php echo $fetch_products['name']?></h5>
                                <h5>Số lượng: <?php echo $fetch_products['amount']?></h5>

                                
                                <!-- Them gia va nut mua -->
                                <div class="price py-2">
                                    <span>Giá: <?php echo $fetch_products['price']; ?>K</span>
                                </div>
                                <div class="d-flex justify-content-between mx-3">
                                    <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">Chi tiết</a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Đặt chỗ</a> -->
                                    <a href="admin_product.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">update</a>
                                    <a href="admin_product.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn btn btn-sm btn-warning rounded py-2 px-4" onclick="return confirm('delete this room?');">delete</a>
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
         echo '<h3 class="font-alt text-center text-danger py-5">no product added yet!</h3>';
      }
      ?>
   </div>

</section>

<section class="edit-room-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `product` WHERE id = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
      <input type="hidden" name="update_old_type" value="<?php echo $fetch_update['type']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="assets/product/<?php echo $fetch_update['type'].'/'; echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="enter product name">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="enter product price">
      <input type="number" name="update_amount" value="<?php echo $fetch_update['amount']; ?>" min="0" class="box" required placeholder="enter amount of product">
      <input type="file" class="box" value="<?php echo "assets/product/".$fetch_update['type'].'/'; echo $fetch_update['image']; ?>" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <select name="update_type" class="form-group box font-alt">
               <option value="<?php echo $fetch_update['type']; ?>"><?php echo $fetch_update['type']; ?></option>
                <option value="food">Food</option>
                <option value="drink">Drink</option>
                <option value="fruit">Fruit</option>
      </select>
      <input type="submit" value="update" name="update_room" class="btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">
      <input type="reset" value="cancel" id="close-update-1" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-waring">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-room-form").style.display = "none";</script>';
      }
   ?>

</section>








