-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-05-05 14:30:09
-- 服务器版本： 10.4.11-MariaDB
-- PHP 版本： 7.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `ass2`
--

-- --------------------------------------------------------

--
-- 表的结构 `tb_category`
--

CREATE TABLE `tb_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tb_category`
--

INSERT INTO `tb_category` (`id`, `name`) VALUES
(1, 'c1'),
(2, 'C2');

-- --------------------------------------------------------

--
-- 表的结构 `tb_customer_info`
--

CREATE TABLE `tb_customer_info` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_nickname` varchar(255) DEFAULT NULL,
  `user_head` varchar(255) DEFAULT NULL,
  `user_description` varchar(255) DEFAULT NULL,
  `default_address` varchar(255) DEFAULT NULL,
  `default_payment_type` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `tb_customer_info`
--

INSERT INTO `tb_customer_info` (`id`, `user_id`, `user_nickname`, `user_head`, `user_description`, `default_address`, `default_payment_type`) VALUES
(1, 1, 'name1.', 'a', 'aaaa', 'suzhou2', 'Wechat'),
(2, 2, 'haha', 'sdds', 'adadada', 'xjtlu', 'Wechat');

-- --------------------------------------------------------

--
-- 表的结构 `tb_item`
--

CREATE TABLE `tb_item` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `if_on_shelf` tinyint(4) NOT NULL,
  `description` text NOT NULL,
  `shipping_fee` int(11) NOT NULL,
  `number_of_sold` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tb_item`
--

INSERT INTO `tb_item` (`id`, `name`, `category_id`, `if_on_shelf`, `description`, `shipping_fee`, `number_of_sold`, `unit_price`, `total_amount`) VALUES
(1, 'item1', 1, 1, '11111111', 100, 10, 10, 156);

-- --------------------------------------------------------

--
-- 表的结构 `tb_order`
--

CREATE TABLE `tb_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `tb_order`
--

INSERT INTO `tb_order` (`id`, `user_id`, `time`, `shipping_address`, `status`, `tracking_number`) VALUES
(1, 1, '2023-05-04 02:42:21', 'aaaaa222', 1, '2'),
(2, 2, '2023-05-03 18:03:54', 'ccccc', 1, '1223232311');

-- --------------------------------------------------------

--
-- 表的结构 `tb_order_item_sku`
--

CREATE TABLE `tb_order_item_sku` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `tb_order_item_sku`
--

INSERT INTO `tb_order_item_sku` (`id`, `item_id`, `order_id`, `quantity`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `tb_store_info`
--

CREATE TABLE `tb_store_info` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `store_nickname` varchar(255) DEFAULT NULL,
  `store_head` varchar(255) DEFAULT NULL,
  `store_description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- 表的结构 `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `role`) VALUES
(1, 'yes', '123456', '1');

--
-- 转储表的索引
--

--
-- 表的索引 `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- 表的索引 `tb_customer_info`
--
ALTER TABLE `tb_customer_info`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `tb_item`
--
ALTER TABLE `tb_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- 表的索引 `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `user_id` (`user_id`);

--
-- 表的索引 `tb_order_item_sku`
--
ALTER TABLE `tb_order_item_sku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- 表的索引 `tb_store_info`
--
ALTER TABLE `tb_store_info`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 表的索引 `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tb_customer_info`
--
ALTER TABLE `tb_customer_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tb_item`
--
ALTER TABLE `tb_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `tb_order_item_sku`
--
ALTER TABLE `tb_order_item_sku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `tb_store_info`
--
ALTER TABLE `tb_store_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 限制导出的表
--

--
-- 限制表 `tb_item`
--
ALTER TABLE `tb_item`
  ADD CONSTRAINT `tb_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tb_category` (`id`);

--
-- 限制表 `tb_order_item_sku`
--
ALTER TABLE `tb_order_item_sku`
  ADD CONSTRAINT `tb_order_item_sku_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `tb_item` (`id`),
  ADD CONSTRAINT `tb_order_item_sku_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `tb_order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
