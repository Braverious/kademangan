-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 27, 2026 at 11:22 AM
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
  `id_berita` bigint UNSIGNED NOT NULL,
  `judul_berita` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug_berita` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi_berita` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('Kegiatan','Pengumuman','Layanan','Umum') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Umum',
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_publish` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `slug_berita`, `isi_berita`, `kategori`, `gambar`, `tgl_publish`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Antusiasme Warga Kelurahan Jayabakti dalam Penyuluhan Program Bank Sampah', 'antusiasme-warga-kelurahan-jayabakti-dalam-penyuluhan-program-bank-sampah', '<p>Mantap kali banggg <strong>SASSS</strong></p>', 'Umum', 'berita/dKP3NrsKbmNktBIjUiKRiGCiD1yErRbQ7IAI0HX7.png', '2026-04-27 16:01:23', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_settings`
--

CREATE TABLE `chatbot_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_settings`
--

INSERT INTO `chatbot_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'system_prompt', 'Anda adalah asisten virtual resmi Kelurahan Kademangan...', '2026-04-27 08:53:04', '2026-04-27 08:53:04');

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
  `id_galeri` bigint UNSIGNED NOT NULL,
  `judul_foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_foto`, `foto`, `tgl_upload`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'Logo Tangerang Selatan', 'galeri/JUd28vmagv2UuTEo5nkVpsFeEuanhLFHCoE34iok.png', '2026-04-27 16:01:39', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jangkauan`
--

