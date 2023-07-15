<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; //tạo session admin
$status_array = array('Chờ xác nhận', 'Đã xác nhận', 'Đã giao', 'Huỷ');

if (!isset($admin_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
};

if (isset($_POST['update'])) { //cập nhật trạng thái đơn hàng từ submit='update_order'
   $order_update_id = $_POST['id'];
   $update_status = $_POST['update_status'];
   mysqli_query($conn, "UPDATE `orders` SET status = '$update_status' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Trạng thái đơn hàng đã được cập nhật!';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/tung.css">
</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="orders">

      <h1 class="title">Đơn đặt hàng</h1>
      <table id="table-product" border="1">
         <tr>
            <th>Mã đơn hàng</th>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Phương thức thanh toán </th>
            <th>Địa chỉ nhận </th>
            <th>Lời nhắn</th>
            <th>Thời gian</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
         </tr>
         <?php

         $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE status != 'Chưa thanh toán'") or die('query failed');
         if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
               $grand_total = 0;
               $idOrder = $fetch_orders['id'];
               $select_cart = mysqli_query(
                  $conn,
                  "SELECT carts.quantity as 'cart_quantity',carts.price as 'product_price'
                     FROM users us 
                     JOIN orders od ON us.id = od.user_id 
                     JOIN carts ON od.id = carts.order_id 
                     WHERE STATUS != 'Chưa Thanh Toán' 
                     AND od.id = '$idOrder'"
               ) or die('query failed'); //lấy ra giỏ hàng tương ứng với id người dùng
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $grand_total += $fetch_cart['cart_quantity'] * $fetch_cart['product_price'];
                  }
         ?>
                  <tr>
                     <td><?= $fetch_orders["id"] ?></td>
                     <td><?= $fetch_orders["name"] ?></td>
                     <td><?= $fetch_orders["number"] ?></td>
                     <td><?= $fetch_orders["method"] ?></td>
                     <td><?= $fetch_orders["address"] ?></td>
                     <td><?= $fetch_orders["note"] ?></td>
                     <td><?= $fetch_orders["placed_on"] ?></td>
                     <td><?= $grand_total ?> VND</td>
                     <form action="" method="POST">
                        <input type="hidden" name="id" value="<?php echo $fetch_orders['id']; ?>">
                        <td>
                           <select name="update_status" class="box-select">
                              <?php
                              foreach ($status_array as $status) {
                                 $selected = ($status == $fetch_orders['status']) ? 'selected' : '';
                                 echo '<option value="' . $status . '" ' . $selected . '>' . $status . '</option>';
                              }
                              ?>
                           </select>
                        </td>
                        <td>
                           <div class="action-order">

                              <input class="input-order input-order-update" type="submit" name="update" value="Cập nhật" />
                              <button class="input-order input-order-detail" type="button" onclick="location.href='admin_order_detail.php?order_id=<?php echo $fetch_orders['id']; ?>'">Chi tiết</button>
                           </div>
                     </form>
                     </td>
                  </tr>

         <?php
               }
            }
         } else {
            echo '<p class="empty">Không có đơn đặt hàng nào!</p>';
         }
         ?>
      </table>
   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>