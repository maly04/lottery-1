-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2016 at 05:02 AM
-- Server version: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lottery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group`
--

CREATE TABLE `tbl_group` (
  `g_id` int(11) NOT NULL,
  `g_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `g_info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_group`
--

INSERT INTO `tbl_group` (`g_id`, `g_name`, `g_info`) VALUES
(1, 'AB', 'Pos A + Pos B'),
(2, 'ABC', 'Pos A + Pos B + POS C'),
(3, '4P', 'POS : A+B+C+D'),
(4, '5P', 'POS : A+B+C+D+F'),
(5, 'BCD', 'POS : B+C+D'),
(6, 'AF', 'POS : A+F'),
(7, 'A', 'POS A'),
(8, 'B', 'POS B'),
(9, 'C', 'POS C'),
(10, 'D', 'POS D'),
(11, 'F', 'POS F'),
(12, 'I', 'POS I'),
(13, 'N', 'POS N'),
(14, 'AC', 'POS A+C'),
(15, 'AD', 'A+D'),
(16, 'CD', 'PSO C+D'),
(17, 'BD', 'POS BD'),
(18, 'Lo(23+19)', 'LO afternoon 19 pos'),
(19, 'Lo(25+20)', 'Lo afternoon 20 pos 3 digit'),
(20, 'Lo(32+25)', 'Lo evening 25 pos for 3 digit'),
(21, '7P', 'POS : A+B+C+D Fpr 2 Digit'),
(22, '6P', 'POS : A+B+C+D Fpr 3 Digit');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_number`
--

CREATE TABLE `tbl_number` (
  `num_id` int(11) NOT NULL,
  `num_number` int(5) NOT NULL,
  `num_sym` int(2) NOT NULL,
  `num_end_number` int(3) DEFAULT NULL,
  `num_reverse` int(1) DEFAULT NULL,
  `num_price` float NOT NULL,
  `num_currency` int(2) NOT NULL,
  `g_id` int(11) NOT NULL,
  `r_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paper`
--

CREATE TABLE `tbl_paper` (
  `p_id` int(11) NOT NULL,
  `p_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `p_number` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `p_time` int(2) NOT NULL,
  `p_date` date NOT NULL,
  `s_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_paper`
--

