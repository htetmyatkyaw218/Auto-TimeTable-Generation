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

INSERT INTO `subject` (`sub_id`, `scode`, `sname`, `year_id`, `pre_requisite`, `credit_unit`, `type`, `dept_code`, `degree_type`) VALUES
(1, 'M-1101', 'Myanmar', 1, '-', 3, 'Core', 'Myan', 'CST'),
(2, 'E-1101', 'English', 1, '-', 3, 'Core', 'Eng', 'CST'),
(3, 'P-1101', 'Physics', 1, '-', 3, 'Core', 'Phy', 'CST'),
(4, 'CST-1102', 'Principle of Information Technology', 1, '-', 3, 'Core', 'FCS,FCST', 'CST'),
(5, 'CST-1141', 'Mathematics of Computing(Calculus I)', 1, '-', 3, 'Core', 'FC', 'CST'),
(7, 'M-1201', 'Myanmar', 2, '-', 3, 'Core', 'Myan', 'CST'),
(8, 'E-1201', 'English', 2, '-', 3, 'Core', 'Eng', 'CST'),
(9, 'P-1201', 'Physics', 2, '-', 3, 'Core', 'Phy', 'CST'),
(10, 'CST-1211', 'Programming Logic & Design(Programming in C++)', 2, '-', 3, 'Core', 'FCS', 'CST'),
(11, 'CST-1242', 'Mathematics of Computing(Discrete I)', 2, '-', 3, 'Core', 'FC', 'CS'),
(12, 'CST(SS-1201)', 'Supporting Skills II(Office 365)', 2, '-', 3, 'Elective', 'ITSM', 'CST'),
(13, 'E-2101', 'English', 3, '-', 3, 'Core', 'Eng', 'CST'),
(14, 'CST-2113', 'Programming Language Skill(Java)', 3, '-', 3, 'Core', 'FCS', 'CST'),
(15, 'CST-2141', 'Calculus II', 3, 'CST-1142', 3, 'Core', 'FC', 'CST'),
(17, 'CST-2124', 'Introduction and Software Engineering', 3, '-', 3, 'Core', 'FIS', 'CST'),
(19, 'E-2101', 'English', 5, '-', 3, 'Core', 'Eng', 'CST'),
(20, 'CST-2113', 'Programming Language Skill(Java)', 5, '-', 3, 'Core', 'FCS', 'CST'),
(21, 'CST-2141', 'Linear Algebra', 5, 'CST-1142', 3, 'Core', 'FC', 'CST'),
(23, 'CST-2124', 'Introduction and Software Engineering', 5, '-', 3, 'Core', 'FIS', 'CST'),
(25, 'CST-3131', 'Computer  Architecture & Organization-I', 7, 'CST-2133', 3, 'Core', 'FCST', 'CST'),
(26, 'CST-3142', 'Numerical Analysis(Numerical methods for Differential Equations) ', 7, 'CST-2142', 3, 'Core', 'FC', 'CST'),
(27, 'CST-3113', 'Artificial Intelligence', 7, 'CST-2133', 3, 'Core', 'FCS', 'CST'),
(28, 'CS-3124', 'Software Analysis and Design', 7, 'CST-2223', 3, 'Core', 'FIS', 'CS'),
(29, 'CS-3125', 'Database System Structure', 7, 'CST-2124', 3, 'Core', 'FIS', 'CS'),
(31, 'CST(SK)-3157', 'Financial management & Accounting', 7, '-', 1, 'Elective', 'ITSM', 'CST'),
(32, 'CST-3131', 'Computer  Architecture & Organization', 9, 'CST-2133', 3, 'Core', 'FCST', 'CST'),
(33, 'CST-3142', 'Numerical Analysis(Numerical methods for Differential Equations', 9, 'CST-2142', 3, 'Core', 'FC', 'CST'),
(34, 'CST-3113', 'Artificial Intelligence', 9, 'CST-2133', 3, 'Core', 'FCS', 'CST'),
(35, 'CT-3134', 'Electronics(Electronic Devices)', 9, 'CT-2234', 3, 'Core', 'FCST', 'CT'),
(36, 'CT-3135', 'Control Systems', 9, '-', 3, 'Core', 'FCST', 'CT'),
(37, 'CT(SK)-3136', 'Linux Fundamentals and Administration', 9, '-', 2, 'Elective', 'FCST', 'CT'),
(38, 'CST(SK)-3157', 'Financial management & Accounting', 9, '-', 1, 'Elective', 'ITSM', 'CST'),
(39, 'E-4101', 'English', 11, '-', 3, 'Core', 'Eng', 'CST'),
(40, 'CST-4111', 'Analysis of Algorithms', 11, 'CST-221', 3, 'Core', 'FCS', 'CST'),
(43, 'CS-4124', 'Information Assurance and Security', 11, '-', 2, 'Core', 'FIS', 'CST'),
(45, 'CS-4142', 'Operations Research', 11, '-', 3, 'Core', 'FC', 'CS'),
(46, 'E-4101', 'English', 13, '-', 3, 'Core', 'Eng', 'CST'),
(47, 'CST-4111', 'Analysis of Algorithms', 13, 'CST-2211', 3, 'Core', 'FCS', 'CST'),
(49, 'CT-4133', 'Computer Networks II', 13, 'CST-3235', 3, 'Core', 'FCST', 'CT'),
(50, 'CT-4134', 'Embedded Systems II', 13, '-', 3, 'Core', 'FCST', 'CT'),
(109, 'CST-2112', 'Data Structures and Algorithms', 3, '', 3, 'Core', 'FCS', 'CS'),
(110, 'CST-2112', 'Data Structures and Algorithms', 5, '', 3, 'Core', 'FCS', 'CT'),
(111, 'CS-4113', 'Computer Vision', 11, '', 3, 'Core', 'FCS', 'CS'),
(112, 'CST-4211', 'Parallel And Distributed Computing', 12, '', 3, 'Core', 'FCS', 'CS'),
(113, 'CST-4211', 'Parallel And Distributed Computing', 14, '', 3, 'Core', 'FCS', 'CT'),
(114, 'CS-4214', 'Advanced Artificial Intelligence', 12, '', 3, 'Core', 'FCS', 'CS'),
(116, 'CS-5112', 'Advanced Artificial Intelligence', 15, '', 3, 'Core', 'FCS', 'CS'),
(117, 'CST-2135', 'Computer Architecture and Organization', 5, '', 3, 'Core', 'FCST', 'CT'),
(119, 'CT-4132', 'Digital Design', 13, '', 3, 'Core', 'FCST', 'CT'),
(120, 'CT-4233', 'Cryptography and Network Security', 14, '', 3, 'Core', 'FCST', 'CT'),
(121, 'CT-4234', 'Embendded Systems Integrating', 14, '', 3, 'Core', 'FCST', 'CT'),
(122, 'CT-4235', 'Signals and Systems', 14, '', 3, 'Core', 'FCST', 'CT'),
(123, 'CT-4236', 'Cyber Security and Ethical Hacking', 14, '', 3, 'Core', 'FCST', 'CT'),
(124, 'CT-5131', 'Digital Forensics', 16, '', 3, 'Core', 'FCST', 'CT'),
(125, 'CT-5132', 'Advanced Networking', 16, '', 3, 'Core', 'FCST', 'CT'),
(126, 'CT-5136', 'Image Processing and Computer Vision', 16, '', 3, 'Core', 'FCST', 'CT'),
(127, 'E-5101', 'English', 15, '', 3, 'Core', 'Eng', 'CS'),
(128, 'E-5101', 'English', 16, '', 3, 'Core', 'Eng', 'CT'),
(129, 'CST-4257', 'Business Information System', 12, '', 3, 'Core', 'ITSM', 'CST'),
(130, 'CST-4257', 'Business Information System', 14, '', 3, 'Core', 'ITSM', 'CST'),
(131, 'CS(SK)-3156', 'Web Development', 7, '', 3, 'Core', 'ITSM', 'CST'),
(133, 'CST-5155', 'Business Information System(ERP)', 15, '', 3, 'Core', 'ITSM', 'CS'),
(134, 'CST-5155', 'Business Information System(ERP)', 16, '', 3, 'Core', 'ITSM', 'CT'),
(135, 'CST-1154', 'Web Development', 1, '', 3, 'Core', 'ITSM', 'CST'),
(136, 'CST-1123', 'Basic Data Processing', 1, '', 3, 'Core', 'FIS', 'CST'),
(137, 'CST-2126', 'Database System Structure', 3, '', 3, 'Core', 'FIS', 'CS'),
(138, 'CST-2126', 'Database System Structure', 5, '', 3, 'Core', 'FIS', 'CT'),
(140, 'CST-4125', 'Software Project management', 13, '', 3, 'Core', 'FIS', 'CT'),
(141, 'CS-4223', 'Object-Oriented Design and Development', 12, '', 3, 'Core', 'FIS', 'CS'),
(142, 'CS-4225', 'Advanced Database System', 12, '', 3, 'Core', 'FIS', 'CS'),
(143, 'CS-5121', 'Cyber Security and Digital Forensics', 15, '', 3, 'Core', 'FIS', 'CST'),
(144, 'CST-5123', 'Data Mining', 15, '', 3, 'Core', 'FIS', 'CS'),
(145, 'CST-5123', 'Data Mining', 16, '', 3, 'Core', 'FIS', 'CT'),
(146, 'CST-4242', 'Modeling and Simulation', 12, '', 3, 'Core', 'FC', 'CST'),
(147, 'CST-4242', 'Modeling and Simulation', 14, '', 3, 'Core', 'FC', 'CT'),
(148, 'CST-6142', 'Mathematics of Computing( VI )', 21, '', 3, 'Core', 'FC', 'CST'),
(150, 'CS-6124', 'Advanced Data Mining', 21, '', 3, 'Core', 'FIS', 'CS'),
(151, 'CST-6155', 'Human-Computer Interaction', 21, '', 3, 'Core', 'ITSM', 'CS'),
(153, 'CST-4125', 'Software Project management', 11, '', 3, 'Core', 'FIS', 'CS'),
(154, 'E-6101', 'English', 21, '', 3, 'Core', 'Eng', 'CST'),
(155, 'CST-6103', 'Strategies For Emerging Technologies', 21, '', 3, 'Core', 'FCS', 'CS'),
(157, 'CST(SK)-6117', 'Social Issues and Professional Practices', 21, '', 3, 'Core', 'FCS', 'CS');

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

