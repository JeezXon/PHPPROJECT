-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 02:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `agent_name` varchar(255) NOT NULL,
  `agent_uname` varchar(255) NOT NULL,
  `agent_pass` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent_name`, `agent_uname`, `agent_pass`) VALUES
(23, 'Mathew Laresma', 'mat', 'mat123');

-- --------------------------------------------------------

--
-- Table structure for table `agent_user`
--

CREATE TABLE `agent_user` (
  `ID` int(11) DEFAULT NULL,
  `ATicket_num` varchar(255) DEFAULT NULL,
  `Clients_Aname` varchar(255) DEFAULT NULL,
  `Agent_Aname` varchar(255) DEFAULT NULL,
  `Aconcern` varchar(255) NOT NULL,
  `Aseverity` varchar(255) NOT NULL,
  `Adate_start` varchar(255) NOT NULL,
  `Adate_F` varchar(255) NOT NULL,
  `Astatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agent_user`
--

INSERT INTO `agent_user` (`ID`, `ATicket_num`, `Clients_Aname`, `Agent_Aname`, `Aconcern`, `Aseverity`, `Adate_start`, `Adate_F`, `Astatus`) VALUES
(NULL, '211', 'Joie', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-30', 'Ongoing'),
(NULL, '209', 'Folland Yamba', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-30', 'Done'),
(NULL, '213', 'Folland Yamba', 'Mathew Laresma', 'Code error', 'Severe', '2024-10-18', '2024-10-31', 'Done'),
(NULL, '215', 'Joie', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-19', 'Done');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `Client_name` varchar(255) DEFAULT NULL,
  `concern` varchar(255) DEFAULT NULL,
  `contact_num` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`Client_name`, `concern`, `contact_num`, `email`, `id`) VALUES
('Folland Yamba', NULL, '09999812241', 'yamba@gmail.com', 31),
('Joie', NULL, '09999812241', 'joie@gmail.com', 32);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Ticket_num` int(11) NOT NULL,
  `Client_Name` varchar(2552) NOT NULL,
  `Agent_Name` varchar(255) NOT NULL,
  `Concern` varchar(255) NOT NULL,
  `Severity` varchar(255) NOT NULL,
  `Date_start` date NOT NULL,
  `Date_end` date NOT NULL,
  `Sttus` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `Ticket_tnum` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `client_tname` varchar(255) NOT NULL,
  `agent_tname` varchar(255) NOT NULL,
  `tconcern` varchar(255) NOT NULL,
  `severity` varchar(50) DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`Ticket_tnum`, `id`, `client_tname`, `agent_tname`, `tconcern`, `severity`, `date_start`, `date_end`) VALUES
(197, 0, 'Arvin Rosal', '', 'Streaming Errors', 'Normal', '0000-00-00', '0000-00-00'),
(198, 0, 'Arvin Rosal', '', 'Streaming Errors', 'Normal', '0000-00-00', '0000-00-00'),
(199, 0, 'Arvin Rosal', 'Carlos Dungog', 'Streaming Errors', 'Medium', '2024-10-20', '2024-11-02'),
(200, 0, 'xon xage', '', 'Device Compatibility Issues', 'Normal', '0000-00-00', '0000-00-00'),
(201, 0, 'xon xage', 'Carlos Dungog', 'Device Compatibility Issues', 'Medium', '2024-10-24', '2024-11-06'),
(202, 0, 'David ', '', 'Connection Loss', 'Normal', '0000-00-00', '0000-00-00'),
(203, 0, 'David ', '', 'Connection Loss', 'Normal', '0000-00-00', '0000-00-00'),
(204, 0, 'David ', 'Francis Falar', 'Connection Loss', 'Medium', '2024-10-18', '2024-10-30'),
(205, 0, 'Joie', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(206, 0, 'David ', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(207, 0, 'David ', 'Mathew Laresma', '', 'Severe', '2024-10-18', '2024-10-25'),
(208, 0, 'Folland Yamba', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(209, 0, 'Folland Yamba', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-30'),
(210, 0, 'Joie', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(211, 0, 'Joie', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-30'),
(212, 0, 'Folland Yamba', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(213, 0, 'Folland Yamba', 'Mathew Laresma', 'Code error', 'Severe', '2024-10-18', '2024-10-31'),
(214, 0, 'Joie', '', '', 'Normal', '0000-00-00', '0000-00-00'),
(215, 0, 'Joie', 'Mathew Laresma', 'Misleading statement of account', 'Severe', '2024-10-18', '2024-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_counter`
--

CREATE TABLE `ticket_counter` (
  `id` int(11) NOT NULL,
  `current_ticket_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_counter`
--

INSERT INTO `ticket_counter` (`id`, `current_ticket_number`) VALUES
(2, 215);

-- --------------------------------------------------------

--
-- Table structure for table `usern`
--

CREATE TABLE `usern` (
  `ID` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usern`
--

INSERT INTO `usern` (`ID`, `user_name`, `password`, `name`) VALUES
(1, 'admin', 'xon123', 'Jason');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_counter`
--
ALTER TABLE `ticket_counter`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `ticket_counter`
--
ALTER TABLE `ticket_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
