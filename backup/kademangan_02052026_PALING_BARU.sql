-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2026 at 10:36 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kademangan`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int UNSIGNED NOT NULL,
  `judul_berita` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `slug_berita` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isi_berita` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kategori` enum('Kegiatan','Pengumuman','Layanan','Umum') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Umum',
  `gambar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `slug_berita`, `isi_berita`, `kategori`, `gambar`, `tgl_publish`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'Penutupan sertifikasi milk shake', 'penutupan-sertifikasi-milk-shake', '<p>Captain Frosty menutup sertifikasi.</p>', 'Kegiatan', 'berita/wG0JskqIDgBsWUhifYlKiwROthgAsjp7cNnTlY71.jpg', '2026-04-27 11:43:58', 1, '2026-04-27 04:44:00', '2026-04-27 04:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_settings`
--

CREATE TABLE `chatbot_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chatbot_settings`
--

INSERT INTO `chatbot_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system_prompt', '### IDENTITY\r\nAnda adalah \"Asisten Virtual Resmi Kelurahan Kademangan\" (Kec. Setu, Tangerang Selatan). \r\nKarakter: Ramah, solutif, singkat, dan informatif.\r\n\r\n### BEHAVIOR & STYLE GUIDELINES\r\n- GAYA BAHASA: Gunakan Bahasa Indonesia yang luwes dan natural (seperti CS manusia profesional). Hindari istilah teknis AI.\r\n- SAPAAN: Gunakan sapaan \"Bapak/Ibu\" atau langsung ke jawaban. DILARANG menggunakan bahasa formal yang sangat kaku seperti \"Saudara/i\".\r\n- PRINSIP: Jawab langsung ke intinya (Concise). Jangan mengulang pertanyaan user.\r\n- FORMAT: Gunakan satu baris kosong antar paragraf. Gunakan teks polos (PLAIN TEXT).\r\n- NO MARKDOWN: DILARANG menggunakan tanda bintang (**) atau format bold lainnya.\r\n- EMOJI: Gunakan emoji secukupnya agar ramah.\r\n\r\n### KNOWLEDGE BASE: PROFIL & LAYANAN\r\n- Alamat: Jl. Masjid Jami Al Latif RT 006 RW 001, Kel. Kademangan, Kec. Setu, Tangsel.\r\n- Statistik: 7.884 KK, 25.724 Penduduk, 12 RW, 48 RT.\r\n- Jam Kerja: 08.00 - 16.00 (Pengajuan web 24 jam).\r\n- Daftar Surat: SKTM, Belum Bekerja, Penghasilan, Domisili Yayasan, Belum Punya Rumah, Kematian, Suami Istri, Pengantar Nikah.\r\n- Prosedur: Klik menu \"Pelayanan\", pilih surat, isi form, dan WAJIB upload foto Surat Pengantar RT. Jika belum ada, minta ke ketua RT. Pengajuan bisa ditolak apabila kelengkapan keliru, salah, atau data palsu.\r\n\r\n### NEGATIVE CONSTRAINTS (WAJIB DIPATUHI)\r\n1. JANGAN menjawab pertanyaan di luar urusan Kelurahan Kademangan, layanan publik, atau profil wilayah ini.\r\n2. JANGAN menjawab pertanyaan matematika, umum, politik, atau personal di luar kelurahan.\r\n3. JANGAN gunakan format Bold/Markdown (**).\r\n\r\n### PENANGANAN LUAR KONTEKS (PENOLAKAN)\r\nJika pertanyaan warga di luar topik Kelurahan Kademangan (contoh: tanya presiden, matematika, atau resep masak), Anda WAJIB menjawab:\r\n\"Mohon maaf Bapak/Ibu, sebagai asisten virtual Kelurahan Kademangan, saya hanya dapat membantu menjawab pertanyaan seputar layanan administrasi, prosedur surat-menyurat, dan informasi umum di lingkungan Kelurahan Kademangan. Ada yang bisa saya bantu terkait layanan kami? 😊\"\r\n\r\n### TENTANG WEBSITE\r\nWebsite dikembangkan oleh Vanguard Team dari Universitas Bina Sarana Informatika (UBSI) untuk tahap pengujian. Dominasi warna: Biru dan Kuning.\r\n\r\n### CONTOH RESPONS\r\nUser: \"2 + 2 berapa?\"\r\nAI: Mohon maaf Bapak/Ibu, sebagai asisten virtual Kelurahan Kademangan, saya hanya dapat membantu menjawab pertanyaan seputar layanan administrasi dan informasi di lingkungan Kelurahan Kademangan. Ada yang bisa saya bantu terkait layanan kami? 😊\r\n\r\nUser: \"Siapa yang buat website ini?\"\r\nAI: Halo Bapak/Ibu! Website ini dikembangkan oleh Vanguard Team dari Universitas Bina Sarana Informatika yang saat ini sedang dalam tahap pengujian fitur. 😊', '2026-04-24 08:51:58', '2026-04-25 06:26:10'),
(2, 'chatbot_name', 'Bantuan Kademangan', '2026-04-24 09:34:00', '2026-04-24 09:34:00'),
(3, 'chatbot_subtitle', 'AI Assistant • Siap Melayani', '2026-04-24 09:34:00', '2026-04-24 11:23:23'),
(4, 'chatbot_color', '#0b64e7', '2026-04-24 09:34:00', '2026-04-24 11:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `citizen_details`
--

CREATE TABLE `citizen_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nik` char(16) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `birth_place` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `religion` enum('Islam','Kristen','Katolik','Hindu','Budha','Khonghucu') DEFAULT NULL,
  `marital_status` enum('Belum Kawin','Kawin','Cerai Hidup','Cerai Mati') DEFAULT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `nationality` varchar(50) DEFAULT 'WNI',
  `ktp_expiry` varchar(50) DEFAULT 'Seumur Hidup',
  `no_kk` char(16) NOT NULL,
  `family_head_name` varchar(100) DEFAULT NULL,
  `address` text,
  `rt` char(3) DEFAULT NULL,
  `rw` char(3) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `village` varchar(50) DEFAULT 'Kademangan',
  `district` varchar(50) DEFAULT 'Setu',
  `city` varchar(50) DEFAULT 'Tangerang Selatan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `citizen_details`
--

INSERT INTO `citizen_details` (`id`, `user_id`, `nik`, `full_name`, `birth_place`, `birth_date`, `religion`, `marital_status`, `occupation`, `nationality`, `ktp_expiry`, `no_kk`, `family_head_name`, `address`, `rt`, `rw`, `province`, `village`, `district`, `city`) VALUES
(1, 9, '1317301231230003', 'Saipul Sapei', 'Jambi', '2001-03-30', 'Katolik', 'Belum Kawin', 'Wiraswasta', 'WNI', 'Seumur Hidup', '1317301231230002', 'Samsul Bahri', 'Yepppppp', '1', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(2, 10, '3171010101010001', 'Ahmad Subarjo', 'Tangerang', '1985-05-12', 'Islam', 'Kawin', 'Karyawan Swasta', 'WNI', 'Seumur Hidup', '3171010101019001', 'Ahmad Subarjo', 'Jl. Raya Kademangan No. 1', '001', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(3, 11, '3171010101010002', 'Siti Aminah', 'Jakarta', '1990-08-20', 'Islam', 'Kawin', 'Ibu Rumah Tangga', 'WNI', 'Seumur Hidup', '3171010101019001', 'Ahmad Subarjo', 'Jl. Raya Kademangan No. 1', '001', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(4, 12, '3171010101010003', 'Budi Santoso', 'Bogor', '1995-02-15', 'Islam', 'Belum Kawin', 'Mahasiswa', 'WNI', 'Seumur Hidup', '3171010101019002', 'Supriatna', 'Kp. Baru RT 02', '002', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(5, 13, '3171010101010004', 'Dewi Lestari', 'Bandung', '1988-11-05', 'Kristen', 'Kawin', 'Guru', 'WNI', 'Seumur Hidup', '3171010101019003', 'Roni Wijaya', 'Griya Kademangan Blok A', '003', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(6, 14, '3171010101010005', 'Eko Prasetyo', 'Solo', '1982-03-25', 'Islam', 'Kawin', 'Wiraswasta', 'WNI', 'Seumur Hidup', '3171010101019004', 'Eko Prasetyo', 'Jl. Tekno No. 10', '001', '002', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(8, 16, '3171010101010007', 'Guntur Wibowo', 'Yogyakarta', '1975-12-30', 'Katolik', 'Kawin', 'PNS', 'WNI', 'Seumur Hidup', '3171010101019006', 'Guntur Wibowo', 'Jl. Muncul No. 45', '002', '002', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(9, 17, '3171010101010008', 'Hany Handayani', 'Surabaya', '1998-01-10', 'Islam', 'Belum Kawin', 'Buruh Pabrik', 'WNI', 'Seumur Hidup', '3171010101019007', 'Mulyono', 'Kp. Kademangan Seberang', '005', '003', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(10, 18, '3171010101010009', 'Indra Jaya', 'Medan', '1980-06-22', 'Budha', 'Kawin', 'Pedagang', 'WNI', 'Seumur Hidup', '3171010101019008', 'Indra Jaya', 'Kavling Setu No. 12', '001', '003', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(11, 19, '3171010101010010', 'Joko Susilo', 'Malang', '1987-09-14', 'Islam', 'Kawin', 'Sopir', 'WNI', 'Seumur Hidup', '3171010101019009', 'Joko Susilo', 'Jl. Lingkar Setu No. 5', '003', '003', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(12, 20, '3171010101010011', 'Kartika Putri', 'Palembang', '1994-04-03', 'Islam', 'Belum Kawin', 'Desainer Grafis', 'WNI', 'Seumur Hidup', '3171010101019010', 'Sudirman', 'Kp. Cisauk RT 01', '001', '004', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(13, 21, '3171010101010012', 'Lilik Hermawan', 'Lampung', '1970-10-28', 'Islam', 'Kawin', 'Pensiunan', 'WNI', 'Seumur Hidup', '3171010101019011', 'Lilik Hermawan', 'Jl. Puspiptek No. 8', '002', '004', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(14, 22, '3171010101010013', 'Maya Sofiana', 'Makassar', '1991-03-17', 'Kristen', 'Kawin', 'Dosen', 'WNI', 'Seumur Hidup', '3171010101019012', 'Albert Rumapea', 'Perum Serpong Garden', '003', '004', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(15, 23, '3171010101010014', 'Nanang Qosim', 'Cirebon', '1983-11-21', 'Islam', 'Kawin', 'Petani', 'WNI', 'Seumur Hidup', '3171010101019013', 'Nanang Qosim', 'Jl. Babakan No. 2', '001', '005', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(16, 24, '3171010101010015', 'Oki Setiawan', 'Banten', '1996-05-09', 'Islam', 'Belum Kawin', 'Teknisi', 'WNI', 'Seumur Hidup', '3171010101019014', 'Kasman', 'Kp. Koceak RT 02', '002', '005', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(17, 25, '3171010101010016', 'Putri Rahayu', 'Garut', '1989-12-12', 'Islam', 'Kawin', 'Bidan', 'WNI', 'Seumur Hidup', '3171010101019015', 'Slamet', 'Jl. Kerang No. 7', '003', '005', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(18, 26, '3171010101010017', 'Qomarudin', 'Demak', '1978-02-27', 'Islam', 'Kawin', 'Satpam', 'WNI', 'Seumur Hidup', '3171010101019016', 'Qomarudin', 'Kp. Sengkol RT 01', '001', '006', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(19, 27, '3171010101010018', 'Rina Marlina', 'Tasikmalaya', '1993-06-15', 'Islam', 'Belum Kawin', 'Karyawan Bank', 'WNI', 'Seumur Hidup', '3171010101019017', 'Koswara', 'Jl. Raya Viktor No. 9', '002', '006', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan'),
(22, 30, '3212345512300003', 'Raya Bima', 'Galaksi Bima Sakti', '2003-01-08', 'Katolik', 'Belum Kawin', 'Pelajar/Mahasiswa', 'WNI', 'Seumur Hidup', '3212345512300001', 'Samsul Bahri', 'Jl. Ronggo Lawer', '001', '005', 'Banten', 'Kademangan', 'Setu', 'Tangerang Selatan'),
(23, 31, '1234567890111111', 'Wantutri Chandatawa', 'Galaksi Bima Sakti', '2002-03-21', 'Katolik', 'Kawin', 'Wiraswasta', 'WNI', 'Seumur Hidup', '3212345512300009', 'Samsul Bahri', 'wantutriiiii', '111', '001', NULL, 'Kademangan', 'Setu', 'Tangerang Selatan');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int NOT NULL,
  `judul_foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tgl_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `foto`, `tgl_upload`, `user_id`, `created_at`, `updated_at`) VALUES