INSERT INTO `teacher` (`teacher_id`, `tname`, `rank`, `email`, `ph_no`, `address`, `dept_code`) VALUES
(1, 'Dr. Khin Lay Thwin', 'Professor', 'khinlaythwin@ucspathein.edu.mm', '09254385977', 'Pathein', 'FCS'),
(2, 'Dr.Moe Moe San', 'Associate Professor', 'moemoesan@ucspathein.edu.mm', '09451603599', 'Yangon', 'FCS'),
(3, 'Daw Moe Moe Thu', 'Associate Professor', 'moemoethu@ucspathein.edu.mm', '09-354646666', 'Maubin', 'FCS'),
(4, 'Daw Zin Mie Mie Aung ', 'Assistant Lecturer', 'zinmiemieaung@ucspathein.edu.mm', '09451603599', 'Bogalay', 'FCS'),
(5, 'Daw Ei Ei Aung', 'Lecturer', 'eieiaung@ucspathein.edu.mm', '', '', 'FCS'),
(6, 'Daw May Zin Tun', 'Lecturer', 'mayzintun@ucspathein.edu.mm', '', '', 'FCS'),
(12, 'Dr.Mar Mar Min', 'Professor', 'marmarmin@ucspathein.edu.mm', '', '', 'FCST'),
(13, 'Daw Soe Moe Myint', 'Associate Professor', 'soemoemyint@ucspathein.edu.mm', '', '', 'FCST'),
(14, 'Daw Thin Thin Htwe', 'Associate Professor', 'thinthinhtwe@ucspathein.edu.mm', '', '', 'FCST'),
(15, 'Daw Thandar Aung', 'Lecturer', 'thandaraung@ucspathein.edu.mm', '', '', 'FCST'),
(16, 'Daw Zin May Oo', 'Assistant Lecturer', 'zinmayoo@ucspathein.edu.mm', '', '', 'FCST'),
(17, 'Dr.Yan Naung Soe', 'Lecturer', 'ynsoe@ucspathein.edu.mm', '', '', 'FCST'),
(18, 'Dr.Myat Thiri Khine', 'Professor', 'myatthirikhine@ucspathein.edu.mm', '', '', 'FIS'),
(19, 'Daw Yu Yu Khaing', 'Associate Professor', 'yuyukhaing@ucspathein.edu.mm', '', '', 'FIS'),
(20, 'Daw Win	Mar', 'Lecturer', 'winmaris@ucspathein.edu.mm', '', '', 'FIS'),
(21, 'Dr.Nway Yu Aung', 'Lecturer', 'nwayuaung@ucspathein.edu.mm', '', '', 'FIS'),
(22, 'Daw Lei Yi Htwe', 'Lecturer', 'leiyihtwe@ucspathein.edu.mm', '', '', 'FIS'),
(26, 'Dr.Zin Min Soe', 'Professor', 'zinminsoe@ucspathein.edu.mm', '', '', 'FC'),
(27, 'Daw Aye Aye Khaing', 'Associate Professor', 'ayeayekhaing@ucspathein.edu.mm', '', '', 'FC'),
(28, 'Daw San San Myint', 'Lecturer', 'sansanmyint@ucspathein.edu.mm', '', '', 'FC'),
(29, 'Daw Thandar	Soe', 'Lecturer', 'thandarsoe@ucspathein.edu.mm', '', '', 'FC'),
(30, 'Daw Thin Thin	Hlaing', 'Lecturer', 'thinthinhlaing@ucspathein.edu.mm', '', '', 'FC'),
(31, 'Daw Ngu War	Khin', 'Lecturer', 'nguwarkhin@ucspathein.edu.mm', '', '', 'FC'),
(32, 'Daw Zar Ni Win', 'Lecturer', 'zarniwin@ucspathein.edu.mm', '', '', 'FC'),
(33, 'Daw Moe Moe Myint', 'Associate Professor', 'moemoemyint@ucspathein.edu.mm', '', '', 'ITSM'),
(35, 'Daw Chaw Su	Han', 'Associate Professor', 'chawsuhan@ucspathein.edu.mm', '', '', 'Eng'),
(36, 'Daw Yin Nyein Aye', 'Lecturer', 'yinnyeinaye@ucspathein.edu.mm', '', '', 'Eng'),
(37, 'Daw Aye Nyeint Nyeint Aung', 'Assistant Lecturer', 'ayenyeintaung@ucspathein.edu.mm', '', '', 'Eng'),
(38, 'Daw Nwe Nwe Aye', 'Assistant Lecturer', 'nwenweaye@ucspathein.edu.mm', '', '', 'Eng'),
(39, 'Daw San San Myaing', 'Associate Professor', 'sansanmyaing@ucspathein.edu.mm', '', '', 'Myan'),
(40, 'Daw Thin Phyu Mhwe', 'Lecturer', 'thinphyumhwe@ucspathein.edu.mm', '', '', 'Myan'),
(41, 'Dr.Sanda Win', 'Professor', 'sandawin@ucspathein.edu.mm', '', '', 'Phy'),
(42, 'Dr.Swe Kyawtt Shinn', 'Associate Professor', 'swekyawttshinn@ucspathein.edu.mm', '', '', 'Phy'),
(43, 'Daw Thiri	Win', 'Lecturer', 'thiriwin@ucspathein.edu.mm', '', '', 'Phy'),
(44, 'Daw Htike Htike Aung', 'Lecturer', 'htikehtikeung@ucspathein.edu.mm', '09-354646666', '', 'Phy'),
(45, 'Daw Kalayar Maw', 'Associate Professor', 'kalayarmaw@ucspathein.edu.mm', '09-254385977', '19 Street, Botahtaung, Yangon', 'Myan'),
(46, 'Daw Phyu Hnin Aye', 'Lecturer', 'phyuhninaye@ucspathein.edu.mm', '09-688552323', 'Min Road, Pathein', 'Eng'),
(47, 'Dr Sandar Win', 'Professor', 'sandaraung@ucspathein.edu.mm', '09451603599', 'Pagoda Road, Bogalay ', 'Phy'),
(48, 'Daw Thandar Win', 'Associate Professor', 'sandaraung@ucspathein.edu.mm', '09-254385977', 'Pagoda Road, Bogalay', 'FCST'),
(49, 'Daw Ei Ei Soe', 'Associate Professor', 'kalayarmaw@ucspathein.edu.mm', '09-451603599', '19 Street, Botahtaung, Yangon', 'FCS'),
(50, 'Daw Aye Aye Mu', 'Associate Professor', 'phyuhninaye@ucspathein.edu.mm', '09-254385977', 'Min Road, Pathein', 'FC'),
(51, 'Daw Kay Kay Moe', 'Professor', 'kalayarmaw@ucspathein.edu.mm', '09-451603599', '19 Street, Botahtaung, Yangon', 'FIS'),
(56, 'Daw Htet Wint Wint Phyo', 'Assistant Lecturer', '', '', 'pathein', 'Eng'),
(57, 'Daw Phyo Ei Mon', 'Lecturer', '', '', 'Pathein', 'Eng'),
(58, 'Daw Cho Mar Kyaw', 'Lecturer', '', '', 'Pathein', 'Phy'),
(59, 'Daw Phyo Chit Chit Po', 'Lecturer', '', '', 'Pathein', 'Phy'),
(60, 'Daw Myint Myint Maw', 'Lecturer', '', '', 'Pathein', 'FC'),
(61, 'Daw Su Mon Hlaing', 'Assistant Lecturer', '', '', 'Pathein', 'FC'),
(62, 'Daw Nandar Lwin', 'Assistant Lecturer', '', '', 'Pathein', 'FCST'),
(63, 'Dr.khing Htet Win', 'Lecturer', '', '', 'Pathein', 'FCST'),
(64, 'CUH', 'Lecturer', '', '', 'Pathein', 'FCST'),
(65, 'Dr.May Thu Htun', 'Lecturer', '', '', 'Pathein', 'FCS'),
(66, 'Daw Htwe Htwe Aung', 'Lecturer', '', '', 'Pathein', 'FCS'),
(67, 'U Kaung Htet Oo', 'Assistant Lecturer', '', '', 'Pathein', 'FCS'),
(68, 'Dr.Ei Ei Moe', 'Lecturer', '', '', 'Pathein', 'FCS'),
(69, 'Dr.Thu Zar Hlaing', 'Associate Professor', '', '', 'Pathein', 'FCS'),
(70, 'Daw Chit Hsu Wai', 'Associate Professor', '', '', 'Pathein', 'FIS'),
(71, 'Daw Wut Yee Kyaw', 'Associate Professor', '', '', 'Pathein', 'FIS'),
(72, 'Dr.Thanda Zaw', 'Lecturer', '', '', 'Pathein', 'FIS'),
(73, 'Daw San San Maw', 'Lecturer', '', '', 'Pathein', 'FIS'),
(74, 'Daw Swe Zin Aung', 'Associate Professor', '', '', 'Pathein', 'FIS'),
(75, 'Dr.Gant Gaw Wutt Mhon', 'Lecturer', '', '', 'Pathein', 'FIS'),
(76, 'Daw Aye Aye Theint', 'Lecturer', '', '', 'Pathein', 'ITSM'),
(77, 'Daw Hlaing Hlaing Win', 'Assistant Lecturer', '', '', 'Pathein', 'ITSM'),
(78, 'Daw Saw Yu Nwe', 'Associate Professor', '', '', 'Pathein', 'Eng');

