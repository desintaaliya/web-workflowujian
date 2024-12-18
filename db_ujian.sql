-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2024 at 02:35 AM
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
-- Database: `db_ujian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Nuraeni', '$2y$10$VMTYzm2CUvblzxI07WxGUuNWIyHF.CRcsl52TTDdTdzgQqMGDMvX2');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

CREATE TABLE `dokumen` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `dokumen_path` varchar(255) DEFAULT NULL,
  `tipe_dokumen` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`id`, `peserta_id`, `dokumen_path`, `tipe_dokumen`) VALUES
(7, 7, 'uploads/674e71d0eddc3.jpg', 'image/jpeg'),
(8, 9, 'uploads/674e7516b43d3.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `hasil_ujian`
--

CREATE TABLE `hasil_ujian` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `jadwal_ujian_id` int(11) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `status_ujian` enum('Selesai','Ditunda','Gagal') DEFAULT 'Selesai',
  `tanggal_ujian` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujian`
--

CREATE TABLE `jadwal_ujian` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujiann`
--

CREATE TABLE `jadwal_ujiann` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `jenis_ujian` varchar(255) NOT NULL,
  `tanggal_ujian` date NOT NULL,
  `waktu_ujian` time NOT NULL,
  `lokasi_ujian` varchar(255) DEFAULT NULL,
  `batas_waktu` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'belum_mulai',
  `deskripsi_ujian` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_ujiannn`
--

CREATE TABLE `jadwal_ujiannn` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `jenis_ujian` varchar(255) NOT NULL,
  `tanggal_ujian` date NOT NULL DEFAULT curdate(),
  `waktu_ujian` time NOT NULL DEFAULT '00:00:00',
  `lokasi_ujian` varchar(255) DEFAULT NULL,
  `batas_waktu` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Belum Mulai',
  `deskripsi_ujian` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasus`
--

CREATE TABLE `kasus` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_ditambahkan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `jenis_kelas` varchar(50) NOT NULL,
  `jabatan_fungsional` varchar(100) NOT NULL,
  `jenjang` varchar(50) NOT NULL,
  `bidang` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `jenis_kelas`, `jabatan_fungsional`, `jenjang`, `bidang`, `created_at`) VALUES
(1, 'Kelas Reguler', 'Pengawas Perdagangan', 'Ahli Madya', '-', '2024-11-29 08:24:09'),
(2, 'Kelas Reguler', 'Analis Perdagangan', 'Ahli Utama', '-', '2024-11-29 08:28:21'),
(3, 'Kelas Khusus', 'Penera', 'Ahli Pertama', '-', '2024-12-03 03:45:47'),
(4, 'Kelas Khusus', 'Analis Perdagangan', 'Ahli Pertama', 'forum perundingan', '2024-12-12 07:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `kloter_ujian`
--

CREATE TABLE `kloter_ujian` (
  `id` int(11) NOT NULL,
  `kloter_id` varchar(50) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_keikutsertaan`
--

CREATE TABLE `log_keikutsertaan` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) DEFAULT NULL,
  `jadwal_ujian_id` int(11) DEFAULT NULL,
  `status_awal` enum('Menunggu','Belum Mulai','Selesai') DEFAULT 'Menunggu',
  `status_akhir` enum('Menunggu','Belum Mulai','Selesai') DEFAULT 'Menunggu',
  `waktu_perubahan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_notifikasi`
--

