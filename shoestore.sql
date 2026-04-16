-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 16 2026 г., 19:46
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shoestore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `type`, `message`, `created_at`) VALUES
(1, NULL, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.product_sizes\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\catalog.php:49', '2026-04-16 15:34:40'),
(2, NULL, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.product_sizes\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\catalog.php:49', '2026-04-16 15:34:49'),
(3, NULL, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.product_sizes\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\catalog.php:49', '2026-04-16 15:35:46'),
(4, NULL, 'error', 'Exception: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'stock\' in \'field list\' in C:\\xammp\\htdocs\\PraktikaKarevo\\product.php:13', '2026-04-16 15:45:06'),
(5, 1, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.orders\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\stats.php:7', '2026-04-16 16:06:03'),
(6, 1, 'error', 'PHP error [2]: Undefined array key \"is_blocked\" in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\users.php:71', '2026-04-16 16:06:06'),
(7, 1, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.orders\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\orders.php:12', '2026-04-16 16:06:15'),
(8, 1, 'error', 'Exception: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'materials\' in \'field list\' in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\products.php:96', '2026-04-16 16:17:01'),
(9, 1, 'error', 'Exception: SQLSTATE[42S22]: Column not found: 1054 Unknown column \'materials\' in \'field list\' in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\products.php:96', '2026-04-16 16:17:08'),
(10, 1, 'admin', 'Добавлен товар ID=3', '2026-04-16 16:25:03'),
(11, 1, 'admin', 'Обновлены размеры товара ID=3', '2026-04-16 16:25:03'),
(12, 1, 'admin', 'Обновлён товар ID=3', '2026-04-16 16:25:23'),
(13, 1, 'admin', 'Обновлены размеры товара ID=3', '2026-04-16 16:25:23'),
(14, 1, 'admin', 'Обновлён товар ID=3', '2026-04-16 16:25:39'),
(15, 1, 'admin', 'Обновлены размеры товара ID=3', '2026-04-16 16:25:39'),
(16, 1, 'admin', 'Обновлён товар ID=2', '2026-04-16 16:25:49'),
(17, 1, 'admin', 'Обновлены размеры товара ID=2', '2026-04-16 16:25:49'),
(18, 1, 'admin', 'Обновлён товар ID=2', '2026-04-16 16:25:56'),
(19, 1, 'admin', 'Обновлены размеры товара ID=2', '2026-04-16 16:25:56'),
(20, 1, 'admin', 'Обновлён товар ID=2', '2026-04-16 16:26:00'),
(21, 1, 'admin', 'Обновлены размеры товара ID=2', '2026-04-16 16:26:00'),
(22, 1, 'error', 'PHP error [2]: Undefined array key \"is_blocked\" in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\users.php:71', '2026-04-16 16:26:27'),
(23, 1, 'error', 'Exception: SQLSTATE[42S02]: Base table or view not found: 1146 Table \'shoestore.orders\' doesn\'t exist in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\stats.php:7', '2026-04-16 16:26:53'),
(24, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:21:07'),
(25, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:21:07'),
(26, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:02'),
(27, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:02'),
(28, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:02'),
(29, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:02'),
(30, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:07'),
(31, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:07'),
(32, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:18'),
(33, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:18'),
(34, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:44'),
(35, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:44'),
(36, 1, 'error', 'PHP error [2]: Undefined array key \"created_at\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:40', '2026-04-16 17:28:44'),
(37, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\orders.php:42', '2026-04-16 17:28:44'),
(38, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\orders.php:43', '2026-04-16 17:30:20'),
(39, 1, 'error', 'PHP error [8192]: htmlspecialchars(): Passing null to parameter #1 ($string) of type string is deprecated in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\orders.php:43', '2026-04-16 17:30:20'),
(40, 1, 'error', 'PHP error [2]: Undefined array key \"address\" in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\orders.php:43', '2026-04-16 17:30:20'),
(41, 1, 'error', 'PHP error [8192]: htmlspecialchars(): Passing null to parameter #1 ($string) of type string is deprecated in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\orders.php:43', '2026-04-16 17:30:20'),
(42, 1, 'error', 'PHP error [2]: Undefined array key \"is_blocked\" in C:\\xammp\\htdocs\\PraktikaKarevo\\admin\\users.php:71', '2026-04-16 17:34:21'),
(43, 1, 'admin', 'Изменён пользователь ID=1 роль=admin блок=1', '2026-04-16 17:38:08'),
(44, 1, 'admin', 'Изменён пользователь ID=1 роль=admin блок=1', '2026-04-16 17:38:12'),
(45, 1, 'admin', 'Изменён пользователь ID=1 роль=admin блок=1', '2026-04-16 17:38:14');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Новый','В обработке','Отправлен','Доставлен','Отменен') NOT NULL DEFAULT 'Новый',
  `total` decimal(10,2) NOT NULL,
  `delivery_address` text NOT NULL,
  `delivery_method` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total`, `delivery_address`, `delivery_method`, `payment_method`, `comment`) VALUES
(1, 1, '2026-04-16 17:21:07', 'Новый', 5990.00, 'амкапап', 'Курьер', 'Карта', NULL),
(2, 1, '2026-04-16 17:28:44', 'Новый', 5990.00, 'ккеке', 'Курьер', 'Карта', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `size` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `size`, `quantity`, `price`) VALUES
(1, 1, 1, '41', 1, 5990.00),
(2, 2, 1, '40', 1, 5990.00);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `materials` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `materials`, `price`, `category`, `brand`, `status`, `created_at`) VALUES
(1, 'Кроссовки Air Max', 'Удобные кроссовки для бега', NULL, 5990.00, 'кроссовки', 'Nike', 'active', '2026-04-16 15:44:43'),
(2, 'Ботинки Timberland', 'Водонепроницаемые ботинки', '', 12990.00, 'ботинки', 'Timberland', '', '2026-04-16 15:44:43'),
(3, 'Секретные подкрадулины', 'Тапки невидимки', 'Темная материя', 1488.00, 'Тайна', 'Абабагалмага', '', '2026-04-16 16:25:03');

-- --------------------------------------------------------

--
-- Структура таблицы `product_colors`
--

CREATE TABLE `product_colors` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color`) VALUES
(1, 1, 'черный'),
(2, 1, 'белый'),
(3, 2, 'коричневый');

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`) VALUES
(1, 1, 'airmax.jpg'),
(2, 2, 'timberland.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `size` varchar(20) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `size`, `stock`) VALUES
(1, 1, '40', 9),
(2, 1, '41', 9),
(3, 1, '42', 10),
(9, 3, '14', 88),
(16, 2, '42', 5),
(17, 2, '43', 5),
(18, 2, '44', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `role`, `is_blocked`, `created_at`, `updated_at`) VALUES
(1, 'admin@gmail.com', '$2y$10$a/nYP116PFWBkOzKsjm.Me39RrKXb4aCoFQrvFC9zflygBKpwXo7K', 'testadmin', '+11111111111', 'admin', 0, '2026-03-07 17:57:50', '2026-04-16 17:40:33');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_type` (`type`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_brand` (`brand`),
  ADD KEY `idx_status` (`status`);

--
-- Индексы таблицы `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color` (`color`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size` (`size`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