-- --------------------------------------------------------

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

INSERT INTO `teaches` (`teaches_id`, `sub_id`, `section_id`, `year_id`, `teacher_name`, `dept_code`) VALUES
(398, 104, 1, 20, 'Daw Nwe Nwe Aye', 'Eng'),
(399, 105, 1, 20, 'Daw Zar Ni Win', 'FC'),
(400, 106, 1, 20, 'Daw Win	Mar', 'FIS'),
(401, 107, 1, 20, 'Dr.Myat Cho Mon Oo', 'ITSM'),
(402, 108, 1, 20, 'Daw Thin Phyu Mhwe', 'Myan'),
(427, 1, 1, 1, 'Daw San San Myaing', 'Myan'),
(428, 2, 1, 1, 'Daw Chaw Su	Han,Daw Aye Yu Nwe', 'Eng'),
(429, 3, 1, 1, 'Dr.Sanda Win', 'Phy'),
(430, 4, 1, 1, 'Daw Nandar Htun,Daw Zin Mie Mie Aung ', 'FCS,FCST'),
(431, 5, 1, 1, 'Dr.Zin Min Soe', 'FC'),
(432, 135, 1, 1, 'Daw Hlaing Hlaing Win', 'ITSM'),
(433, 136, 1, 1, 'Dr.Myat Thiri Khine,Daw Chit Hsu Wai', 'FIS'),
(434, 124, 1, 16, 'Dr.khing Htet Win', 'FCST'),
(435, 125, 1, 16, 'Daw Thin Thin Htwe', 'FCST'),
(436, 126, 1, 16, 'Daw Soe Moe Myint', 'FCST'),
(437, 128, 1, 16, 'Daw Chaw Su	Han', 'Eng'),
(438, 134, 1, 16, 'Daw Aye Aye Theint', 'ITSM'),
(439, 145, 1, 16, 'Dr.Gant Gaw Wutt Mhon', 'FIS'),
(440, 1, 2, 1, 'Daw San San Myaing', 'Myan'),
(441, 2, 2, 1, 'Daw Chaw Su	Han,Daw Aye Yu Nwe', 'Eng'),
(442, 3, 2, 1, 'Daw Cho Mar Kyaw', 'Phy'),
(443, 4, 2, 1, 'Daw Zin Mie Mie Aung ,Daw Nandar Htun', 'FCS,FCST'),
(444, 5, 2, 1, 'Daw Aye Aye Khaing', 'FC'),
(445, 135, 2, 1, 'Daw Hlaing Hlaing Win', 'ITSM'),
(446, 136, 2, 1, 'Dr.Myat Thiri Khine,Daw Wut Yee Kyaw', 'FIS'),
(447, 1, 3, 1, 'Daw San San Myaing', 'Myan'),
(448, 2, 3, 1, 'Daw Chaw Su	Han,Daw Aye Yu Nwe', 'Eng'),
(449, 3, 3, 1, 'Daw Phyo Chit Chit Po', 'Phy'),
(450, 4, 3, 1, 'Daw Zin Mie Mie Aung ,Daw Nandar Htun', 'FCS,FCST'),
(451, 5, 3, 1, 'Daw Ngu War	Khin', 'FC'),
(452, 135, 3, 1, 'Daw Hlaing Hlaing Win', 'ITSM'),
(453, 136, 3, 1, 'Dr.Myat Thiri Khine,Daw Chit Hsu Wai', 'FIS'),
(454, 1, 4, 1, 'Daw San San Myaing', 'Myan'),
(455, 2, 4, 1, 'Daw Chaw Su	Han,Daw Aye Yu Nwe', 'Eng'),
(456, 3, 4, 1, 'Daw Phyo Chit Chit Po', 'Phy'),
(457, 4, 4, 1, 'Daw Zin Mie Mie Aung ,Daw Nandar Htun', 'FCS,FCST'),
(458, 5, 4, 1, 'Daw Thin Thin	Hlaing', 'FC'),
(459, 135, 4, 1, 'Daw Hlaing Hlaing Win', 'ITSM'),
(460, 136, 4, 1, 'Dr.Myat Thiri Khine,Daw Wut Yee Kyaw', 'FIS'),
(461, 13, 1, 3, 'Daw Htet Wint Wint Phyo,Daw Nwe Nwe Aye', 'Eng'),
(462, 14, 1, 3, 'Dr.May Thu Htun', 'FCS'),
(463, 15, 1, 3, 'Daw Ngu War	Khin', 'FC'),
(464, 17, 1, 3, 'Dr.Thanda Zaw', 'FIS'),
(465, 109, 1, 3, 'Daw May Zin Tun,U Kaung Htet Oo', 'FCS'),
(466, 137, 1, 3, 'Daw San San Maw', 'FIS'),
(472, 19, 1, 5, 'Daw Htet Wint Wint Phyo,Daw Nwe Nwe Aye', 'Eng'),
(473, 20, 1, 5, 'Dr.May Thu Htun', 'FCS'),
(474, 21, 1, 5, 'Daw Myint Myint Maw', 'FC'),
(475, 23, 1, 5, 'Dr.Thanda Zaw', 'FIS'),
(476, 110, 1, 5, 'U Kaung Htet Oo,Daw May Zin Tun', 'FCS'),
(477, 117, 1, 5, 'Dr.Mar Mar Min,Daw Nandar Lwin', 'FCST'),
(478, 138, 1, 5, 'Daw San San Maw', 'FIS'),
(479, 25, 1, 7, 'Dr.khing Htet Win', 'FCST'),
(480, 26, 1, 7, 'Daw Thin Thin	Hlaing', 'FC'),
(481, 27, 1, 7, 'Daw May Zin Tun', 'FCS'),
(482, 28, 1, 7, 'Dr.Thanda Zaw', 'FIS'),
(483, 29, 1, 7, 'Daw San San Maw', 'FIS'),
(484, 31, 1, 7, 'Daw Moe Moe Myint', 'ITSM'),
(485, 131, 1, 7, 'Daw Aye Aye Theint', 'ITSM'),
(486, 32, 1, 9, 'Dr.khing Htet Win', 'FCST'),
(487, 33, 1, 9, 'Daw Thin Thin	Hlaing', 'FC'),
(488, 34, 1, 9, 'Daw May Zin Tun', 'FCS'),
(489, 35, 1, 9, 'Daw Thin Thin Htwe', 'FCST'),
(490, 36, 1, 9, 'Daw Soe Moe Myint', 'FCST'),
(491, 37, 1, 9, 'CUH', 'FCST'),
(492, 38, 1, 9, 'Daw Moe Moe Myint', 'ITSM'),
(493, 132, 1, 9, 'Daw Aye Aye Theint', 'ITSM'),
(494, 39, 1, 11, 'Daw Phyo Ei Mon', 'Eng'),
(495, 40, 1, 11, 'Daw Htwe Htwe Aung', 'FCS'),
(496, 43, 1, 11, 'Daw Wut Yee Kyaw', 'FIS'),
(497, 45, 1, 11, 'Daw Aye Aye Khaing', 'FC'),
(498, 111, 1, 11, 'Dr.Ei Ei Moe', 'FCS'),
(499, 153, 1, 11, 'Daw Swe Zin Aung', 'FIS'),
(500, 39, 2, 11, 'Daw Phyo Ei Mon', 'Eng'),
(501, 40, 2, 11, 'Daw Htwe Htwe Aung', 'FCS'),
(502, 43, 2, 11, 'Daw Wut Yee Kyaw', 'FIS'),
(503, 45, 2, 11, 'Daw Su Mon Hlaing', 'FC'),
(504, 111, 2, 11, 'Dr.Ei Ei Moe', 'FCS'),
(505, 153, 2, 11, 'Daw Swe Zin Aung', 'FIS'),
(506, 46, 1, 13, 'Daw Phyo Ei Mon', 'Eng'),
(507, 47, 1, 13, 'Daw Htwe Htwe Aung', 'FCS'),
(508, 49, 1, 13, 'Daw Thin Thin Htwe', 'FCST'),
(509, 50, 1, 13, 'Dr.Mar Mar Min,Dr.khing Htet Win', 'FCST'),
(510, 119, 1, 13, 'Dr.khing Htet Win', 'FCST'),
(511, 140, 1, 13, 'Daw Swe Zin Aung', 'FIS'),
(512, 112, 1, 12, 'Dr.Khin Lay Thwin,U Kaung Htet Oo', 'FCS'),
(513, 114, 1, 12, 'Dr.Thu Zar Hlaing', 'FCS'),
(514, 129, 1, 12, 'Daw Moe Moe Myint', 'ITSM'),
(515, 141, 1, 12, 'Daw Swe Zin Aung', 'FIS'),
(516, 142, 1, 12, 'Dr.Gant Gaw Wutt Mhon', 'FIS'),
(517, 146, 1, 12, 'Dr.Zin Min Soe', 'FC'),
(518, 113, 1, 14, 'Dr.Khin Lay Thwin,U Kaung Htet Oo', 'FCS'),
(519, 120, 1, 14, 'Daw Soe Moe Myint', 'FCST'),
(520, 121, 1, 14, 'Dr.Mar Mar Min', 'FCST'),
(521, 122, 1, 14, 'Daw Soe Moe Myint', 'FCST'),
(522, 123, 1, 14, 'Daw Thin Thin Htwe', 'FCST'),
(523, 130, 1, 14, 'Daw Moe Moe Myint', 'ITSM'),
(524, 147, 1, 14, 'Dr.Zin Min Soe', 'FC'),
(525, 116, 1, 15, 'Dr.Moe Moe San', 'FCS'),
(526, 127, 1, 15, 'Daw Chaw Su	Han', 'Eng'),
(527, 133, 1, 15, 'Daw Aye Aye Theint', 'ITSM'),
(528, 143, 1, 15, 'Daw Chit Hsu Wai', 'FIS'),
(529, 144, 1, 15, 'Dr.Gant Gaw Wutt Mhon', 'FIS'),
(536, 148, 1, 21, 'Dr.Zin Min Soe', 'FC'),
(537, 150, 1, 21, 'Dr.Gant Gaw Wutt Mhon', 'FIS'),
(538, 151, 1, 21, 'Daw Moe Moe Myint', 'ITSM'),
(539, 154, 1, 21, 'Daw Chaw Su	Han', 'Eng'),
(540, 155, 1, 21, 'Dr.Khin Lay Thwin', 'FCS'),
(541, 157, 1, 21, 'Dr.Moe Moe San', 'FCS');

