<?php
//nhúng vào các trang bán hàng
if (isset($message)) { //hiển thị thông báo sau khi thao tác với biến message được gán giá trị
   foreach ($message as $message) {
      echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>'; //đóng thẻ này
   }
}
?>

<header class="header">
   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">HAUIBOOK</a>

         <nav class="navbar">
            <a href="home.php">Trang chủ</a>
            <a href="about.php">Thông tin</a>
            <a href="shop.php">Cửa hàng</a>
            <a href="contact.php">Liên hệ</a>
            <a href="orders.php">Đơn hàng</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i></a>

            <?php if ($user_id != '') {
            ?>
               <div id="user-btn" class="fas fa-user"></div>

               <div class="user-box">
                  <p>Tên người dùng : <span><?php echo $_SESSION['user_name']; ?></span></p>
                  <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                  <a href="logout.php" class="delete-btn">Đăng xuất</a>
               </div>
            <?php
            } else {
            ?>
               <a href="register.php" class="register">Đăng ký</a>
               <a href="logout.php" class="login">Đăng nhập</a>
            <?php
            }

            ?>
            <!-- <?php
            $select_cart = mysqli_query($conn, "SELECT * FROM `carts` WHERE user_id = 1") or die('query failed');
            $cart_rows_number = mysqli_num_rows($select_cart);
            $total = 0;
            while ($fetch_total = mysqli_fetch_assoc($select_cart)) {
               $total += $fetch_total['quantity'] * $fetch_total['price'];
            }
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> <span>(<?php echo $total; ?> VND)</span> </a> -->
         </div>
      </div>
   </div>
   </div>

</header>