-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 07, 2021 lúc 07:19 AM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `comp1640`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` varchar(50) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `post_id`, `comment_content`, `time`) VALUES
(44, 1, 43, 'Can you check for me please', '2021-04-02 18:46:35'),
(45, 2, 43, 'sure  i will check on Friday', '2021-04-02 19:20:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(20) NOT NULL,
  `faculty_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`, `faculty_description`) VALUES
(1, 'IT', 'Information Technology'),
(2, 'Business', 'Business related subjects'),
(3, 'Event', 'Event related subjects');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `type` text NOT NULL,
  `message` text NOT NULL,
  `status` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`notification_id`, `name`, `type`, `message`, `status`, `date`) VALUES
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:08:25'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:08:43'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:25:28'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:32:46'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:37:59'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:38:57'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:10:17'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:25:49'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:31:23'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 15:25:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `post_image` char(50) NOT NULL,
  `post_file` text NOT NULL,
  `post_content` text NOT NULL,
  `submit_date` datetime NOT NULL,
  `selected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `term_id`, `faculty_id`, `post_image`, `post_file`, `post_content`, `submit_date`, `selected`) VALUES
(43, 1, 4, 1, 'Logo_BTEC_FPT.png', 'Lecture10_conceptualizing.pdf', '', '2021-04-02 18:44:03', 1),
(44, 4, 4, 2, 'DSC_6559.jpg', 'Lecture10_conceptualizing.pdf', '', '2021-04-01 09:29:46', 0),
(45, 8, 4, 1, 'auction.PNG', 'Lecture10_conceptualizing.pdf', '', '2021-04-01 09:37:28', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `term`
--

CREATE TABLE `term` (
  `term_id` int(11) NOT NULL,
  `term_deadline` datetime NOT NULL,
  `term_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `term`
--

INSERT INTO `term` (`term_id`, `term_deadline`, `term_description`) VALUES
(4, '2021-04-30 15:30:00', 'term 4');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `user_email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `faculty_id`, `username`, `password`, `user_role`, `user_email`) VALUES
(1, 1, 'DuyAnh', '781f357c35df1fef3138f6d29670365a', 'Student', 'da200066@gmail.com'),
(2, 1, 'Dung', '781f357c35df1fef3138f6d29670365a', 'Coordinator', 'something@gmail.com'),
(3, 3, 'Binh', '781f357c35df1fef3138f6d29670365a', 'Manager', 'something@gmail.com'),
(4, 2, 'Quang', '781f357c35df1fef3138f6d29670365a', 'Student', 'something@gmail.com'),
(5, 2, 'Long', '781f357c35df1fef3138f6d29670365a', 'Coordinator', 'da200066@gmail.com'),
(7, 2, 'Admin1', '781f357c35df1fef3138f6d29670365a', 'Admin', 'something@gmail.com'),
(8, 2, 'VietQuoc', '781f357c35df1fef3138f6d29670365a', 'Student', 'somethingelse@gmail.com'),
(9, 1, 'QuangLV', '781f357c35df1fef3138f6d29670365a', 'Student', 'something@gmail.com'),
(11, 1, 'Guest1', '781f357c35df1fef3138f6d29670365a', 'Guest', 'da200066@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_user_id` (`user_id`),
  ADD KEY `comment_post_post_id` (`post_id`);

--
-- Chỉ mục cho bảng `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_term_term_id` (`term_id`),
  ADD KEY `post_user_user_id` (`user_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Chỉ mục cho bảng `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`term_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_faculty_faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `term`
--
ALTER TABLE `term`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `comment_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `post_term_term_id` FOREIGN KEY (`term_id`) REFERENCES `term` (`term_id`),
  ADD CONSTRAINT `post_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_faculty_faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
