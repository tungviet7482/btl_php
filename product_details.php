<?php

include 'config.php';

session_start();
$user_id = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; //tạo session người dùng thường
}

if (!isset($user_id)) { // session không tồn tại => quay lại trang đăng nhập
   header('location:login.php');
}
if (isset($_POST['mua_ngay'])){
    include "./action/add_to_cart.php";
    $_POST['add_to_cart'] = 1;
    header("Location: checkout.php");
}

include "./action/add_to_cart.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product_details</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <?php include 'header.php'; ?>

    <section class="details_Pro">
        <div class="color__box_home">
            <div class="Product_details">
                <?php
                $ids = $_GET['id'];
                $select_products_details = mysqli_query($conn, "SELECT products.*,categories.name as catename FROM `products` JOIN `categories` ON products.category_id = categories.id WHERE products.id = $ids");

                $fetch_product_details = mysqli_fetch_assoc($select_products_details);
                ?>

                <div class="Product_details_left">
                    <div class="Product_images">
                        <img class="image" src="uploaded_img/<?php echo $fetch_product_details['image']; ?>" alt="">
                    </div>
                </div>
                <div class="Product_details_right">
                    <div class="Product_name">
                        <?php echo $fetch_product_details['name']; ?>
                    </div>
                    <div class="author">
                        Tác giả: <?php echo $fetch_product_details['author']; ?>
                    </div>
                    <div class="Product_Categories">
                        Danh Mục: <?php echo $fetch_product_details['catename']; ?>
                    </div>

                    <div class="Product_Price">
                        <div class="_NewPrice">
                            <?php echo $fetch_product_details['newprice']; ?> VND
                        </div>
                        <div class="_Price">

                            <?php echo $fetch_product_details['price']; ?> VND

                        </div>
                    </div>
                    <div class="describe">
                        Mô tả: <?php echo $fetch_product_details['describes']; ?>
                    </div>
                    
                    <form action="" method="post">
                    <div class="quality_product">
                        <input type="number" min="<?= ($fetch_product_details['quantity'] > 0) ? 1 : 0 ?>" max="<?php echo $fetch_product_details['quantity']; ?>" name="product_quantity" value="<?= ($fetch_product_details['quantity'] > 0) ? 1 : 0 ?>" class="qty">
                    </div>

                    <div class="pay_and_add">
                        <input type="submit" value="Mua ngay" name="mua_ngay" class="pay_product">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_product_details['id']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product_details['newprice']; ?>">
                        <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="add_product">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <section class="related_products">
        <div class="color__box">
            <h1 class="title">Những Sách cùng thể loại</h1>
            <div class="box-container">
                <?php
                $cate_id = $fetch_product_details['category_id'];
                $pro_id = $fetch_product_details['id'];
                $select_products = mysqli_query($conn, "SELECT * FROM `products`  WHERE `category_id` = $cate_id and id <> $pro_id  ORDER BY id DESC  LIMIT 4") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                        include('item.php');
                    }
                } else {
                    echo '<p class="empty">Chưa có sách cùng thể loại!</p>';
                }
                ?>
            </div>
            <div class="load-more">
                <a href="shop.php" class="option-btn">Xem thêm...</a>
            </div>

        </div>


    </section>







    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</body>