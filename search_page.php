<?php

include 'config.php';

session_start();

$user_id = '';
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; //tạo session người dùng thường
}

if (isset($_POST['add_to_cart'])) { //thêm sách vào giỏi hàng từ form submit name='add_to_cart'

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   if ($product_quantity == 0) {
      $message[] = 'Sách đã hết hàng!';
   } else {
      if ($user_id == '') { // session không tồn tại => quay lại trang đăng nhập
         header('location:login.php');
      }
      $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `carts` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

      if (mysqli_num_rows($check_cart_numbers) > 0) { //kiểm tra sách có trogn giỏ hàng chưa và tăng số lượng
         $result = mysqli_fetch_assoc($check_cart_numbers);
         $num = $result['quantity'] + $product_quantity;
         $select_quantity = mysqli_query($conn, "SELECT * FROM `products` WHERE name='$product_name'");
         $fetch_quantity = mysqli_fetch_assoc($select_quantity);
         if ($num > $fetch_quantity['quantity']) {
            $num = $fetch_quantity['quantity'];
         }
         mysqli_query($conn, "UPDATE `carts` SET quantity='$num' WHERE name = '$product_name' AND user_id = '$user_id'");
         $message[] = 'Đã có trong giỏ hàng!';
      } else {
         mysqli_query($conn, "INSERT INTO `carts`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
         $message[] = 'Đã được thêm trong giỏ hàng!';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang tìm kiếm</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/hieu.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading heading-search">
      <h3>Tìm kiếm sách</h3>
   </div>

   <section class="search-form">

      <form action="" method="post">
         <input type="text" name="search" placeholder="Tên sách bạn muốn tìm..." class="box">
         <input type="submit" name="submit" value="Tìm kiếm" class="btn">
      </form>

   </section>
   <section class="products" style="padding-top: 0;">
      <div class="box-container">
         <?php
         if (isset($_POST['submit'])) { //tìm kiếm sách bằng cách truy vấn keyword từ form = like
            $search_item = $_POST['search'];
            $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%{$search_item}%'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
               while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                  include('item.php');
               }
            } else {
               echo '<div class="empty empty-search">Vui lòng tìm lại sách!</div>';
               // echo '<script type="text/javascript">
               //      window.onload = function () { alert("Vui lòng tìm lại sách!"); }
               //        </script>';
            }
         }
         ?>
      </div>
   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>