-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2026 at 09:49 AM
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
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `slug_berita`, `isi_berita`, `kategori`, `gambar`, `tgl_publish`, `id_user`, `created_at`, `updated_at`) VALUES
(2, 'Antusiasme Warga Kelurahan Jayabakti dalam Penyuluhan Program Bank Sampah', 'antusiasme-warga-kelurahan-jayabakti-dalam-penyuluhan-program-bank-sampah', '<p><strong>Jayabakti, 14 November 2025</strong> – Aula Kelurahan Jayabakti dipenuhi warga yang antusias mengikuti \"Penyuluhan dan Sosialisasi Program Bank Sampah\" pagi ini (14/11). Acara ini dibuka langsung oleh Bapak Lurah Jayabakti, Budi Santoso, S.Sos.</p><p>Dalam sambutannya, beliau menekankan pentingnya pengelolaan sampah yang baik dari tingkat rumah tangga untuk mengurangi volume sampah di TPA dan memberikan nilai ekonomis bagi warga.</p><p>\"Kami berharap program bank sampah ini tidak hanya membuat lingkungan kita lebih bersih, tapi juga bisa menambah sedikit pemasukan untuk kas RT atau bahkan untuk warga sendiri,\" ujar Bapak Budi.<br>Penyuluhan ini menghadirkan narasumber dari Dinas Lingkungan Hidup Kota Bekasi yang memberikan pelatihan praktis tentang pemilahan sampah organik, anorganik, dan residu. Warga juga diajarkan cara mencatat dan menimbang sampah yang akan disetorkan ke bank sampah unit RW masing-masing.</p>', 'Kegiatan', 'ea5742f21c68ea75392a7e65a1653f2a.jpg', '2025-11-14 06:23:54', 1, '2026-04-23 13:06:22', '2026-04-23 13:06:22');

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
(1, 'system_prompt', '### IDENTITY\r\nAnda adalah \"Asisten Virtual Resmi Kelurahan Kademangan\" (Kec. Setu, Tangerang Selatan). \r\nKarakter: Ramah, solutif, singkat, dan informatif.\r\n\r\n### BEHAVIOR & STYLE GUIDELINES\r\n- GAYA BAHASA: Gunakan Bahasa Indonesia yang luwes dan natural (seperti CS manusia profesional). Hindari istilah teknis AI.\r\n- SAPAAN: Gunakan sapaan \"Bapak/Ibu\" atau langsung ke jawaban. DILARANG menggunakan bahasa formal yang sangat kaku seperti \"Saudara/i\".\r\n- PRINSIP: Jawab langsung ke intinya (Concise). Jangan mengulang pertanyaan user.\r\n- FORMAT: Gunakan bullet points untuk prosedur. Gunakan satu baris kosong antar paragraf agar enak dibaca di layar HP.\r\n- NO MARKDOWN BOLD: DILARANG KERAS menggunakan format bold atau tanda bintang ganda (**) pada kata atau kalimat apa pun. Kirimkan semua jawaban dalam bentuk teks polos (plain text).\r\n- EMOJI: Penggunaan emoji diperbolehkan untuk menambah kesan ramah.\r\n\r\n### KNOWLEDGE BASE: PROFIL WILAYAH\r\n- Alamat: Jl. Masjid Jami Al Latif RT 006 RW 001, Kel. Kademangan, Kec. Setu, Tangsel.\r\n- Status: Kelurahan terluas ke-3 di Kec. Setu (Berdasarkan Perda 10/2012).\r\n- Statistik Utama: 7.884 KK, 25.724 Penduduk, 12 RW, dan 48 RT (Mayoritas Suku Sunda).\r\n\r\n### LAYANAN ADMINISTRASI & PROSEDUR\r\n- Daftar Surat: SKTM, Surat Keterangan Belum Bekerja, Penghasilan, Domisili Yayasan, Belum Punya Rumah, Kematian, Suami Istri, Pengantar Nikah.\r\n- Alur Pengajuan: \r\n  1. Klik tombol \"Pelayanan\" di website.\r\n  2. Pilih jenis surat yang dibutuhkan.\r\n  3. Isi formulir lengkap.\r\n  4. WAJIB: Upload foto \"Surat Pengantar RT\" sebagai syarat utama validasi.\r\n- Surat akan dilayani dengan jam operasional atau jam kerja dari pukul 08.00 hingga pukul 16.00, sementara pengajuan surat tetap dapat dilakukan 24 jam.\r\n\r\n### NEGATIVE CONSTRAINTS (TIDAK BOLEH DILAKUKAN)\r\n1. DILARANG menggunakan format Markdown bold (contoh: **teks**) dalam situasi apa pun.\r\n2. Jangan menjawab pertanyaan di luar urusan Kelurahan Kademangan, pemerintahan, atau layanan publik.\r\n3. Jika tidak tahu jawaban pastinya, arahkan warga untuk datang langsung ke kantor kelurahan pada jam kerja.\r\n4. Jangan memberikan opini politik atau isu sensitif lainnya.\r\n\r\n### TENTANG WEBSITE\r\nWebsite ini sedang dalam pengujian, maka kemungkinan ada banyak fitur yang belum sempurna. Website ini dikembangkan oleh Vanguard Team dari Universitas Bina Sarana Informatika. \r\n\r\n### CIRI CIRI WEBSITE\r\nWarna website ini didominasi oleh warna biru dan kuning.\r\n\r\n### CONTOH RESPONS\r\nUser: \"Siapa yang buat website ini?\"\r\nAI: Halo Bapak/Ibu! Website ini dikembangkan oleh Vanguard Team dari Universitas Bina Sarana Informatika yang saat ini sedang dalam tahap pengujian fitur. 😊', '2026-04-24 08:51:58', '2026-04-24 09:47:32'),
(2, 'chatbot_name', 'Bantuan Kademangan', '2026-04-24 09:34:00', '2026-04-24 09:34:00'),
(3, 'chatbot_subtitle', 'AI Assistant • Siap Melayani', '2026-04-24 09:34:00', '2026-04-24 09:34:00'),
(4, 'chatbot_color', '#0d6efd', '2026-04-24 09:34:00', '2026-04-24 09:34:00');

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
  `id_user` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `foto`, `tgl_upload`, `id_user`, `created_at`, `updated_at`) VALUES
