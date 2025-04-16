-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 05:26 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `semt_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `CompanyID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `about` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `fire_extinguishers`
--

CREATE TABLE `fire_extinguishers` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `status` enum('Active','Expired') DEFAULT 'Active',
  `conditions` enum('Good','NeedRepair') DEFAULT 'Good',
  `expiry_date` date DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `inspection_frequency` enum('Monthly','Annually') DEFAULT 'Annually',
  `additional_notes` text DEFAULT NULL,
  `station_name` varchar(100) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `enter_by` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fire_extinguishers`
--

INSERT INTO `fire_extinguishers` (`id`, `serial_number`, `brand`, `type`, `capacity`, `location`, `installation_date`, `status`, `conditions`, `expiry_date`, `weight`, `inspection_frequency`, `additional_notes`, `station_name`, `platform`, `enter_by`) VALUES
(10, '0012', 'test', 'gy', 'hgyyt', 'fgccgfdgf', '2025-02-01', 'Active', 'Good', '2025-01-10', '0.00', 'Monthly', 'gyh', 'Maradana', '09', 'aaa'),
(9, '0006', 'test', 'co2', 'hgyyt', 'ft', '2025-01-17', 'Active', 'Good', '2025-01-17', '0.00', 'Monthly', 'bh', '1', '1', 'aaa'),
(7, '0011', 'test', 'gy', 'hgyyt', 'ft', '2025-01-31', 'Active', 'Good', '2025-01-22', '0.00', 'Monthly', 'nftyr', 'Colombo Fort', '04', 'user'),
(6, '0010', 'hhh', 'gy', 'hgyyt', 'ft', '2025-01-02', 'Active', 'Good', '2025-01-30', '504.00', 'Monthly', 'nvg', 'Colombo Fort', '1', 'user'),
(11, '0015', 'test', 'gy', 'hgyyt', 'fgccgfdgf', '2025-01-29', 'Active', 'Good', '2025-01-17', '454.00', 'Monthly', 'mghjg', 'Colombo Fort', '11', 'user'),
(12, '0018', 'test', 'gy', 'hgyyt', 'fgccgfdgf', '2025-01-16', 'Active', 'Good', '2025-01-17', '454.00', 'Monthly', 'ffhyf', 'Maradana', '05', 'aaa'),
(13, '0020', 'test', 'gy', 'hgyyt', 'fgccgfdgf', '2025-01-24', 'Active', 'Good', '2025-01-24', '454.00', 'Monthly', 'hjjgh', 'Colombo Fort', '08', 'user'),
(14, '0078', 'sdhhx', 'nhjv', '15', NULL, '2024-01-01', 'Active', 'Good', '2026-01-01', '400.00', '', '', 'Colombo Fort', '11', 'user'),
(15, '0088', 'kj', 'fg', 'dgf', NULL, '2024-01-01', 'Active', 'Good', '2026-01-01', '600.00', '', 'fuhjff', 'Colombo Fort', '02', 'user'),
(23, '0090', 'gdff', 'hdjf', '125', NULL, '2023-01-01', 'Active', 'Good', '2025-01-01', '140.00', '', 'dhjhcc', 'Colombo Fort', '03', 'user'),
(27, '0095', 'bjnk', 'hihi', '425', NULL, '2021-01-01', 'Expired', '', '2023-01-01', '425.00', 'Monthly', '', 'Colombo Fort', '10', 'user'),
(28, '0099', 'jdh', 'jkcjxc', '800', NULL, '2021-01-01', 'Active', 'NeedRepair', '2023-01-01', '700.00', 'Annually', 'cx', 'Colombo Fort', '03', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `fire_extinguishers_history`
--

CREATE TABLE `fire_extinguishers_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `maintenance_type` varchar(100) DEFAULT NULL,
  `service_provider` varchar(100) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `next_scheduled_maintenance` date DEFAULT NULL,
  `maintenance_results` text DEFAULT NULL,
  `repair_details` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `status` enum('Completed','Pending') DEFAULT 'Pending',
  `additional_notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fire_extinguishers_history`
--