-- --------------------------------------------------------

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

INSERT INTO `timetable` (`id`, `day`, `period1`, `period2`, `period3`, `section_id`, `year_id`) VALUES
(191, 'Monday', 'CS-3124', 'CST-3131', 'CST-3113', 1, 7),
(192, 'Tueday', 'CS-3125', 'CST(SK)-3156', 'CST-3142', 1, 7),
(193, 'Wedday', 'CST-3142', 'CS-3124', 'CST-3131', 1, 7),
(194, 'Thuday', 'CST(SK)-3157', 'CST-3113', 'CST(SK)-3156', 1, 7),
(195, 'Friday', 'CS-3125', 'CST(SK)-3157', '', 1, 7),
(196, 'Monday', 'CST-4125', 'CST-4111', 'E-4101', 1, 13),
(197, 'Tueday', 'CT-4133', 'CT-4132', 'CST-4111', 1, 13),
(198, 'Wedday', 'CT-4134', '', 'CST-4125', 1, 13),
(199, 'Thuday', 'CT-4132', 'E-4101', '', 1, 13),
(200, 'Friday', '', 'CT-4133', 'CT-4134', 1, 13),
(201, 'Monday', '', 'CS-4124', '', 1, 11),
(202, 'Tueday', 'CS-4142', 'CS-4113', 'CS-4124', 1, 11),
(203, 'Wedday', 'CS-4113', 'E-4101', '', 1, 11),
(204, 'Thuday', 'CST-4111', 'CS-4142', 'CST-4125', 1, 11),
(205, 'Friday', 'CST-4125', 'CST-4111', 'E-4101', 1, 11),
(206, 'Monday', 'CS-4142', 'CST-4125', 'CS-4113', 2, 11),
(207, 'Tueday', '', 'E-4101', 'CST-4125', 2, 11),
(208, 'Wedday', 'CS-4124', 'CS-4142', 'CST-4111', 2, 11),
(209, 'Thuday', 'CS-4113', '', 'CST-4111', 2, 11),
(210, 'Friday', 'E-4101', 'CS-4124', '', 2, 11),
(211, 'Monday', 'CST-4242', 'CS-4225', '', 1, 12),
(212, 'Tueday', 'CST-4257', 'CST-4211', '', 1, 12),
(213, 'Wedday', 'CS-4223', 'CST-4242', 'CS-4214', 1, 12),
(214, 'Thuday', 'CS-4223', 'CST-4211', '', 1, 12),
(215, 'Friday', 'CS-4225', 'CS-4214', 'CST-4257', 1, 12),
(216, 'Monday', 'CST-4242', 'CT-4235', 'CT-4234', 1, 14),
(217, 'Tueday', '', 'CST-4211', 'CT-4233', 1, 14),
(218, 'Wedday', 'CT-4235', 'CST-4242', 'CST-4257', 1, 14),
(219, 'Thuday', 'CT-4236', 'CST-4211', 'CST-4257', 1, 14),
(220, 'Friday', 'CT-4234', 'CT-4233', 'CT-4236', 1, 14),
(221, 'Monday', 'CS-5121', 'CS-5112', '', 1, 15),
(222, 'Tueday', 'E-5101', 'CS-5121', 'CST-5123', 1, 15),
(223, 'Wedday', 'CST-5123', 'CST-5155', '', 1, 15),
(224, 'Thuday', 'E-5101', 'CS-5112', '', 1, 15),
(225, 'Friday', 'CST-5155', '', '', 1, 15),
(226, 'Monday', 'CT-5132', '', 'CT-5136', 1, 16),
(227, 'Tueday', 'E-5101', 'CT-5132', 'CST-5123', 1, 16),
(228, 'Wedday', 'CST-5123', 'CST-5155', 'CT-5131', 1, 16),
(229, 'Thuday', 'E-5101', '', 'CT-5136', 1, 16),
(230, 'Friday', 'CST-5155', 'CT-5131', '', 1, 16),
(231, 'Monday', 'CST-6155', 'CST-6142', 'E-6101', 1, 21),
(232, 'Tueday', 'CS-6124', 'CST-6142', 'CST-6155', 1, 21),
(233, 'Wedday', 'CST(SK)-6117', 'CST-6103', '', 1, 21),
(234, 'Thuday', 'CST-6103', '', 'CST(SK)-6117', 1, 21),
(235, 'Friday', 'E-6101', 'CS-6124', '', 1, 21),
(236, 'Monday', 'CT(SK)-3136', 'CST-3131', 'CST-3113', 1, 9),
(237, 'Tueday', 'CT(SK)-3136', 'CT-3135', 'CST-3142', 1, 9),
(238, 'Wedday', 'CST-3142', 'CT-3135', 'CST-3131', 1, 9),
(239, 'Thuday', 'CST(SK)-3157', 'CST-3113', 'CT-3134', 1, 9),
(240, 'Friday', 'CT-3134', 'CST(SK)-3157', '', 1, 9),
(241, 'Monday', 'CST-1154', 'CST-1102', 'M-1101', 1, 1),
(242, 'Tueday', 'P-1101', 'E-1101', 'CST-1123', 1, 1),
(243, 'Wedday', 'CST-1123', 'E-1101', 'P-1101', 1, 1),
(244, 'Thuday', 'CST-1102', 'CST-1141', 'CST-1154', 1, 1),
(245, 'Friday', 'CST-1141', 'M-1101', '', 1, 1),
(261, 'Monday', 'CST-2113', 'CST-2141', 'E-2101', 1, 3),
(262, 'Tueday', 'CST-2112', 'CST-2113', 'CST-2126', 1, 3),
(263, 'Wedday', 'CST-2124', 'E-2101', 'CST-2112', 1, 3),
(264, 'Thuday', 'CST-2126', 'CST-2112', 'CST-2141', 1, 3),
(265, 'Friday', 'CST-2124', '', '', 1, 3),
(266, 'Monday', 'CST-2135', 'CST-2124', 'CST-2141', 1, 5),
(267, 'Tueday', 'CST-2141', 'CST-2112', 'E-2101', 1, 5),
(268, 'Wedday', 'CST-2112', 'CST-2135', 'CST-2113', 1, 5),
(269, 'Thuday', 'CST-2113', 'CST-2124', 'CST-2126', 1, 5),
(270, 'Friday', 'E-2101', 'CST-2126', '', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(8, 'khinlaythwin@gmail.com', 'b0baee9d279d34fa1dfd71aadb908c3f'),
(9, 'khinlaythwin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'khinlaythwin@gmail.com', '65bb86549756830caa529e032f829eb2'),
(10, 'khinlaythwin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(11, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(12, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(13, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(14, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(15, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e'),
(16, '', 'b2ca678b4c936f905fb82f2733f5297f'),
(17, '', 'b2ca678b4c936f905fb82f2733f5297f'),
(18, 'khinlaythwin@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e');

-- --------------------------------------------------------

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
