<section class="show-rooms wow fadeInUp">

   <div>

      <?php
         $select_products = mysqli_query($db->con, "SELECT * FROM `room` WHERE room_type = 'normal'") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            
      ?>
         <section id="phong-vip">
            <div class="container py-5 wow fadeInUp" data-wow-delay="0.5s">
                <h4 class="font-alt font-size-20">Phòng thường</h4>
                <hr>
                <!-- owl carousel -->
                <div class="owl-carousel owl-theme">
                  <?php while($fetch_products = mysqli_fetch_assoc($select_products)){ ?>
                    <!-- ITEM 1 -->
                    <div class="item py-2">
                        <div class="room font-rale mr-2 img-fill-2">
                           
                            <a href="booking.php?book=<?php echo $fetch_products['id']; ?>"><img src="./assets/room/<?php echo $fetch_products['room_type'].'/'; echo $fetch_products['room_image']; ?>" alt="room1" class="img-fluid"></a>

                        </div>
                            <div>
                            <div class="text-center">
                                <h6>Phòng <?php echo $fetch_products['room_name']?></h6>
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
                                <div class="flex">
                                    <!-- <a class="btn btn-sm btn-primary rounded py-2 px-4" href="">Chi tiết</a>
                                    <a class="btn btn-sm btn-dark rounded py-2 px-4" href="">Đặt chỗ</a> -->
                                    <a href="booking.php?book=<?php echo $fetch_products['id']; ?>" class="option-btn btn btn-sm btn-primary rounded py-2 px-4 bg-danger border-danger">Đặt phòng</a>
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
         echo '<h3 class="font-alt text-center text-danger py-5">no normal room added yet!</h3>';
      }
      ?>
   </div>

</section>