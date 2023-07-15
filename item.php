<form action="" method="post" class="box">
  <a href="product_details.php?id=<?php echo $fetch_products['id']; ?>">
    <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
  </a>
  <!-- hiển thị tên và tác giả -->
  <div class="name">
    <a href="product_details.php?id=<?php echo $fetch_products['id']; ?>">
      <?php echo $fetch_products['name']; ?>
      - <?php echo $fetch_products['author']; ?>
    </a>
  </div>
  <!-- <div class="name"><?php echo $fetch_products['describes']; ?></div> -->
  <div class="price"><?php echo $fetch_products['newprice']; ?> VND /<span class="old-price"><?php echo $fetch_products['price']; ?> VND</span></div>
  <!-- <input type="number" min="<?= ($fetch_products['quantity'] > 0) ? 1 : 0 ?>" max="<?php echo $fetch_products['quantity']; ?>" name="product_quantity" value="<?= ($fetch_products['quantity'] > 0) ? 1 : 0 ?>" class="qty"> -->
  <input type="hidden" name="quantity">
  <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
  <input type="hidden" name="product_price" value="<?php echo $fetch_products['newprice']; ?>">
  <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
</form>