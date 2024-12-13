-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2024 at 08:41 PM
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
-- Database: `ahp_crips`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_alternatif`
--

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_alternatif`
--

INSERT INTO `tb_alternatif` (`kode_alternatif`, `nama_alternatif`, `keterangan`, `total`, `rank`) VALUES
('FF', 'FUEL FILTER SEC SPIN ON HI EFFICIENCY', '', 0.45030402699963, 3),
('OF', 'OIL FILTER (FLTR ELEMENT SPIN ON LUBE OIL FULL FLOW)', '', 0.26478560835739, 12),
('FE', 'FILTER ELEMENT', '', 0.29904560479171, 11),
('FC', 'FILTER CARTRIDGE', '', 0.36419799156639, 7),
('AF', 'AIR FILTER', '', 0.18059966153732, 16),
('OS', 'OIL SEPARATOR', '', 0.24122616533822, 13),
('RB', 'RIBBED BELT FOR FAN DRIVE', '', 0.61437183754792, 1),
('BP', 'BELT POLY-V', '', 0.1910790493569, 15),
('HP', 'HP PUMP LEFT SIDE', '', 0.34298675635897, 9),
('HP P', 'HP PUMP', '', 0.40636287543237, 5),
('PI', 'PAPER INSERT', '', 0.12512842989558, 18),
('FES', 'FILTER ELEMENT SPIN ON LUBE OIL', '', 0.17439369712326, 17),
('FFS', 'FUEL FILTER SPIN-ON LEFT SIDE', '', 0.38088334380003, 6),
('CS', 'COPPER SEALING RING', '', 0.35967210859261, 8),
('FER', 'FILTER ELEMENT RIGHT SIDE', '', 0.20332957789716, 14),
('FFSO', 'FUEL FILTER SPIN-ON RIGHT SIDE', '', 0.32025683999913, 10),
('CA', 'CLEANER AIR W/ADAP F', '', 0.44577877831221, 4),
('OSR', 'OIL SEPARATOR MACHINE', '', 0.58438013753851, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_alternatif_saw`
--

CREATE TABLE `tb_alternatif_saw` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(256) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`kode_kriteria`, `nama_kriteria`) VALUES
('C4', 'Dampak Kegagalan'),
('C3', 'Kesediaan Barang'),
('C2', 'Garansi'),
('C1', 'Kemungkinan Kegagalan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kriteria_saw`
--

CREATE TABLE `tb_kriteria_saw` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  `bobot` double NOT NULL,
  `type` enum('cost','benefit') NOT NULL DEFAULT 'benefit'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kriteria_saw`
--

INSERT INTO `tb_kriteria_saw` (`kode_kriteria`, `nama_kriteria`, `bobot`, `type`) VALUES
('1', 'wisnu', 11, 'cost'),
('12', '241231', 21, 'benefit'),
('123123', 'wdsa', 2, 'benefit'),
('132', '231', 312, 'benefit'),
('2', 'sadas', 4, 'cost'),
('21', 'e12', 2, 'benefit'),
('23', 'wdaw', 2, 'cost'),
('3', 'wdsa', 2, 'cost');

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_saw`
--

CREATE TABLE `tb_nilai_saw` (
  `kode_alternatif` varchar(16) NOT NULL,
  `kode_kriteria` varchar(16) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_rel_alternatif`
--

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL,
  `kode_alternatif` varchar(255) DEFAULT NULL,
  `kode_kriteria` varchar(255) DEFAULT NULL,
  `kode_sub` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_rel_alternatif`
--

INSERT INTO `tb_rel_alternatif` (`ID`, `kode_alternatif`, `kode_kriteria`, `kode_sub`) VALUES
(54, 'OS', 'C4', 'C41'),
(53, 'OS', 'C3', 'C33'),
(52, 'OS', 'C2', 'C22'),
(51, 'OS', 'C1', 'C12'),
(50, 'AF', 'C4', 'C41'),
(49, 'AF', 'C3', 'C32'),
(48, 'AF', 'C2', 'C22'),
(47, 'AF', 'C1', 'C13'),
(46, 'FF', 'C4', 'C41'),
(45, 'FF', 'C3', 'C31'),
(44, 'FF', 'C2', 'C21'),
(43, 'FF', 'C1', 'C12'),
(42, 'OF', 'C4', 'C43'),
(41, 'OF', 'C3', 'C33'),
(40, 'OF', 'C2', 'C21'),
(39, 'OF', 'C1', 'C13'),
(38, 'FE', 'C4', 'C42'),
(37, 'FE', 'C3', 'C32'),
(36, 'FE', 'C2', 'C21'),
(35, 'FE', 'C1', 'C13'),
(34, 'FC', 'C4', 'C41'),
(33, 'FC', 'C3', 'C31'),
(32, 'FC', 'C2', 'C21'),
(31, 'FC', 'C1', 'C13'),
(59, 'BP', 'C1', 'C12'),
(58, 'RB', 'C4', 'C41'),
(57, 'RB', 'C3', 'C32'),
(56, 'RB', 'C2', 'C21'),
(55, 'RB', 'C1', 'C11'),
(60, 'BP', 'C2', 'C23'),
(61, 'BP', 'C3', 'C33'),
(62, 'BP', 'C4', 'C42'),
(63, 'HP', 'C1', 'C13'),
(64, 'HP', 'C2', 'C21'),
(65, 'HP', 'C3', 'C31'),
(66, 'HP', 'C4', 'C42'),
(67, 'HP P', 'C1', 'C12'),
(68, 'HP P', 'C2', 'C21'),
(69, 'HP P', 'C3', 'C32'),
(70, 'HP P', 'C4', 'C41'),
(71, 'PI', 'C1', 'C13'),
(72, 'PI', 'C2', 'C22'),
(73, 'PI', 'C3', 'C33'),
(74, 'PI', 'C4', 'C43'),
(75, 'FES', 'C1', 'C13'),
(76, 'FES', 'C2', 'C23'),
(77, 'FES', 'C3', 'C31'),
(78, 'FES', 'C4', 'C42'),
(79, 'FFS', 'C1', 'C12'),
(80, 'FFS', 'C2', 'C21'),
(81, 'FFS', 'C3', 'C33'),
(82, 'FFS', 'C4', 'C41'),
(83, 'CS', 'C1', 'C12'),
(84, 'CS', 'C2', 'C21'),
(85, 'CS', 'C3', 'C33'),
(86, 'CS', 'C4', 'C42'),
(87, 'FER', 'C1', 'C13'),
(88, 'FER', 'C2', 'C22'),
(89, 'FER', 'C3', 'C31'),
(90, 'FER', 'C4', 'C42'),
(91, 'FFSO', 'C1', 'C13'),
(92, 'FFSO', 'C2', 'C21'),
(93, 'FFSO', 'C3', 'C32'),
(94, 'FFSO', 'C4', 'C41'),
(95, 'CA', 'C1', 'C11'),
(96, 'CA', 'C2', 'C23'),
(97, 'CA', 'C3', 'C32'),
(98, 'CA', 'C4', 'C41'),
(99, 'OSR', 'C1', 'C11'),
(100, 'OSR', 'C2', 'C21'),
(101, 'OSR', 'C3', 'C32'),
(102, 'OSR', 'C4', 'C43');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rel_kriteria`
--

CREATE TABLE `tb_rel_kriteria` (
  `ID` int(11) NOT NULL,
  `ID1` varchar(16) DEFAULT NULL,
  `ID2` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_rel_kriteria`
--

INSERT INTO `tb_rel_kriteria` (`ID`, `ID1`, `ID2`, `nilai`) VALUES
(106, 'C3', 'C3', 1),
(114, 'C2', 'C4', 5),
(109, 'C4', 'C1', 0.142857142),
(113, 'C1', 'C4', 7),
(115, 'C3', 'C4', 3),
(112, 'C4', 'C4', 1),
(108, 'C2', 'C3', 3),
(111, 'C4', 'C3', 0.333333333),
(110, 'C4', 'C2', 0.2),
(107, 'C1', 'C3', 5),
(103, 'C1', 'C2', 3),
(104, 'C3', 'C1', 0.2),
(105, 'C3', 'C2', 0.333333333),
(100, 'C1', 'C1', 1),
(101, 'C2', 'C1', 0.333333333),
(102, 'C2', 'C2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rel_sub`
--

CREATE TABLE `tb_rel_sub` (
  `ID` int(11) NOT NULL,
  `ID1` varchar(255) DEFAULT NULL,
  `ID2` varchar(255) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `bobot` double DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_rel_sub`
--

INSERT INTO `tb_rel_sub` (`ID`, `ID1`, `ID2`, `nilai`, `bobot`) VALUES
(696, 'C11', 'C11', 1, NULL),
(697, 'C12', 'C11', 0.333333333, NULL),
(698, 'C12', 'C12', 1, NULL),
(699, 'C11', 'C12', 3, NULL),
(700, 'C13', 'C11', 0.2, NULL),
(701, 'C13', 'C12', 0.333333333, NULL),
(702, 'C13', 'C13', 1, NULL),
(703, 'C11', 'C13', 5, NULL),
(704, 'C12', 'C13', 3, NULL),
(705, 'C21', 'C11', 1, NULL),
(706, 'C21', 'C12', 1, NULL),
(707, 'C21', 'C13', 1, NULL),
(708, 'C21', 'C21', 1, NULL),
(709, 'C11', 'C21', 1, NULL),
(710, 'C12', 'C21', 1, NULL),
(711, 'C13', 'C21', 1, NULL),
(712, 'C22', 'C11', 1, NULL),
(713, 'C22', 'C12', 1, NULL),
(714, 'C22', 'C13', 1, NULL),
(715, 'C22', 'C21', 0.2, NULL),
(716, 'C22', 'C22', 1, NULL),
(717, 'C11', 'C22', 1, NULL),
(718, 'C12', 'C22', 1, NULL),
(719, 'C13', 'C22', 1, NULL),
(720, 'C21', 'C22', 5, NULL),
(721, 'C23', 'C11', 1, NULL),
(722, 'C23', 'C12', 1, NULL),
(723, 'C23', 'C13', 1, NULL),
(724, 'C23', 'C21', 0.142857142, NULL),
(725, 'C23', 'C22', 0.333333333, NULL),
(726, 'C23', 'C23', 1, NULL),
(727, 'C11', 'C23', 1, NULL),
(728, 'C12', 'C23', 1, NULL),
(729, 'C13', 'C23', 1, NULL),
(730, 'C21', 'C23', 7, NULL),
(731, 'C22', 'C23', 3, NULL),
(732, 'C31', 'C11', 1, NULL),
(733, 'C31', 'C12', 1, NULL),
(734, 'C31', 'C13', 1, NULL),
(735, 'C31', 'C21', 1, NULL),
(736, 'C31', 'C22', 1, NULL),
(737, 'C31', 'C23', 1, NULL),
(738, 'C31', 'C31', 1, NULL),
(739, 'C11', 'C31', 1, NULL),
(740, 'C12', 'C31', 1, NULL),
(741, 'C13', 'C31', 1, NULL),
(742, 'C21', 'C31', 1, NULL),
(743, 'C22', 'C31', 1, NULL),
(744, 'C23', 'C31', 1, NULL),
(745, 'C32', 'C11', 1, NULL),
(746, 'C32', 'C12', 1, NULL),
(747, 'C32', 'C13', 1, NULL),
(748, 'C32', 'C21', 1, NULL),
(749, 'C32', 'C22', 1, NULL),
(750, 'C32', 'C23', 1, NULL),
(751, 'C32', 'C31', 0.333333333, NULL),
(752, 'C32', 'C32', 1, NULL),
(753, 'C11', 'C32', 1, NULL),
(754, 'C12', 'C32', 1, NULL),
(755, 'C13', 'C32', 1, NULL),
(756, 'C21', 'C32', 1, NULL),
(757, 'C22', 'C32', 1, NULL),
(758, 'C23', 'C32', 1, NULL),
(759, 'C31', 'C32', 3, NULL),
(760, 'C33', 'C11', 1, NULL),
(761, 'C33', 'C12', 1, NULL),
(762, 'C33', 'C13', 1, NULL),
(763, 'C33', 'C21', 1, NULL),
(764, 'C33', 'C22', 1, NULL),
(765, 'C33', 'C23', 1, NULL),
(766, 'C33', 'C31', 0.142857142, NULL),
(767, 'C33', 'C32', 0.2, NULL),
(768, 'C33', 'C33', 1, NULL),
(769, 'C11', 'C33', 1, NULL),
(770, 'C12', 'C33', 1, NULL),
(771, 'C13', 'C33', 1, NULL),
(772, 'C21', 'C33', 1, NULL),
(773, 'C22', 'C33', 1, NULL),
(774, 'C23', 'C33', 1, NULL),
(775, 'C31', 'C33', 7, NULL),
(776, 'C32', 'C33', 5, NULL),
(777, 'C41', 'C11', 1, NULL),
(778, 'C41', 'C12', 1, NULL),
(779, 'C41', 'C13', 1, NULL),
(780, 'C41', 'C21', 1, NULL),
(781, 'C41', 'C22', 1, NULL),
(782, 'C41', 'C23', 1, NULL),
(783, 'C41', 'C31', 1, NULL),
(784, 'C41', 'C32', 1, NULL),
(785, 'C41', 'C33', 1, NULL),
(786, 'C41', 'C41', 1, NULL),
(787, 'C11', 'C41', 1, NULL),
(788, 'C12', 'C41', 1, NULL),
(789, 'C13', 'C41', 1, NULL),
(790, 'C21', 'C41', 1, NULL),
(791, 'C22', 'C41', 1, NULL),
(792, 'C23', 'C41', 1, NULL),
(793, 'C31', 'C41', 1, NULL),
(794, 'C32', 'C41', 1, NULL),
(795, 'C33', 'C41', 1, NULL),
(796, 'C42', 'C11', 1, NULL),
(797, 'C42', 'C12', 1, NULL),
(798, 'C42', 'C13', 1, NULL),
(799, 'C42', 'C21', 1, NULL),
(800, 'C42', 'C22', 1, NULL),
(801, 'C42', 'C23', 1, NULL),
(802, 'C42', 'C31', 1, NULL),
(803, 'C42', 'C32', 1, NULL),
(804, 'C42', 'C33', 1, NULL),
(805, 'C42', 'C41', 0.333333333, NULL),
(806, 'C42', 'C42', 1, NULL),
(807, 'C11', 'C42', 1, NULL),
(808, 'C12', 'C42', 1, NULL),
(809, 'C13', 'C42', 1, NULL),
(810, 'C21', 'C42', 1, NULL),
(811, 'C22', 'C42', 1, NULL),
(812, 'C23', 'C42', 1, NULL),
(813, 'C31', 'C42', 1, NULL),
(814, 'C32', 'C42', 1, NULL),
(815, 'C33', 'C42', 1, NULL),
(816, 'C41', 'C42', 3, NULL),
(817, 'C43', 'C11', 1, NULL),
(818, 'C43', 'C12', 1, NULL),
(819, 'C43', 'C13', 1, NULL),
(820, 'C43', 'C21', 1, NULL),
(821, 'C43', 'C22', 1, NULL),
(822, 'C43', 'C23', 1, NULL),
(823, 'C43', 'C31', 1, NULL),
(824, 'C43', 'C32', 1, NULL),
(825, 'C43', 'C33', 1, NULL),
(826, 'C43', 'C41', 0.2, NULL),
(827, 'C43', 'C42', 0.333333333, NULL),
(828, 'C43', 'C43', 1, NULL),
(829, 'C11', 'C43', 1, NULL),
(830, 'C12', 'C43', 1, NULL),
(831, 'C13', 'C43', 1, NULL),
(832, 'C21', 'C43', 1, NULL),
(833, 'C22', 'C43', 1, NULL),
(834, 'C23', 'C43', 1, NULL),
(835, 'C31', 'C43', 1, NULL),
(836, 'C32', 'C43', 1, NULL),
(837, 'C33', 'C43', 1, NULL),
(838, 'C41', 'C43', 5, NULL),
(839, 'C42', 'C43', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_sub`
--

CREATE TABLE `tb_sub` (
  `kode_sub` varchar(255) NOT NULL,
  `kode_kriteria` varchar(255) DEFAULT NULL,
  `nama_sub` varchar(255) DEFAULT NULL,
  `nilai_sub` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_sub`
--

INSERT INTO `tb_sub` (`kode_sub`, `kode_kriteria`, `nama_sub`, `nilai_sub`) VALUES
('C11', 'C1', 'Rendah', 0.63334572036725),
('C12', 'C1', 'Sedang', 0.26049795609934),
('C13', 'C1', 'Tinggi', 0.10615632353341),
('C21', 'C2', '1 Tahun', 0.72350605738496),
('C22', 'C2', '2 Tahun', 0.19318605996184),
('C23', 'C2', '3 Tahun', 0.083307882653203),
('C31', 'C3', 'Diatas 7 Hari', 0.64338886937742),
('C32', 'C3', 'Diatas 1 Bulan', 0.28283902475994),
('C33', 'C3', 'Diatas 6 Bulan', 0.073772105862637),
('C41', 'C4', 'Rendah', 0.63334572036725),
('C42', 'C4', 'Sedang', 0.26049795609934),
('C43', 'C4', 'Tinggi', 0.10615632353341);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `kode_user` varchar(16) NOT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `user` varchar(16) DEFAULT NULL,
  `pass` varchar(16) DEFAULT NULL,
  `level` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`kode_user`, `nama_user`, `user`, `pass`, `level`) VALUES
('U001', 'Administrator', 'admin', 'admin', 'admin'),
('U002', 'User', 'user', 'user', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_alternatif`
--
ALTER TABLE `tb_alternatif`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indexes for table `tb_alternatif_saw`
--
ALTER TABLE `tb_alternatif_saw`
  ADD PRIMARY KEY (`kode_alternatif`);

--
-- Indexes for table `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `tb_kriteria_saw`
--
ALTER TABLE `tb_kriteria_saw`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indexes for table `tb_nilai_saw`
--
ALTER TABLE `tb_nilai_saw`
  ADD PRIMARY KEY (`kode_alternatif`,`kode_kriteria`),
  ADD KEY `kode_kriteria` (`kode_kriteria`);

--
-- Indexes for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_rel_kriteria`
--
ALTER TABLE `tb_rel_kriteria`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_rel_sub`
--
ALTER TABLE `tb_rel_sub`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tb_sub`
--
ALTER TABLE `tb_sub`
  ADD PRIMARY KEY (`kode_sub`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`kode_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_rel_alternatif`
--
ALTER TABLE `tb_rel_alternatif`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `tb_rel_kriteria`
--
ALTER TABLE `tb_rel_kriteria`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `tb_rel_sub`
--
ALTER TABLE `tb_rel_sub`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=840;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_nilai_saw`
--
ALTER TABLE `tb_nilai_saw`
  ADD CONSTRAINT `tb_nilai_saw_ibfk_1` FOREIGN KEY (`kode_alternatif`) REFERENCES `tb_alternatif_saw` (`kode_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_nilai_saw_ibfk_2` FOREIGN KEY (`kode_kriteria`) REFERENCES `tb_kriteria_saw` (`kode_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
