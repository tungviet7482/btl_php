<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id']; //tạo session admin

if (!isset($admin_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
}

if (isset($_GET['delete'])) { //xóa người dùng từ onclick href='delete'
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Người dùng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/admin_style.css">
   <link rel="stylesheet" href="css/tung.css">

</head>

<body>

   <?php include 'admin_header.php'; ?>

   <section class="users">

      <h1 class="title"> Tài khoản người dùng </h1>

      <section class="show-products">
         <table id="table-product" border="1">
            <tr>
               <th>Mã người dùng</th>
               <th>Tên người dùng</th>
               <th>Email</th>
               <th>Quyền</th>
               <th>Hành động</th>
            </tr>
            <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            if (mysqli_num_rows($select_users) > 0) {
               while ($fetch_users = mysqli_fetch_assoc($select_users)) {
            ?>
                  <tr>
                     <td><?= $fetch_users["id"] ?></td>
                     <td><?= $fetch_users["name"] ?></td>
                     <td><?= $fetch_users["email"] ?></td>
                     <td><?= $fetch_users["user_type"] ?></td>
                     <td>
                        <?php
                        if ($fetch_users['user_type'] == 'admin') {
                        ?>
                           <a href="#" onclick="return confirm('Không thể xóa Admin?');" class="delete-btn">Xóa</a>
                        <?php
                        } else {
                        ?>
                           <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Xóa người dùng này?');" class="delete-btn">Xóa</a>
                        <?php
                        }
                        ?>
                     </td>
                  </tr>

            <?php
               }
            } else {
               echo '<p class="empty">Không có sách nào được thêm!</p>';
            }
            ?>
         </table>
      </section>

   </section>

   <script src="js/admin_script.js"></script>

</body>

</html>