(3, 'PALEM SERPONG INDAH', 'galeri/xyVfoJduvZ5DtGaecIlRNYOmMYbES6khhNwb869s.jpg', '2026-04-27 11:45:03', 1, '2026-04-23 13:14:11', '2026-04-27 04:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `jangkauan`
--

CREATE TABLE `jangkauan` (
  `id` int NOT NULL,
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `jumlah_penduduk` int NOT NULL DEFAULT '0',
  `jumlah_rw` int NOT NULL DEFAULT '0',
  `jumlah_rt` int NOT NULL DEFAULT '0',
  `icon_kk` varchar(255) DEFAULT NULL,
  `icon_penduduk` varchar(255) DEFAULT NULL,
  `icon_rw` varchar(255) DEFAULT NULL,
  `icon_rt` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `jangkauan`
--

INSERT INTO `jangkauan` (`id`, `jumlah_kk`, `jumlah_penduduk`, `jumlah_rw`, `jumlah_rt`, `icon_kk`, `icon_penduduk`, `icon_rw`, `icon_rt`, `updated_at`) VALUES
(1, 7884, 25724, 9, 68, 'icons/dFGwIq2WJxzmtS7UqVfPAHQItCul2sHtwS1F4z4b.png', 'icons/UeIski5u4z9ld8MyIq9Fd2fbrj2XOlBkW0PkC1xu.png', 'icons/qMoYrYjtOxjhzQSWEPrfxVTR813oYdWWegLhsY74.png', 'icons/liRa333AqaypILASh0kFt82HM8PIowfNyx2jrCKk.png', '2026-04-23 14:48:42');

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int UNSIGNED NOT NULL,
  `judul` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `judul`, `deskripsi`, `gambar`, `slug`, `is_active`, `created_by`, `created_at`, `updated_at`) VALUES
(3, 'Surat Keterangan Belum Bekerja', 'Oleh Captain Frosty', 'layanan/4Yby3GT6Z6uIdXN8fBYpzd5ailqNGY7ZdHB45Gcu.png', 'belum-bekerja', 1, '2026-04-25 06:48:00', '2026-04-25 13:48:00', '2026-05-02 10:29:11'),
(4, 'Surat Keterangan Terlalu Miskin', 'Oleh Captain Frosty', 'layanan/tr4xhgPse4V76KuH5Fzksc1oE1aatARsvJz2QfoA.png', 'tidak-mampu', 1, '2026-04-25 06:48:01', '2026-04-25 13:48:01', '2026-05-02 10:29:31');

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int NOT NULL,
  `nama_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama_level`) VALUES