CREATE TABLE `log_notifikasi` (
  `id` int(11) NOT NULL,
  `notifikasi_id` int(11) DEFAULT NULL,
  `tindakan` varchar(50) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT 'Belum Dibaca',
  `penguji_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_penunjukan`
--

CREATE TABLE `notifikasi_penunjukan` (
  `id` int(11) NOT NULL,
  `penguji_id` int(11) DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `status` enum('Belum Dibaca','Dibaca') DEFAULT 'Belum Dibaca',
  `tanggal_dikirim` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi_penunjukan`
--

INSERT INTO `notifikasi_penunjukan` (`id`, `penguji_id`, `pesan`, `status`, `tanggal_dikirim`) VALUES
(1, 1, 'Penunjukan sebagai penguji untuk ujian', 'Dibaca', '2024-12-11 08:07:41'),
(2, 2, 'Penunjukan sebagai penguji untuk ujian', '', '2024-12-11 08:07:41'),
(3, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', 'Dibaca', '2024-12-11 08:55:30'),
(4, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', '', '2024-12-11 08:58:34'),
(5, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', '', '2024-12-11 09:08:16'),
(6, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', '', '2024-12-11 09:14:03'),
(7, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', '', '2024-12-11 09:14:26'),
(8, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', '', '2024-12-11 09:25:41'),
(9, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', 'Belum Dibaca', '2024-12-11 09:25:49'),
(10, 2, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', 'Belum Dibaca', '2024-12-11 09:33:09'),
(11, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', 'Belum Dibaca', '2024-12-12 02:05:45'),
(12, 1, 'Anda telah ditunjuk untuk menguji kloter ID: KL-20241209', 'Belum Dibaca', '2024-12-12 04:19:20');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_ujian`
--

CREATE TABLE `notifikasi_ujian` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('belum dibaca','sudah dibaca') DEFAULT 'belum dibaca',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifikasi_ujian`
--

INSERT INTO `notifikasi_ujian` (`id`, `user_id`, `pesan`, `status`, `dibuat_pada`) VALUES
(1, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:11:28'),
(2, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:13:06'),
(3, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:15:51'),
(4, 2, 'Anda tidak hadir pada ujian ini dan dipindahkan ke status \'Menunggu\'. Anda akan diberi jadwal ujian berikutnya.', 'sudah dibaca', '2024-12-03 07:17:15'),
(5, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:17:39'),
(6, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:26:20'),
(7, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:28:52'),
(8, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:31:56'),
(9, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:43:10'),
(10, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:47:28'),
(11, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:47:32'),
(12, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:48:15'),
(13, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:51:35'),
(14, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:52:52'),
(15, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:55:39'),
(16, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 07:58:17'),
(17, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-03 08:01:44'),
(18, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 02:04:44'),
(19, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 02:30:59'),
(20, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 02:33:32'),
(21, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 02:34:50'),
(22, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 03:16:53'),
(23, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-04 03:53:45'),
(24, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-05 01:51:11'),
(25, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-05 02:13:24'),
(26, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-05 02:16:50'),
(27, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-05 07:47:58'),
(28, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-05 08:45:49'),
(29, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 01:39:36'),
(30, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 01:42:14'),
(31, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 01:44:34'),
(32, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:05:26'),
(33, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:08:31'),
(34, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:08:35'),
(35, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:17:50'),
(36, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:19:25'),
(37, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:19:30'),
(38, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:28:03'),
(39, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:29:35'),
(40, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:33:10'),
(41, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:35:26'),
(42, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:39:18'),
(43, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-06 02:49:29'),
(44, 1, 'Anda tidak hadir pada ujian ini dan dipindahkan ke status \'Menunggu\'. Anda akan diberi jadwal ujian berikutnya.', 'sudah dibaca', '2024-12-06 08:56:59'),
(45, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-06 09:01:53'),
(46, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-06 09:19:22'),
(47, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-09 01:33:44'),
(48, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-09 02:31:27'),
(49, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-09 02:39:22'),
(50, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-09 07:26:14'),
(51, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-10 08:44:48'),
(52, 2, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'sudah dibaca', '2024-12-11 02:15:22'),
(53, 1, 'Jadwal ujian Anda: Tanggal, Waktu, Lokasi', 'belum dibaca', '2024-12-12 03:14:25');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `kontak` varchar(15) NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `instansi` varchar(255) NOT NULL,
  `dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penguji`
--

CREATE TABLE `penguji` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penguji`
--

INSERT INTO `penguji` (`id`, `nama`, `username`, `email`, `password`) VALUES
(1, 'Nuraeni', '', '', ''),
(2, 'Syiva', '', '', ''),
(3, 'Penguji 1', '', '', ''),
(4, 'Penguji 1', '', '', ''),
(5, 'Penguji 1', '', '', ''),
(6, 'Penguji A', '', '', ''),
(7, 'Penguji B', '', '', ''),
(8, '', 'Lilik linaa karlina', 'liliklinaakarlinaaa@gmail.com', '$2y$10$JF3ehLAGqx4pvdg4qxBmQOf3QHSahfU5a6mQrYcpyKsBhi3OmjTJ6'),
(9, '', 'Nuraeniii', 'nuraeniii@gmail.com', '$2y$10$SKYTpTrz1AM3uq3NudfeNOKQGHSJMqeKnpyhY7ZspGTXt8XER.d4q'),
(10, '', 'Syivaaviaa', 'syivaaviaaa@gmail.com', '$2y$10$nRdSj4Jc1CDqHRX.gCFYueNXGguUC0/h2pAAQBtEke3VzwbfAhww2'),
(11, '', 'Syivaaviaaa', 'syivaviaaaa@gmail.com', '$2y$10$u7btPAkRHWG1WPPYgrICweIXIlGl5nzF5skKmE8hLRdBypelTZjEC');

-- --------------------------------------------------------

--
-- Table structure for table `penunjukan_penguji`
--

CREATE TABLE `penunjukan_penguji` (
  `id` int(11) NOT NULL,
  `kloter_id` int(11) NOT NULL,
  `penguji_id` int(11) NOT NULL,
  `status` enum('Menunggu Konfirmasi','Selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penunjukan_penguji`
--

INSERT INTO `penunjukan_penguji` (`id`, `kloter_id`, `penguji_id`, `status`) VALUES
(1, 0, 1, 'Selesai'),
(2, 0, 1, 'Selesai'),
(3, 0, 1, 'Selesai'),
(4, 0, 1, 'Selesai'),
(5, 0, 1, 'Selesai'),
(6, 0, 1, 'Selesai'),
(7, 0, 1, 'Selesai'),
(8, 0, 2, 'Menunggu Konfirmasi'),
(9, 0, 1, 'Selesai'),
(10, 1, 2, 'Menunggu Konfirmasi'),
(11, 2, 1, 'Selesai'),
(12, 0, 2, 'Menunggu Konfirmasi'),
(13, 0, 1, 'Selesai'),
(14, 0, 1, 'Selesai'),
(15, 0, 1, 'Selesai'),
(16, 0, 1, 'Menunggu Konfirmasi'),
(17, 0, 1, 'Menunggu Konfirmasi'),
(18, 0, 1, 'Menunggu Konfirmasi'),
(19, 0, 1, 'Menunggu Konfirmasi'),
(20, 0, 1, 'Menunggu Konfirmasi'),
(21, 0, 1, 'Menunggu Konfirmasi'),
(22, 0, 2, 'Menunggu Konfirmasi'),
(23, 0, 1, 'Menunggu Konfirmasi'),
(24, 0, 1, 'Menunggu Konfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kontak` varchar(15) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `jenis_ujian` enum('Tertulis','Wawancara','Seminar','Praktikum','Studi Kasus','Portofolio') NOT NULL,
  `status_verifikasi` enum('lolos','tidak lolos','belum diverifikasi','belum','terverifikasi') DEFAULT 'belum diverifikasi',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(255) DEFAULT NULL,
  `alasan_penolakan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `status_kehadiran` varchar(255) NOT NULL,
  `kloter_id` varchar(50) DEFAULT NULL,
  `tanggal_ujian` date DEFAULT NULL,
  `waktu_ujian` time DEFAULT NULL,
  `lokasi_ujian` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id`, `nama`, `nik`, `alamat`, `kontak`, `jabatan`, `instansi`, `jenis_ujian`, `status_verifikasi`, `created_at`, `email`, `alasan_penolakan`, `status`, `status_kehadiran`, `kloter_id`, `tanggal_ujian`, `waktu_ujian`, `lokasi_ujian`) VALUES
(1, 'Desinta Kartika Sari', NULL, NULL, NULL, NULL, NULL, 'Tertulis', 'belum diverifikasi', '2024-12-09 04:05:05', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(2, 'Saepul Roihan', NULL, NULL, NULL, NULL, NULL, 'Tertulis', 'belum diverifikasi', '2024-12-09 04:05:05', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL),
(7, 'Saepul Roihan', '1234567890', 'Parongpong', '0882000951268', '-', '-', 'Tertulis', 'lolos', '2024-12-03 02:49:52', 'saepulroihan@gmail.com', NULL, NULL, '', 'KL-20241209', '2024-12-09', '09:00:00', 'Bandung'),
(9, 'Desinta Kartika Sari', '0987654321', 'Cihanjuang', '081572084313', '-', '-', 'Tertulis', 'lolos', '2024-12-03 03:03:50', NULL, NULL, NULL, '', 'KL-20241209', '2024-12-09', '09:00:00', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `peserta_ujian`
--

CREATE TABLE `peserta_ujian` (
  `peserta_ujian_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `konfirmasi_kehadiran` enum('Ya','Tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `soal_text` text NOT NULL,
  `pilihan_a` text NOT NULL,
  `pilihan_b` text NOT NULL,
  `pilihan_c` text NOT NULL,
  `pilihan_d` text NOT NULL,
  `jawaban_benar` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `soal_text`, `pilihan_a`, `pilihan_b`, `pilihan_c`, `pilihan_d`, `jawaban_benar`) VALUES
(1, 'Apa kepanjangan dari RB dalam Permenpan RB No. 2 Tahun 2024?', 'Reformasi Birokrasi', 'Revolusi Birokrasi', 'Rencana Birokrasi', 'Reformasi Birokrasi Nasional', 'a'),
(2, 'Siapa yang berhak mengajukan permohonan pelayanan dalam Permenpan RB No. 2?', 'Masyarakat Umum', 'Pemerintah Daerah', 'Instansi Swasta', 'Pemerintah Pusat', 'a'),
(3, 'Apa tujuan utama dari Permenpan RB No. 2?', 'Meningkatkan kualitas pelayanan publik', 'Mengurangi beban pekerjaan pegawai', 'Meningkatkan jumlah pegawai', 'Memperkenalkan teknologi baru', 'a'),
(4, 'Siapa yang bertanggung jawab atas pelayanan publik menurut Permenpan RB No. 2?', 'Pemerintah Pusat', 'Pemerintah Daerah', 'Instansi Swasta', 'Lembaga Swadaya Masyarakat', 'b'),
(5, 'Apa yang dimaksud dengan pelayanan publik menurut Permenpan RB No. 2?', 'Layanan untuk warga negara dari instansi pemerintah', 'Layanan dari sektor swasta untuk pemerintah', 'Layanan sosial untuk pegawai', 'Layanan dari pemerintah untuk pegawai', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `ujian_id` int(11) NOT NULL,
  `nama_ujian` varchar(255) NOT NULL,
  `tanggal_ujian` datetime NOT NULL,
  `lokasi_ujian` varchar(255) DEFAULT NULL,
  `jenis_ujian` enum('Tertulis','Wawancara','Seminar','Praktikum','Portofolio','Studi Kasus') NOT NULL,
  `status_ujian` enum('Aktif','Selesai','Dibatalkan') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`ujian_id`, `nama_ujian`, `tanggal_ujian`, `lokasi_ujian`, `jenis_ujian`, `status_ujian`, `created_at`, `updated_at`) VALUES
(1, '', '0000-00-00 00:00:00', NULL, 'Tertulis', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15'),
(2, '', '0000-00-00 00:00:00', NULL, 'Wawancara', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15'),
(3, '', '0000-00-00 00:00:00', NULL, 'Seminar', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15'),
(4, '', '0000-00-00 00:00:00', NULL, '', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15'),
(5, '', '0000-00-00 00:00:00', NULL, 'Portofolio', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15'),
(6, '', '0000-00-00 00:00:00', NULL, 'Studi Kasus', 'Aktif', '2024-12-09 04:09:15', '2024-12-09 04:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `ujiann`
--

CREATE TABLE `ujiann` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `jenis_ujian` varchar(50) NOT NULL,
  `tanggal_ujian` datetime NOT NULL,
  `lokasi_ujian` varchar(255) NOT NULL,
  `status_ujian` enum('Menunggu','Terlaksana','Selesai') DEFAULT 'Menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('Menunggu','Lulus','Tidak Lulus') DEFAULT 'Menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_kehadiran` enum('Hadir','Dibatalkan','Menunggu') DEFAULT 'Menunggu',
  `jenis_ujian` enum('Tertulis','Wawancara','Seminar','Praktikum','Studi Kasus','Portofolio') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `status`, `created_at`, `status_kehadiran`, `jenis_ujian`) VALUES
(1, 'Desinta Kartika Sari', 'desintakartikasari@gmail.com', '$2y$10$MWgafd7CQIOI5WEJ7CEn5uNDL476L8B0hu0qAge8rQQurLd/IVAC2', 'Menunggu', '2024-12-06 03:26:37', 'Hadir', NULL),
(2, 'Saepul roihan', 'saepulroihan@gmail.com', '$2y$10$IyM4TeR.QwhkjK4owFkAruFdzLeJPV2qZSQazx02sDDa4IBy59Q3i', 'Menunggu', '2024-12-06 03:26:37', 'Hadir', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wawancara`
--

CREATE TABLE `wawancara` (
  `id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `jenis_wawancara` enum('online','offline') NOT NULL,
  `jadwal` datetime DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `link_video_conference` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_ibfk_1` (`peserta_id`);

--
-- Indexes for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`),
  ADD KEY `jadwal_ujian_id` (`jadwal_ujian_id`);

--
-- Indexes for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `jadwal_ujiann`
--
ALTER TABLE `jadwal_ujiann`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_ujiannn`
--
ALTER TABLE `jadwal_ujiannn`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `kasus`
--
ALTER TABLE `kasus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kloter_ujian`
--
ALTER TABLE `kloter_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_keikutsertaan`
--
ALTER TABLE `log_keikutsertaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`),
  ADD KEY `jadwal_ujian_id` (`jadwal_ujian_id`);

--
-- Indexes for table `log_notifikasi`
--
ALTER TABLE `log_notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasi_id` (`notifikasi_id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `notifikasi_penunjukan`
--
ALTER TABLE `notifikasi_penunjukan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penguji_id` (`penguji_id`);

--
-- Indexes for table `notifikasi_ujian`
--
ALTER TABLE `notifikasi_ujian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penguji`
--
ALTER TABLE `penguji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penunjukan_penguji`
--
ALTER TABLE `penunjukan_penguji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD PRIMARY KEY (`peserta_ujian_id`),
  ADD KEY `peserta_id` (`peserta_id`),
  ADD KEY `ujian_id` (`ujian_id`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`ujian_id`);

--
-- Indexes for table `ujiann`
--
ALTER TABLE `ujiann`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wawancara`
--
ALTER TABLE `wawancara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peserta_id` (`peserta_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jadwal_ujiann`
--
ALTER TABLE `jadwal_ujiann`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_ujiannn`
--
ALTER TABLE `jadwal_ujiannn`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasus`
--
ALTER TABLE `kasus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kloter_ujian`
--
ALTER TABLE `kloter_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_keikutsertaan`
--
ALTER TABLE `log_keikutsertaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_notifikasi`
--
ALTER TABLE `log_notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifikasi_penunjukan`
--
ALTER TABLE `notifikasi_penunjukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifikasi_ujian`
--
ALTER TABLE `notifikasi_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penguji`
--
ALTER TABLE `penguji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `penunjukan_penguji`
--
ALTER TABLE `penunjukan_penguji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  MODIFY `peserta_ujian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `ujian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ujiann`
--
ALTER TABLE `ujiann`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wawancara`
--
ALTER TABLE `wawancara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hasil_ujian`
--
ALTER TABLE `hasil_ujian`
  ADD CONSTRAINT `hasil_ujian_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `hasil_ujian_ibfk_2` FOREIGN KEY (`jadwal_ujian_id`) REFERENCES `jadwal_ujiann` (`id`);

--
-- Constraints for table `jadwal_ujian`
--
ALTER TABLE `jadwal_ujian`
  ADD CONSTRAINT `jadwal_ujian_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_ujiannn`
--
ALTER TABLE `jadwal_ujiannn`
  ADD CONSTRAINT `jadwal_ujiannn_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);

--
-- Constraints for table `log_keikutsertaan`
--
ALTER TABLE `log_keikutsertaan`
  ADD CONSTRAINT `log_keikutsertaan_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `log_keikutsertaan_ibfk_2` FOREIGN KEY (`jadwal_ujian_id`) REFERENCES `jadwal_ujiann` (`id`);

--
-- Constraints for table `log_notifikasi`
--
ALTER TABLE `log_notifikasi`
  ADD CONSTRAINT `log_notifikasi_ibfk_1` FOREIGN KEY (`notifikasi_id`) REFERENCES `notifikasi_penunjukan` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);

--
-- Constraints for table `notifikasi_penunjukan`
--
ALTER TABLE `notifikasi_penunjukan`
  ADD CONSTRAINT `notifikasi_penunjukan_ibfk_1` FOREIGN KEY (`penguji_id`) REFERENCES `penguji` (`id`);

--
-- Constraints for table `peserta_ujian`
--
ALTER TABLE `peserta_ujian`
  ADD CONSTRAINT `peserta_ujian_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peserta_ujian_ibfk_2` FOREIGN KEY (`ujian_id`) REFERENCES `ujian` (`ujian_id`);

--
-- Constraints for table `ujiann`
--
ALTER TABLE `ujiann`
  ADD CONSTRAINT `ujiann_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wawancara`
--
ALTER TABLE `wawancara`
  ADD CONSTRAINT `wawancara_ibfk_1` FOREIGN KEY (`peserta_id`) REFERENCES `peserta` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