(3, 'PALEM SERPONG INDAH', '539a26ae19faafc93820a60fbaf47d85.jpg', '2025-10-29 10:39:52', 1, '2026-04-23 13:14:11', '2026-04-23 13:14:11');

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
  `created_by` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` int NOT NULL,
  `nama_level` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`) VALUES
(1, 'Superadmin'),
(2, 'Admin/Staff');

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
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `about_html`, `related_links`, `social_links`, `favicon`, `logo`, `youtube_link`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc nunc nulla, tempor sit amet tortor ut, lobortis hendrerit nisi. Aliquam id finibus erat. Vivamus in finibus eros. Aenean ut pulvinar odio. Pellentesque tempor metus eget risus varius ultricies.', '[{\"title\":\"Pemerintah Kota Tangerang Selatan\",\"url\":\"https:\\/\\/www.tangerangselatankota.go.id\"},{\"title\":\"Kecamatan Setu Kota Tangerang Selatan\",\"url\":\"https:\\/\\/kecsetu.tangerangselatankota.go.id\"}]', '[{\"icon\":\"fa-youtube\",\"label\":\"@dsdabmbktangsels\",\"url\":\"https:\\/\\/www.youtube.com\\/channel\\/UCVNJNLQozN3NTdn1qZR05_A\"},{\"icon\":\"fa-x-twitter\",\"label\":\"@dsdabmbk\",\"url\":\"https:\\/\\/x.com\\/dsdabmbk\"},{\"icon\":\"fa-instagram\",\"label\":\"@kelurahan.kademangan\",\"url\":\"https:\\/\\/instagram.com\\/kelurahan.kademangan\"}]', 'uploads/settings/uKSOslL8X65WSsfx8lR6wd2e0jPbXPSOAvxspsVv.png', NULL, 'https://www.youtube.com/watch?v=fh9lvBAZw2g', '2026-04-23 13:00:51', '2026-04-23 14:03:49', NULL);

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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
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
  `id_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `status`, `created_at`, `updated_at`, `id_user`) VALUES
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
  ADD PRIMARY KEY (`id_level`);

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
-- Indexes for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

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
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