CREATE TABLE `jangkauan` (
  `id` bigint UNSIGNED NOT NULL,
  `jumlah_kk` int NOT NULL DEFAULT '0',
  `jumlah_penduduk` int NOT NULL DEFAULT '0',
  `jumlah_rw` int NOT NULL DEFAULT '0',
  `jumlah_rt` int NOT NULL DEFAULT '0',
  `icon_kk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_penduduk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_rw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_rt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jangkauan`
--

INSERT INTO `jangkauan` (`id`, `jumlah_kk`, `jumlah_penduduk`, `jumlah_rw`, `jumlah_rt`, `icon_kk`, `icon_penduduk`, `icon_rw`, `icon_rt`, `created_at`, `updated_at`) VALUES
(1, 25000, 0, 0, 0, 'icons/9fpE0xrDQ5zrIHrnkzpkczrSdcDZ4G60fGVtUnBp.png', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `judul`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(6, 'Tangsel', 'sssssssssssssssssss', 'layanan/UL3DxUF3pzCkVsFRXLFbEZMHP4s3knsX1NjWlWsI.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id_level` bigint UNSIGNED NOT NULL,
  `nama_level` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id_level`, `nama_level`, `created_at`, `updated_at`) VALUES
(1, 'Superadmin', NULL, NULL),
(2, 'Admin/Staff', NULL, NULL);

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
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_21_233600_create_level_table', 1),
(6, '2026_04_21_233610_create_layanan_table', 1),
(7, '2026_04_21_233652_create_user_table', 1),
(8, '2026_04_21_233746_create_berita_table', 1),
(9, '2026_04_21_233818_create_galeri_table', 1),
(10, '2026_04_21_233840_create_pengumuman_table', 1),
(11, '2026_04_21_233945_create_running_texts_table', 1),
(12, '2026_04_21_234027_create_ref_jabatan_table', 1),
(13, '2026_04_21_234114_create_jangkauan_table', 1),
(14, '2026_04_22_003651_create_surat_sktm_table', 1),
(15, '2026_04_23_205124_create_surat_belum_bekerja_table', 1),
(16, '2026_04_23_205548_create_surat_belum_memiliki_rumah_table', 1),
(17, '2026_04_23_205650_create_surat_domisili_yayasan_table', 1),
(18, '2026_04_23_211034_create_surat_kematian_table', 1),
(19, '2026_04_23_212245_create_surat_kematian_nondukcapil_table', 1),
(20, '2026_04_23_212335_create_surat_keterangan_suami_istri_table', 1),
(21, '2026_04_23_212413_create_surat_pengantar_nikah_table', 1),
(22, '2026_04_23_222342_create_site_settings_table', 1),
(23, '2026_04_24_154557_create_chatbot_settings_table', 1),
(24, '2026_04_25_121452_create_pejabat_table', 1),
(25, '2026_04_25_142551_create_surat_penghasilan_table', 1),
(26, '2026_04_27_000000_add_home_fields_to_site_settings_table', 2);

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
-- Table structure for table `pejabat`
--

CREATE TABLE `pejabat` (
  `id` bigint UNSIGNED NOT NULL,
  `jabatan_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` bigint UNSIGNED NOT NULL,
  `judul` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipe` enum('info','peringatan','penting') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'info',
  `mulai_tayang` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `berakhir_tayang` datetime DEFAULT NULL,
  `status` enum('draft','publish') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'publish',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `tipe`, `mulai_tayang`, `berakhir_tayang`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'dddddddddddddddd', 'ssssssssssssssssssssss', 'info', '2026-04-27 16:01:00', '2026-04-28 16:01:00', 'publish', 1, '2026-04-27 09:01:51', '2026-04-27 09:01:51');

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
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urut` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ref_jabatan`
--

INSERT INTO `ref_jabatan` (`id`, `nama`, `urut`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Lurah', 1, 1, NULL, NULL),
(2, 'Sekretaris', 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `running_texts`
--

CREATE TABLE `running_texts` (
  `id` bigint UNSIGNED NOT NULL,
  `position` enum('top','bottom') COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('left','right') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'left',
  `speed` tinyint UNSIGNED NOT NULL DEFAULT '5',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `running_texts`
--

INSERT INTO `running_texts` (`id`, `position`, `content`, `direction`, `speed`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'top', 'Selamat datang di kelurahan kedamangan', 'left', 6, 1, '2026-04-27 09:14:14', '2026-04-27 09:14:14'),
(2, 'bottom', 'Pelayana buka jam 08:00 - 15:00', 'left', 5, 1, '2026-04-27 09:14:14', '2026-04-27 09:14:14');

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` int UNSIGNED NOT NULL,
  `about_html` mediumtext COLLATE utf8mb4_unicode_ci,
  `related_links` mediumtext COLLATE utf8mb4_unicode_ci,
  `social_links` mediumtext COLLATE utf8mb4_unicode_ci,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_description` text COLLATE utf8mb4_unicode_ci,
  `section_order` mediumtext COLLATE utf8mb4_unicode_ci,
  `youtube_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `about_html`, `related_links`, `social_links`, `favicon`, `logo`, `home_title`, `home_description`, `section_order`, `youtube_link`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '', '[]', '[]', NULL, NULL, NULL, NULL, '[\"home\",\"runningtext\",\"Layanan\",\"galeri\",\"pengumuman\",\"berita\",\"jangkauan\",\"video\"]', 'https://youtu.be/GC6DNb49HWM?si=j-DRODGiFSc6tfJ0', '2026-04-27 08:58:21', '2026-04-27 17:16:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_bekerja`
--

CREATE TABLE `surat_belum_bekerja` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warganegara` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_belum_bekerja`
--

INSERT INTO `surat_belum_bekerja` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `nik`, `telepon_pemohon`, `warganegara`, `agama`, `pekerjaan`, `alamat`, `keperluan`, `status`, `id_user`, `created_at`, `updated_at`) VALUES
(1, '001/RT/2026', '2026-04-01', '[]', NULL, 'Budi Santoso', 'Tangerang', '2000-01-01', 'Laki-laki', '1234567890123456', '08123456789', 'Indonesia', 'Islam', 'Belum Bekerja', 'Jl. Contoh Alamat No.1', 'Melamar pekerjaan', 'Pending', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `surat_belum_memiliki_rumah`
--

CREATE TABLE `surat_belum_memiliki_rumah` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kewarganegaraan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_domisili_yayasan`
--

CREATE TABLE `surat_domisili_yayasan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_penanggung_jawab` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kewarganegaraan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pemohon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_organisasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kegiatan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pengurus` int NOT NULL,
  `nama_notaris_pendirian` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_akta_pendirian` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_akta_pendirian` date NOT NULL,
  `nama_notaris_perubahan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_akta_perubahan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_akta_perubahan` date DEFAULT NULL,
  `npwp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian`
--

CREATE TABLE `surat_kematian` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hari_meninggal` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `jam_meninggal` time NOT NULL,
  `tempat_meninggal` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sebab_meninggal` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_pemakaman` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_tanggal_lahir` date NOT NULL,
  `pelapor_agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_pekerjaan` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_no_telepon` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelapor_hubungan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_surat_rt` date DEFAULT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_kematian_nondukcapil`
--

CREATE TABLE `surat_kematian_nondukcapil` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_ahli_waris` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_ahli_waris` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_ahli_waris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hubungan_ahli_waris` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_almarhum` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_almarhum` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_meninggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_meninggal` date NOT NULL,
  `alamat_almarhum` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan_almarhum` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keperluan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_keterangan_suami_istri`
--

CREATE TABLE `surat_keterangan_suami_istri` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_pihak_satu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_pihak_satu` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempat_lahir_pihak_satu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir_pihak_satu` date NOT NULL,
  `jenis_kelamin_pihak_satu` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama_pihak_satu` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan_pihak_satu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warganegara_pihak_satu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pihak_satu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pihak_dua` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik_pihak_dua` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_pihak_dua` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_pengantar_nikah`
--

CREATE TABLE `surat_pengantar_nikah` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pria_nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Laki-laki',
  `pria_tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_tanggal_lahir` date NOT NULL,
  `pria_kewarganegaraan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_pekerjaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_status` enum('Jejaka','Duda','Beristri') COLLATE utf8mb4_unicode_ci NOT NULL,
  `pria_istri_ke` tinyint UNSIGNED DEFAULT NULL,
  `ortu_nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ortu_nik` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ortu_tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ortu_tanggal_lahir` date DEFAULT NULL,
  `ortu_kewarganegaraan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indonesia',
  `ortu_agama` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ortu_pekerjaan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ortu_alamat` text COLLATE utf8mb4_unicode_ci,
  `wanita_nama` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_tanggal_lahir` date NOT NULL,
  `wanita_kewarganegaraan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_pekerjaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanita_status` enum('Perawan','Janda') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_penghasilan`
--

CREATE TABLE `surat_penghasilan` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pemohon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warganegara` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surat_sktm`
--

CREATE TABLE `surat_sktm` (
  `id` bigint UNSIGNED NOT NULL,
  `nomor_surat_rt` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_surat_rt` date NOT NULL,
  `dokumen_pendukung` text COLLATE utf8mb4_unicode_ci,
  `nomor_surat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_pemohon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tempat_lahir` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nik` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon_pemohon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `warganegara` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pekerjaan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_orang_tua` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_dtks` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penghasilan_bulanan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keperluan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Pending','Disetujui','Ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `id_user` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `surat_sktm`
--

INSERT INTO `surat_sktm` (`id`, `nomor_surat_rt`, `tanggal_surat_rt`, `dokumen_pendukung`, `nomor_surat`, `nama_pemohon`, `tempat_lahir`, `tanggal_lahir`, `nik`, `telepon_pemohon`, `jenis_kelamin`, `warganegara`, `agama`, `pekerjaan`, `nama_orang_tua`, `alamat`, `id_dtks`, `penghasilan_bulanan`, `keperluan`, `status`, `id_user`, `created_at`, `updated_at`) VALUES
(1, '001/SKTM/RT01', '2025-11-14', '[\"dummy1.pdf\"]', '470/001/KDM/2025', 'Agus Setiawan', 'Tangerang', '1990-07-15', '3275011507900001', '081234567890', 'Laki-laki', 'Indonesia', 'Islam', 'Karyawan Swasta', 'Budi Setiawan', 'Kademangan RT 01 RW 02', 'DTKS001', 'Rp 1.000.000', 'Pengajuan Beasiswa', 'Disetujui', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04'),
(2, '002/SKTM/RT02', '2025-12-01', '[\"dummy2.pdf\"]', NULL, 'Siti Aisyah', 'Jakarta', '1995-03-20', '3275011507900002', '082345678901', 'Perempuan', 'Indonesia', 'Islam', 'Ibu Rumah Tangga', 'Ahmad', 'Kademangan RT 03 RW 04', NULL, 'Rp 500.000', 'Bantuan Sosial', 'Pending', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jabatan_id` bigint UNSIGNED DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default.jpg',
  `id_level` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `nip`, `jabatan_id`, `username`, `password`, `foto`, `id_level`, `created_at`, `updated_at`) VALUES
(1, 'Kelurahan Kademangan', NULL, NULL, 'superadmin', '$2y$10$rJ3kkPFOdVPyKv8UX8SYMer75wf769CXvxoGvB9HoBrP4oG4Em2H6', '1776493013_bOCgVAy7WJjSHRgH6G9WFqg9jVlcZWBDvVKqz0fP.png', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04'),
(2, 'Madsuki, S.H.', '196911051989121002', 1, 'madsuki', '$2y$10$b5vRbZ5M3rj11uFp4fXi9.tUSLf2Dgym6jBzWRqJDughAWE1wwXUC', '1776655473_vqvX0mcjG3jquN7WdVvWwwqNmgavYA3ar8CF2veV.png', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04'),
(3, 'Muhammad Djupri, S.KOM., M.AK', '198507222011011012', 2, 'djupri', '$2y$10$b5vRbZ5M3rj11uFp4fXi9.tUSLf2Dgym6jBzWRqJDughAWE1wwXUC', 'default.jpg', 1, '2026-04-27 08:53:04', '2026-04-27 08:53:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  ADD UNIQUE KEY `chatbot_settings_key_unique` (`key`);

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
-- Indexes for table `pejabat`
--
ALTER TABLE `pejabat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengumuman_created_by_foreign` (`created_by`);

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
  ADD UNIQUE KEY `ref_jabatan_nama_unique` (`nama`);

--
-- Indexes for table `running_texts`
--
ALTER TABLE `running_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_belum_bekerja_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_belum_memiliki_rumah_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_domisili_yayasan_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_kematian_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_kematian_nondukcapil_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_keterangan_suami_istri_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_pengantar_nikah_id_user_foreign` (`id_user`);

--
-- Indexes for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_sktm_id_user_foreign` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `user_id_level_foreign` (`id_level`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chatbot_settings`
--
ALTER TABLE `chatbot_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jangkauan`
--
ALTER TABLE `jangkauan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id_level` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pejabat`
--
ALTER TABLE `pejabat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ref_jabatan`
--
ALTER TABLE `ref_jabatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `running_texts`
--
ALTER TABLE `running_texts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_penghasilan`
--
ALTER TABLE `surat_penghasilan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_belum_bekerja`
--
ALTER TABLE `surat_belum_bekerja`
  ADD CONSTRAINT `surat_belum_bekerja_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_belum_memiliki_rumah`
--
ALTER TABLE `surat_belum_memiliki_rumah`
  ADD CONSTRAINT `surat_belum_memiliki_rumah_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_domisili_yayasan`
--
ALTER TABLE `surat_domisili_yayasan`
  ADD CONSTRAINT `surat_domisili_yayasan_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_kematian`
--
ALTER TABLE `surat_kematian`
  ADD CONSTRAINT `surat_kematian_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_kematian_nondukcapil`
--
ALTER TABLE `surat_kematian_nondukcapil`
  ADD CONSTRAINT `surat_kematian_nondukcapil_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_keterangan_suami_istri`
--
ALTER TABLE `surat_keterangan_suami_istri`
  ADD CONSTRAINT `surat_keterangan_suami_istri_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_pengantar_nikah`
--
ALTER TABLE `surat_pengantar_nikah`
  ADD CONSTRAINT `surat_pengantar_nikah_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `surat_sktm`
--
ALTER TABLE `surat_sktm`
  ADD CONSTRAINT `surat_sktm_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_id_level_foreign` FOREIGN KEY (`id_level`) REFERENCES `level` (`id_level`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
