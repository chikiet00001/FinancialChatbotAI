-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 22, 2025 lúc 10:30 AM
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
-- Cơ sở dữ liệu: `financialchatbot`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversation_logs`
--

CREATE TABLE `conversation_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `sender` enum('user','bot') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(4, '2025_03_29_104450_create_sessions_table', 1),
(5, '2025_03_29_125016_create_users_table', 1),
(6, '2025_03_29_125132_create_conversation_logs_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('aCQmHXADUcp7Ge2JK4K0veMYCsM0pL04nJxMZTyV', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUEI1MHhHMUxiNEk5YzRtQUE5Q2dnVnRxWmNQWG90VDBEaW9CNDg4dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9jaGF0Ym90YWkvcmVnaXN0ZXIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1745240652);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'john_doe', 'john@example.com', '$2y$12$qrbsNQDnkNgeXJg2tTFBlehgbV/.2FZJDFH1C/VEqg8DwOJOoAZf6', 'user', NULL, '2025-04-03 07:04:51'),
(2, 'chikiet00001', 'chikiet00001@gmail.com', '$2y$12$D0txOVogtP5V3FyYE5RVXuLmziOELN1QNwYEthSEzMAy2voFr1qtC', 'admin', '2025-03-29 19:56:45', '2025-03-29 19:56:45'),
(3, 'chikiet00002', 'chikiet00002@gmail.com', '$2y$12$2/c9o3DAoSaiCGR04EVF5u0TCzfRMW4SWLOm16LthLYvnDX1OaiZ2', 'user', '2025-03-29 20:03:28', '2025-03-29 20:03:28'),
(4, 'chikiet00003', 'chikiet00003@gmail.com', '$2y$12$iANxqUR9lHfBzJvwuyxEC.p1BaHzbPl2dR63PPxABeGK.w8XEBiTi', 'user', '2025-03-29 20:04:20', '2025-03-29 20:04:20'),
(5, 'chikiet00004', 'chikiet00004@gmail.com', '$2y$12$S/X6RsXe4.xIrQvbEovWDuNihUZ1MBiK9hhI3ZwbCjM.TXJUjIjBG', 'user', '2025-03-29 20:23:32', '2025-03-29 20:23:32'),
(6, 'chikiet00005', 'chikiet00005@gmail.com', '$2y$12$5ePM.cAu.v4dYHhRp.GS3O3cC5jcas2rWJZFl2x6O8d4sqnZVegG2', 'user', '2025-03-30 01:56:01', '2025-03-30 01:56:01'),
(7, 'chikiet00006', 'chikiet00006@gmail.com', '$2y$12$hpbJITLSCufnWF.EWS7uVeptOf4YpQZfd/qJSYgYX5mGBKaAhZfgO', 'user', '2025-03-30 02:28:44', '2025-03-30 02:28:44'),
(8, 'chikiet00007', 'chikiet00007@gmail.com', '$2y$12$nL.JdDzOj797j3Rh.TK7JeSB.G6y2z9rWyVx/OX7CLnkhNkPeZamy', 'user', '2025-03-30 02:45:54', '2025-03-30 02:45:54'),
(9, 'chikiet00008', 'chikiet00008@gmail.com', '$2y$12$QrLVvto8ZNDSVg5RYIJWNOBzJyBLV93B8DrLs0oud7otTBApBP5vS', 'user', '2025-03-30 02:46:23', '2025-03-30 02:46:23'),
(10, 'chikiet00009', 'chikiet00009@gmail.com', '$2y$12$0RiOC2hVsAIrjqOJlCp06OjF3RND81xs8zdafiYtLBPrSiU/yv1qS', 'user', '2025-03-30 02:59:57', '2025-03-30 02:59:57'),
(11, 'chikiet00010', 'chikiet00010@gmail.com', '$2y$12$u8gKKwbMBb8D3oP8/V3G6eMWF4PyPy5lhnkV2jy2/NqzhYZ0my9t6', 'user', '2025-03-30 03:04:08', '2025-03-30 03:04:08'),
(12, 'chikiet00011', 'chikiet00011@gmail.com', '$2y$12$WVPcJ503IJLbgKLS.ZbWSu.OwkYedx85oYK2UeAzBs/zma2bpjYXu', 'user', '2025-03-30 03:05:22', '2025-03-30 03:05:22'),
(13, 'chikiet00012', 'chikiet00012@gmail.com', 'kiet220903', 'user', NULL, NULL),
(14, 'chikiet00013', 'chikiet00013@gmail.com', 'kiet220903', 'user', NULL, NULL),
(15, 'chikiet00014', 'chikiet00014@gmail.com', 'kiet220903', 'user', NULL, NULL),
(16, 'chikiet00015', 'chikiet00015@gmail.com', '$2y$12$jDjg1KmC1FQ2X6t7tCNXU.OjBK0tFUb6.8dp0VweHS0/JBitdx9zC', 'admin', NULL, NULL),
(17, 'chikiet00016', 'chikiet00016@gmail.com', '$2y$12$6Nyn5ahAxRGAJ5yQy085OeQgBr5xZWIm2nV3lzfWoWjV1TFPN0QD6', 'admin', NULL, NULL),
(18, 'chikiet00017', 'chikiet00017@gmail.com', '$2y$12$B2zUUM/HWUU04NTBfj38IOrG2qeSOhMZM1XZhSSN7trta6UCyAfJm', 'user', NULL, NULL),
(19, 'chikiet00018', 'chikiet00018@gmail.com', '$2y$12$LrZx6eylYuwJA0KItDwFd.66/jEKZvjlerZBP9JCXkj9o677t7J0.', 'user', NULL, NULL),
(20, 'chikiet00019', 'chikiet00019@gmail.com', '$2y$12$FFuiOWcN9nuOFMcGXL1fK.ZPgJt.TMpXa9vqHEP6ohJv3vPhV0zsC', 'user', NULL, NULL),
(21, 'chikiet00020', 'chikiet00020@gmail.com', '$2y$12$CPgDexyDOlrf.RBe/yQqPefB9fdzeDfMcRQ/rozKnUE7mVIkk.60S', 'user', NULL, NULL),
(22, 'chikiet00021', 'chikiet00021@gmail.com', '$2y$12$SIQk3hOhQJ7iyp6faLMoB.9V9btn6JxJT4lIY7wtVA6IESn8A8LCe', 'user', '2025-04-02 07:31:51', '2025-04-02 07:31:51'),
(23, 'chikiet00022', 'chikiet00022@gmail.com', '$2y$12$BUp2jvA2w5eDCd2OpJHzdOMfpdwgMnwGDBbjep/RceNdburQQohJC', 'user', '2025-04-02 07:33:50', '2025-04-02 07:33:50'),
(24, 'chikiet00023', 'chikiet00023@gmail.com', '$2y$12$kpAWVyoDAULjmFK5FmpVcujgi.4aZty.NlHt.5kyOXG5udc15Wi/a', 'user', '2025-04-02 07:36:20', '2025-04-02 07:36:20'),
(25, 'chikiet00024', 'chikiet00024@gmail.com', '$2y$12$aRIZtVn.Z0cAJY35mT4GKO8ihRf187KQQYBzaXOuHKqyMuI5A2FT6', 'user', '2025-04-02 20:00:45', '2025-04-02 20:00:45'),
(26, 'chikiet00025', 'chikiet00025@gmail.com', '$2y$12$8YNa00gWyGtFb/aOeVqB0uzwjCieQ6.Pm7SEroTepAO/VEL1haXfG', 'user', '2025-04-02 20:03:36', '2025-04-02 20:03:36'),
(27, 'chikiet00026', 'chikiet00026@gmail.com', '$2y$12$J47vzePXfBQGKj6g4VAqu.ydEHslQJC1ByLT2Kn7t8FuwrDfrUTpa', 'user', '2025-04-02 20:06:59', '2025-04-02 20:06:59'),
(28, 'chikiet00027', 'chikiet00027@gmail.com', '$2y$12$TI3y3UBmNZ/IwgsG3ATpCutcPG0blIiohym2QQ7j49vqQpyO3c6je', 'user', '2025-04-02 20:10:26', '2025-04-02 20:10:26'),
(29, 'chikiet00028', 'chikiet00028@gmail.com', '$2y$12$Ogr4s/0qIv7EW3Xy4Nc7L.zJg9JAsa3PsjiWm.UP/Qr/sjWay1Cl.', 'user', '2025-04-02 20:14:39', '2025-04-02 20:14:39'),
(30, 'chikiet00029', 'chikiet00029@gmail.com', '$2y$12$PvmSZVuEaa3vjphRyPqCCO57WQDroC5SvXOtlEpXQ/Atv1OrxV0NS', 'user', '2025-04-02 20:16:41', '2025-04-02 20:16:41'),
(31, 'chikiet00030', 'chikiet00030@gmail.com', '$2y$12$aPqLGbb.oEM6DyQqDBP1kOrPYZuQpLJhewMtL8hbQIelutxUVZEq6', 'user', '2025-04-02 20:26:36', '2025-04-02 20:26:36');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `conversation_logs`
--
ALTER TABLE `conversation_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversation_logs_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `conversation_logs`
--
ALTER TABLE `conversation_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `conversation_logs`
--
ALTER TABLE `conversation_logs`
  ADD CONSTRAINT `conversation_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
