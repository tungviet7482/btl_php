<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id']; //tạo session người dùng thường

if (!isset($user_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
}

if (isset($_POST['update_cart'])) { //cập nhật giỏ hàng từ form submit name='update_cart'
   $product_id = $_POST['product_id'];
   $cart_quantity = $_POST['cart_quantity'] - $_POST['cart_quantity_old'];
   $order_id = $_POST['order_id'];
   mysqli_query($conn, "CALL THEM_SACH($order_id, $user_id, $product_id, $cart_quantity)") or die('query failed');
   $message[] = 'Giỏ hàng đã được cập nhật!';
}

if (isset($_GET['delete'])) { //xóa sách khỏi giỏ hàng từ onclick href='delete'
   $product_id = $_GET['product_id'];
   $order_id = $_GET['order_id'];
   mysqli_query($conn, "CALL XOA_SACH($order_id, $user_id, $product_id)") or die('query failed');
   header('location:cart.php');
}

if (isset($_GET['deleteall'])) { // Xóa tất cả qua giá trị delete_All
   $result = mysqli_query($conn, "SELECT * FROM orders WHERE status = 'Chưa thanh toán' AND user_id = $user_id ");
   $order_id = mysqli_fetch_assoc($result)['id']; // Sử dụng $_GET để lấy giá trị order_id từ URL
   mysqli_query($conn, "CALL XOA_TAT_CA($order_id, $user_id)") or die('query failed');
   header('Location: cart.php'); // Chuyển hướng sau khi xóa thành công
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giỏ hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>

   <div class="heading heading-search">
      <h3>Giỏ hàng của bạn</h3>
   </div>
   <section class="shopping-cart"> 
      <div class="box-container">
     
         <?php
         $grand_total = 0;
         $select_cart = mysqli_query($conn, "SELECT us.id AS 'user_id',us.name 'user_name',carts.quantity 'cart_quantity',carts.price 'product_price',carts.product_id 'product_id',pd.name 'product_name', od.id 'order_id', image FROM users us JOIN orders od ON us.id = od.user_id JOIN carts ON od.id = carts.order_id JOIN products pd ON pd.id = carts.product_id WHERE STATUS = 'Chưa Thanh Toán' AND us.id = '$user_id';") or die('query failed'); //lấy ra giỏ hàng tương ứng với id người dùng
         if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
         ?>
               <div class="box">
                  <a href="cart.php?delete=1&product_id=<?php echo $fetch_cart['product_id']; ?>&order_id=<?php echo $fetch_cart['order_id']; ?>" class="fas fa-times" onclick="return confirm('Xóa khỏi giỏ hàng?')"></a>
                  <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
                  <p class="name"><?php echo $fetch_cart['product_name']; ?></p>
                  <p class="price"><?php echo $fetch_cart['product_price']; ?> VND (SL: <?php echo $fetch_cart['cart_quantity']; ?>)</p>
                  <input type="number" class="input_<?php echo $fetch_cart['product_id']; ?>" value="<?php echo $fetch_cart['cart_quantity']; ?>" onchange="updateInput(<?php echo $fetch_cart['product_id']; ?>)">
                  <div>
                     <form action="" method="post">
                        <input type="hidden" name="cart_quantity" class="input_<?php echo $fetch_cart['product_id']?>">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_cart['product_id']; ?>">
                        <input type="hidden" name="cart_quantity_old" value="<?php echo $fetch_cart['cart_quantity']; ?>">
                        <input type="hidden" name="order_id" value="<?php echo $fetch_cart['order_id']; ?>">
                        <input type="submit" name="update_cart" value="Cập nhật" class="option-btn">
                     </form>
                     <div class="sub-total"> Số tiền : <span><?php echo $sub_total = ($fetch_cart['cart_quantity'] * $fetch_cart['product_price']); ?> VND</span> </div>
                  </div>
               </div>
         <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty empty-card">Giỏ hàng của bạn trống!</p>';
         }
         ?>
      </div>

     

      <div class="cart-total">
         <p>Tổng tiền : <span><?php echo $grand_total; ?> VND</span></p>
         <div class="flex">
            <a href="cart.php?deleteall=1" class="delete-btn" onclick="return confirm('Xóa tất cả giỏ hàng?');">Xóa tất cả</a>
            <a href="shop.php" class="option-btn">Tiếp tục mua hàng</a>
            <a href="checkout.php" class="btn">Tiến hành thanh toán</a>
         </div>
      </div>

   </section>

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>
<script>
   function updateInput(id) {
      var input = document.querySelectorAll(".input_"+id);
      input[1].value = input[0].value;
      console.log(input);
    }
</script>
</html>