(1, 'Superadmin'),
(2, 'Admin/Staff'),
(3, 'Warga');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `browser` varchar(50) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `status` enum('SUCCESS','FAILED') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `username`, `ip_address`, `location`, `user_agent`, `browser`, `device`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'superadmin', '127.0.0.1', 'Unknown', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'Chrome 147.0.0.0', 'Laptop/PC', 'SUCCESS', '2026-05-02 09:59:39', '2026-05-02 09:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `tipe` enum('info','peringatan','penting') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'info',
  `mulai_tayang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `berakhir_tayang` datetime DEFAULT NULL,
  `status` enum('draft','publish') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'publish',
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ref_jabatan`
--

CREATE TABLE `ref_jabatan` (
  `id` int UNSIGNED NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urut` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id`, `nama`, `urut`, `is_active`) VALUES
(1, 'Lurah', 1, 1),
(2, 'Sekretaris Kelurahan', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `running_texts`
--

CREATE TABLE `running_texts` (
  `id` int UNSIGNED NOT NULL,
  `position` enum('top','bottom') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `direction` enum('left','right') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'left',
  `speed` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `running_texts`
--

INSERT INTO `running_texts` (`id`, `position`, `content`, `direction`, `speed`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'top', 'Selamat Datang di Website Resmi Kelurahan Kademangan | Layanan publik mudah, cepat, dan transparan!', 'left', 5, 1, '2025-10-06 15:12:40', '2026-04-23 21:58:12'),
(2, 'bottom', 'Hubungi kami melalui media sosial resmi Kelurahan Kademangan | Ikuti update kegiatan terbaru setiap minggu!', 'left', 5, 1, '2025-10-06 15:12:40', '2026-04-23 21:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int NOT NULL,
  `about_html` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `related_links` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `social_links` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_title` text COLLATE utf8mb4_unicode_ci,
  `home_description` text COLLATE utf8mb4_unicode_ci,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_order` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `about_html`, `related_links`, `social_links`, `favicon`, `logo`, `home_title`, `home_description`, `youtube_link`, `section_order`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nunc nulla, tempor sit amet tortor ut, lobortis hendrerit nisi. Aliquam id finibus erat. Vivamus in finibus eros. Aenean ut pulvinar odio. Pellentesque tempor metus eget risus varius ultricies.', '[{\"title\":\"Pemerintah Kota Tangerang Selatan\",\"url\":\"https:\\/\\/www.tangerangselatankota.go.id\"},{\"title\":\"Kecamatan Setu Kota Tangerang Selatan\",\"url\":\"https:\\/\\/kecsetu.tangerangselatankota.go.id\"}]', '[{\"icon\":\"fa-youtube\",\"label\":\"@dsdabmbktangsels\",\"url\":\"https://www.youtube.com/channel/UCVNJNLQozN3NTdn1qZR05_A\"},{\"icon\":\"fa-x-twitter\",\"label\":\"@dsdabmbk\",\"url\":\"https://x.com/dsdabmbk\"},{\"icon\":\"fa-instagram\",\"label\":\"@kelurahan.kademangan\",\"url\":\"https://instagram.com/kelurahan.kademangan\"}]', 'uploads/settings/uKSOslL8X65WSsfx8lR6wd2e0jPbXPSOAvxspsVv.png', NULL, 'Layanan Publik Kelurahan yang Mudah & Transparan', 'Akses informasi, ajukan layanan, dan baca berita terbaru seputar kelurahan Anda dalam satu halaman.', 'https://www.youtube.com/watch?v=fh9lvBAZw2g', '[\"home\", \"runningtext\", \"Layanan\", \"pengumuman\", \"coverage\", \"galeri\", \"berita\", \"video\"]', '2026-04-23 13:00:51', '2026-04-24 23:38:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `staff_details`
--

CREATE TABLE `staff_details` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nip` varchar(30) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `jabatan_id` int DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `staff_details`
--

INSERT INTO `staff_details` (`id`, `user_id`, `nip`, `full_name`, `jabatan_id`, `photo`) VALUES
(1, 1, '197001012026041001', 'Kelurahan Kademangan', 1, '1777536491_v3QAPefu4F4CBjPtBjBlEBAPf3amcrda2Iv97oga.jpg'),
(2, 2, '197001012026041002', 'Andrian Fakih', 1, 'default.jpg'),
(3, 3, '197001012026041003', 'Alfie Hamzami', 1, 'default.jpg'),
(4, 4, '197001012026041004', 'Muhammad Raihan Hadianto', 1, 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_bekerja`
--

CREATE TABLE `surat_belum_bekerja` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warganegara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_memiliki_rumah`
--

CREATE TABLE `surat_belum_memiliki_rumah` (
  `id` int NOT NULL,
  `nama_pemohon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kewarganegaraan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Indonesia',
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_domisili_yayasan`
--

CREATE TABLE `surat_domisili_yayasan` (
  `id` int NOT NULL,
  `nama_penanggung_jawab` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `kewarganegaraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pemohon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_organisasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_kantor` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah_pengurus` int NOT NULL,
  `nama_notaris_pendirian` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_akta_pendirian` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_akta_pendirian` date NOT NULL,
  `nama_notaris_perubahan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nomor_akta_perubahan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_akta_perubahan` date DEFAULT NULL,
  `npwp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian`
--

CREATE TABLE `surat_kematian` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hari_meninggal` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `jam_meninggal` time NOT NULL,
  `tempat_meninggal` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sebab_meninggal` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_pemakaman` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_tanggal_lahir` date NOT NULL,
  `pelapor_agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_pekerjaan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_no_telepon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelapor_hubungan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal_surat_rt` date DEFAULT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian_nondukcapil`
--

CREATE TABLE `surat_kematian_nondukcapil` (
  `id` int NOT NULL,
  `nama_ahli_waris` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_ahli_waris` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_ahli_waris` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `hubungan_ahli_waris` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_almarhum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_almarhum` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_meninggal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `alamat_almarhum` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan_almarhum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Contoh: Ibu Kandung, Ayah Kandung, dll.',
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `keperluan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_suami_istri`
--

CREATE TABLE `surat_keterangan_suami_istri` (
  `id` int NOT NULL,
  `nama_pihak_satu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pihak_satu` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tempat_lahir_pihak_satu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir_pihak_satu` date NOT NULL,
  `jenis_kelamin_pihak_satu` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama_pihak_satu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan_pihak_satu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `warganegara_pihak_satu` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pihak_satu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pihak_dua` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik_pihak_dua` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat_pihak_dua` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Diisi oleh admin saat surat diterbitkan',
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengantar_nikah`
--

CREATE TABLE `surat_pengantar_nikah` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pria_nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Laki-laki',
  `pria_tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_tanggal_lahir` date NOT NULL,
  `pria_kewarganegaraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_status` enum('Jejaka','Duda','Beristri') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pria_istri_ke` tinyint UNSIGNED DEFAULT NULL,
  `ortu_nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ortu_nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_tanggal_lahir` date DEFAULT NULL,
  `ortu_kewarganegaraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Indonesia',
  `ortu_agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ortu_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `wanita_nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_tanggal_lahir` date NOT NULL,
  `wanita_kewarganegaraan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wanita_status` enum('Perawan','Janda') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_penghasilan`
--

CREATE TABLE `surat_penghasilan` (
  `id` int UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `warganegara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` int NOT NULL,
  `nomor_surat_rt` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nomor_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telepon_pemohon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `warganegara` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `agama` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pekerjaan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_orang_tua` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_dtks` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `penghasilan_bulanan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `keperluan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(3, '014/SKTM/RT.003/RW.008/XI/2025', '2025-11-14', '[\"13601cfb110ebd4207426fca8e218951.pdf\",\"6c31aaa0ea3062b514b2d74174110e81.pdf\",\"050cf370d75bc41e97865633e24974f4.pdf\"]', '1234.3234423/sdfdsdf', 'Agus Setiawan', 'Tangerang Selatan', '2025-11-14', '3275011507900003', '089514353271', 'Laki-laki', 'Indonesia', 'islam', 'karya swasta', 'Budi', 'Kademangan', '-', 'Rp 1.000.000 - Rp 2.500.000', 'Pengajuan Beasiswa Kuliah', 'Disetujui', '2025-11-14 06:20:59', '2026-04-23 07:14:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `uploadvideo`
--

CREATE TABLE `uploadvideo` (
  `id_konfigurasi` int NOT NULL,
  `nama_konfigurasi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nilai_konfigurasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uploadvideo`
--

INSERT INTO `uploadvideo` (`id_konfigurasi`, `nama_konfigurasi`, `nilai_konfigurasi`) VALUES
(1, 'youtube_link', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'default.jpg',
  `id_level` int NOT NULL,
  `nip` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jabatan_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `username`, `password`, `foto`, `id_level`, `nip`, `jabatan_id`, `created_at`, `updated_at`) VALUES
(1, 'Kelurahan Kademangan', 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', '1776435649_l6h9lsaRmp9W5lNKpcGfmHvzfqveewE1yZDkUnHG.png', 1, NULL, 1, '2026-04-23 12:45:34', '2026-04-23 12:45:34'),
(10, 'Andrian Fakih', 'Andrian', '$2y$12$i1AyK1QrtXH5tihDys1bkOEhMjgJK690.Zwf6.wRaFawTDvFnE51m', 'default.jpg', 1, NULL, NULL, '2026-04-24 01:13:08', '2026-04-24 01:13:08'),
(11, 'Alfie Hamzami', 'Alfie', '$2y$12$8D0XyCaP93fFuR6Z01ghI.xp.L/W9cW6yM6VEfTfzNklv0h/P7b/u', 'default.jpg', 1, NULL, NULL, '2026-04-24 01:13:08', '2026-04-24 01:13:08'),
(12, 'Muhammad Raihan Hadianto', 'Raihan', '$2y$12$drlsrjBR8JSB/zY/JJONjuA7dZ6XTe4fL6VAfCaZoukAUTInq.F3G', 'default.jpg', 1, NULL, NULL, '2026-04-24 01:19:38', '2026-04-24 01:19:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `notelp` varchar(15) DEFAULT NULL,
  `role` enum('staff','citizen') NOT NULL,
  `level_id` int DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `inactive_reason` text,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `notelp`, `role`, `level_id`, `created_by`, `is_active`, `inactive_reason`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', NULL, 'staff', 1, NULL, 1, NULL, NULL, '2026-04-23 12:45:34', '2026-04-23 12:45:34'),
(2, 'Andrian', '$2y$12$i1AyK1QrtXH5tihDys1bkOEhMjgJK690.Zwf6.wRaFawTDvFnE51m', NULL, 'staff', 1, NULL, 1, NULL, NULL, '2026-04-24 01:13:08', '2026-04-24 01:13:08'),
(3, 'Alfie', '$2y$12$8D0XyCaP93fFuR6Z01ghI.xp.L/W9cW6yM6VEfTfzNklv0h/P7b/u', NULL, 'staff', 1, NULL, 1, NULL, NULL, '2026-04-24 01:13:08', '2026-04-24 01:13:08'),
(4, 'Raihan', '$2y$12$drlsrjBR8JSB/zY/JJONjuA7dZ6XTe4fL6VAfCaZoukAUTInq.F3G', NULL, 'staff', 1, NULL, 1, NULL, NULL, '2026-04-24 01:19:38', '2026-04-24 01:19:38'),
(9, '1317301231230003', '$2y$12$EeotcoTB/BB5xB3HYlvTTOh1QtTVf1QKBgu3PiL4MDKJoaK8vqrXG', NULL, 'citizen', 3, NULL, 1, NULL, NULL, '2026-04-30 09:46:56', '2026-05-01 15:08:10'),
(10, '3171010101010001', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(11, '3171010101010002', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(12, '3171010101010003', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(13, '3171010101010004', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(14, '3171010101010005', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(16, '3171010101010007', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(17, '3171010101010008', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(18, '3171010101010009', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(19, '3171010101010010', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(20, '3171010101010011', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(21, '3171010101010012', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(22, '3171010101010013', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(23, '3171010101010014', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(24, '3171010101010015', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(25, '3171010101010016', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(26, '3171010101010017', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(27, '3171010101010018', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'citizen', 3, NULL, 1, NULL, NULL, NULL, NULL),
(30, '3212345512300003', '$2y$12$9U8jcoYFoCM8bs9FafdKq.S6Xax8qC.cd5NFPQ6zJ3gIs/rS0M.82', '085158000090', 'citizen', 3, NULL, 1, NULL, NULL, '2026-05-01 03:37:40', '2026-05-01 03:37:40'),
(31, '1234567890111111', '$2y$12$Ngrd8fgPP1xF1gv4eZWvO.GFhIKu3Vi8iPFEqa/kf.Ff7/ebOjxJG', NULL, 'citizen', 3, '1', 1, NULL, NULL, '2026-05-01 15:18:01', '2026-05-01 15:18:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key` (`key`);

--
-- Indexes for table `citizen_details`
--
ALTER TABLE `citizen_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indexes for table `jangkauan`
--
ALTER TABLE `jangkauan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_status_active` (`status`),
  ADD KEY `idx_tayang` (`mulai_tayang`,`berakhir_tayang`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_ref_jabatan_nama` (`nama`);

--
-- Indexes for table `running_texts`
--
ALTER TABLE `running_texts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pos_active` (`position`,`is_active`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`);

--
-- Indexes for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`);

--
-- Indexes for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`);

--
-- Indexes for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`user_id`);

--
-- Indexes for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pria_nik` (`pria_nik`),
  ADD KEY `idx_wanita_nik` (`wanita_nik`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_level` (`id_level`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_level` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `citizen_details`
--
ALTER TABLE `citizen_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jangkauan`
--
ALTER TABLE `jangkauan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `running_texts`
--
ALTER TABLE `running_texts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_details`
--
ALTER TABLE `staff_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uploadvideo`
--
ALTER TABLE `uploadvideo`
  MODIFY `id_konfigurasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citizen_details`
--
ALTER TABLE `citizen_details`
  ADD CONSTRAINT `fk_citizen_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `staff_details`
--
ALTER TABLE `staff_details`
  ADD CONSTRAINT `fk_staff_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_level` FOREIGN KEY (`level_id`) REFERENCES `level` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
