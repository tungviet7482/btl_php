<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; //tạo session admin

if (!isset($admin_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang quản trị</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="dashboard">

      <h1 class="title">Bảng thông tin</h1>

      <div class="box-container">

         <div class="box">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
            ?>
            <h3><?php echo $number_of_orders; ?></h3>
            <p>Đơn hàng</p>
         </div>

         <div class="box">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
            ?>
            <h3><?php echo $number_of_products; ?></h3>
            <p>Sách</p>
         </div>

         <div class="box">
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
            ?>
            <h3><?php echo $number_of_users; ?></h3>
            <p>Người dùng thường</p>
         </div>

         <div class="box">
            <?php
            $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admins = mysqli_num_rows($select_admins);
            ?>
            <h3><?php echo $number_of_admins; ?></h3>
            <p>Admin</p>
         </div>

         <div class="box">
            <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
            ?>
            <h3><?php echo $number_of_account; ?></h3>
            <p>Số tài khoản</p>
         </div>

         <div class="box">
            <?php
            $total_money = mysqli_query($conn, "SELECT SUM(carts.price*carts.quantity) AS 'money' FROM users us JOIN orders od ON us.id = od.user_id JOIN carts ON od.id = carts.order_id JOIN products pd ON pd.id = carts.product_id WHERE STATUS = 'Chờ xác nhận';") or die('query failed');
            $total_of_price = mysqli_fetch_assoc($total_money);
            ?>
            <h3><?php echo $total_of_price["money"]; ?></h3>
            <p>Tổng số tiền bán được (VNĐ)</p>
         </div>

      </div>

   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>