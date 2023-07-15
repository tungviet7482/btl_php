<?php
if (isset($_POST['add_to_cart'])) { //thêm sách vào giỏi hàng từ form submit name='add_to_cart'

  if ($user_id == '') {
    header('location:login.php');
  }

  $product_id = $_POST['product_id'];
  $product_price = $_POST['product_price'];
  if(isset($_POST['product_quantity']))
    $product_quantity = $_POST['product_quantity'];
  else
    $product_quantity = 1;
  if ($product_quantity == 0) {
    $message[] = 'sách đã hết hàng!';
  } else {
    $check_cart_numbers = mysqli_query($conn, "SELECT *
     FROM users us JOIN orders od ON us.id = od.user_id 
                JOIN carts ON od.id = carts.order_id
     WHERE status = 'Chưa Thanh Toán' AND us.id = '$user_id' AND carts.product_id = '$product_id'") or die('query failed');
    if (mysqli_num_rows($check_cart_numbers) > 0) { //kiểm tra sách có trong giỏ hàng chưa và tăng số lượng
      $result = mysqli_fetch_assoc($check_cart_numbers);
      $order_id = $result['order_id'];
      mysqli_query($conn, "CALL THEM_SACH($order_id, $user_id, $product_id, $product_quantity)");
      $message[] = 'Sách đã có trong giỏ hàng và được thêm số lượng!';
    } else {
      $get_order_id = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id ='$user_id' AND status='Chưa thanh toán'"); // Kiểm tra xem có Đơn hàng chưa
      if (mysqli_num_rows($get_order_id) == 0)
        mysqli_query($conn, "INSERT INTO `orders`(`user_id`, `status`) VALUES ($user_id,'Chưa thanh toán')");

      $get_order_id = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id ='$user_id' AND status='Chưa thanh toán'");
      $result = mysqli_fetch_assoc($get_order_id);
      $order_id = $result['id'];
      mysqli_query($conn, "CALL THEM_SACH_MOI($order_id, $user_id, $product_id, $product_quantity, $product_price)") or die('query failed');
      $message[] = 'Sách đã được thêm vào giỏ hàng!';
    }
  }
}
