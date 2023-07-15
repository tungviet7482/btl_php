<?php

include 'config.php';

session_start();
$user_id = '';
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; //tạo session người dùng thường
}
include('action/add_to_cart.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang chủ</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>
   <?php include 'header.php'; ?>

   <section class="home">
      <div class="color__box_home">
         <div class="setting__slide">
            <div class="setting__slide_left">
               <div id="carouselExampleCaptions" class="carousel slide">
                  <div class="carousel-indicators">
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  </div>
                  <div class="carousel-inner">
                     <div class="carousel-item active ">
                        <img src="./images/image_slide1.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                           <h5>First slide label</h5>
                           <p>Some representative placeholder content for the first slide.</p>
                        </div>
                     </div>
                     <div class="carousel-item set_img_hidden">
                        <img src="./images/image_slide1.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                           <h5>Second slide label</h5>
                           <p>Some representative placeholder content for the second slide.</p>
                        </div>
                     </div>
                     <div class="carousel-item set_img_hidden">
                        <img src="./images/image_slide1.png" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                           <h5>Third slide label</h5>
                           <p>Some representative placeholder content for the third slide.</p>
                        </div>
                     </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     <span class="visually-hidden">Next</span>
                  </button>
               </div>
            </div>

            <div class="setting__slide_right">
               <div class="__slide_right_top">
                  <img src="./images/slide_right1.jpg" alt="">

               </div>

               <div class="__slide_right_bottom">
                  <img src="./images/slide_right2.png" alt="">
               </div>

            </div>

         </div>

      </div>

   </section>

   <section class="products">
      <div class="color__box">
         <h2 class="title_category"> Sách mới nhất</h2>
         <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC LIMIT 4") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                  include('item.php');
               }
            } else {
               echo '<p class="empty">Chưa có sách được bán!</p>';
            }
            ?>
         </div>
         <div class="load-more">
            <a href="shop.php" class="option-btn">Xem thêm...</a>
         </div>
      </div>
   </section>

   <section class="show__category">
      <div class="color__box">
         <?php
         $select_categorie = mysqli_query($conn, "SELECT * FROM `categories` WHERE `id` = 2 LIMIT 8") or die('query failed');
         if (mysqli_num_rows($select_categorie) > 0) {
            while ($fetch_categories = mysqli_fetch_assoc($select_categorie)) {
         ?>
               <h2 class="title_category"> <?php echo $fetch_categories['name'] ?></h2>
         <?php
            }
         }
         ?>

         <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE `category_id` = 2 ORDER BY id DESC LIMIT 8") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                  include('item.php');
               }
            } else {
               echo '<p class="empty">Chưa có sách được bán!</p>';
            }
            ?>
         </div>
         <div class="load-more">
            <a href="shop.php" class="option-btn">Xem thêm...</a>
         </div>
      </div>
   </section>

   <section class="show__category">
      <div class="color__box">
         <?php
         $select_categorie = mysqli_query($conn, "SELECT * FROM `categories` WHERE `id` = 3 ORDER BY id DESC LIMIT 8") or die('query failed');
         if (mysqli_num_rows($select_categorie) > 0) {
            while ($fetch_categories = mysqli_fetch_assoc($select_categorie)) {
         ?>
               <h2 class="title_category"> <?php echo $fetch_categories['name'] ?></h2>
         <?php
            }
         }
         ?>

         <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE `category_id` = 3 ORDER BY id DESC LIMIT 8") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {

                  include('item.php');
               }
            } else {
               echo '<p class="empty">Chưa có sách được bán!</p>';
            }
            ?>
         </div>
         <div class="load-more">
            <a href="shop.php" class="option-btn">Xem thêm...</a>
         </div>
      </div>
   </section>

   <!-- <section class="about">
      <div class="color__box">
         <div class="flex">
            <div class="image">
               <img src="images/about-img.jpg" alt="">
            </div>
            <div class="content">
               <h3>HAUIBOOK</h3>
               <p>Từ hội những bạn trẻ yêu thích đọc truyện, chúng mình muốn cùng chia sẻ những đam mê và sở thích tới mọi người.</p>
            </div>
         </div>
      </div>
   </section> -->

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>