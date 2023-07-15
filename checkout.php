<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; //tạo session người dùng thường

if (!isset($user_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
}

if (isset($_POST['order_btn'])) { //nhập thông tin đơn hàng từ form submit name='order_btn'

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $number = $_POST['number'];
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $method = mysqli_real_escape_string($conn, $_POST['method']);
   $address = mysqli_real_escape_string($conn, $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country']);
   $note = mysqli_real_escape_string($conn, $_POST['note']);
   $placed_on = date('d-m-Y');
   $status = "Chờ xác nhận"; //trạng thái mặc định khi mới đặt hàng
   $result = mysqli_query($conn, "SELECT * FROM `orders` WHERE `user_id` = $user_id AND `status` = 'Chưa thanh toán'");
   $order_id = mysqli_fetch_assoc($result)['id'];
   mysqli_query($conn, "UPDATE `orders` SET `name`='$name',`number`='$number',`email`='$email',`method`='$method',`address`='$address',`note`='$note',`placed_on`='$placed_on',`status`='$status' WHERE `id` = $order_id");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading">
      <h3>Thanh toán</h3>
      <p> <a href="home.php">Trang chủ</a> / Thanh toán </p>
   </div>

   <section class="display-order">

      <?php
      $grand_total = 0;
      $select_cart = mysqli_query($conn, "SELECT us.id AS 'user_id',us.name 'user_name',carts.quantity 'cart_quantity',carts.price 'product_price',carts.product_id 'product_id',pd.name 'product_name', od.id 'order_id', image FROM users us JOIN orders od ON us.id = od.user_id JOIN carts ON od.id = carts.order_id JOIN products pd ON pd.id = carts.product_id WHERE STATUS = 'Chưa Thanh Toán' AND us.id = '$user_id'") or die('query failed');
      if (mysqli_num_rows($select_cart) > 0) {
         while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = $fetch_cart['product_price'] * $fetch_cart['cart_quantity'];
            $grand_total += $total_price;
      ?>
            <p> <?php echo $fetch_cart['product_name']; ?> <span>(<?php echo $fetch_cart['product_price'] . ' VND' . ' x ' . $fetch_cart['cart_quantity']; ?>)</span> </p>
      <?php
         }
      } else {
         echo '<p class="empty">Giỏ hàng của bạn trống!</p>';
      }
      ?>
      <div class="grand-total"> Tổng số tiền : <span><?php echo $grand_total; ?> VND</span> </div>

   </section>

   <section class="checkout">

      <form action="" method="post">
         <h3>Nhập thông tin đơn hàng</h3>
         <div class="flex">
            <div class="inputBox">
               <span>Họ tên:</span>
               <input type="text" name="name" required placeholder="Nguyễn Văn A">
            </div>
            <div class="inputBox">
               <span>Số điện thoại :</span>
               <input type="number" name="number" required placeholder="0123456789">
            </div>
            <div class="inputBox">
               <span>Email :</span>
               <input type="email" name="email" required placeholder="abc@gmail.com">
            </div>
            <div class="inputBox">
               <span>Phương thức thanh toán :</span>
               <select name="method">
                  <option value="Tiền mặt khi nhận hàng">Tiền mặt khi nhận hàng</option>
                  <option value="Thẻ ngân hàng">Thẻ ngân hàng</option>
                  <option value="Paypal">Paypal</option>
               </select>
            </div>
            <div class="inputBox">
               <span>Địa chỉ :</span>
               <input type="text" name="street" required placeholder="Số nhà, số đường, phường/xã, huyện/thị xã">
            </div>
            <div class="inputBox">
               <span>Thành phố:</span>
               <input type="text" name="city" required placeholder="Hà Nội">
            </div>
            <div class="inputBox">
               <span>Nước :</span>
               <input type="text" name="country" required placeholder="Việt Nam">
            </div>
            <div class="inputBox">
               <span>Ghi chú:</span>
               <input type="text" name="note" required placeholder="Lời nhắn">
            </div>
         </div>
         <input type="submit" value="Đặt hàng" class="btn" name="order_btn" id="btn_order">
      </form>

   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>
<script>
   var empty = document.querySelector(".empty");
   var btnOrder = document.getElementById('btn_order');
   if(empty) {
      btnOrder.disabled = true;
      btnOrder.style.opacity = '0.5';
      btnOrder.value = "Không thể đặt hàng";
   }
   else{
      btnOrder.disabled = false;
      btnOrder.style.opacity = '1';
      btnOrder.value = "Đặt hàng";
   }
</script>
</html>