INSERT INTO `fire_extinguishers_history` (`id`, `item_id`, `maintenance_type`, `service_provider`, `maintenance_date`, `next_scheduled_maintenance`, `maintenance_results`, `repair_details`, `cost`, `status`, `additional_notes`) VALUES
(1, 6, 'Replacement', NULL, '2025-02-04', '2025-05-04', NULL, NULL, NULL, 'Pending', NULL),
(2, 6, 'Repair', NULL, '2025-05-04', '2025-08-04', NULL, NULL, NULL, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fire_extinguishers_invoice`
--

CREATE TABLE `fire_extinguishers_invoice` (
  `id` int(11) NOT NULL,
  `repair_request_id` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `invoice_attachment` text DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Overdue') DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approval_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fire_extinguishers_invoice`
--

INSERT INTO `fire_extinguishers_invoice` (`id`, `repair_request_id`, `invoice_date`, `amount`, `invoice_attachment`, `payment_status`, `remarks`, `paid_date`, `approved_by`, `approval_date`) VALUES
(1, 13, '2025-01-31', '5000.00', '../uploads/quotation_679c6f51eec99.pdf', 'Pending', 'nvfgh', NULL, 'user', '2025-02-23'),
(2, 15, '2025-01-31', '4000.00', '../uploads/quotation_679c6fc601345.pdf', 'Pending', 'gycd', NULL, NULL, NULL),
(6, 18, '2025-02-22', '5000.00', '../uploads/quotation_67b9f9372692f.pdf', 'Pending', 'bhjbjh', NULL, 'user', '2025-02-23'),
(4, 16, '2025-02-16', '4000.00', '../uploads/quotation_67b1f5a191338.pdf', 'Paid', 'bkjh', NULL, 'user', '2025-02-23'),
(5, 14, '2025-02-16', '1000.00', '../uploads/quotation_67b1f5e2b1656.pdf', 'Pending', 'nn', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `fire_extinguishers_quotations`
--

CREATE TABLE `fire_extinguishers_quotations` (
  `id` int(11) NOT NULL,
  `repair_request_id` int(11) NOT NULL,
  `quotation_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `quotation_attachment` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `payment_status` enum('Pending','Paid','In Progress') DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fire_extinguishers_quotations`
--

INSERT INTO `fire_extinguishers_quotations` (`id`, `repair_request_id`, `quotation_date`, `amount`, `quotation_attachment`, `remarks`, `approved_by`, `approval_date`, `payment_status`) VALUES
(7, 16, '2025-02-01', '4000.00', '../uploads/quotation_679e38a15ac1d.pdf', 'mgdtr', 'user', '2025-02-23', 'In Progress'),
(9, 18, '2025-02-16', '4000.00', '../uploads/quotation_67b1fbe808c6a.pdf', 'bvng', NULL, NULL, 'Pending'),
(5, 14, '2025-01-31', '5000.00', '../uploads/quotation_679c9d5492430.pdf', 'jyj', NULL, NULL, 'In Progress'),
(8, 12, '2025-02-10', '5000.00', '../uploads/quotation_67aa2ea08ad66.pdf', 'mkl', NULL, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `fire_extinguishers_requests`
--

CREATE TABLE `fire_extinguishers_requests` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(150) NOT NULL,
  `type` varchar(200) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `scheduled_service_date` date DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `description` text DEFAULT NULL,
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `service_date` date DEFAULT NULL,
  `repair_details` text DEFAULT NULL,
  `cost_estimation` decimal(10,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `station_name` varchar(150) NOT NULL,
  `platform_number` varchar(150) NOT NULL,
  `send_by` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fire_extinguishers_requests`
--

INSERT INTO `fire_extinguishers_requests` (`id`, `serial_number`, `type`, `service_type`, `request_date`, `scheduled_service_date`, `status`, `description`, `priority`, `service_date`, `repair_details`, `cost_estimation`, `quotation_id`, `invoice_id`, `attachments`, `station_name`, `platform_number`, `send_by`) VALUES
(18, '0011', 'gy', 'Recharging', '2025-02-16', NULL, 'Completed', 'hguyj', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '04', 'user'),
(14, '0001', 'water spray', 'Inspection', '2025-01-24', NULL, 'In Progress', 'fgfg', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Maradana', '01', 'aaa'),
(12, '0002', 'Dry Powder', 'Recharging', '2025-01-23', NULL, 'Pending', 'hfyhfy', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Maradana', '01', 'aaa'),
(16, '0010', 'gy', 'Recharging', '2025-01-29', NULL, 'In Progress', 'hufrehufe', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '04', 'user'),
(17, '0006', 'gy', 'Recharging', '2025-02-01', NULL, 'Pending', 'yttdtr', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Maradana', '01', 'aaa'),
(19, '0010', 'gy', 'Recharging', '2025-02-24', NULL, 'Pending', 'sijxoisgicuj', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '1', 'user'),
(20, '0006', 'co2', 'Inspection', '2025-03-03', NULL, 'Pending', 'hyhdjwh', 'Low', NULL, NULL, NULL, NULL, NULL, NULL, '1', '1', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_schedule`
--

CREATE TABLE `maintenance_schedule` (
  `M_ScheduleID` int(11) NOT NULL,
  `maintenance` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `platform_id` int(11) NOT NULL,
  `StationID` int(11) NOT NULL,
  `platform_number` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`platform_id`, `StationID`, `platform_number`) VALUES
(1, 1, '01'),
(2, 2, '04');

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

CREATE TABLE `station` (
  `StationID` int(11) NOT NULL,
  `line_name` varchar(255) NOT NULL,
  `station_name` varchar(255) NOT NULL,
  `station_type` varchar(100) NOT NULL,
  `station_code` varchar(50) NOT NULL,
  `platform` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`StationID`, `line_name`, `station_name`, `station_type`, `station_code`, `platform`) VALUES
(1, 'main', 'maradana', 'FOT', '001', '1'),
(2, 'main', 'colombo fort', 'KDT', '002', '2');

-- --------------------------------------------------------

--
-- Table structure for table `station_details`
--

CREATE TABLE `station_details` (
  `station_id` int(3) DEFAULT NULL,
  `station_code` varchar(5) DEFAULT NULL,
  `station_type` varchar(4) DEFAULT NULL,
  `station_name` varchar(25) DEFAULT NULL,
  `station_line` varchar(16) DEFAULT NULL,
  `area` varchar(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `station_details`
--

INSERT INTO `station_details` (`station_id`, `station_code`, `station_type`, `station_name`, `station_line`, `area`) VALUES
(1, 'MDA', 'MAIN', 'Maradana', 'MAIN LINE', 'SUBURBAN'),
(2, 'DAG', 'SUB', 'Dematagoda', 'MAIN LINE', 'SUBURBAN'),
(3, 'URW', 'MAIN', 'Orugodawaththa', 'MAIN LINE', 'SUBURBAN'),
(4, 'KLN', 'MAIN', 'Kolonnawa', 'MAIN LINE', 'SUBURBAN'),
(5, 'KLA', 'MAIN', 'Kelaniya', 'MAIN LINE', 'SUBURBAN'),
(6, 'WSL', 'SUB', 'Wanawasala', 'MAIN LINE', 'SUBURBAN'),
(7, 'HUN', 'MAIN', 'Hunupitiya', 'MAIN LINE', 'SUBURBAN'),
(8, 'EDM', 'SUB', 'Enderamulla', 'MAIN LINE', 'SUBURBAN'),
(9, 'HRP', 'SUB', 'Horape', 'MAIN LINE', 'SUBURBAN'),
(10, 'RGM', 'MAIN', 'Ragama', 'MAIN LINE', 'SUBURBAN'),
(11, 'WPA', 'SUB', 'Walpola', 'MAIN LINE', 'SUBURBAN'),
(12, 'BTU', 'SUB', 'Batuwatta', 'MAIN LINE', 'SUBURBAN'),
(13, 'BGH', 'SUB', 'Bulugahagoda', 'MAIN LINE', 'SUBURBAN'),
(14, 'GAN', 'MAIN', 'Ganemulla', 'MAIN LINE', 'SUBURBAN'),
(15, 'YGD', 'SUB', 'Yagoda', 'MAIN LINE', 'SUBURBAN'),
(16, 'GPH', 'MAIN', 'Gampaha', 'MAIN LINE', 'SUBURBAN'),
(17, 'DRL', 'SUB', 'Daraluwa', 'MAIN LINE', 'SUBURBAN'),
(18, 'BEM', 'SUB', 'Bemmulla', 'MAIN LINE', 'SUBURBAN'),
(19, 'MGG', 'SUB', 'Magalegoda', 'MAIN LINE', 'SUBURBAN'),
(20, 'HDP', 'SUB', 'Heendeniya pattigoda', 'MAIN LINE', 'SUBURBAN'),
(21, 'VGD', 'MAIN', 'Veyangoda', 'MAIN LINE', 'SUBURBAN'),
(22, 'WRW', 'SUB', 'Wadurawa', 'MAIN LINE', 'SUBURBAN'),
(23, 'KEN', 'SUB', 'Keenawala', 'MAIN LINE', 'SUBURBAN'),
(24, 'PLL', 'MAIN', 'Pallewela', 'MAIN LINE', 'SUBURBAN'),
(25, 'GND', 'SUB', 'Ganegoda', 'MAIN LINE', 'SUBURBAN'),
(26, 'WRD', 'SUB', 'Wijaya rajadahana', 'MAIN LINE', 'SUBURBAN'),
(27, 'MIR', 'MAIN', 'Mirigama', 'MAIN LINE', 'SUBURBAN'),
(28, 'WWT', 'SUB', 'Wilwatta', 'MAIN LINE', 'SUBURBAN'),
(29, 'BTL', 'SUB', 'Botale', 'MAIN LINE', 'SUBURBAN'),
(30, 'APS', 'MAIN', 'Ambepussa', 'MAIN LINE', 'SUBURBAN'),
(31, 'YTG', 'SUB', 'Yattalgoda', 'MAIN LINE', 'SUBURBAN'),
(32, 'BJM', 'SUB', 'Bujjomuwa', 'MAIN LINE', 'SUBURBAN'),
(33, 'ALW', 'MAIN', 'Alawwa', 'MAIN LINE', 'SUBURBAN'),
(34, 'WKA', 'SUB', 'Walakumbura', 'MAIN LINE', 'SUBURBAN'),
(35, 'PLG', 'MAIN', 'Polgahawela', 'MAIN LINE', 'SUBURBAN'),
(36, 'PNL', 'SUB', 'Panaliya', 'MAIN LINE', 'URBAN'),
(37, 'TSM', 'SUB', 'Tismalpola', 'MAIN LINE', 'URBAN'),
(38, 'KSP', 'HALT', 'Korosse', 'MAIN LINE', 'URBAN'),
(39, 'YGM', 'SUB', 'Yatagama', 'MAIN LINE', 'URBAN'),
(40, 'RBK', 'MAIN', 'Rambukkana', 'MAIN LINE', 'URBAN'),
(41, 'KMA', 'MAIN', 'Kadigamuwa', 'MAIN LINE', 'URBAN'),
(42, 'R01', 'HALT', 'Yatlweideniya', 'MAIN LINE', 'URBAN'),
(43, 'GDA', 'SUB', 'Gangoda', 'MAIN LINE', 'URBAN'),
(44, 'IKT', 'MAIN', 'Ihalakotte', 'MAIN LINE', 'URBAN'),
(45, 'R02', 'HALT', 'Makehelwala', 'MAIN LINE', 'URBAN'),
(46, 'GVP', 'HALT', 'Good view', 'MAIN LINE', 'URBAN'),
(47, 'BNA', 'MAIN', 'Balana', 'MAIN LINE', 'URBAN'),
(48, 'R03', 'HALT', 'Weralugolla', 'MAIN LINE', 'URBAN'),
(49, 'KGW', 'MAIN', 'Kadugannawa', 'MAIN LINE', 'URBAN'),
(50, 'R04', 'HALT', 'Urapola', 'MAIN LINE', 'URBAN'),
(51, 'R05', 'HALT', 'Kotabogoda', 'MAIN LINE', 'URBAN'),
(52, 'PLT', 'MAIN', 'Pilimatalawa', 'MAIN LINE', 'URBAN'),
(53, 'PDA', 'MAIN', 'Peradeniya junction', 'MAIN LINE', 'URBAN'),
(54, 'R06', 'HALT', 'Barammana', 'MAIN LINE', 'URBAN'),
(55, 'KOS ', 'SUB', 'Koshinna', 'MAIN LINE', 'URBAN'),
(56, 'GEY', 'MAIN', 'Gelioya', 'MAIN LINE', 'URBAN'),
(57, 'R07', 'HALT', 'Polgahaanga', 'MAIN LINE', 'URBAN'),
(58, 'R08', 'HALT', 'Weligalla', 'MAIN LINE', 'URBAN'),
(59, 'R09', 'HALT', 'Gangathilaka', 'MAIN LINE', 'URBAN'),
(60, 'R10', 'HALT', 'Kahatapitiya', 'MAIN LINE', 'URBAN'),
(61, 'GPL', 'MAIN', 'Gampola', 'MAIN LINE', 'URBAN'),
(62, 'R11', 'HALT', 'Wallahagoda', 'MAIN LINE', 'URBAN'),
(63, 'TBL', 'HALT', 'Tembiligala', 'MAIN LINE', 'URBAN'),
(64, 'ULP', 'MAIN', 'Ulapane', 'MAIN LINE', 'URBAN'),
(65, 'R12', 'HALT', 'Pallegama', 'MAIN LINE', 'URBAN'),
(66, 'R13', 'HALT', 'Warakawa', 'MAIN LINE', 'URBAN'),
(67, 'NVP', 'MAIN', 'Nawalapitiya', 'MAIN LINE', 'URBAN'),
(68, 'SLP', 'HALT', 'Salem brige', 'MAIN LINE', 'URBAN'),
(69, 'HYP', 'HALT', 'Hynd-ford', 'MAIN LINE', 'URBAN'),
(70, 'INO', 'MAIN', 'Induru oya', 'MAIN LINE', 'URBAN'),
(71, 'R14', 'HALT', 'Hangaranoya', 'MAIN LINE', 'URBAN'),
(72, 'PRP', 'HALT', 'Penrhos', 'MAIN LINE', 'URBAN'),
(73, 'GBD', 'MAIN', 'Galboda', 'MAIN LINE', 'URBAN'),
(74, 'R15', 'HALT', 'Dekinda', 'MAIN LINE', 'URBAN'),
(75, 'WWP', 'HALT', 'Weywelthalawa', 'MAIN LINE', 'URBAN'),
(76, 'WLA', 'MAIN', 'Watawala', 'MAIN LINE', 'URBAN'),
(77, 'IWL', 'SUB', 'Ihala watawala', 'MAIN LINE', 'URBAN'),
(78, 'RZL', 'MAIN', 'Rozella', 'MAIN LINE', 'URBAN'),
(79, 'HTN', 'MAIN', 'Hatton', 'MAIN LINE', 'URBAN'),
(80, 'R16', 'HALT', 'Galkandawatta', 'MAIN LINE', 'URBAN'),
(81, 'KGA', 'MAIN', 'Kotagala', 'MAIN LINE', 'URBAN'),
(82, 'R17', 'HALT', 'Dericlaire', 'MAIN LINE', 'URBAN'),
(83, 'SCP', 'HALT', 'Sl clair', 'MAIN LINE', 'URBAN'),
(84, 'TKL', 'MAIN', 'Talawakele', 'MAIN LINE', 'URBAN'),
(85, 'WTG', 'MAIN', 'Watagoda', 'MAIN LINE', 'URBAN'),
(86, 'GWN', 'MAIN', 'Great western', 'MAIN LINE', 'URBAN'),
(87, 'RDL', 'SUB', 'Radella', 'MAIN LINE', 'URBAN'),
(88, 'NOA', 'MAIN', 'Nanuoya', 'MAIN LINE', 'URBAN'),
(89, 'PKP', 'SUB', 'Parakumpura', 'MAIN LINE', 'URBAN'),
(90, 'ABL', 'MAIN', 'Ambewela', 'MAIN LINE', 'URBAN'),
(91, 'PPL', 'MAIN', 'Pattipola', 'MAIN LINE', 'URBAN'),
(92, 'OHA', 'MAIN', 'Ohiya', 'MAIN LINE', 'URBAN'),
(93, 'IGH', 'MAIN', 'Idalgashinna', 'MAIN LINE', 'URBAN'),
(94, 'GNP', 'HALT', 'Glenanore', 'MAIN LINE', 'URBAN'),
(95, 'HPT', 'MAIN', 'Haputale', 'MAIN LINE', 'URBAN'),
(96, 'DLA', 'MAIN', 'Diyatalawa', 'MAIN LINE', 'URBAN'),
(97, 'BDA', 'MAIN', 'Bandarawela', 'MAIN LINE', 'URBAN'),
(98, 'KNM', 'SUB', 'Kinigama', 'MAIN LINE', 'URBAN'),
(99, 'HLO', 'MAIN', 'Heeloya', 'MAIN LINE', 'URBAN'),
(100, 'KEL', 'SUB', 'Kithal elle', 'MAIN LINE', 'URBAN'),
(101, 'ELL', 'MAIN', 'Ella', 'MAIN LINE', 'URBAN'),
(102, 'DDR', 'MAIN', 'Demodara', 'MAIN LINE', 'URBAN'),
(103, 'UDW', 'SUB', 'Uoduwara', 'MAIN LINE', 'URBAN'),
(104, 'HEA', 'MAIN', 'Hali-ella', 'MAIN LINE', 'URBAN'),
(105, 'BAD', 'MAIN', 'Badulla', 'MAIN LINE', 'URBAN'),
(106, 'SUA', 'SUB', 'Sarasaviuyana', 'MTL LINE', 'URBAN'),
(107, 'S01', 'HALT', 'Rajawatta', 'MTL LINE', 'URBAN'),
(108, 'S02', 'HALT', 'Ransaies hills', 'MTL LINE', 'URBAN'),
(109, 'S03', 'HALT', 'Suduhumpola', 'MTL LINE', 'URBAN'),
(110, 'KDT', 'MAIN', 'Kandy', 'MTL LINE', 'URBAN'),
(111, 'S04', 'HALT', 'Agiriya', 'MTL LINE', 'URBAN'),
(112, 'MYA', 'SUB', 'Mahaiyawa', 'MTL LINE', 'URBAN'),
(113, 'S05', 'HALT', 'Katugastota road', 'MTL LINE', 'URBAN'),
(114, 'S06', 'HALT', 'Mawilmada', 'MTL LINE', 'URBAN'),
(115, 'KTG', 'MAIN', 'Katugastota', 'MTL LINE', 'URBAN'),
(116, 'PTW', 'SUB', 'Palletalawinna', 'MTL LINE', 'URBAN'),
(117, 'UDL', 'SUB', 'Udatalawinna', 'MTL LINE', 'URBAN'),
(118, 'MEE', 'SUB', 'Meegammana', 'MTL LINE', 'URBAN'),
(119, 'S07', 'HALT', 'Yatinuwara', 'MTL LINE', 'URBAN'),
(120, 'WGA', 'MAIN', 'Wattegama', 'MTL LINE', 'URBAN'),
(121, 'S08', 'HALT', 'Yatawara', 'MTL LINE', 'URBAN'),
(122, 'PTP', 'SUB', 'Pathanpaha', 'MTL LINE', 'URBAN'),
(123, 'S09', 'HALT', 'Marukona', 'MTL LINE', 'URBAN'),
(124, 'UWL', 'SUB', 'Udathathawela', 'MTL LINE', 'URBAN'),
(125, 'UKL', 'MAIN', 'Ukuwela', 'MTL LINE', 'URBAN'),
(126, 'S10', 'HALT', 'Thawalakoya', 'MTL LINE', 'URBAN'),
(127, 'S11', 'HALT', 'Elwala', 'MTL LINE', 'URBAN'),
(128, 'S12', 'HALT', 'Kohombiliwala', 'MTL LINE', 'URBAN'),
(129, 'MTL', 'MAIN', 'Matale', 'MTL LINE', 'URBAN'),
(130, 'PRL', 'SUB', 'Peralanda', 'PTM LINE', 'SUBURBAN'),
(131, 'KAN', 'SUB', 'Kandana', 'PTM LINE', 'SUBURBAN'),
(132, 'KAW', 'SUB', 'Kapuwatta', 'PTM LINE', 'SUBURBAN'),
(133, 'JLA', 'MAIN', 'Jaela', 'PTM LINE', 'SUBURBAN'),
(134, 'TUD', 'SUB', 'Tudella', 'PTM LINE', 'SUBURBAN'),
(135, 'KUD', 'SUB', 'Kudahakapola', 'PTM LINE', 'SUBURBAN'),
(136, 'AWP', 'SUB', 'Alawathupitiya', 'PTM LINE', 'SUBURBAN'),
(137, 'SED', 'MAIN', 'Seeduwa', 'PTM LINE', 'SUBURBAN'),
(138, 'LGM', 'SUB', 'Liyanagemulla', 'PTM LINE', 'SUBURBAN'),
(139, 'IPZ', 'SUB', 'Investment pro zone', 'PTM LINE', 'SUBURBAN'),
(140, 'KTK', 'MAIN', 'Katunayaka', 'PTM LINE', 'SUBURBAN'),
(141, 'CAK', 'MAIN', 'Colombo air port', 'PTM LINE', 'SUBURBAN'),
(142, 'KUR', 'MAIN', 'Kurana', 'PTM LINE', 'SUBURBAN'),
(143, 'NGB', 'MAIN', 'Negombo', 'PTM LINE', 'SUBURBAN'),
(144, 'KAT', 'SUB', 'Kattuwa', 'PTM LINE', 'URBAN'),
(145, 'KCH', 'MAIN', 'Kochchikade', 'PTM LINE', 'URBAN'),
(146, 'WKL', 'SUB', 'Waikkala', 'PTM LINE', 'URBAN'),
(147, 'BLT', 'MAIN', 'Bolawatta', 'PTM LINE', 'URBAN'),
(148, 'BSA', 'SUB', 'Boralessa', 'PTM LINE', 'URBAN'),
(149, 'LWL', 'MAIN', 'Lunuwila', 'PTM LINE', 'URBAN'),
(150, 'TDR', 'SUB', 'Tummodera', 'PTM LINE', 'URBAN'),
(151, 'NAT', 'MAIN', 'Nattandiya', 'PTM LINE', 'URBAN'),
(152, 'WHP', 'SUB', 'Walahapitiya', 'PTM LINE', 'URBAN'),
(153, 'KWW', 'MAIN', 'Kudawewa', 'PTM LINE', 'URBAN'),
(154, 'NPK', 'SUB', 'Nelumpokuna', 'PTM LINE', 'URBAN'),
(155, 'MDP', 'MAIN', 'Madampe', 'PTM LINE', 'URBAN'),
(156, 'KYA', 'SUB', 'Kakapalliya', 'PTM LINE', 'URBAN'),
(157, 'SWR', 'SUB', 'Sawarana', 'PTM LINE', 'URBAN'),
(158, 'CHL', 'MAIN', 'Chilaw', 'PTM LINE', 'URBAN'),
(159, 'MNG', 'SUB', 'Manuwangama', 'PTM LINE', 'URBAN'),
(160, 'BGY', 'MAIN', 'Bangadeniya', 'PTM LINE', 'URBAN'),
(161, 'AKT', 'SUB', 'Arachchikattuwa', 'PTM LINE', 'URBAN'),
(162, 'AVD', 'SUB', 'Anawilandawa', 'PTM LINE', 'URBAN'),
(163, 'BOA', 'SUB', 'Battulu oya', 'PTM LINE', 'URBAN'),
(164, 'PCK', 'SUB', 'Pulachchikulam', 'PTM LINE', 'URBAN'),
(165, 'MNL', 'MAIN', 'Mundal', 'PTM LINE', 'URBAN'),
(166, 'MGE', 'SUB', 'Madgala eliya', 'PTM LINE', 'URBAN'),
(167, 'MKI', 'SUB', 'Madurankuliya', 'PTM LINE', 'URBAN'),
(168, 'EPN', 'SUB', 'Erakkulam peddi nagavillu', 'PTM LINE', 'URBAN'),
(169, 'PVI', 'MAIN', 'Palavi', 'PTM LINE', 'URBAN'),
(170, 'TDY', 'SUB', 'Thilladiya', 'PTM LINE', 'URBAN'),
(171, 'PTM', 'MAIN', 'Puttalam', 'PTM LINE', 'URBAN'),
(172, 'NOR', 'MAIN', 'Noornagar', 'PTM LINE', 'URBAN'),
(173, 'KPL', 'MAIN', 'Karandipuwal', 'PTM LINE', 'URBAN'),
(174, 'YPW', 'HALT', 'Yapahuwa', 'BCO LINE', 'URBAN'),
(175, 'KON', 'MAIN', 'Konwewa', 'BCO LINE', 'URBAN'),
(176, 'RNA', 'SUB', 'Ranmukagama', 'BCO LINE', 'URBAN'),
(177, 'MLG', 'MAIN', 'Moragollagama', 'BCO LINE', 'URBAN'),
(178, 'SYA', 'SUB', 'Siyabalangamuwa', 'BCO LINE', 'URBAN'),
(179, 'NGM', 'SUB', 'Negama', 'BCO LINE', 'URBAN'),
(180, 'AWK', 'SUB', 'Aukana', 'BCO LINE', 'URBAN'),
(181, 'KLW', 'MAIN', 'Kalawewa', 'BCO LINE', 'URBAN'),
(182, 'IHA', 'HALT', 'Ihalagama', 'BCO LINE', 'URBAN'),
(183, 'KRA', 'MAIN', 'Kekirawa', 'BCO LINE', 'URBAN'),
(184, 'HLA', 'SUB', 'Horiwila', 'BCO LINE', 'URBAN'),
(185, 'PUW', 'MAIN', 'Palugaswewa', 'BCO LINE', 'URBAN'),
(186, 'HBN', 'SUB', 'Habarana', 'BCO LINE', 'URBAN'),
(187, 'HKT', 'SUB', 'Hataraskotuwa', 'BCO LINE', 'URBAN'),
(188, 'GOA', 'MAIN', 'Gal oya junction', 'BCO LINE', 'URBAN'),
(189, 'MIY', 'SUB', 'Minneriya', 'BCO LINE', 'URBAN'),
(190, 'HRG', 'MAIN', 'Hingarakgoda', 'BCO LINE', 'URBAN'),
(191, 'HAU', 'HALT', 'Hathamuna', 'BCO LINE', 'URBAN'),
(192, 'JAP', 'SUB', 'Jayanthipura', 'BCO LINE', 'URBAN'),
(193, 'LYA', 'SUB', 'Laksauyana', 'BCO LINE', 'URBAN'),
(194, 'PKU', 'SUB', 'Parakumuyana', 'BCO LINE', 'URBAN'),
(195, 'PLN', 'MAIN', 'Polonnaruwa', 'BCO LINE', 'URBAN'),
(196, 'GAL', 'SUB', 'Gallella', 'BCO LINE', 'URBAN'),
(197, 'MPT', 'MAIN', 'Manampitiya', 'BCO LINE', 'URBAN'),
(198, 'SVP', 'SUB', 'Sewarapitiya', 'BCO LINE', 'URBAN'),
(199, 'WKD', 'MAIN', 'Welikanda', 'BCO LINE', 'URBAN'),
(200, 'PNI', 'MAIN', 'Punani', 'BCO LINE', 'URBAN'),
(201, 'RDT', 'SUB', 'Redethana', 'BCO LINE', 'URBAN'),
(202, 'KDN', 'SUB', 'Kadadasi nagaraya', 'BCO LINE', 'URBAN'),
(203, 'VCH', 'MAIN', 'Valachchenai', 'BCO LINE', 'URBAN'),
(204, 'KKH', 'SUB', 'Kalkudah', 'BCO LINE', 'URBAN'),
(205, 'DPM', 'SUB', 'Devapuram', 'BCO LINE', 'URBAN'),
(206, 'VML', 'HALT', 'Chandaramulai', 'BCO LINE', 'URBAN'),
(207, 'EVR', 'MAIN', 'Eravur', 'BCO LINE', 'URBAN'),
(208, 'BCO', 'MAIN', 'Batticoloa', 'BCO LINE', 'URBAN'),
(209, 'APR', 'SUB', 'Agbopura', 'TCO LINE', 'URBAN'),
(210, 'KNI', 'MAIN', 'Kantale', 'TCO LINE', 'URBAN'),
(211, 'GTL', 'HALT', 'Ganthalawa', 'TCO LINE', 'URBAN'),
(212, 'MLP', 'SUB', 'Mollipotana', 'TCO LINE', 'URBAN'),
(213, 'TAN', 'MAIN', 'Tampalakamam', 'TCO LINE', 'URBAN'),
(214, 'CBY', 'MAIN', 'China bay', 'TCO LINE', 'URBAN'),
(215, 'TCO  ', 'MAIN', 'Trincomalee', 'TCO LINE', 'URBAN'),
(216, 'GRB', 'SUB', 'Girambe', 'NORTH LINE', 'URBAN'),
(217, 'TWG', 'SUB', 'Talawattegedara', 'NORTH LINE', 'URBAN'),
(218, 'PTA', 'MAIN', 'Pothuhera', 'NORTH LINE', 'URBAN'),
(219, 'NLY', 'SUB', 'Nailiya', 'NORTH LINE', 'URBAN'),
(220, 'KRN', 'MAIN', 'Kurunegala', 'NORTH LINE', 'URBAN'),
(221, 'MTG', 'SUB', 'Muttatugala', 'NORTH LINE', 'URBAN'),
(222, 'W01', 'HALT', 'Maraluwawa', 'NORTH LINE', 'URBAN'),
(223, 'W02', 'HALT', 'Maddegama', 'NORTH LINE', 'URBAN'),
(224, 'W03', 'HALT', 'Thuruliyagama', 'NORTH LINE', 'URBAN'),
(225, 'W04', 'HALT', 'Hadiriwalana', 'NORTH LINE', 'URBAN'),
(226, 'WEL', 'MAIN', 'Wellawa', 'NORTH LINE', 'URBAN'),
(227, 'W05', 'HALT', 'Pahala wardana', 'NORTH LINE', 'URBAN'),
(228, 'W06', 'HALT', 'Pora pola', 'NORTH LINE', 'URBAN'),
(229, 'W07', 'HALT', 'Pora pola junction', 'NORTH LINE', 'URBAN'),
(230, 'W08', 'HALT', 'Pinnagolla', 'NORTH LINE', 'URBAN'),
(231, 'W09', 'HALT', 'Dewadda', 'NORTH LINE', 'URBAN'),
(232, 'W10', 'HALT', 'Nelumpathgama', 'NORTH LINE', 'URBAN'),
(233, 'GNW', 'MAIN', 'Ganewatta', 'NORTH LINE', 'URBAN'),
(234, 'W11', 'HALT', 'Thbbagalla', 'NORTH LINE', 'URBAN'),
(235, 'W12', 'HALT', 'Udugodagama', 'NORTH LINE', 'URBAN'),
(236, 'W13', 'HALT', 'Uyangalla', 'NORTH LINE', 'URBAN'),
(237, 'HRL', 'SUB', 'Hiriyala', 'NORTH LINE', 'URBAN'),
(238, 'W14', 'HALT', 'Weragala', 'NORTH LINE', 'URBAN'),
(239, 'W15', 'HALT', 'Adagala', 'NORTH LINE', 'URBAN'),
(240, 'W16', 'HALT', 'Mirihanpitigama', 'NORTH LINE', 'URBAN'),
(241, 'NAG', 'MAIN', 'Nagollagama', 'NORTH LINE', 'URBAN'),
(242, 'TIM', 'HALT', 'Thimbiriyagedara', 'NORTH LINE', 'URBAN'),
(243, 'MHO', 'MAIN', 'Maho', 'NORTH LINE', 'URBAN'),
(244, 'RGA', 'SUB', 'Randenigama', 'NORTH LINE', 'URBAN'),
(245, 'ABN', 'MAIN', 'Ambanpola', 'NORTH LINE', 'URBAN'),
(246, 'GLM', 'MAIN', 'Galgamuwa', 'NORTH LINE', 'URBAN'),
(247, 'SGM', 'MAIN', 'Senerathgama', 'NORTH LINE', 'URBAN'),
(248, 'TBM', 'MAIN', 'Tambuttegama', 'NORTH LINE', 'URBAN'),
(249, 'TLA', 'MAIN', 'Talawa', 'NORTH LINE', 'URBAN'),
(250, 'SRP', 'MAIN', 'Srawastipura', 'NORTH LINE', 'URBAN'),
(251, 'APT', 'SUB', 'Anuradh new town', 'NORTH LINE', 'URBAN'),
(252, 'W17', 'HALT', 'School halt', 'NORTH LINE', 'URBAN'),
(253, 'ANP', 'MAIN', 'Anuradhapura', 'NORTH LINE', 'URBAN'),
(254, 'MHJ', 'SUB', 'Mihintale junction', 'NORTH LINE', 'URBAN'),
(255, 'MHN', 'MAIN', 'Mihintale', 'NORTH LINE', 'URBAN'),
(256, 'W18', 'HALT', 'Samagipura', 'NORTH LINE', 'URBAN'),
(257, 'W19', 'HALT', 'Ashokapura', 'NORTH LINE', 'URBAN'),
(258, 'SAL', 'SUB', 'Salaiyapura', 'NORTH LINE', 'URBAN'),
(259, 'PHW', 'MAIN', 'Parasangahawewa', 'NORTH LINE', 'URBAN'),
(260, 'W20', 'HALT', 'Siyabalagaswawa', 'NORTH LINE', 'URBAN'),
(261, 'MEM', 'SUB', 'Medagama', 'NORTH LINE', 'URBAN'),
(262, 'W21', 'HALT', 'Weralamurippuwa', 'NORTH LINE', 'URBAN'),
(263, 'MWH', 'MAIN', 'Madawachchiya', 'NORTH LINE', 'URBAN'),
(264, 'PON', 'SUB', 'Poonewa', 'NORTH LINE', 'URBAN'),
(265, 'EKM', 'SUB', 'Eratperiyakulam', 'NORTH LINE', 'URBAN'),
(266, 'VNA', 'MAIN', 'Vavuniya', 'NORTH LINE', 'URBAN'),
(267, 'TDK', 'SUB', 'Thandikulam', 'NORTH LINE', 'URBAN'),
(268, 'OMT', 'MAIN', 'Omantai', 'NORTH LINE', 'URBAN'),
(269, 'PKM', 'MAIN', 'Puliyankulama', 'NORTH LINE', 'URBAN'),
(270, 'MKM', 'MAIN', 'Mankulama', 'NORTH LINE', 'URBAN'),
(271, 'MRK', 'MAIN', 'Murikandy', 'NORTH LINE', 'URBAN'),
(272, 'AVN', 'SUB', 'Ariviyal nagar', 'NORTH LINE', 'URBAN'),
(273, 'KOC', 'MAIN', 'Killinochoih', 'NORTH LINE', 'URBAN'),
(274, 'PRN', 'MAIN', 'Paranthan', 'NORTH LINE', 'URBAN'),
(275, 'EPS', 'MAIN', 'Elephant pass', 'NORTH LINE', 'URBAN'),
(276, 'PAL', 'MAIN', 'Pallai', 'NORTH LINE', 'URBAN'),
(277, 'EML', 'SUB', 'Eluthumattuval', 'NORTH LINE', 'URBAN'),
(278, 'MSL', 'SUB', 'Mirusuvil', 'NORTH LINE', 'URBAN'),
(279, 'KKM', 'MAIN', 'Kodikamam', 'NORTH LINE', 'URBAN'),
(280, 'MES', 'SUB', 'Meesalai', 'NORTH LINE', 'URBAN'),
(281, 'SAK', 'SUB', 'Sankaththanai', 'NORTH LINE', 'URBAN'),
(282, 'CCH', 'MAIN', 'Chavakachcheri', 'NORTH LINE', 'URBAN'),
(283, 'TPH', 'SUB', 'Thachchanthoppu', 'NORTH LINE', 'URBAN'),
(284, 'NVT', 'MAIN', 'Navatkuli', 'NORTH LINE', 'URBAN'),
(285, 'PNK', 'SUB', 'Pungankulam', 'NORTH LINE', 'URBAN'),
(286, 'JFN', 'MAIN', 'Jaffna', 'NORTH LINE', 'URBAN'),
(287, 'KKV', 'SUB', 'Kokuvil', 'NORTH LINE', 'URBAN'),
(288, 'KDV', 'MAIN', 'Kondavil', 'NORTH LINE', 'URBAN'),
(289, 'INL', 'SUB', 'Inuvil', 'NORTH LINE', 'URBAN'),
(290, 'CKM', 'MAIN', 'Chunnakam', 'NORTH LINE', 'URBAN'),
(291, 'MAL', 'SUB', 'Mallakam', 'NORTH LINE', 'URBAN'),
(292, 'TPI', 'SUB', 'Tellipallai', 'NORTH LINE', 'URBAN'),
(293, 'MVT', 'SUB', 'Mavittapuram', 'NORTH LINE', 'URBAN'),
(294, 'CFS', 'SUB', 'Kan. cement fac. sid.', 'NORTH LINE', 'URBAN'),
(295, 'KKS', 'MAIN', 'Kankesantural', 'NORTH LINE', 'URBAN'),
(296, 'BSL', 'MAIN', 'Baseline road', 'KV LINE', 'SUBURBAN'),
(297, 'CRD', 'SUB', 'Cotta road', 'KV LINE', 'SUBURBAN'),
(298, 'NHP', 'MAIN', 'Narahenpita', 'KV LINE', 'SUBURBAN'),
(299, 'KPE', 'SUB', 'Kirillapone', 'KV LINE', 'SUBURBAN'),
(300, 'NUG', 'MAIN', 'Nugegoda', 'KV LINE', 'SUBURBAN'),
(301, 'PRW', 'SUB', 'Pangiriwatta', 'KV LINE', 'SUBURBAN'),
(302, 'UHM', 'SUB', 'Udahamulla', 'KV LINE', 'SUBURBAN'),
(303, 'NWN', 'SUB', 'Navinna', 'KV LINE', 'SUBURBAN'),
(304, 'MAG', 'MAIN', 'Maharagama', 'KV LINE', 'SUBURBAN'),
(305, 'PAN', 'SUB', 'Pannipitiya', 'KV LINE', 'SUBURBAN'),
(306, 'KOT', 'MAIN', 'Kottwa', 'KV LINE', 'SUBURBAN'),
(307, 'MPL', 'SUB', 'Malapalla', 'KV LINE', 'SUBURBAN'),
(308, 'MKB', 'MAIN', 'Makubura', 'KV LINE', 'SUBURBAN'),
(309, 'HHR', 'SUB', 'Homagama hospital road', 'KV LINE', 'SUBURBAN'),
(310, 'HMA', 'MAIN', 'Homagama ', 'KV LINE', 'SUBURBAN'),
(311, 'PNG', 'SUB', 'Panagoda', 'KV LINE', 'SUBURBAN'),
(312, 'GGA', 'SUB', 'Godagama', 'KV LINE', 'SUBURBAN'),
(313, 'MGD', 'MAIN', 'Meegoda', 'KV LINE', 'SUBURBAN'),
(314, 'WAK', 'SUB', 'Watareka', 'KV LINE', 'SUBURBAN'),
(315, 'X01', 'HALT', 'Lyanwala', 'KV LINE', 'SUBURBAN'),
(316, 'PDK', 'MAIN', 'Padukka', 'KV LINE', 'SUBURBAN'),
(317, 'ARW', 'SUB', 'Arukwatte', 'KV LINE', 'URBAN'),
(318, 'AGP', 'SUB', 'Angampitiya', 'KV LINE', 'URBAN'),
(319, 'UGL', 'SUB', 'Uggalla', 'KV LINE', 'URBAN'),
(320, 'PNW', 'SUB', 'Pinnawala', 'KV LINE', 'URBAN'),
(321, 'GMA', 'SUB', 'Gammana', 'KV LINE', 'URBAN'),
(322, 'MRK', 'SUB', 'Morakele', 'KV LINE', 'URBAN'),
(323, 'WGG', 'MAIN', 'Waga', 'KV LINE', 'URBAN'),
(324, 'KDG', 'SUB', 'Kadugoda', 'KV LINE', 'URBAN'),
(325, 'X02', 'HALT', 'Arapangama', 'KV LINE', 'URBAN'),
(326, 'KSG', 'MAIN', 'Kosgama', 'KV LINE', 'URBAN'),
(327, 'X03', 'HALT', 'Aluth ambalama', 'KV LINE', 'URBAN'),
(328, 'X04', 'HALT', 'Miriswaththa', 'KV LINE', 'URBAN'),
(329, 'X05', 'HALT', 'Higurala', 'KV LINE', 'URBAN'),
(330, 'PWP', 'SUB', 'Puwakpitiya', 'KV LINE', 'URBAN'),
(331, 'X06', 'HALT', 'Puwakpitiya new town', 'KV LINE', 'URBAN'),
(332, 'X07', 'HALT', 'Kiriwandala', 'KV LINE', 'URBAN'),
(333, 'AVS', 'MAIN', 'Avissawella', 'KV LINE', 'URBAN'),
(334, 'NYK', 'SUB', 'Neriyakulam', 'THLAIMANNAR LINE', 'URBAN'),
(335, 'CDK', 'MAIN', 'Cheddikulam', 'THLAIMANNAR LINE', 'URBAN'),
(336, 'MRD', 'MAIN', 'Madhu road', 'THLAIMANNAR LINE', 'URBAN'),
(337, 'MUK', 'MAIN', 'Murunkan', 'THLAIMANNAR LINE', 'URBAN'),
(338, 'MTM', 'SUB', 'Mathottam', 'THLAIMANNAR LINE', 'URBAN'),
(339, 'TVM', 'SUB', 'Thiruketheeswaram', 'THLAIMANNAR LINE', 'URBAN'),
(340, 'MAN', 'MAIN', 'Mannar', 'THLAIMANNAR LINE', 'URBAN'),
(341, 'TDV', 'SUB', 'Thoddaweli', 'THLAIMANNAR LINE', 'URBAN'),
(342, 'PES', 'MAIN', 'Pesalai', 'THLAIMANNAR LINE', 'URBAN'),
(343, 'TLM', 'MAIN', 'Talaimannar', 'THLAIMANNAR LINE', 'URBAN'),
(344, 'TMP', 'MAIN', 'Talaimannar pier', 'THLAIMANNAR LINE', 'URBAN'),
(345, 'FOT', 'MAIN', 'Colombo fort', 'COAST LINE', 'SUBURBAN'),
(346, 'SCR', 'SUB', 'Secretariat halt', 'COAST LINE', 'SUBURBAN'),
(347, 'KPN', 'MAIN', 'Kompannavidiya', 'COAST LINE', 'SUBURBAN'),
(348, 'KLP', 'MAIN', 'Kollupitiya', 'COAST LINE', 'SUBURBAN'),
(349, 'BPT', 'MAIN', 'Bambalapitiya', 'COAST LINE', 'SUBURBAN'),
(350, 'WTE', 'MAIN', 'Wellawatte', 'COAST LINE', 'SUBURBAN'),
(351, 'DWL', 'MAIN', 'Dehiwala', 'COAST LINE', 'SUBURBAN'),
(352, 'MLV', 'MAIN', 'Mount lavinia', 'COAST LINE', 'SUBURBAN'),
(353, 'RML', 'MAIN', 'Ratmalana', 'COAST LINE', 'SUBURBAN'),
(354, 'AGL', 'MAIN', 'Angulana', 'COAST LINE', 'SUBURBAN'),
(355, 'LNA', 'MAIN', 'Lunawa', 'COAST LINE', 'SUBURBAN'),
(356, 'MRT', 'MAIN', 'Moratuwa', 'COAST LINE', 'SUBURBAN'),
(357, 'KOR', 'SUB', 'Koralawella', 'COAST LINE', 'SUBURBAN'),
(358, 'EYA', 'MAIN', 'Egoda uyana', 'COAST LINE', 'SUBURBAN'),
(359, 'PND', 'MAIN', 'Panadura', 'COAST LINE', 'SUBURBAN'),
(360, 'PIN', 'SUB', 'Pinwatte', 'COAST LINE', 'SUBURBAN'),
(361, 'WDA', 'MAIN', 'Wadduwa', 'COAST LINE', 'SUBURBAN'),
(362, 'TRH', 'SUB', 'Train halt no 1', 'COAST LINE', 'SUBURBAN'),
(363, 'KTN', 'MAIN', 'Kalutara north', 'COAST LINE', 'SUBURBAN'),
(364, 'KTS', 'MAIN', 'Kalutara south', 'COAST LINE', 'SUBURBAN'),
(365, 'KKD', 'SUB', 'Katukurunda', 'COAST LINE', 'SUBURBAN'),
(366, 'PGN', 'SUB', 'Payagala north', 'COAST LINE', 'SUBURBAN'),
(367, 'PGS', 'MAIN', 'Payagala south', 'COAST LINE', 'SUBURBAN'),
(368, 'MGN', 'SUB', 'Maggona', 'COAST LINE', 'SUBURBAN'),
(369, 'BRL', 'MAIN', 'Beruwala', 'COAST LINE', 'SUBURBAN'),
(370, 'HML', 'SUB', 'Hettimulla', 'COAST LINE', 'SUBURBAN'),
(371, 'ALT', 'MAIN', 'Aluthgama', 'COAST LINE', 'SUBURBAN'),
(372, 'BNT', 'SUB', 'Benthota', 'COAST LINE', 'URBAN'),
(373, 'IDA', 'MAIN', 'Induruwa', 'COAST LINE', 'URBAN'),
(374, 'MWA', 'SUB', 'Maha induruwa', 'COAST LINE', 'URBAN'),
(375, 'KDA', 'MAIN', 'Kosgoda', 'COAST LINE', 'URBAN'),
(376, 'PYA', 'SUB', 'Piyagama', 'COAST LINE', 'URBAN'),
(377, 'AUH', 'MAIN', 'Ahungalla', 'COAST LINE', 'URBAN'),
(378, 'PGD', 'SUB', 'Patha gangoda', 'COAST LINE', 'URBAN'),
(379, 'BPA', 'MAIN', 'Balapitiya', 'COAST LINE', 'URBAN'),
(380, 'AND', 'SUB', 'Andadola', 'COAST LINE', 'URBAN'),
(381, 'KGD', 'SUB', 'Kandegoda', 'COAST LINE', 'URBAN'),
(382, 'ABA', 'MAIN', 'Ambalangoda', 'COAST LINE', 'URBAN'),
(383, 'MPA', 'SUB', 'Madampagama', 'COAST LINE', 'URBAN'),
(384, 'AKU', 'SUB', 'Akurala', 'COAST LINE', 'URBAN'),
(385, 'KWE', 'MAIN', 'Kahawa', 'COAST LINE', 'URBAN'),
(386, 'TWT', 'SUB', 'Telwatte', 'COAST LINE', 'URBAN'),
(387, 'SMA', 'SUB', 'Seenigama', 'COAST LINE', 'URBAN'),
(388, 'HKD', 'MAIN', 'Hikkaduwa', 'COAST LINE', 'URBAN'),
(389, 'TNA', 'SUB', 'Thiranagama', 'COAST LINE', 'URBAN'),
(390, 'KMK', 'SUB', 'Kumarakanda', 'COAST LINE', 'URBAN'),
(391, 'DNA', 'MAIN', 'Dodanduwa', 'COAST LINE', 'URBAN'),
(392, 'RTG', 'SUB', 'Ratgama', 'COAST LINE', 'URBAN'),
(393, 'BSH', 'MAIN', 'Boosa', 'COAST LINE', 'URBAN'),
(394, 'GNT', 'MAIN', 'Gintota', 'COAST LINE', 'URBAN'),
(395, 'PGM', 'SUB', 'Piyadigama', 'COAST LINE', 'URBAN'),
(396, 'RCH', 'SUB', 'Richmond hill', 'COAST LINE', 'URBAN'),
(397, 'GLE', 'MAIN', 'Galle', 'COAST LINE', 'URBAN'),
(398, 'KUG', 'MAIN', 'Katugoda', 'COAST LINE', 'URBAN'),
(399, 'UNW', 'SUB', 'Unawatuna', 'COAST LINE', 'URBAN'),
(400, 'TLP', 'MAIN', 'Talpe', 'COAST LINE', 'URBAN'),
(401, 'HBD', 'SUB', 'Habaraduwa', 'COAST LINE', 'URBAN'),
(402, 'KOG', 'MAIN', 'Koggala', 'COAST LINE', 'URBAN'),
(403, 'KTL', 'SUB', 'Kathaluwa', 'COAST LINE', 'URBAN'),
(404, 'ANM', 'MAIN', 'Ahangama', 'COAST LINE', 'URBAN'),
(405, 'MED', 'SUB', 'Midigama', 'COAST LINE', 'URBAN'),
(406, 'KMB', 'SUB', 'Kumbalagama', 'COAST LINE', 'URBAN'),
(407, 'WLM', 'MAIN', 'Weligama', 'COAST LINE', 'URBAN'),
(408, 'PLR', 'SUB', 'Polwathu modara', 'COAST LINE', 'URBAN'),
(409, 'MIS', 'SUB', 'Mirissa', 'COAST LINE', 'URBAN'),
(410, 'KMG', 'MAIN', 'Kamburugamuwa', 'COAST LINE', 'URBAN'),
(411, 'WLG', 'SUB', 'Walgama', 'COAST LINE', 'URBAN'),
(412, 'MTR', 'MAIN', 'Matara', 'COAST LINE', 'URBAN'),
(413, 'PLD', 'SUB', 'Piladuwa', 'COAST LINE', 'URBAN'),
(414, 'WEH', 'SUB', 'Werahena', 'COAST LINE', 'URBAN'),
(415, 'KEK', 'MAIN', 'Kakanadura', 'COAST LINE', 'URBAN'),
(416, 'BAM', 'MAIN', 'Babaranda', 'COAST LINE', 'URBAN'),
(417, 'WEW', 'SUB', 'Wawrukannala', 'COAST LINE', 'URBAN'),
(418, 'BEL', 'MAIN', 'Beliaththa', 'COAST LINE', 'URBAN');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `user_type` enum('station_master','fire_company','scale_company','admin') DEFAULT NULL,
  `station` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `user_name`, `password`, `email`, `phone`, `user_type`, `station`) VALUES
(16, 'admin', '$2y$10$pnAvoxLtk6QJmEKA5UVAzucPHznCHMV0J70Mr1GQh9oSGNdiE0gbu', 'mohamedasmeer325@gmail.com', '0723796453', 'admin', NULL),
(15, 'scale', '$2y$10$0qGAwSj0tPz8lHkGesqIjuWwSwpgJXW4ytzd2.fcBW4eA4rhb/CwO', 'mohamedasmeer325@gmail.com', '0723796453', 'scale_company', NULL),
(14, 'fire', '$2y$10$iYkbc5emMgpIH325IQqU5eZw6lhzMNVJE2egaOvEuXVDPX3mwgdbG', 'mohamedasmeer325@gmail.com', '0723796453', 'fire_company', NULL),
(13, 'user', '$2y$10$cw3OrYM8AgJqUA0o1nj2muEaLX3mJmGHsQblAUR7J1E0QmhuiioMa', 'mohamedasmeer325@gmail.com', '0723796453', 'station_master', 'Colombo fort'),
(9, 'aaa', '$2y$10$lCEiBJS3mXK9D9MWeZUj8O2lkkWltDDK4tzew9Ho1lPNm5iZPFgVq', 'mohamedasmeer325@gmail.com', '0723796453', 'station_master', 'Maradana'),
(10, 'nf', '$2y$10$Mux0OxlWcxhwqd7LAtMnZ.f2NMxPonsb2tAUeDWGeqc1z/jIzyDB2', 'mohamedasmeer325@gmail.com', '0723796453', 'station_master', 'Dematagoda'),
(12, 'vhgf', '$2y$10$LuSQgpCK9uXA9goYkXbbeOlKSR/zQ/rUJyryQ0hr5wdZ3HOcq2KyO', 'mohamedasmeer325@gmail.com', '0723796453', 'station_master', 'Ragama');

-- --------------------------------------------------------

--
-- Table structure for table `weight_scales`
--

CREATE TABLE `weight_scales` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(50) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `model` varchar(100) DEFAULT NULL,
  `capacity` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `installation_date` date DEFAULT NULL,
  `status` enum('Active','NeedRepair') DEFAULT 'Active',
  `conditions` enum('Good','NeedRepair') DEFAULT 'Good',
  `inspection_frequency` enum('Monthly','Annually') DEFAULT 'Annually',
  `display_type` enum('Manual','Digital') DEFAULT 'Digital',
  `weight` decimal(10,2) DEFAULT NULL,
  `power_source` varchar(50) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  `station_name` varchar(100) DEFAULT NULL,
  `platform` varchar(100) DEFAULT NULL,
  `enter_by` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight_scales`
--

INSERT INTO `weight_scales` (`id`, `serial_number`, `brand`, `model`, `capacity`, `location`, `installation_date`, `status`, `conditions`, `inspection_frequency`, `display_type`, `weight`, `power_source`, `additional_notes`, `station_name`, `platform`, `enter_by`) VALUES
(10, '0013', 'test', 'gy', 'hgyyt', 'ft', '2025-01-09', 'Active', 'Good', '', 'Manual', '0.00', 'battery', 'bh', 'Colombo Fort', NULL, 'user'),
(9, '0004', 'kkkkkkk', 'llllll', 'hgyyt', 'ft', '2025-01-30', 'Active', 'Good', '', 'Manual', '0.00', 'battery', 'bh', 'Colombo Fort', NULL, 'user'),
(8, '0002', 'test', 'gy', 'hgyyt', 'ft', '2025-01-11', 'Active', 'Good', '', 'Manual', '0.00', 'battery', 'ft', 'Maradana', NULL, 'aaa'),
(7, '0001', 'test', 'gy', 'hgyyt', 'ft', '2025-01-23', 'Active', 'Good', 'Monthly', 'Manual', '0.00', 'battery', 'bvg', '1', NULL, 'aaa'),
(11, '0003', 'test', 'gy', 'hgyyt', 'ft', '2025-01-25', 'Active', 'Good', '', 'Manual', '0.00', 'battery', 'ghfg', 'Colombo Fort', NULL, 'user'),
(12, '0009', 'test', 'gy', 'hgyyt', 'ft', '2025-01-09', 'Active', 'Good', 'Annually', 'Digital', '0.00', 'battery', 'ghgjh', 'Colombo Fort', NULL, 'user'),
(13, '0045', 'test', 'gy', 'hgyyt', 'ft', '2025-02-06', 'Active', 'Good', 'Annually', 'Manual', '0.00', 'ac', 'njhh', 'Colombo Fort', NULL, 'user'),
(14, '0046', 'test', 'gy', 'hgyyt', 'ft', '2025-01-16', 'Active', 'Good', 'Annually', 'Manual', '50.00', 'battery', 'vgvn', 'Colombo Fort', NULL, 'user'),
(15, '97', 'kjh', 'ghhj', '150', 'ghf', '2024-01-01', 'Active', 'Good', '', 'Manual', '65.00', 'battery', 'huchcu', 'Colombo Fort', NULL, 'user'),
(16, '99', 'kjh', 'ghj', '400', 'fgdh', '2024-01-01', 'Active', 'Good', 'Monthly', 'Manual', '125.00', 'battery', 'bjhffx', 'Colombo Fort', NULL, 'user'),
(17, '0100', 'jxuchx', 'jivh', '400', 'hhxv', '2021-01-01', '', '', 'Annually', 'Digital', '560.00', 'powered', 'cs', 'Colombo Fort', NULL, 'user'),
(18, '0101', 'nhcvh', 'jkvhj', '1000', 'jccjc', '2021-01-01', 'NeedRepair', 'NeedRepair', 'Annually', 'Digital', '150.00', 'ac', 'ccghcg', 'Colombo Fort', NULL, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `weight_scales_history`
--

CREATE TABLE `weight_scales_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `maintenance_type` varchar(100) DEFAULT NULL,
  `service_provider` varchar(100) DEFAULT NULL,
  `maintenance_date` date DEFAULT NULL,
  `next_scheduled_maintenance` date DEFAULT NULL,
  `maintenance_results` text DEFAULT NULL,
  `repair_details` text DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `status` enum('Completed','Pending') DEFAULT 'Pending',
  `additional_notes` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight_scales_history`
--

INSERT INTO `weight_scales_history` (`id`, `item_id`, `maintenance_type`, `service_provider`, `maintenance_date`, `next_scheduled_maintenance`, `maintenance_results`, `repair_details`, `cost`, `status`, `additional_notes`) VALUES
(1, 7, NULL, NULL, '2025-02-06', '2025-05-06', NULL, NULL, NULL, 'Pending', NULL),
(2, 8, NULL, NULL, '2025-02-13', '2025-05-13', NULL, NULL, NULL, 'Pending', NULL),
(3, 7, 'Recharging', NULL, '2025-02-14', '2025-05-14', NULL, NULL, NULL, 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `weight_scales_invoice`
--

CREATE TABLE `weight_scales_invoice` (
  `id` int(11) NOT NULL,
  `repair_request_id` int(11) NOT NULL,
  `invoice_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `invoice_attachment` text DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Overdue') DEFAULT 'Pending',
  `remarks` text DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approval_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight_scales_invoice`
--

INSERT INTO `weight_scales_invoice` (`id`, `repair_request_id`, `invoice_date`, `amount`, `invoice_attachment`, `payment_status`, `remarks`, `paid_date`, `approved_by`, `approval_date`) VALUES
(1, 5, '2025-02-23', '5000.00', '../uploads/quotation_67bb30809b236.pdf', 'Paid', 'ddfgf', NULL, 'user', '2025-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `weight_scales_quotations`
--

CREATE TABLE `weight_scales_quotations` (
  `id` int(11) NOT NULL,
  `repair_request_id` int(11) NOT NULL,
  `quotation_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `quotation_attachment` text DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `approval_date` date DEFAULT NULL,
  `payment_status` enum('Pending','Paid','In Progress') DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight_scales_quotations`
--

INSERT INTO `weight_scales_quotations` (`id`, `repair_request_id`, `quotation_date`, `amount`, `quotation_attachment`, `remarks`, `approved_by`, `approval_date`, `payment_status`) VALUES
(7, 5, '2025-01-31', '555.00', '../uploads/quotation_679ca2ae6dd01.pdf', 'mbjm', NULL, NULL, 'Paid'),
(6, 6, '2025-01-31', '4000.00', '../uploads/quotation_679ca1b0dfe9e.pdf', 'vgh', NULL, NULL, 'Pending'),
(5, 7, '2025-01-31', '4000.00', '../uploads/quotation_679c9c52b321a.pdf', 'ghubg', NULL, NULL, 'Pending'),
(8, 8, '2025-02-01', '5000.00', '../uploads/quotation_679e405eea379.pdf', ' hnvhg', NULL, NULL, 'Pending'),
(9, 8, '2025-02-10', '5000.00', '../uploads/quotation_67aa27952eaca.pdf', 'bnfhg', NULL, NULL, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `weight_scales_requests`
--

CREATE TABLE `weight_scales_requests` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(150) NOT NULL,
  `model` varchar(200) DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `scheduled_service_date` date DEFAULT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `description` text DEFAULT NULL,
  `priority` enum('Low','Medium','High') DEFAULT 'Medium',
  `service_date` date DEFAULT NULL,
  `repair_details` text DEFAULT NULL,
  `cost_estimation` decimal(10,2) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `station_name` varchar(150) NOT NULL,
  `platform_number` varchar(150) DEFAULT NULL,
  `send_by` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `weight_scales_requests`
--

INSERT INTO `weight_scales_requests` (`id`, `serial_number`, `model`, `service_type`, `request_date`, `scheduled_service_date`, `status`, `description`, `priority`, `service_date`, `repair_details`, `cost_estimation`, `quotation_id`, `invoice_id`, `attachments`, `station_name`, `platform_number`, `send_by`) VALUES
(8, '0001', 'gy', 'Repair', '2025-02-01', NULL, 'Pending', 'fhg', 'High', NULL, NULL, NULL, NULL, NULL, NULL, 'Maradana', '', 'aaa'),
(7, '0004', 'gy', 'Recharging', '2025-01-29', NULL, 'Pending', 'bj', 'High', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '', 'user'),
(5, '0004', 'gy', 'Inspection', '2025-01-29', NULL, 'Completed', 'hjd', 'Medium', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '', 'user'),
(6, '0004', 'gy', 'Recharging', '2025-01-29', NULL, 'In Progress', 'bj', 'High', NULL, NULL, NULL, NULL, NULL, NULL, 'Colombo Fort', '', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`CompanyID`);

--
-- Indexes for table `fire_extinguishers`
--
ALTER TABLE `fire_extinguishers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `fk_station_name` (`station_name`),
  ADD KEY `fk_platform` (`platform`);

--
-- Indexes for table `fire_extinguishers_history`
--
ALTER TABLE `fire_extinguishers_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `fire_extinguishers_invoice`
--
ALTER TABLE `fire_extinguishers_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_request_id` (`repair_request_id`);

--
-- Indexes for table `fire_extinguishers_quotations`
--
ALTER TABLE `fire_extinguishers_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_request_id` (`repair_request_id`);

--
-- Indexes for table `fire_extinguishers_requests`
--
ALTER TABLE `fire_extinguishers_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`serial_number`),
  ADD KEY `fk_station_id` (`station_name`),
  ADD KEY `fk_platform_id` (`platform_number`);

--
-- Indexes for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD PRIMARY KEY (`M_ScheduleID`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`platform_id`),
  ADD KEY `station_id` (`StationID`);

--
-- Indexes for table `station`
--
ALTER TABLE `station`
  ADD PRIMARY KEY (`StationID`),
  ADD UNIQUE KEY `station_code` (`station_code`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `weight_scales`
--
ALTER TABLE `weight_scales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `serial_number` (`serial_number`),
  ADD KEY `fk_station_name` (`station_name`),
  ADD KEY `fk_platform` (`platform`);

--
-- Indexes for table `weight_scales_history`
--
ALTER TABLE `weight_scales_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `weight_scales_invoice`
--
ALTER TABLE `weight_scales_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_request_id` (`repair_request_id`);

--
-- Indexes for table `weight_scales_quotations`
--
ALTER TABLE `weight_scales_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_request_id` (`repair_request_id`);

--
-- Indexes for table `weight_scales_requests`
--
ALTER TABLE `weight_scales_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`serial_number`),
  ADD KEY `fk_station_id` (`station_name`),
  ADD KEY `fk_platform_id` (`platform_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `CompanyID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fire_extinguishers`
--
ALTER TABLE `fire_extinguishers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `fire_extinguishers_history`
--
ALTER TABLE `fire_extinguishers_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fire_extinguishers_invoice`
--
ALTER TABLE `fire_extinguishers_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `fire_extinguishers_quotations`
--
ALTER TABLE `fire_extinguishers_quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fire_extinguishers_requests`
--
ALTER TABLE `fire_extinguishers_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  MODIFY `M_ScheduleID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `platform_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `station`
--
ALTER TABLE `station`
  MODIFY `StationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `weight_scales`
--
ALTER TABLE `weight_scales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `weight_scales_history`
--
ALTER TABLE `weight_scales_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `weight_scales_invoice`
--
ALTER TABLE `weight_scales_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `weight_scales_quotations`
--
ALTER TABLE `weight_scales_quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `weight_scales_requests`
--
ALTER TABLE `weight_scales_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
