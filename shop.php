<?php

include 'config.php';

session_start();

$user_id = '';
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; //tạo session người dùng thường
}
include("action/add_to_cart.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cửa hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Cửa hàng</h3>
   </div>

   <section class="products">
      <h2 class="title">Tất cả sách</h2>
      <select class="sort-box" onchange="window.location = this.options[this.selectedIndex].value">
         <option>Sắp xếp</option>
         <option value="?field=id& sort=DESC">Sách mới nhất</option>
         <option value="?field=id& sort=ASC">Sách cũ nhất</option>
         <option value="?field=category, name& sort=ASC">Tăng dần theo thể loại</option>
         <option value="?field=category, name& sort=DESC">Giảm dần theo thể loại</option>
         <option value="?field=newprice& sort=ASC">Giá tăng dần</option>
         <option value="?field=newprice& sort=DESC">Giá giảm dần</option>
      </select>

      <div style="clear:both"></div>

      <div class="box-container">

         <?php
         $select_num = mysqli_query($conn, "SELECT id FROM `products`");
         if (mysqli_num_rows($select_num) > 0) {
            if (isset($_GET['field']) && isset($_GET['sort'])) {
               $field = $_GET['field'];
               $sort = $_GET['sort'];
               $oder = "ORDER BY " . $field . " " . $sort;
            } else {
               $oder = "ORDER BY `id` DESC";
            }
            $select_products = mysqli_query($conn, "SELECT * FROM `products` " . $oder) or die('query failed');
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
               include('item.php');
            }
         } else {
            echo '<p class="empty">Chưa có sách được bán!</p>';
         }
         ?>
      </div>

   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>