INSERT INTO `tbl_paper` (`p_id`, `p_code`, `p_number`, `p_time`, `p_date`, `s_id`, `u_id`) VALUES
(1, '00001', '1', 5, '2016-10-07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parameter_type`
--

CREATE TABLE `tbl_parameter_type` (
  `pat_id` int(5) NOT NULL,
  `pat_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pat_key` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_parameter_type`
--

INSERT INTO `tbl_parameter_type` (`pat_id`, `pat_name`, `pat_key`) VALUES
(1, 'Currency', 'currency'),
(2, 'Type', 'type'),
(3, 'Shift (time)', 'shift'),
(4, 'symbol', 'sym');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_parameter_value`
--

CREATE TABLE `tbl_parameter_value` (
  `pav_id` int(5) NOT NULL,
  `pav_value` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pat_id` int(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_parameter_value`
--

INSERT INTO `tbl_parameter_value` (`pav_id`, `pav_value`, `pat_id`) VALUES
(1, 'Real', 1),
(2, 'Dolla', 1),
(3, 'Income', 2),
(4, 'Costs', 2),
(5, 'Afternoon', 3),
(6, 'Evening', 3),
(7, '=', 4),
(8, '>', 4),
(9, '->', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos`
--

CREATE TABLE `tbl_pos` (
  `pos_id` int(11) NOT NULL,
  `pos_time` int(1) NOT NULL,
  `pos_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pos_two_digit` int(2) NOT NULL,
  `pos_there_digit` int(3) NOT NULL,
  `pos_info` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pos`
--

INSERT INTO `tbl_pos` (`pos_id`, `pos_time`, `pos_name`, `pos_two_digit`, `pos_there_digit`, `pos_info`) VALUES
(1, 5, 'A', 1, 1, 'POS A'),
(2, 5, 'B', 1, 1, 'POS B'),
(3, 5, 'C', 1, 1, 'POS C'),
(4, 5, 'D', 1, 1, 'POS D'),
(5, 5, 'F', 1, 1, 'POS F'),
(6, 5, 'I', 1, 1, 'POS I'),
(7, 5, 'N', 1, 1, 'POS N'),
(8, 5, 'Lo 23 + 19', 23, 19, 'Lo 23 + 19 Afternoon'),
(9, 5, 'Lo 25 + 20', 25, 20, 'Lo 25 + 20'),
(10, 6, 'A', 4, 3, 'POS A'),
(11, 6, 'B', 1, 1, 'POS B'),
(12, 6, 'C', 1, 1, 'POS C'),
(13, 6, 'D', 1, 1, 'POS D'),
(14, 6, 'LO 32 + 25', 32, 25, 'LO 32 + 25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_group`
--

CREATE TABLE `tbl_pos_group` (
  `pg_id` int(11) NOT NULL,
  `pos_id` int(11) NOT NULL,
  `g_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_pos_group`
--

INSERT INTO `tbl_pos_group` (`pg_id`, `pos_id`, `g_id`) VALUES
(1, 1, 7),
(2, 2, 8),
(3, 3, 9),
(4, 4, 10),
(5, 5, 11),
(6, 6, 12),
(7, 7, 13),
(8, 8, 18),
(9, 9, 19),
(10, 1, 1),
(11, 2, 1),
(12, 1, 2),
(13, 2, 2),
(14, 3, 2),
(15, 1, 3),
(16, 2, 3),
(17, 3, 3),
(18, 4, 3),
(19, 1, 4),
(20, 2, 4),
(21, 3, 4),
(22, 4, 4),
(23, 5, 4),
(24, 2, 5),
(25, 3, 5),
(26, 4, 5),
(27, 10, 7),
(28, 11, 8),
(29, 12, 9),
(30, 13, 10),
(31, 14, 20),
(32, 10, 1),
(33, 10, 1),
(34, 10, 2),
(35, 11, 2),
(36, 12, 2),
(37, 11, 5),
(38, 12, 5),
(39, 13, 5),
(40, 10, 21),
(41, 11, 21),
(42, 12, 21),
(43, 13, 21),
(44, 10, 22),
(45, 11, 22),
(46, 12, 22),
(47, 13, 22);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_result`
--

CREATE TABLE `tbl_result` (
  `re_id` int(11) NOT NULL,
  `re-date` date NOT NULL,
  `re_num_result` int(5) NOT NULL,
  `pos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_row`
--

CREATE TABLE `tbl_row` (
  `r_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `s_id` int(11) NOT NULL,
  `s_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_phone` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_line` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_fb` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_address` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `s_start` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_end` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `s_two_digit_charge` float NOT NULL,
  `s_three_digit_charge` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`s_id`, `s_name`, `s_phone`, `s_line`, `s_fb`, `s_address`, `s_info`, `s_start`, `s_end`, `s_two_digit_charge`, `s_three_digit_charge`) VALUES
(1, 'Tong Darasmile', '(012) 640-406', 'tongdarasmile', 'tongdarasmile', 'st 310, Phnom Penh', 'New ', '2016-09-01', '', 70, 65);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_charge`
--

CREATE TABLE `tbl_staff_charge` (
  `stc_id` int(11) NOT NULL,
  `stc_date` date NOT NULL,
  `stc_two_digit_charge` int(2) NOT NULL,
  `stc_three_digit_charge` int(2) NOT NULL,
  `s_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_staff_charge`
--

INSERT INTO `tbl_staff_charge` (`stc_id`, `stc_date`, `stc_two_digit_charge`, `stc_three_digit_charge`, `s_id`) VALUES
(1, '2016-10-06', 70, 65, 1),
(2, '2016-10-07', 70, 70, 1),
(3, '2016-10-08', 75, 69, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_transction`
--

CREATE TABLE `tbl_staff_transction` (
  `st_id` int(11) NOT NULL,
  `st_price` float NOT NULL,
  `st_currency` int(2) NOT NULL,
  `st_type` int(2) NOT NULL,
  `st_date_diposit` date NOT NULL,
  `s_id` int(11) NOT NULL,
  `st_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `u_phone` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `u_line` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `u_password` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`u_id`, `u_name`, `u_phone`, `u_line`, `u_username`, `u_password`, `role`) VALUES
(1, 'Ny Vannarith', '(012) 666-555', 'tongdarasmile', 'admin', 'rithkc0123', 1),
(2, 'test', '(777) 777-777', 'testlottery', 'test', 'rithkc0123', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_group`
--
ALTER TABLE `tbl_group`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `tbl_number`
--
ALTER TABLE `tbl_number`
  ADD PRIMARY KEY (`num_id`);

--
-- Indexes for table `tbl_paper`
--
ALTER TABLE `tbl_paper`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tbl_parameter_type`
--
ALTER TABLE `tbl_parameter_type`
  ADD PRIMARY KEY (`pat_id`);

--
-- Indexes for table `tbl_parameter_value`
--
ALTER TABLE `tbl_parameter_value`
  ADD PRIMARY KEY (`pav_id`);

--
-- Indexes for table `tbl_pos`
--
ALTER TABLE `tbl_pos`
  ADD PRIMARY KEY (`pos_id`);

--
-- Indexes for table `tbl_pos_group`
--
ALTER TABLE `tbl_pos_group`
  ADD PRIMARY KEY (`pg_id`);

--
-- Indexes for table `tbl_result`
--
ALTER TABLE `tbl_result`
  ADD PRIMARY KEY (`re_id`);

--
-- Indexes for table `tbl_row`
--
ALTER TABLE `tbl_row`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tbl_staff_charge`
--
ALTER TABLE `tbl_staff_charge`
  ADD PRIMARY KEY (`stc_id`);

--
-- Indexes for table `tbl_staff_transction`
--
ALTER TABLE `tbl_staff_transction`
  ADD PRIMARY KEY (`st_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_username` (`u_username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_group`
--
ALTER TABLE `tbl_group`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `tbl_number`
--
ALTER TABLE `tbl_number`
  MODIFY `num_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_paper`
--
ALTER TABLE `tbl_paper`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_parameter_type`
--
ALTER TABLE `tbl_parameter_type`
  MODIFY `pat_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_parameter_value`
--
ALTER TABLE `tbl_parameter_value`
  MODIFY `pav_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tbl_pos`
--
ALTER TABLE `tbl_pos`
  MODIFY `pos_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `tbl_pos_group`
--
ALTER TABLE `tbl_pos_group`
  MODIFY `pg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `tbl_result`
--
ALTER TABLE `tbl_result`
  MODIFY `re_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_row`
--
ALTER TABLE `tbl_row`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tbl_staff_charge`
--
ALTER TABLE `tbl_staff_charge`
  MODIFY `stc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tbl_staff_transction`
--
ALTER TABLE `tbl_staff_transction`
  MODIFY `st_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
