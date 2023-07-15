<?php
include 'config.php';

session_start();

$user_id = '';
if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id']; //tạo session người dùng thường
}

// $user_id = $_SESSION['user_id']; //tạo session người dùng thường

// if (!isset($user_id)) { // session không tồn tại => quay lại trang đăng nhập
//    header('location:login.php');
// }
// ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thông tin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'header.php'; ?>
   
   <!-- <div class="bread-crumb">
      <p> <a href="home.php">Trang chủ</a> / Thông tin </p>
   </div> -->
   <div class="heading">
      <h3>Về HAUIBOOK.</h3>
   </div>

   <section class="about">

      <div class="flex">
         <div class="content">
            <h3>Tại sao lại có HAUIBOOK.</h3>
            <p>HAUIBOOK là tên của một trang web được xây dựng nhằm mục đích giúp các bạn trẻ đam mê đọc sách, đặc biệt là truyện trinh thám và tiểu thuyết, có thể dễ dàng tìm kiếm và mua những quyển sách yêu thích của mình.</p>
            <p>Với sự đam mê và niềm tin vào tầm quan trọng của việc đọc sách, HAUIBOOK đã phát triển từ một ý tưởng đơn giản thành một trang web hoàn chỉnh. Mục tiêu của HAUIBOOK là cung cấp những quyển sách chất lượng, sâu sắc và hấp dẫn đến tay độc giả. Đội ngũ của HAUIBOOK đã tìm kiếm và tuyển chọn những quyển sách đa dạng về thể loại, đảm bảo rằng độc giả có nhiều sự lựa chọn và trải nghiệm đọc sách tuyệt vời.</p>
            <p>HAUIBOOK hy vọng rằng thông qua việc cung cấp những quyển sách chất lượng và đáng đọc, nó có thể góp phần khơi dậy niềm đam mê đọc sách trong mọi người và mang đến những giây phút giải trí và tri thức bổ ích.</p>
            <a href="contact.php" class="btn">Liên hệ</a>
            
            <div class="pimage">
                  <img src="images/about.jpg" alt="">
            </div>
         </div>

         <div class="image">
         </div>
      </div>


   </section>
   <section class="authors">

      <h1 class="title">Thành viên của HAUIBOOK.</h1>

      <div class="box-container">

         <div class="box">
            <img src="images/author-1.jpg" alt="">
            <div class="share">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
            </div>
            <h3>Phạm Trung Hiếu</h3>
         </div>

         <div class="box">
            <img src="images/author-2.jpg" alt="">
            <div class="share">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
            </div>
            <h3>Nguyễn Văn Thắng</h3>
         </div>

         <div class="box">
            <img src="images/author-2.jpg" alt="">
            <div class="share">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
            </div>
            <h3>Vương Quốc Tuấn</h3>
         </div>

         <div class="box">
            <img src="images/author-2.jpg" alt="">
            <div class="share">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
            </div>
            <h3>Nguyễn Viết Q.Tùng</h3>
         </div>

         <div class="box">
            <img src="images/author-2.jpg" alt="">
            <div class="share">
               <a href="#" class="fab fa-facebook-f"></a>
               <a href="#" class="fab fa-twitter"></a>
               <a href="#" class="fab fa-instagram"></a>
            </div>
            <h3>Phạm Thanh Tùng</h3>
         </div>

      </div>

   </section>
   <section class="reviews">

      <h1 class="title">Phản hồi của khách hàng</h1>

      <div class="box-container">

         <div class="box">
            <img src="images/pic-1.png" alt="">      
            <div>
               <h3>Hoàng Văn Hải</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>
            <p>Giao hàng nhanh. Sản phẩm chất lượng tốt, giá cả phù hợp. Shop đóng gói hàng cẩn thận. Sẽ ủng hộ shop lần sau 🥰</p>
         </div>

         <div class="box">
            <img src="images/pic-1.png" alt="">      
            <div>
               <h3>Phạm Tiến Mạnh</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>
            <p>Trẻ em bây giờ tiếp cận với công nghệ sớm nên ít quan tâm đến truyện và sách như trẻ em hồi xưa. Mình mua những cuốn truyện này cho em mình đọc để khơi dậy tình yêu sách của nó, điều đó sẽ được bắt đầu từ những cuốn truyện tranh, như mình hồi xưa vậy</p>
         </div>
         
         <div class="box">
            <img src="images/pic-1.png" alt="">      
            <div>
               <h3>Nguyễn Thị Bích Tuyền</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>
            <p>Sản phẩm mới nguyên truyện đẹp đóng gói ổn không bị móp méo gì cả nói chung khá là ok</p>
         </div>

         <div class="box">
            <img src="images/pic-1.png" alt="">      
            <div>
               <h3>Hoàng Chí Công</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>
            <p>Sản phẩm mới nguyên truyện đẹp đóng gói ổn không bị móp méo gì cả nói chung khá là ok</p>
         </div>

         <div class="box">
            <img src="images/pic-1.png" alt="">      
            <div>
               <h3>Nguyễn Mạnh Thắng</h3>
               <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
               </div>
            </div>
            <p>Truyện chuẩn, hay giá hợp lý. Shop gói hàng đẹp, chắc chắn. Tốt</p>
         </div>
   </section>

   

   <?php include 'footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>