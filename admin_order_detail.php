<?php

include 'config.php';

session_start();

$order_id = $_GET['order_id'];

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

      <h1 class="title">Chi tiết đơn hàng</h1>
      <div class="cart-detail">
         <?php
         $order_query = mysqli_query($conn, "SELECT * FROM `orders` o WHERE o.id = $order_id") or die('query failed');
         if (mysqli_num_rows($order_query) > 0) {
            $fetch_orders = mysqli_fetch_assoc($order_query);
         ?>
            <div class="box-cart-detail">
               <p class="text-detail"> Họ tên: <?php echo $fetch_orders['name']; ?></p>
               <p class="text-detail"> Ngày đặt hàng: <?php echo $fetch_orders['placed_on']; ?></p>
               <p class="text-detail"> Số điện thoại: <?php echo $fetch_orders['number']; ?></p>
               <p class="text-detail"> Email: <?php echo $fetch_orders['email']; ?></p>
               <p class="text-detail"> Địa chỉ: <?php echo $fetch_orders['address']; ?></p>
               <p class="text-detail"> Ghi chú: <?php echo $fetch_orders['note']; ?></p>
               <p class="text-detail"> Phương thức thanh toán: <?php echo $fetch_orders['method']; ?></p>
               <p class="text-detail"> Trạng thái: <?= $fetch_orders['status']; ?> </p>
            </div>
            <table id="table-product-2" border="1">
               <tr>
                  <th>Bìa sách</th>
                  <th>Tên sách</th>
                  <th>Tác giả</th>
                  <th>Giá</th>
                  <th>Số lượng</th>
                  <th>Tổng tiền</th>
               </tr>
               <?php
               $grand_total = 0;
               $idOrder = $fetch_orders['id'];
               $select_cart = mysqli_query(
                  $conn,
                  "SELECT p.name as 'product_name', 
                           p.author as 'author', 
                           p.image as 'image',
                           p.id as 'product_id',
                           c.price as 'price',
                           c.quantity as 'quantity'
                           FROM orders o
                           INNER JOIN carts c ON o.id = c.order_id 
                           INNER JOIN products p ON p.id = c.product_id
                           WHERE o.status != 'Chưa Thanh Toán' 
                           AND o.id = '$idOrder'"
               ) or die('query failed');
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $total = $fetch_cart['price'] * $fetch_cart['quantity'];
                     $grand_total += $total;
               ?>
                     <tr>
                        <td>
                           <a href="product_details.php?id=<?php echo $fetch_cart['product_id']; ?>">
                              <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>">
                           </a>
                        </td>
                        <td><?= $fetch_cart["product_name"] ?></td>
                        <td><?= $fetch_cart["author"] ?></td>
                        <td><?= $fetch_cart["price"] ?> VND</td>
                        <td><?= $fetch_cart["quantity"] ?></td>
                        <td><?= $total ?> VND</td>
                     </tr>
                  <?php
                  }
                  ?>
                  <tr>
                     <td colspan="5" style="text-align: right"><b>Thành tiền</b> </td>
                     <td><b><?= $grand_total ?> VND</b></td>
                  </tr>
            <?php
               }
            }
            ?>
            </table>


      </div>
   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>