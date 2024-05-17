-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2024 at 05:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffeeshop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblcart`
--

CREATE TABLE `tblcart` (
  `cartID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcartitem`
--

CREATE TABLE `tblcartitem` (
  `cartitemID` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_datetime` datetime DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL,
  `cartid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory_inventory`
--

CREATE TABLE `tblcategory_inventory` (
  `categoryInventory_id` int(11) NOT NULL,
  `inventory_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory_inventory`
--

INSERT INTO `tblcategory_inventory` (`categoryInventory_id`, `inventory_category`) VALUES
(1, 'Sweetener'),
(2, 'Coffee Bean'),
(3, 'Milk'),
(4, 'Sinker'),
(5, 'Disposable'),
(6, 'Toppings'),
(7, 'Flavor');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory_product`
--

CREATE TABLE `tblcategory_product` (
  `categoryProduct_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory_product`
--

INSERT INTO `tblcategory_product` (`categoryProduct_id`, `category`) VALUES
(1, 'americano'),
(2, 'brewed'),
(3, 'frappe'),
(4, 'espresso'),
(5, 'latte'),
(6, 'cappuccino'),
(20, 'milk based');

-- --------------------------------------------------------

--
-- Table structure for table `tblcoffeeshop`
--

CREATE TABLE `tblcoffeeshop` (
  `coffeeshopid` int(11) NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_no` varchar(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `employees_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcoffeeshop`
--

INSERT INTO `tblcoffeeshop` (`coffeeshopid`, `shopname`, `branch`, `address`, `contact_no`, `email`, `employees_id`) VALUES
(1, 'Only Coffee', 'Legarda Manila ', '2255 Legarda St, Sampaloc, 1008 Metro Manila', '09156351463', 'onlycoffee@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblcustomers`
--

CREATE TABLE `tblcustomers` (
  `customerid` int(11) NOT NULL,
  `customername` varchar(255) NOT NULL,
  `contactnumber` varchar(13) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcustomers`
--

INSERT INTO `tblcustomers` (`customerid`, `customername`, `contactnumber`, `email`, `address`) VALUES
(2, 'Edie shing', '09123123123', 'edi@gmail.com', 'doon lang'),
(3, 'Mang kanor', '09222222222', 'Testemail@mailinator.com', 'testaddress'),
(4, 'Megan old', '09222222222', 'Testemail14@mailinator.com', 'testaddress'),
(5, 'Andrew E', '09222222222', 'Testemail@mailinator.com', 'testaddress');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployees`
--

CREATE TABLE `tblemployees` (
  `employeeID` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `position` varchar(255) NOT NULL DEFAULT 'guest',
  `hiredate` date NOT NULL DEFAULT current_timestamp(),
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblemployees`
--

INSERT INTO `tblemployees` (`employeeID`, `firstname`, `lastname`, `email`, `position`, `hiredate`, `username`, `password`) VALUES
(1, 'Super', 'Admin', 'superadmin@gmail.com', 'admin', '2024-04-01', 'superadmin', '$2y$10$ExJqrs6/0hYlS7mTyFwbN.ja1XeJAb78OZExDw5UxO2PAk91YL2yu'),
(34, 'Jan', 'Manuel', 'jan@gmail.com', 'admin', '2024-04-23', 'enrique', '$2y$10$woVQnRr/aNbyJaSU6BxFuu03QDnKz34oqzPzYH6mKLzKNk0ZQBRGa'),
(35, 'test', 'test3', 'test@gmail.com', 'guest', '2024-04-23', 'testing', '$2y$10$FO9R0sczJKEUWd.AO7Ga8O0UXDHjL2v9UsKGU6l39ASpA7Z4WB85C'),
(39, 'Juan', 'Luna', 'juan@gmail.com', 'guest', '2024-04-23', 'juan', '$2y$10$uerZ8nU9of.PLLelQqufcec3cz5ubJL.mbCdGGbdFTYfWLx5Y7Cvm'),
(42, 'JP', 'Olarte', 'jp@gmail.com', 'admin', '2024-04-25', 'jp', '$2y$10$VVzxH5W.aTdBNNse4dzwRe4/iMvJ50hS.8rvsx.lztgH8kBv0S0KG'),
(44, 'justin', 'japson', 'justin@gmail.com', 'admin', '2024-04-26', 'justin', '$2y$10$IWQQ7taqWigMODDzty9sne727TSQbKysBdNk2i3ygVRIXjcd.8nfO'),
(48, '123', '123', '123@gmail.com', 'guest', '2024-04-28', '123', '$2y$10$JHUgWklGX0.sXqyQm/cr7uXAYUHZpvy1VRnSqzYd78yFNqNcioNHG'),
(49, '567', '567', '567@gmail.com', 'guest', '2024-04-28', '567', '$2y$10$Zt6w8iCyIaxxch5/.5FVlOFHq.cD2cRyBLJlIfh3nDpC0ZQMRKVaW'),
(50, 'asd', 'asd', 'asd@gmail.com', 'guest', '2024-04-28', 'asd', '$2y$10$DXOO2fGt/4aFsZJkJc8PR.uXXD6zag0oPuHQMdB5opRPQeChPCCmm'),
(51, 'hjk', 'hjk', 'hjk@gmail.com', 'guest', '2024-04-28', 'hjk', '$2y$10$s93SHRL2EXONjTQGQAXOqeuDYz.FaeR5ArsqBiA.qtnsBhmOfTBKi'),
(52, 'fgh', 'fgh', 'fgh@gmail.com', 'guest', '2024-04-28', 'fgh', '$2y$10$RBhNmLguxOClmfRV767OU.ZOT6QL8jSSpvUkjpHj9wKcMzW4YEIJ2'),
(53, 'bnm', 'bnm', 'bnm@gmail.com', 'guest', '2024-04-30', 'bnm', '$2y$10$.NSyw0oi5UXLPBQBD6nms.fiZ7C6MmjUB664fpygbHykhJur7JV76'),
(54, 'Juan', 'Juan', '1@gmail.com', 'guest', '2024-04-30', 'juan1', '$2y$10$ikMcg.8J7ODyWVZ9W4FQZuytQ86joKmOXBdzlE0m1N4dtQu7CoAt.'),
(55, 'xcv', 'xcv', 'xcv@gmail.com', 'guest', '2024-04-30', 'xcv', '$2y$10$Z4mXOqoO2sVOIqJxPF9tDOM096ncf0jdisP.nMP0f6lybUFJKP74y'),
(64, 'rgn', 'rgn', 'rgn@gmail.com', 'guest', '2024-04-30', 'rgn', '$2y$10$xQqe3wFEgA7y71kQrgRaOOb1824V8EEhh2ba1kK1Ddt4dMkGqNEIK'),
(65, 'ytr', 'ytr', 'ytr@gmail.com', 'guest', '2024-04-30', 'ytr', '$2y$10$A6sRJPYOtxOChk.IgPdsDu9XwzDGB7IqHSyAsF0miZgHt7oaEH4Le');

-- --------------------------------------------------------

--
-- Table structure for table `tblfeedback`
--

CREATE TABLE `tblfeedback` (
  `feedbackid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `feedback_desc` text DEFAULT NULL,
  `feedback_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `customerid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblfeedback`
--

INSERT INTO `tblfeedback` (`feedbackid`, `title`, `feedback_desc`, `feedback_datetime`, `customerid`) VALUES
(19, 'Good Coffee', 'Coffee served here in only coffee is one of the best', '2024-04-23 14:58:06', 35),
(21, 'Test Title', 'Test feedback body', '2024-04-26 17:46:22', 39),
(22, 'Fast Service', 'The service here in only coffee has one of the fastest service in the coffee industry.', '2024-04-26 20:21:17', 42),
(23, 'Strong coffee', 'Coffee that\'s been served to me is too strong', '2024-04-27 21:06:59', 44);

-- --------------------------------------------------------

--
-- Table structure for table `tblinventory`
--

CREATE TABLE `tblinventory` (
  `inventory_id` int(11) NOT NULL,
  `inventory_item` varchar(255) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblinventory`
--

INSERT INTO `tblinventory` (`inventory_id`, `inventory_item`, `item_type`, `quantity`, `unit`) VALUES
(3, 'Powdered Sugar', 'Sweetener', 11, 'bags'),
(4, 'Arrabica Coffee Bean', 'Coffee Bean', 10, 'bags'),
(5, 'Liberica Coffee Bean', 'Coffee Bean', 10, 'bags'),
(6, 'Oat Milk', 'Milk', 10, 'Gallons'),
(7, 'Soy Milk', 'Milk', 11, 'Gallons'),
(8, 'Pearls', 'Sinker', 10, 'packs'),
(9, 'Nata De Coco', 'Sinker', 10, 'packs'),
(10, 'Small Cups', 'Disposable', 20, 'packs'),
(11, 'Straws', 'Disposable', 20, 'packs'),
(12, 'Cream', 'Toppings', 10, 'cans'),
(13, 'Marshmallows', 'Toppings', 10, 'packs'),
(14, 'Caramel', 'Flavor', 10, 'bottles'),
(15, 'Matcha', 'Flavor', 0, 'bottle'),
(16, 'Oreo', 'Flavor', 12, 'pack'),
(41, '123', 'Coffee Bean', 123, '123'),
(42, 'Kikiam', 'Sinker', 123, 'boxes');

-- --------------------------------------------------------

--
-- Table structure for table `tblorderitem`
--

CREATE TABLE `tblorderitem` (
  `orderitem_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` enum('active','completed','ended') NOT NULL,
  `orderid` int(11) DEFAULT NULL,
  `productid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorderitem`
--

INSERT INTO `tblorderitem` (`orderitem_id`, `quantity`, `status`, `orderid`, `productid`) VALUES
(1, 2, 'completed', NULL, 17),
(2, 1, 'completed', NULL, 7),
(3, 3, 'active', NULL, 21),
(4, 5, 'completed', NULL, 15),
(5, 2, 'completed', NULL, 17),
(6, 1, 'active', NULL, 16),
(7, 2, 'active', NULL, 10),
(8, 2, 'completed', NULL, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tblorders`
--

CREATE TABLE `tblorders` (
  `order_id` int(11) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `order_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `base_coffee_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblorders`
--

INSERT INTO `tblorders` (`order_id`, `order_type`, `order_datetime`, `quantity`, `base_coffee_id`, `customer_id`, `order_number`) VALUES
(108, 'take-out', '2024-04-29 21:08:28', 1, 11, 34, 101),
(109, 'take-out', '2024-04-29 21:08:28', 1, 16, 34, 101),
(110, 'take-out', '2024-04-29 21:08:47', 1, 15, 34, 101),
(111, 'take-out', '2024-04-29 21:14:59', 1, 7, 34, 102),
(112, 'take-out', '2024-04-29 21:14:59', 1, 11, 34, 102),
(113, 'take-out', '2024-04-29 21:15:30', 1, 70, 34, 103),
(114, 'take-out', '2024-04-29 21:15:30', 1, 17, 34, 103),
(115, 'take-out', '2024-04-29 22:07:30', 1, 7, 34, 104),
(116, 'take-out', '2024-04-29 22:07:45', 1, 11, 34, 105),
(117, 'take-out', '2024-04-29 23:38:58', 1, 7, 34, 106),
(118, 'take-out', '2024-04-29 23:39:10', 1, 11, 34, 107),
(119, 'take-out', '2024-04-30 11:18:05', 1, 7, 48, 108),
(120, 'take-out', '2024-04-30 11:18:05', 1, 11, 48, 108),
(121, 'take-out', '2024-04-30 11:31:05', 1, 11, 65, 109);

-- --------------------------------------------------------

--
-- Table structure for table `tblpayment`
--

CREATE TABLE `tblpayment` (
  `paymentID` int(100) NOT NULL,
  `order_datetime` datetime NOT NULL,
  `amountpayed` decimal(10,2) NOT NULL,
  `paymenttype` varchar(50) NOT NULL,
  `customerid` int(11) DEFAULT NULL,
  `orderid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpayment`
--

INSERT INTO `tblpayment` (`paymentID`, `order_datetime`, `amountpayed`, `paymenttype`, `customerid`, `orderid`) VALUES
(2, '2023-11-09 16:39:07', 500.00, 'Cash', NULL, NULL),
(7, '2023-11-09 16:39:07', 500.00, 'Cash', NULL, NULL),
(9, '2023-11-09 16:37:27', 500.00, 'Cash', NULL, NULL),
(11, '2023-11-09 16:38:21', 500.00, 'Cash', NULL, NULL),
(76, '2023-11-10 11:26:03', 2500.00, 'Cash', NULL, NULL),
(99, '2023-11-10 11:26:03', 550.00, 'Cash', NULL, NULL),
(100, '2023-11-10 16:39:07', 500.00, 'Cash', NULL, NULL),
(101, '2023-11-10 16:39:07', 500.00, 'Cash', NULL, NULL),
(102, '2023-11-11 16:37:27', 500.00, 'Cash', NULL, NULL),
(103, '2023-11-11 16:38:21', 500.00, 'Cash', NULL, NULL),
(104, '2023-11-12 11:26:03', 2500.00, 'Cash', NULL, NULL),
(105, '2023-11-12 11:26:03', 550.00, 'Cash', NULL, NULL),
(106, '2023-11-13 16:39:07', 500.00, 'Cash', NULL, NULL),
(107, '2023-11-13 16:39:07', 500.00, 'Cash', NULL, NULL),
(108, '2023-11-14 16:37:27', 500.00, 'Cash', NULL, NULL),
(109, '2023-11-14 16:38:21', 500.00, 'Cash', NULL, NULL),
(110, '2023-11-15 11:26:03', 2500.00, 'Cash', NULL, NULL),
(111, '2023-11-15 11:26:03', 550.00, 'Cash', NULL, NULL),
(112, '2023-10-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(113, '2023-10-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(114, '2023-10-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(115, '2023-10-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(116, '2023-10-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(117, '2023-10-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(118, '2023-10-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(119, '2023-10-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(120, '2023-10-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(121, '2023-10-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(122, '2023-10-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(123, '2023-09-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(124, '2023-09-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(125, '2023-09-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(126, '2023-09-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(127, '2023-09-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(128, '2023-09-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(129, '2023-09-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(130, '2023-09-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(131, '2023-09-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(132, '2023-09-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(133, '2023-09-05 11:26:03', 550.00, 'Cash', NULL, NULL),
(134, '2023-08-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(135, '2023-08-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(136, '2023-08-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(137, '2023-08-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(138, '2023-08-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(139, '2023-08-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(140, '2023-08-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(141, '2023-08-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(142, '2023-08-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(143, '2023-08-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(144, '2023-08-05 11:26:03', 550.00, 'Cash', NULL, NULL),
(145, '2023-07-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(146, '2023-07-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(147, '2023-07-01 11:26:03', 550.00, 'Cash', NULL, NULL),
(148, '2023-07-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(149, '2023-07-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(150, '2023-07-02 11:26:03', 550.00, 'Cash', NULL, NULL),
(151, '2023-07-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(152, '2023-07-03 11:26:03', 550.00, 'Cash', NULL, NULL),
(153, '2023-07-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(154, '2023-07-04 11:26:03', 550.00, 'Cash', NULL, NULL),
(155, '2023-07-05 11:26:03', 550.00, 'Cash', NULL, NULL),
(156, '2025-12-25 04:29:00', 10.00, 'Card', NULL, NULL),
(159, '2023-11-16 22:36:42', 130.00, 'Card', NULL, NULL),
(160, '2023-11-16 22:36:42', 111.11, 'Card', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts`
--

CREATE TABLE `tblproducts` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts`
--

INSERT INTO `tblproducts` (`product_id`, `product_name`, `product_description`, `price`, `image`, `status`, `category`) VALUES
(7, 'Salted Caramel Cold Breww', 'a salted caramel coffee that is brewed colddss', 130.00, 'coffee-3727673_640.jpg', 'Available', 'brewed'),
(10, 'Vanilla Cream Frappe', 'A coffee that is frapped with vanilla cream', 200.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Not Available', 'frappe'),
(11, 'Iced Americano', 'A coffee that is americanized with ice', 100.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Available', 'frappe'),
(15, 'Iced White Chocolate mocha', 'A white chocolate flavored coffee with ice and mocha', 200.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Available', 'espresso'),
(16, 'Espresso Machiato', 'A expressed coffee with macchiato', 200.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Available', 'espresso'),
(17, 'Iced caffe latte', 'a coffee with ice and latted', 130.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Available', 'latte'),
(21, 'Iced Special Cappuccinoo', 'a coffee with ice and cappucinized but its special', 130.00, 'stock-of-mix-a-cup-coffee-latte-more-motive-top-view-foodgraphy-generative-ai-photo.jpg', 'Available', 'cappuccino'),
(70, 'Hot milk', 'It is just milk that is hot', 120.01, 'coffee-3727673_640.jpg', 'Available', 'milk based');

-- --------------------------------------------------------

--
-- Table structure for table `tblproducts_inventory`
--

CREATE TABLE `tblproducts_inventory` (
  `productsInventory_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproducts_inventory`
--

INSERT INTO `tblproducts_inventory` (`productsInventory_id`, `products_id`, `inventory_id`) VALUES
(113, 10, 15),
(115, 11, 14),
(116, 11, 4),
(117, 15, 5),
(118, 15, 14),
(119, 16, 14),
(120, 16, 4),
(121, 16, 3),
(122, 17, 5),
(123, 21, 14),
(124, 21, 5),
(125, 70, 7),
(126, 7, 42),
(127, 7, 41);

-- --------------------------------------------------------

--
-- Table structure for table `tblpromo`
--

CREATE TABLE `tblpromo` (
  `promoid` int(11) NOT NULL,
  `promoname` varchar(255) NOT NULL,
  `promodesc` text DEFAULT NULL,
  `promocode` varchar(20) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblpromo`
--

INSERT INTO `tblpromo` (`promoid`, `promoname`, `promodesc`, `promocode`, `value`, `startdate`, `enddate`) VALUES
(1, '50% off', 'minus 50% off purchases', 'SINKWENTY', 0.50, '2024-01-01', '2024-01-31'),
(2, 'Free Upsize', 'free upsize of minimum spent of 500 php', 'FREEUP', 0.00, '2024-02-11', '2024-02-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(11) NOT NULL DEFAULT 'guest',
  `date_of_registration` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `customer_name`, `email`, `username`, `password`, `role`, `date_of_registration`) VALUES
(9, 'Sendo', 'sendo@gmail.com', 'xdo123', '$2y$10$bUqmv08S7XMeHV4DZ2NSDuucG9p7BwM3RtCgpzyHHeC8vTx7dq2am', 'guest', '2024-03-29 12:44:03'),
(10, 'Sendo Galang', 'odnes@gmail.com', 'sendo123', '$2y$10$ks2bC7Ez3Oc1SqICfCbylu1gg/w28jWoNYnDfo0MYDTGpbYfrVjmO', 'admin', '2024-03-29 12:46:02'),
(11, 'Jeffel Madula', 'jeffel@example.com', 'jeffel123', '$2y$10$3CJVRwaRV8SJA5sSAd4gaOMmY9eTc4TP9n4pMh.fMhOmpcdABYHMa', 'admin', '2024-03-29 12:49:51'),
(12, 'Kurby', 'kurby@gmail.com', 'kurby', '$2y$10$68yUATYNr5N94obo7QyQleqhmQQFbP8tZDexM.V23uLfmYTA8QcAG', 'guest', '2024-03-29 12:53:59'),
(13, 'Test', 'test@gmail.com', 'test123', '$2y$10$qca.TQG9r3Swm1ukUB09i.rC5bD0nd8i4sTPuxsJolMMH2gXcijXe', 'guest', '2024-03-29 13:31:17'),
(14, 'Test', 'kurtdiestro@gmail.com', 'test', '$2y$10$sZa1.2aH0aCzEOJyctWICuKMuAEDgVN2Mhu/LHCqDgQdStm2Kwore', 'guest', '2024-03-29 13:32:07'),
(15, 'example', 'example@gmail.com', 'example', '$2y$10$1eMXin60acXoNAEjl4Jn2eCyCjTbXqgUb3f62fOvuScH83DVKWu0u', 'guest', '2024-04-07 14:26:29'),
(16, 'Test', 'sendo1111@gmail.com', 'test', '$2y$10$48rdsHHNsvQzm4oZQC7LrOOycyKfTTcMGCxnJdTsjRSIX6ghQx.i.', 'guest', '2024-04-20 11:05:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbluserlogs`
--

CREATE TABLE `tbluserlogs` (
  `logid` int(11) NOT NULL,
  `log_datetime` datetime NOT NULL,
  `loginfo` varchar(255) NOT NULL,
  `employeeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbluserlogs`
--

INSERT INTO `tbluserlogs` (`logid`, `log_datetime`, `loginfo`, `employeeid`) VALUES
(154, '2024-04-23 23:04:19', 'jan@gmail.com has edited an employee information.', 34),
(155, '2024-04-23 23:12:50', 'jan@gmail.com has added a new employee.', 34),
(156, '2024-04-23 23:13:14', 'jan@gmail.com has edited an employee information.', 34),
(157, '2024-04-23 23:14:38', 'jan@gmail.com has edited an employee information.', 34),
(158, '2024-04-23 23:15:08', 'jan@gmail.com has added a new employee.', 34),
(159, '2024-04-23 23:15:17', 'jan@gmail.com has deleted a employee.', 34),
(160, '2024-04-23 23:15:19', 'jan@gmail.com has deleted a employee.', 34),
(161, '2024-04-24 16:05:37', 'jan@gmail.com has added a new employee.', 34),
(162, '2024-04-24 16:05:47', 'jan@gmail.com has edited an employee information.', 34),
(163, '2024-04-24 16:05:51', 'jan@gmail.com has edited an employee information.', 34),
(164, '2024-04-24 16:06:07', 'jan@gmail.com has edited an employee information.', 34),
(165, '2024-04-24 16:06:16', 'jan@gmail.com has edited an employee information.', 34),
(166, '2024-04-24 16:06:25', 'jan@gmail.com has edited an employee information.', 34),
(167, '2024-04-24 16:06:32', 'jan@gmail.com has deleted a employee.', 34),
(168, '2024-04-25 14:06:17', 'jan@gmail.com has added a new employee.', 34),
(169, '2024-04-25 14:06:24', 'jan@gmail.com has edited an employee information.', 34),
(170, '2024-04-25 14:06:31', 'jan@gmail.com has edited an employee information.', 34),
(171, '2024-04-25 14:06:35', 'jan@gmail.com has deleted a employee.', 34),
(172, '2024-04-25 14:15:14', 'jan@gmail.com has deleted a employee.', 34),
(173, '2024-04-25 14:19:25', 'jan@gmail.com has edited an employee information.', 34),
(174, '2024-04-25 14:19:33', 'jan@gmail.com has edited an employee information.', 34),
(175, '2024-04-25 14:22:41', 'jan@gmail.com has added a new employee.', 34),
(176, '2024-04-25 14:23:45', 'jan@gmail.com has added a new employee.', 34),
(177, '2024-04-25 14:24:35', 'jan@gmail.com has edited an employee information.', 34),
(178, '2024-04-25 14:49:14', 'jan@gmail.com has edited an employee information.', 34),
(179, '2024-04-25 23:32:37', 'jan@gmail.com has edited an employee information.', 34),
(180, '2024-04-26 19:41:27', 'jan@gmail.com has edited an employee information.', 34),
(181, '2024-04-26 19:41:40', 'jan@gmail.com has edited an employee information.', 34),
(182, '2024-04-26 19:42:01', 'justin@gmail.com has edited an employee information.', 44),
(183, '2024-04-26 23:15:22', 'jp@gmail.com has edited an employee information.', 42),
(184, '2024-04-26 23:17:23', 'jp@gmail.com has edited an employee information.', 42),
(185, '2024-04-26 23:17:27', 'jp@gmail.com has edited an employee information.', 42),
(186, '2024-04-26 23:17:44', 'jp@gmail.com has added a new employee.', 42),
(187, '2024-04-26 23:17:50', 'jp@gmail.com has deleted a employee.', 42),
(188, '2024-04-26 23:20:28', 'jp@gmail.com has added a new employee.', 42),
(189, '2024-04-26 23:25:39', 'jp@gmail.com has edited an employee information.', 42),
(190, '2024-04-26 23:28:34', 'jp@gmail.com has edited an employee information.', 42),
(191, '2024-04-26 23:28:52', 'jp@gmail.com has edited an employee information.', 42),
(192, '2024-04-26 23:31:04', 'jp@gmail.com has added a new employee.', 42),
(193, '2024-04-26 23:31:14', 'jp@gmail.com has edited an employee information.', 42),
(194, '2024-04-26 23:31:23', 'jp@gmail.com has edited an employee information.', 42),
(195, '2024-04-26 23:31:28', 'jp@gmail.com has deleted a employee.', 42),
(196, '2024-04-26 23:31:32', 'jp@gmail.com has deleted a employee.', 42);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `body` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `customerid` (`customerid`);

--
-- Indexes for table `tblcartitem`
--
ALTER TABLE `tblcartitem`
  ADD PRIMARY KEY (`cartitemID`),
  ADD KEY `productid` (`productid`),
  ADD KEY `cartid` (`cartid`);

--
-- Indexes for table `tblcategory_inventory`
--
ALTER TABLE `tblcategory_inventory`
  ADD PRIMARY KEY (`categoryInventory_id`);

--
-- Indexes for table `tblcategory_product`
--
ALTER TABLE `tblcategory_product`
  ADD PRIMARY KEY (`categoryProduct_id`);

--
-- Indexes for table `tblcoffeeshop`
--
ALTER TABLE `tblcoffeeshop`
  ADD PRIMARY KEY (`coffeeshopid`),
  ADD KEY `employees_id` (`employees_id`);

--
-- Indexes for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  ADD PRIMARY KEY (`customerid`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`employeeID`) USING BTREE;

--
-- Indexes for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD PRIMARY KEY (`feedbackid`),
  ADD KEY `customerid` (`customerid`);

--
-- Indexes for table `tblinventory`
--
ALTER TABLE `tblinventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `tblorderitem`
--
ALTER TABLE `tblorderitem`
  ADD PRIMARY KEY (`orderitem_id`),
  ADD KEY `orderid` (`orderid`),
  ADD KEY `productid` (`productid`);

--
-- Indexes for table `tblorders`
--
ALTER TABLE `tblorders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD PRIMARY KEY (`paymentID`),
  ADD KEY `customerid` (`customerid`),
  ADD KEY `orderid` (`orderid`);

--
-- Indexes for table `tblproducts`
--
ALTER TABLE `tblproducts`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tblproducts_inventory`
--
ALTER TABLE `tblproducts_inventory`
  ADD PRIMARY KEY (`productsInventory_id`),
  ADD KEY `tblproducts_inventory_idfk_1` (`products_id`),
  ADD KEY `tblproducts_inventory_idfk_2` (`inventory_id`);

--
-- Indexes for table `tblpromo`
--
ALTER TABLE `tblpromo`
  ADD PRIMARY KEY (`promoid`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbluserlogs`
--
ALTER TABLE `tbluserlogs`
  ADD PRIMARY KEY (`logid`),
  ADD KEY `employeeid` (`employeeid`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblcart`
--
ALTER TABLE `tblcart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcartitem`
--
ALTER TABLE `tblcartitem`
  MODIFY `cartitemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblcategory_inventory`
--
ALTER TABLE `tblcategory_inventory`
  MODIFY `categoryInventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblcategory_product`
--
ALTER TABLE `tblcategory_product`
  MODIFY `categoryProduct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblcoffeeshop`
--
ALTER TABLE `tblcoffeeshop`
  MODIFY `coffeeshopid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcustomers`
--
ALTER TABLE `tblcustomers`
  MODIFY `customerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `employeeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  MODIFY `feedbackid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tblinventory`
--
ALTER TABLE `tblinventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tblorderitem`
--
ALTER TABLE `tblorderitem`
  MODIFY `orderitem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tblorders`
--
ALTER TABLE `tblorders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tblpayment`
--
ALTER TABLE `tblpayment`
  MODIFY `paymentID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `tblproducts`
--
ALTER TABLE `tblproducts`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tblproducts_inventory`
--
ALTER TABLE `tblproducts_inventory`
  MODIFY `productsInventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `tblpromo`
--
ALTER TABLE `tblpromo`
  MODIFY `promoid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbluserlogs`
--
ALTER TABLE `tbluserlogs`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcart`
--
ALTER TABLE `tblcart`
  ADD CONSTRAINT `tblcart_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `tblcustomers` (`customerid`);

--
-- Constraints for table `tblcartitem`
--
ALTER TABLE `tblcartitem`
  ADD CONSTRAINT `tblcartitem_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `tblproducts` (`product_id`),
  ADD CONSTRAINT `tblcartitem_ibfk_2` FOREIGN KEY (`cartid`) REFERENCES `tblcart` (`cartID`);

--
-- Constraints for table `tblcoffeeshop`
--
ALTER TABLE `tblcoffeeshop`
  ADD CONSTRAINT `tblcoffeeshop_ibfk_1` FOREIGN KEY (`employees_id`) REFERENCES `tblemployees` (`employeeID`);

--
-- Constraints for table `tblfeedback`
--
ALTER TABLE `tblfeedback`
  ADD CONSTRAINT `FK_tblfeedback_tbluser` FOREIGN KEY (`customerid`) REFERENCES `tblemployees` (`employeeID`);

--
-- Constraints for table `tblorderitem`
--
ALTER TABLE `tblorderitem`
  ADD CONSTRAINT `tblorderitem_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `tblorders` (`order_id`),
  ADD CONSTRAINT `tblorderitem_ibfk_2` FOREIGN KEY (`productid`) REFERENCES `tblproducts` (`product_id`);

--
-- Constraints for table `tblpayment`
--
ALTER TABLE `tblpayment`
  ADD CONSTRAINT `tblpayment_ibfk_1` FOREIGN KEY (`customerid`) REFERENCES `tblcustomers` (`customerid`),
  ADD CONSTRAINT `tblpayment_ibfk_2` FOREIGN KEY (`orderid`) REFERENCES `tblorders` (`order_id`);

--
-- Constraints for table `tblproducts_inventory`
--
ALTER TABLE `tblproducts_inventory`
  ADD CONSTRAINT `tblproducts_inventory_idfk_1` FOREIGN KEY (`products_id`) REFERENCES `tblproducts` (`product_id`),
  ADD CONSTRAINT `tblproducts_inventory_idfk_2` FOREIGN KEY (`inventory_id`) REFERENCES `tblinventory` (`inventory_id`);

--
-- Constraints for table `tbluserlogs`
--
ALTER TABLE `tbluserlogs`
  ADD CONSTRAINT `tbluserlogs_ibfk_2` FOREIGN KEY (`employeeid`) REFERENCES `tblemployees` (`employeeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
