-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 07:21 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `universitytimetabledb`
--

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE `degree` (
  `degree_type` varchar(20) NOT NULL,
  `degree_type_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`degree_type`, `degree_type_name`) VALUES
('CS', 'Computer Science'),
('CST', 'Computer Science & Technology'),
('CT', 'Computer Technology');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_code` varchar(50) NOT NULL,
  `dept_name` varchar(100) NOT NULL,
  `dept_building` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_code`, `dept_name`, `dept_building`) VALUES
('Eng', 'Department of Language(English)', 'A11'),
('FC', 'Faculty of Computing', 'A9'),
('FCS', 'Faculty of Computer Science', 'A1'),
('FCST', 'Faculty of Computer Science and Technology', 'F3'),
('FIS', 'Faculty of Information Science', 'A5'),
('ITSM', 'Department of Information Technology Supporting and Maintenance', 'F9'),
('Myan', 'Department of Language(Myanmar)', 'A8'),
('Phy', 'Department of Natural Science', 'B5');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`admin_id`, `username`, `password`) VALUES
(2, 'admin', 'Admin2025$'),
(3, 'Admin', 'Admin2025$');

-- --------------------------------------------------------

--
-- Table structure for table `period`
--

CREATE TABLE `period` (
  `pid` int(11) NOT NULL,
  `subperweek` int(11) NOT NULL,
  `periodperday` int(11) NOT NULL,
  `acdyear` varchar(20) NOT NULL,
  `semester` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `period`
--

INSERT INTO `period` (`pid`, `subperweek`, `periodperday`, `acdyear`, `semester`) VALUES
(1, 2, 3, '2025-2026', 'Semester I'),
(2, 2, 3, '2025-2026', 'Semester II');

-- --------------------------------------------------------

--
-- Table structure for table `rank_db`
--

CREATE TABLE `rank_db` (
  `rank` varchar(50) NOT NULL,
  `rank_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rank_db`
--

INSERT INTO `rank_db` (`rank`, `rank_code`) VALUES
('Assistant Lecturer', 'AL'),
('Associate Professor', 'AP'),
('Lecturer', 'L'),
('Professor', 'P'),
('Tutor', 'T');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(6) NOT NULL,
  `section_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `section_name`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `sub_id` int(6) NOT NULL,
  `scode` varchar(20) NOT NULL,
  `sname` varchar(100) NOT NULL,
  `year_id` int(11) NOT NULL,
  `pre_requisite` varchar(20) NOT NULL,
  `credit_unit` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `dept_code` varchar(20) NOT NULL,
  `degree_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subject`
--

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int(6) NOT NULL,
  `tname` varchar(100) NOT NULL,
  `rank` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `address` varchar(250) NOT NULL,
  `dept_code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacher`
--


--
-- Table structure for table `teaches`
--

CREATE TABLE `teaches` (
  `teaches_id` int(6) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `year_id` int(11) NOT NULL,
  `teacher_name` varchar(50) NOT NULL,
  `dept_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teaches`
--


--
-- Table structure for table `timetable`
--

CREATE TABLE `timetable` (
  `id` int(11) NOT NULL,
  `day` varchar(20) DEFAULT NULL,
  `period1` varchar(100) DEFAULT NULL,
  `period2` varchar(100) DEFAULT NULL,
  `period3` varchar(100) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `timetable`
--


--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `year`
--

CREATE TABLE `year` (
  `year_id` int(6) NOT NULL,
  `year_name` varchar(50) NOT NULL,
  `acdyear` varchar(20) NOT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `year`
--

INSERT INTO `year` (`year_id`, `year_name`, `acdyear`, `semester`) VALUES
(1, 'First Year', '2025-2026', 'Semester I'),
(2, 'First Year', '2025-2026', 'Semester II'),
(3, 'Second Year(CS)', '2025-2026', 'Semester I'),
(4, 'Second year(CS)', '2025-2026', 'Semester II'),
(5, 'Second Year(CT)', '2025-2026', 'Semester I'),
(6, 'Second Year(CT)', '2025-2026', 'Semester II'),
(7, 'Third Year(CS)', '2025-2026', 'Semester I'),
(8, 'Third Year(CS)', '2025-2026', 'Semester II'),
(9, 'Third Year(CT)', '2025-2026', 'Semester I'),
(10, 'Third Year(CT)', '2025-2026', 'Semester II'),
(11, 'Fourth Year(CS)', '2025-2026', 'Semester I'),
(12, 'Fourth Year(CS)', '2025-2026', 'Semester II'),
(13, 'Fourth Year(CT)', '2025-2026', 'Semester I'),
(14, 'Fourth Year(CT)', '2025-2026', 'Semester II'),
(15, 'Fifth Year(CS)', '2025-2026', 'Semester I'),
(16, 'Fifth Year(CT)', '2025-2026', 'Semester I'),
(21, 'Master(CS)', '2025-2026', 'Semester I'),
(22, 'Master(CT)', '2025-2026', 'Semester I');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`degree_type`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_code`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `period`
--
ALTER TABLE `period`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `rank_db`
--
ALTER TABLE `rank_db`
  ADD PRIMARY KEY (`rank_code`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`sub_id`),
  ADD KEY `degree_type` (`degree_type`),
  ADD KEY `dept_code` (`dept_code`),
  ADD KEY `year_id` (`year_id`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `Rank Name` (`rank`),
  ADD KEY `dept_code` (`dept_code`);

--
-- Indexes for table `teaches`
--
ALTER TABLE `teaches`
  ADD PRIMARY KEY (`teaches_id`),
  ADD KEY `sub_id` (`sub_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `timetable`
--
ALTER TABLE `timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year`
--
ALTER TABLE `year`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `period`
--
ALTER TABLE `period`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `sub_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `teaches`
--
ALTER TABLE `teaches`
  MODIFY `teaches_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=542;

--
-- AUTO_INCREMENT for table `timetable`
--
ALTER TABLE `timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `year`
--
ALTER TABLE `year`
  MODIFY `year_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `degree_type` FOREIGN KEY (`degree_type`) REFERENCES `degree` (`degree_type`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `year_id` FOREIGN KEY (`year_id`) REFERENCES `year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `dept_code` FOREIGN KEY (`dept_code`) REFERENCES `department` (`dept_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
