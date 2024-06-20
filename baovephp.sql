-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 18, 2024 lúc 04:32 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `baovephp`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bill`
--

CREATE TABLE `bill` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `id_order` varchar(50) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `total` decimal(40,0) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `bill`
--

INSERT INTO `bill` (`id`, `fullname`, `email`, `phone`, `address`, `id_order`, `product_name`, `total`, `status`) VALUES
(10, 'Nguyễn Thanh Vũ', 'vuntpk03665@gmail.com', '0987654321', 'Quang Hiep, Cumgar, Dak Lak', '23', 'Iphone 15 pro', 21600, 'thành công');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Xiaomi brand'),
(3, 'Apple brand'),
(4, 'Samsung brand'),
(5, 'Google brands');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `Code` varchar(50) NOT NULL,
  `DiscountPercentage` decimal(5,2) DEFAULT NULL,
  `DiscountAmount` decimal(10,2) DEFAULT NULL,
  `ExpiryDate` date DEFAULT NULL,
  `UsageLimit` int(11) DEFAULT NULL,
  `UsedCount` int(11) DEFAULT 0,
  `MinimumSpend` decimal(10,2) DEFAULT NULL,
  `IsActive` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `coupons`
--

INSERT INTO `coupons` (`id`, `Code`, `DiscountPercentage`, `DiscountAmount`, `ExpiryDate`, `UsageLimit`, `UsedCount`, `MinimumSpend`, `IsActive`) VALUES
(1, 'shopmall7th7', 10.00, 0.00, '2024-12-31', 100, 0, 50.00, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(35,0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` varchar(150) DEFAULT 'chưa thanh toán',
  `payment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`, `updated_at`, `status`, `payment`) VALUES
(23, 1, 21600, '2024-06-16 23:11:17', '2024-06-16 23:11:17', 'thành công', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(40,0) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(23, 23, 6, 1, 24000, '2024-06-16 23:11:17', '2024-06-16 23:11:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(50,0) NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `price`, `image`, `quantity`, `description`, `category_id`) VALUES
(1, 'Xaomi 14 Ultra', 290000, 'xiaomi-14-ultra.jpg', 10, 'Đây là đoạn mô tả ngắn về sản phẩm', 1),
(4, 'Xaomi 14', 230000, 'xiaomi-14_4.jpg', 130, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 1),
(5, 'Xaomi 12 Pro', 12000, 'xiaomi-12-pro_arenamobiles.jpg', 134, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 1),
(6, 'Iphone 15 pro', 24000, 'iphone-15-pro-256gb_1.jpg', 130, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 3),
(7, 'Iphone 15 plus', 17000, 'iphone-15-plus-256gb-color-blue.jpg', 322, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 3),
(8, 'Iphone 14', 15000, 'iphone-14_1.jpg', 4324, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 3),
(9, 'Samsung Z Fold 5', 23000, 'galaxy-z-fold-5-xam-1_1__1.jpg', 130, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 4),
(10, 'Samsung s24 Ultra', 24000, 'ss-s24-timultra-22.jpg', 130, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 4),
(11, 'Google Pixel 8 pro', 40000, 'pixel_8pro_black.jpg', 434, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 5),
(12, 'Google Pixel Fold', 50000, 'pixel_fold.jpg', 4343, 'Nằm trong phân khúc iPhone 14 Series cao cấp nhất hiện nay, iPhone 14 Pro 128GB đã và đang nhận được rất nhiều sự yêu thích từ người tiêu dùng Việt. Thế hệ iPhone mới nhất này thu hút người dùng với kiểu dáng sang trọng, tinh tế từ màn hình Dynamic Island cùng hiệu năng cực đỉnh của chipset Apple A16 Bionic. Với nhiều đột phá mạnh mẽ, iPhone 14 Pro 128GB chắc chắn sẽ là phân khúc smartphone mạnh mẽ, sang trọng top đầu hiện nay mà bạn không nên bỏ qua nhé!', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `phone`, `password`, `role`, `fullname`, `address`, `reset_token`, `reset_token_expires`) VALUES
(1, 'admin', 'vuntpk03665@gmail.com', '0987654321', '$2y$10$9yXWAKIGTeKgRpEzUBX4OesdCM8MKrGnHm00DZQTTGj1uj0G6Tmfe', 'admin', 'Nguyễn Thanh Vũ', 'Quang Hiep, Cumgar, Dak Lak', NULL, NULL),
(2, 'thanhvu', 'nguyenthanhvudvfb2005@gmail.com', '0987654321', '$2y$10$l6AH34zsOaIA.RE13q64W..RtItOfWy5XQ6hU..FI7sFpp5OSVE2K', 'user', 'Nguyễn Thanh Vũ User', 'Tân An, Buôn Ma Thuột', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_cart` (`user_id`),
  ADD KEY `fk_product_cart` (`product_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_orders` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_details_order` (`order_id`),
  ADD KEY `fk_order_details_product` (`product_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bill`
--
ALTER TABLE `bill`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_cart` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_user_cart` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_orders` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `fk_order_details_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_details_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
