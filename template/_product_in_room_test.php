


<?php

if(isset($_GET['book'])){
$bookroom_id = $_GET['book'];
    
    }


if(isset($_POST['delete-prod'])){

    $user_id = $_SESSION['id'];
    $delete_id = $_POST['del-prod'];
   print_r($delete_id);
    if (isset($bookroom_id)){
    mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$bookroom_id' and user_id = $user_id") or die('query failed');
    header('location:booking.php?book='.$bookroom_id);
        
}
    else{
    $room_id = mysqli_query($conn, "SELECT room_id FROM `room_product` WHERE product_id = '$delete_id' and user_id = $user_id") or die('query failed');
    mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$room_id' and user_id = $user_id") or die('query failed');
    header('location:booking.php?book='.$room_id);

    }
 
    // mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price', type = '$update_type', amount = '$update_amount' WHERE id = '$update_p_id'") or die('query failed');
  
 
 }


?>
    


<section class="show-rooms">
   <div>

   <section id="phong-vip">
            <div class="container py-5 wow fadeInUp" data-wow-delay="0.5s">
                <h4 class="font-alt font-size-20">Dich vu trong phong</h4>
                <hr>
                <!-- owl carousel -->
                <div class="owl-carousel owl-theme">
                <?php


$user_id = $_SESSION['id'];

$sql  = "SELECT
room.id as room_id,
product.id as product_id 
FROM
room
LEFT JOIN
room_product on room_product.room_id = room.id and room_product.user_id = $user_id
LEFT JOIN
product on product.id = room_product.product_id
WHERE room.id = $bookroom_id
";


$result = mysqli_query($conn,$sql) or die('query failed'); // your custom function like using pdo or mysqli
foreach($result as $product)
    {
        $product_id = $product['product_id'];
        $select_products = mysqli_query($conn,"SELECT * FROM `product` WHERE id = '$product_id'") or die('query failed');
        // array_push($md_array["cuisine"],$newdata);
        // print_r($select_products);

        while( $row = mysqli_fetch_assoc($select_products)){ 
            $fetch_products_1[] = $row;
        }      
    }
      if(mysqli_num_rows($select_products) > 0){
              
      ?>
        
                  <?php foreach($fetch_products_1 as $fetch_products){ 
                    // print_r($fetch_products_1)
                    // print_r($fetch_products);
                    // print_r($select_products);
                    $product_id = $fetch_products['id'];
                    $room_id = $_GET['book'];
                    $select_product_name = mysqli_query($conn, "SELECT amount FROM `room_product` WHERE product_id = '$product_id' and room_id = '$room_id'") or die('query failed');
                    $fetch_products_amount = mysqli_fetch_assoc($select_product_name)
                    ?>
                    
                    <!-- ITEM 1 -->
                    <div class="item py-2">
                        <div class="room font-rale mr-2 img-fill-3">
                            <a href="#"><img src="./assets/product/<?php echo $fetch_products['type'].'/'; echo $fetch_products['image']; ?>" alt="room1" class="img-fluid img-fill-4"></a>
                            </div>
                            <div>
                            <div class="text-center">
                                <h5><?php echo $fetch_products['name']?></h5>
                                <!-- Them 5 sao -->
                                
                                <h6>Số lượng: <?php echo $fetch_products_amount['amount']?></h6>


                                <!-- Them gia va nut mua -->
                                <div class="price py-2">
                                    <span>Tổng: <?php echo $fetch_products['price']*$fetch_products_amount['amount']; ?>K</span>
                                </div>

                                <br>
                                <div class="d-flex justify-content-between mx-5 px-3">
                                    <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">Chi tiết</a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Đặt chỗ</a> -->
                                    <form action="" method="post" enctype="multipart/form-data">
                                    <a href="">
                                    <input type="hidden" name="del-prod" value="<?php echo $fetch_products['id']; ?>">
                                    <input type="submit" value="Xoa khoi phong" name="delete-prod" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">
                                    </a>
                                  
                                   </form>

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
         echo '<h3 class="font-alt text-center text-danger py-5">no product add to the room added yet!</h3>';
      }
      ?>
      <?php
?>
   </div>

</section>
