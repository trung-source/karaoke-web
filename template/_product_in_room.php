

<?php
if(isset($_GET['book'])){
    $room_id = $_GET['book'];
    $room_id_query = mysqli_query($conn, "SELECT * FROM `room` WHERE id = '$room_id'") or die('query failed');
}


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
WHERE room.id = $room_id
";


$result = mysqli_query($conn,$sql) or die('query failed'); // your custom function like using pdo or mysqli
$fetch_products_1 = [];
foreach($result as $product)
    {
        $product_id = $product['product_id'];
        $select_products = mysqli_query($conn,"SELECT * FROM `product` WHERE id = '$product_id'") or die('query failed');
        // array_push($md_array["cuisine"],$newdata);
        // print_r($select_products);

        while( $row = mysqli_fetch_assoc($select_products)){ 
            if(!in_array($row,$fetch_products_1)){
            $fetch_products_1[] = $row;
            }
        }   
        
    }

$resultArray = $fetch_products_1;
// print_r($resultArray);

    
// $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
if(mysqli_num_rows($select_products) > 0){
// $resultArray = array();



// fetch product data one by one
// while($item = mysqli_fetch_array($select_products,MYSQLI_ASSOC)){
//     // print_r($item);
//     $resultArray[] = $item;
// }
shuffle($resultArray);
$type = array_map(function($pro){return $pro['type'];}, $resultArray);
$unique = array_unique($type);
sort($unique);







if(isset($_POST['add-to-room'])){

    $user_id = $_SESSION['id'];
    $product_id = $_POST['item_id'];
 
    $select_product_name = mysqli_query($conn, "SELECT product_id FROM `room_product` WHERE product_id = '$product_id' and room_id = '$room_id'") or die('query failed');
 
    if(mysqli_num_rows($select_product_name) > 0){
       $messages[] = 'product already added in the room';
    }else{
       $add_product_query = mysqli_query($conn, "INSERT INTO `room_product`(product_id,room_id,user_id) VALUES('$product_id', '$room_id','$user_id')") or die('query failed');
 
       if($add_product_query){
             $messages[] = 'product added successfully!';
       }else{
          $messages[] = 'product could not be added!';
       }
       header('location:booking.php?book='.$room_id);
    }

    ?>
    <!-- <h3><?php echo $messages[0] ?></h3> -->
    <?php
 }



 
if(isset($_POST['delete-prod'])){

    $user_id = $_SESSION['id'];
    $delete_id = $_POST['del-prod'];
//    print_r($delete_id);
    if (isset($room_id)){
    mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$room_id' and user_id = $user_id") or die('query failed');
    header('location:booking.php?book='.$room_id);
        
}
    else{
    $room_id = mysqli_query($conn, "SELECT room_id FROM `room_product` WHERE product_id = '$delete_id' and user_id = $user_id") or die('query failed');
    mysqli_query($conn, "DELETE FROM `room_product` WHERE product_id = '$delete_id' and room_id = '$room_id' and user_id = $user_id") or die('query failed');
    header('location:booking.php?book='.$room_id);

    }
 
    // mysqli_query($conn, "UPDATE `product` SET name = '$update_name', price = '$update_price', type = '$update_type', amount = '$update_amount' WHERE id = '$update_p_id'") or die('query failed');
  
 
 }


?>

        <section id="special-price wow fadeInUp">
            <div class="container">
            <hr>
                <h4 class="font-alt font-size-20">Dich vu trong phong hat</h4>
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
                    <?php array_map(function($item){
                        ?>
                  
                    <!-- ITEM 10-->
                    <div class="grid-item border <?php echo $item["type"] ?? "type" ?>">

                        <div class="item py-2" style="width: 200px;">
                            <div class="product font-rale">
                            <a href="#"><img src="<?php echo "./assets/product/".$item['type'].'/'.$item['image'] ?? "./assets/products/1.jpg" ?>" alt="product1" class="img-fluid img-fill-4"></a>

                                <div class="text-center">
                                    <h5><?php echo $item['name']?></h5>
                                <!-- <h5>Số lượng: <?php echo $item['amount']?></h5> -->

                                
                                <!-- Them gia va nut mua -->
                                <div class="price py-2">
                                    <span>Giá: <?php echo $item['price']; ?>K</span>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data">
                                    <a href="">
                                    <input type="hidden" name="del-prod" value="<?php echo $item['id']; ?>">
                                    <input type="submit" value="Xóa khỏi phòng" name="delete-prod" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">
                                </a>
                                </form>
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


