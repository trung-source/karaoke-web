

<?php

$select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
if(mysqli_num_rows($select_products) > 0){
$resultArray = array();


// fetch product data one by one
while($item = mysqli_fetch_array($select_products,MYSQLI_ASSOC)){
    // print_r($item);
    $resultArray[] = $item;
}
shuffle($resultArray);
$type = array_map(function($pro){return $pro['type'];}, $resultArray);
$unique = array_unique($type);
sort($unique);




if(isset($_GET['book'])){
    $room_id = $_GET['book'];
    $room_id_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
}



// if(isset($_GET['delete'])){
//     $delete_id = $_GET['delete'];
//     mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
//     header('location:cart.php');
//  }




if(isset($_POST['update_room-1'])){

    $user_id = $_SESSION['id'];
    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_amount = $_POST['update_amount'];
    $select_product_name = mysqli_query($conn, "SELECT product_id FROM `room_product` WHERE product_id = '$update_p_id' and room_id = '$room_id'") or die('query failed');
 
 
 
    // mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price', type = '$update_type', amount = '$update_amount' WHERE id = '$update_p_id'") or die('query failed');
 
 
 
    if(mysqli_num_rows($select_product_name) > 0){
        // $message[] = 'product already added in the room';
        mysqli_query($conn, "UPDATE `room_product` SET amount = '$update_amount' WHERE product_id = '$update_p_id' and room_id = '$room_id'") or die('query failed');
        // $add_product_query = mysqli_query($conn, "INSERT INTO `room_product`(product_id,room_id,user_id,amount) VALUES('$update_p_id', '$room_id','$user_id','$update_amount')") or die('query failed');

     }else{
        $add_product_query = mysqli_query($conn, "INSERT INTO `room_product`(product_id,room_id,user_id,amount) VALUES('$update_p_id', '$room_id','$user_id','$update_amount')") or die('query failed');
  
        
        header('location:booking.php?book='.$room_id);
     }
 
 
 }

 

if(isset($_POST['add-to-room'])){

    $user_id = $_SESSION['id'];
    $product_id = $_POST['item_id'];
 
    $select_product_name = mysqli_query($conn, "SELECT product_id FROM `room_product` WHERE product_id = '$product_id' and room_id = '$room_id'") or die('query failed');
 
    if(mysqli_num_rows($select_product_name) > 0){
       $message[] = 'product already added in the room';
    }else{
       $add_product_query = mysqli_query($conn, "INSERT INTO `room_product`(product_id,room_id,user_id) VALUES('$product_id', '$room_id','$user_id')") or die('query failed');
 
       if($add_product_query){
             $message[] = 'product added successfully!';
       }else{
          $message[] = 'product could not be added!';
       }
       header('location:booking.php?book='.$room_id);
    }

    ?>
    <!-- <h3><?php echo $message[0] ?></h3> -->
    <?php
 }



?>

        <section id="special-price wow fadeInUp">
            <div class="container">
            <hr>

                <h4 class="font-alt font-size-20">All Products</h4>
                <div id="filters" class="button-group text-right font-baloo font-size-16">
                    <button class="btn is-checked" data-filter="*">All Type</button>
                    <?php
                        array_map(function($type){
                            printf('<button class="btn is-checked" data-filter=".%s">%s</button>',$type,$type);
                        },$unique);
                    ?>
                    <!-- <button class="btn is-checked" data-filter=".Samsung">Apple</button>

                    <button class="btn is-checked" data-filter=".Samsung">Samsung</button>
                    <button class="btn is-checked" data-filter=".Redmi">Redmi</button> -->
                </div>

                
                <div class="grid">
                    <?php array_map(function($item){?>
                  
                    <!-- ITEM 10-->
                    <div class="grid-item border <?php echo $item["type"] ?? "type" ?>">

                        <div class="item py-2" style="width: 200px;">
                            <div class="product font-rale">
                            <a href="#"><img class="img-fill-4" src="<?php echo "./assets/product/".$item['type'].'/'.$item['image'] ?? "./assets/products/1.jpg" ?>" alt="product1" ></a>

                                <div class="text-center">
                                    <h5><?php echo $item['name']?></h5>
                                <h5>Số lượng: <?php echo $item['amount']?></h5>

                                
                                <!-- Them gia va nut mua -->
                                <div class="price py-2">
                                    <span>Giá: <?php echo $item['price']; ?>K</span>
                                </div>
                                
                                <?php 
                                if(isset($_GET['book'])){
                                    $room_id = $_GET['book'];
                                    ?>
                                <!-- <a href="booking.php?book=<?php echo $room_id; ?>?update=<?php echo $item['id']; ?>" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">update</a> -->
                                <form method="get">
                                    <input type="hidden" name='book' value="<?php echo $room_id ?? '1' ?>">                           
                                    <button type="submit" name="add-to-room-1" value="<?php echo $item['id']?>" class="btn btn-primary font-size-14">Add to Room</button>
                                </form>
                                <?php
                                }
                                    
                                ?>

                                
                                <?php if($_SESSION['user_type']=='admin' || $_SESSION['user_type']=='nhanvien'){ ?>
                                
                                <div class="d-flex justify-content-between mt-3">
                                    <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">Chi tiết</a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Đặt chỗ</a> -->
                                    <a href="admin_product.php?update=<?php echo $item['id']; ?>" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">update</a>
                                    <a href="admin_product.php?delete=<?php echo $item['id']; ?>" class="delete-btn btn btn-sm btn-warning rounded py-2 px-4" onclick="return confirm('delete this room?');">delete</a>
                                 </div>
                                <br>

                                <?php } ?>
                                
                                </div>
                            </div>
                        </div>
                        </div>
                    <?php },$resultArray) ?>

                </div>        
            </div>
            
        </section>
        <!-- !Special sale -->
        <?php
      }else{
         echo '<h3 class="font-alt text-center text-danger py-5">no product added yet!</h3>';
      }
      ?>
<br>



<section class="edit-room-form-1">

      
<?php
    if(isset($_GET['book'])){
        $book_id = $_GET['book'];
        // print_r($book_id);
      if(isset($_GET['add-to-room-1'])){
         $update_id = $_GET['add-to-room-1'];
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
      <input type="number" name="update_amount" value="<?php echo $fetch_update['amount']; ?>" min="0" max="<?php echo $fetch_update['amount']; ?>" class="box" required placeholder="enter amount of product">
      <input type="submit" value="update" name="update_room-1" class="btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">
      <input type="reset" value="cancel" id="close-update-book" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-waring">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-room-form-1").style.display = "none";</script>';

      }

      ?>
<script>
     // Closing small window (room page)
 document.querySelector('#close-update-book').onclick = () =>{
    document.querySelector('.edit-room-form-1').style.display = 'none';
    window.location.href = 'booking.php?book=<?php echo $book_id; ?>';
 }


</script>



      <?php
    }
   ?>

</section>