-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2023 at 06:48 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book_shop`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `THEM_SACH` (IN `order_id_param` INT, IN `user_id_param` INT, IN `product_id_param` INT, IN `quantity_new` INT)   BEGIN
  UPDATE carts
  SET quantity = quantity + quantity_new
  WHERE order_id = order_id_param AND user_id = user_id_param AND product_id = product_id_param;

  UPDATE products
  SET quantity = quantity - quantity_new
  WHERE id = product_id_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `THEM_SACH_MOI` (IN `order_id_param` INT, IN `user_id_param` INT, IN `product_id_param` INT, IN `quantity_param` INT, IN `price_parram` INT)   BEGIN
  INSERT INTO `carts`(`quantity`, `price`, `order_id`, `user_id`, `product_id`) VALUES (quantity_param,price_parram,order_id_param,user_id_param,product_id_param);

  UPDATE products
  SET quantity = quantity - quantity_param
  WHERE id = product_id_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `XOA_SACH` (IN `order_id_param` INT, IN `user_id_param` INT, IN `product_id_param` INT)   BEGIN
  DECLARE quantity_new INT;
  
  -- Lấy giá trị quantity từ bảng carts
  SELECT quantity INTO quantity_new FROM carts WHERE product_id = product_id_param AND order_id = order_id_param AND user_id = user_id_param;
  
  -- Xóa sách khỏi giỏ hàng
  DELETE FROM carts WHERE product_id = product_id_param AND order_id = order_id_param AND user_id = user_id_param;

  -- Cập nhật lại số lượng sách trong bảng products
  UPDATE products SET quantity = quantity + quantity_new WHERE id = product_id_param;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `XOA_TAT_CA` (IN `order_id_param` INT, IN `user_id_param` INT)   BEGIN
  DECLARE product_id_param INT;
  DECLARE quantity_param INT;
  
  -- Lấy dữ liệu từ bảng carts
  DECLARE cur CURSOR FOR SELECT product_id, quantity FROM carts WHERE order_id = order_id_param AND user_id = user_id_param;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET @cursor_finished = TRUE;
  
  OPEN cur;
  SET @cursor_finished = FALSE;
  
  -- Duyệt qua từng bản ghi và cập nhật số lượng sách trong bảng products
  read_loop: LOOP
    FETCH cur INTO product_id_param, quantity_param;
    
    IF @cursor_finished THEN
      LEAVE read_loop;
    END IF;
    
    -- Cập nhật số lượng sách trong bảng products
    UPDATE products SET quantity = quantity + quantity_param WHERE id = product_id_param;
  END LOOP;
  
  CLOSE cur;
  
  -- Xóa tất cả dữ liệu trong bảng carts
  DELETE FROM carts WHERE order_id = order_id_param AND user_id = user_id_param;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`quantity`, `price`, `order_id`, `user_id`, `product_id`) VALUES
(4, 36000, 7, 1, 5),
(1, 93800, 7, 1, 4),
(2, 8400, 7, 1, 3),
(1, 36000, 8, 1, 5),
(1, 14040, 9, 1, 6),
(2, 36000, 10, 3, 5),
(1, 93800, 10, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `describes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `describes`) VALUES
(1, 'Sách thiếu nhi', 'Mô tả sách thiếu nhi'),
(2, 'Truyện hoạt hình', 'Mô tả Truyện hoạt hình'),
(3, 'Văn học - Tư duy', 'Mô tả Văn học - Tư duy'),
(4, 'Kiến thức - Tư duy', 'Mô tả Kiến thức - Tư duy');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `number`, `message`) VALUES
(0, 1, '021321312312', 'qưeqwewqdsad');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `note` varchar(255) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `note`, `placed_on`, `status`) VALUES
(7, 1, 'Tung Pham', '213123213', 'thanhtungph6@gmail.com', 'Thẻ ngân hàng', 'Quan 7,, HCM, Vietnam', '12321321321', '17-06-2023', 'Chờ xác nhận'),
(8, 1, 'Phạm Thanh Tùng', '2131243312', 'thanhtungph6@gmail.com', 'Thẻ ngân hàng', 'ịipjpkop, Hà Nội, Vietnam', '123213123', '17-06-2023', 'Chờ xác nhận'),
(9, 1, '', '', '', '', '', '', '', 'Chưa thanh toán'),
(10, 3, 'Nguyen Thang', '0987654321', 'tgtg2808@gmail.com', 'Tiền mặt khi nhận hàng', 'Dan Phuong, Ha Noi, Ha Noi, Vietnam', 'Không', '19-06-2023', 'Đã xác nhận');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `newprice` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `describes` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `author`, `price`, `discount`, `newprice`, `category_id`, `quantity`, `describes`, `image`) VALUES
(1, '365 truyện kể hàng đêm - Mùa hè ', 'Phạm Trung Nam', 42000, 50, 21000, 1, 978, 'Hay và bổ ích', '365.jpg'),
(2, 'Alice In Borderland - Tặng kèm Card Giấy', 'Alice', 30800, 12, 27104, 2, 123, 'Hành độnh - Kịch tính', 'alilce.jpg'),
(3, 'Bé học toán', 'Nguyễn Văn Thành', 12000, 30, 8400, 3, 276, 'Toán học', 'betapto.jpg'),
(4, 'Kingdom', 'Yasunisa', 134000, 30, 93800, 2, 185, 'Hành động', 'kingdom.jpg'),
(5, 'Đãi tiệc tại nhà', 'Yanny Đặng', 45000, 20, 36000, 2, 231, 'Nhẹ nhàng', 'DaiTiecTaiNha.jpg'),
(6, 'Lê mạt sự ký', 'Nguyễn Duy Chính', 15600, 10, 14040, 4, 55, 'Văn học', 'LeMatSuKy.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Phạm Thanh Tùng', 'thanhtungph3@gmail.com', '5b7a2eb26aa71815d5593bedff2d13b5', 'user'),
(2, 'Phạm Thanh Tùng', 'thanhtungph6@gmail.com', '5b7a2eb26aa71815d5593bedff2d13b5', 'admin'),
(3, 'thang', 'thang@gmail.com', '202cb962ac59075b964b07152d234b70', 'user'),
(4, 'admin', 'admin@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD KEY `FK_CartOrder` (`order_id`),
  ADD KEY `FK_CartUser` (`user_id`),
  ADD KEY `FK_CartProduct` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD KEY `fk_user_message` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_OrderUser` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ProductCategory` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `FK_CartOrder` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `FK_CartProduct` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_user_message` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_OrderUser` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_ProductCategory` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
