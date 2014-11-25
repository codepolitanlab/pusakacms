-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 14, 2014 at 11:27 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `smsbk_sma`
--

-- --------------------------------------------------------

--
-- Table structure for table `authake_groups`
--

CREATE TABLE IF NOT EXISTS `authake_groups` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authake_groups_users`
--

CREATE TABLE IF NOT EXISTS `authake_groups_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authake_rules`
--

CREATE TABLE IF NOT EXISTS `authake_rules` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `group_id` bigint(20) DEFAULT NULL,
  `order` bigint(20) DEFAULT NULL,
  `action` text,
  `permission` text,
  `forward` text,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `authake_users`
--

CREATE TABLE IF NOT EXISTS `authake_users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `emailcheckcode` varchar(128) DEFAULT NULL,
  `passwordchangecode` varchar(128) DEFAULT NULL,
  `disable` tinyint(4) DEFAULT NULL,
  `expire_account` date DEFAULT NULL,
  `created` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  `profil_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_cache`
--

CREATE TABLE IF NOT EXISTS `doctrine_cache` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `data` longblob,
  `expire` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_butir_kompetensi_guru`
--

CREATE TABLE IF NOT EXISTS `m_butir_kompetensi_guru` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `butir_kompetensi_guru` text,
  `jenis_kompetensi_guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_kompetensi_guru_id_idx` (`jenis_kompetensi_guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_butir_kompetensi_kepsek`
--

CREATE TABLE IF NOT EXISTS `m_butir_kompetensi_kepsek` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `butir_kompetensi_kepsek` text,
  `jenis_kompetensi_kepsek_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_kompetensi_kepsek_id_idx` (`jenis_kompetensi_kepsek_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_ekstra_kurikuler`
--

CREATE TABLE IF NOT EXISTS `m_ekstra_kurikuler` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(17) DEFAULT NULL,
  `ekstra_kurikuler` varchar(255) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `pelatih` varchar(100) DEFAULT NULL,
  `proker` text,
  `lambang` text,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_ekstra_kurikuler_jadwal`
--

CREATE TABLE IF NOT EXISTS `m_ekstra_kurikuler_jadwal` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ekstra_kurikuler_id` bigint(20) NOT NULL,
  `hari_id` bigint(20) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ekstra_kurikuler_id_idx` (`ekstra_kurikuler_id`),
  KEY `hari_id_idx` (`hari_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_guru`
--

CREATE TABLE IF NOT EXISTS `m_guru` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_sertifikasi` varchar(5) NOT NULL,
  `nuptk` varchar(20) DEFAULT NULL,
  `kode_guru` varchar(20) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `golongan_darah_id` bigint(20) DEFAULT NULL,
  `jenis_kelamin_id` bigint(20) DEFAULT NULL,
  `status_pernikahan_id` bigint(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `status_pegawai_id` bigint(20) DEFAULT NULL,
  `tgl_diangkat` date DEFAULT NULL,
  `pangkat_golongan_id` bigint(20) DEFAULT NULL,
  `gaji` double DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenjang_pendidikan_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `guru_pendidikan_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `golongan_darah_id_idx` (`golongan_darah_id`),
  KEY `jenis_kelamin_id_idx` (`jenis_kelamin_id`),
  KEY `status_pernikahan_id_idx` (`status_pernikahan_id`),
  KEY `agama_id_idx` (`agama_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `status_pegawai_id_idx` (`status_pegawai_id`),
  KEY `pangkat_golongan_id_idx` (`pangkat_golongan_id`),
  KEY `jenjang_pendidikan_id_idx` (`jenjang_pendidikan_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `guru_pendidikan_id_idx` (`guru_pendidikan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_mata_pelajaran`
--

CREATE TABLE IF NOT EXISTS `m_mata_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `program_pengajaran_id` bigint(20) DEFAULT NULL,
  `pelajaran_id` bigint(20) DEFAULT NULL,
  `tingkat_kelas_id` bigint(20) DEFAULT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `jumlah_jam` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `program_pengajaran_id_idx` (`program_pengajaran_id`),
  KEY `pelajaran_id_idx` (`pelajaran_id`),
  KEY `tingkat_kelas_id_idx` (`tingkat_kelas_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_organisasi_siswa`
--

CREATE TABLE IF NOT EXISTS `m_organisasi_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_organisasi` varchar(150) DEFAULT NULL,
  `inisial` varchar(150) DEFAULT NULL,
  `sekretariat` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_organisasi_siswa_struktur`
--

CREATE TABLE IF NOT EXISTS `m_organisasi_siswa_struktur` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(100) DEFAULT NULL,
  `organisasi_siswa_id` bigint(20) DEFAULT NULL,
  `urutan` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organisasi_siswa_id_idx` (`organisasi_siswa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_ortu`
--

CREATE TABLE IF NOT EXISTS `m_ortu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_ortu` varchar(1) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `pendidikan_id` bigint(20) DEFAULT NULL,
  `pekerjaan_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `range_penghasilan_id` bigint(20) DEFAULT NULL,
  `siswa_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pendidikan_id_idx` (`pendidikan_id`),
  KEY `pekerjaan_id_idx` (`pekerjaan_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `range_penghasilan_id_idx` (`range_penghasilan_id`),
  KEY `siswa_id_idx` (`siswa_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_pelajaran`
--

CREATE TABLE IF NOT EXISTS `m_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_mp` varchar(100) DEFAULT NULL,
  `pelajaran` varchar(100) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `program_international` bigint(20) DEFAULT NULL,
  `jenis` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_prestasi`
--

CREATE TABLE IF NOT EXISTS `m_prestasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `prestasi` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `tingkat_wilayah_id` bigint(20) DEFAULT NULL,
  `siswa_id` bigint(20) DEFAULT NULL,
  `ekstra_kurikuler_id` bigint(20) DEFAULT NULL,
  `tahun` bigint(20) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tingkat_wilayah_id_idx` (`tingkat_wilayah_id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `ekstra_kurikuler_id_idx` (`ekstra_kurikuler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_rombongan_belajar`
--

CREATE TABLE IF NOT EXISTS `m_rombongan_belajar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tingkat_kelas_id` bigint(20) DEFAULT NULL,
  `program_pengajaran_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sarana_prasarana_id` bigint(20) DEFAULT NULL,
  `rombongan_belajar` varchar(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tingkat_kelas_id_idx` (`tingkat_kelas_id`),
  KEY `program_pengajaran_id_idx` (`program_pengajaran_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sarana_prasarana_id_idx` (`sarana_prasarana_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sarana_prasarana`
--

CREATE TABLE IF NOT EXISTS `m_sarana_prasarana` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_sarana_prasarana` varchar(30) DEFAULT NULL,
  `nama_sarana_prasarana` varchar(50) DEFAULT NULL,
  `penanggung_jawab` varchar(50) DEFAULT NULL,
  `jenis_sarana_prasarana_id` bigint(20) DEFAULT NULL,
  `kondisi_ruangan_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `daya_tampung` double DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_sarana_prasarana_id_idx` (`jenis_sarana_prasarana_id`),
  KEY `kondisi_ruangan_id_idx` (`kondisi_ruangan_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sarana_prasarana_detail`
--

CREATE TABLE IF NOT EXISTS `m_sarana_prasarana_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(30) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `sarana_prasarana_id` bigint(20) DEFAULT NULL,
  `no_tanggal_sertifikat` varchar(32) DEFAULT NULL,
  `cc` varchar(64) DEFAULT NULL,
  `no_rangka` varchar(64) DEFAULT NULL,
  `no_mesin` varchar(64) DEFAULT NULL,
  `merek` varchar(64) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `warna` varchar(64) DEFAULT NULL,
  `no_tanggal_bpkb` varchar(32) DEFAULT NULL,
  `no_polisi` varchar(32) DEFAULT NULL,
  `tanggal_peroleh` date DEFAULT NULL,
  `asal_peroleh` varchar(32) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `satuan` varchar(32) DEFAULT NULL,
  `kondisi_ruangan_id` bigint(20) DEFAULT NULL,
  `harga_total` double DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sarana_prasarana_id_idx` (`sarana_prasarana_id`),
  KEY `kondisi_ruangan_id_idx` (`kondisi_ruangan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sekolah`
--

CREATE TABLE IF NOT EXISTS `m_sekolah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_akreditasi_id` bigint(20) DEFAULT NULL,
  `nss` varchar(100) DEFAULT NULL,
  `nps` varchar(10) DEFAULT NULL,
  `nama_strip` varchar(32) DEFAULT NULL,
  `sekolah` varchar(100) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `status_sekolah_id` bigint(20) DEFAULT NULL,
  `sk_pendirian` varchar(15) DEFAULT NULL,
  `tgl_sk_pendirian` date DEFAULT NULL,
  `no_sk_akreditasi` varchar(100) DEFAULT NULL,
  `tgl_akreditasi` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `luas_halaman` double DEFAULT NULL,
  `luas_tanah` double DEFAULT NULL,
  `luas_bangunan` double DEFAULT NULL,
  `luas_olahraga` double DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `setting_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_akreditasi_id_idx` (`jenis_akreditasi_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `status_sekolah_id_idx` (`status_sekolah_id`),
  KEY `setting_id_idx` (`setting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sekolah_misi`
--

CREATE TABLE IF NOT EXISTS `m_sekolah_misi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `misi` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_sekolah_visi`
--

CREATE TABLE IF NOT EXISTS `m_sekolah_visi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `visi` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_siswa`
--

CREATE TABLE IF NOT EXISTS `m_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_tlp` char(20) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin_id` bigint(20) DEFAULT NULL,
  `agama_id` bigint(20) DEFAULT NULL,
  `golongan_darah_id` bigint(20) DEFAULT NULL,
  `anak_ke` bigint(20) DEFAULT NULL,
  `jumlah_sdr` bigint(20) DEFAULT NULL,
  `status_anak_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `perguruan_tinggi_id` bigint(20) DEFAULT NULL,
  `asal_sekolah_id` bigint(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_kelamin_id_idx` (`jenis_kelamin_id`),
  KEY `agama_id_idx` (`agama_id`),
  KEY `golongan_darah_id_idx` (`golongan_darah_id`),
  KEY `status_anak_id_idx` (`status_anak_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `perguruan_tinggi_id_idx` (`perguruan_tinggi_id`),
  KEY `asal_sekolah_id_idx` (`asal_sekolah_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_tenaga_kependidikan`
--

CREATE TABLE IF NOT EXISTS `m_tenaga_kependidikan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nuptk` varchar(20) DEFAULT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `golongan_darah_id` bigint(20) DEFAULT NULL,
  `jenis_kelamin_id` bigint(20) DEFAULT NULL,
  `status_pernikahan_id` bigint(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `hp` varchar(15) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `status_pegawai_id` bigint(20) DEFAULT NULL,
  `tgl_diangkat` date DEFAULT NULL,
  `pangkat_golongan_id` bigint(20) DEFAULT NULL,
  `gaji` double DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenjang_pendidikan_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `jenis_kepegawaian_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `golongan_darah_id_idx` (`golongan_darah_id`),
  KEY `jenis_kelamin_id_idx` (`jenis_kelamin_id`),
  KEY `status_pernikahan_id_idx` (`status_pernikahan_id`),
  KEY `agama_id_idx` (`agama_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `status_pegawai_id_idx` (`status_pegawai_id`),
  KEY `pangkat_golongan_id_idx` (`pangkat_golongan_id`),
  KEY `jenjang_pendidikan_id_idx` (`jenjang_pendidikan_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `jenis_kepegawaian_id_idx` (`jenis_kepegawaian_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_agama`
--

CREATE TABLE IF NOT EXISTS `r_agama` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `agama` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_asal_dana`
--

CREATE TABLE IF NOT EXISTS `r_asal_dana` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `asal_dana` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_asal_sekolah`
--

CREATE TABLE IF NOT EXISTS `r_asal_sekolah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nps` bigint(20) NOT NULL,
  `jenjang_sekolah_id` bigint(20) DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenjang_sekolah_id_idx` (`jenjang_sekolah_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_bulan`
--

CREATE TABLE IF NOT EXISTS `r_bulan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bulan` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_butir`
--

CREATE TABLE IF NOT EXISTS `r_butir` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `butir` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_butir_dppp`
--

CREATE TABLE IF NOT EXISTS `r_butir_dppp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `butir` text,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_category`
--

CREATE TABLE IF NOT EXISTS `r_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_golongan_darah`
--

CREATE TABLE IF NOT EXISTS `r_golongan_darah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `golongan_darah` varchar(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_guru_keluarga`
--

CREATE TABLE IF NOT EXISTS `r_guru_keluarga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `keluarga` varchar(100) DEFAULT NULL,
  `hubungan_keluarga_id` bigint(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin_id` bigint(20) DEFAULT NULL,
  `golongan_darah_id` bigint(20) DEFAULT NULL,
  `agama_id` bigint(20) DEFAULT NULL,
  `status_pernikahan_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hubungan_keluarga_id_idx` (`hubungan_keluarga_id`),
  KEY `jenis_kelamin_id_idx` (`jenis_kelamin_id`),
  KEY `golongan_darah_id_idx` (`golongan_darah_id`),
  KEY `agama_id_idx` (`agama_id`),
  KEY `status_pernikahan_id_idx` (`status_pernikahan_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_hari`
--

CREATE TABLE IF NOT EXISTS `r_hari` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hari` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_hobby`
--

CREATE TABLE IF NOT EXISTS `r_hobby` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hobby` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_hubungan_keluarga`
--

CREATE TABLE IF NOT EXISTS `r_hubungan_keluarga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `hubungan_keluarga` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jalur_masuk_psb`
--

CREATE TABLE IF NOT EXISTS `r_jalur_masuk_psb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jalur_masuk` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jalur_masuk_pt`
--

CREATE TABLE IF NOT EXISTS `r_jalur_masuk_pt` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jalur_masuk_pt` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jam_pelajaran`
--

CREATE TABLE IF NOT EXISTS `r_jam_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mulai` time DEFAULT NULL,
  `selesai` time DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `hari_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hari_id_idx` (`hari_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_absen`
--

CREATE TABLE IF NOT EXISTS `r_jenis_absen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_absen` varchar(64) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_agenda_sekolah`
--

CREATE TABLE IF NOT EXISTS `r_jenis_agenda_sekolah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_anggota_sekolah` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_akreditasi`
--

CREATE TABLE IF NOT EXISTS `r_jenis_akreditasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_akreditasi` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_buku`
--

CREATE TABLE IF NOT EXISTS `r_jenis_buku` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_buku` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_dokumen`
--

CREATE TABLE IF NOT EXISTS `r_jenis_dokumen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_dokumen` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_jabatan`
--

CREATE TABLE IF NOT EXISTS `r_jenis_jabatan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_jabatan` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_kelamin`
--

CREATE TABLE IF NOT EXISTS `r_jenis_kelamin` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_kepegawaian`
--

CREATE TABLE IF NOT EXISTS `r_jenis_kepegawaian` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_kepegawaian` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_kompetensi_guru`
--

CREATE TABLE IF NOT EXISTS `r_jenis_kompetensi_guru` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_kompetensi_guru` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_kompetensi_kepsek`
--

CREATE TABLE IF NOT EXISTS `r_jenis_kompetensi_kepsek` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_kompetensi_kepsek` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_kurikulum`
--

CREATE TABLE IF NOT EXISTS `r_jenis_kurikulum` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_kurikulum` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_mutasi_siswa`
--

CREATE TABLE IF NOT EXISTS `r_jenis_mutasi_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_mutasi` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_nilai`
--

CREATE TABLE IF NOT EXISTS `r_jenis_nilai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_nilai` varchar(255) DEFAULT NULL,
  `inisial` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_pembayaran`
--

CREATE TABLE IF NOT EXISTS `r_jenis_pembayaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_pembayaran` varchar(32) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_prog_kerja`
--

CREATE TABLE IF NOT EXISTS `r_jenis_prog_kerja` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_program_kerja` varchar(40) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenis_sarana_prasarana`
--

CREATE TABLE IF NOT EXISTS `r_jenis_sarana_prasarana` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_sarana_prasarana` varchar(128) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenjang_pendidikan`
--

CREATE TABLE IF NOT EXISTS `r_jenjang_pendidikan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenjang_pendidikan` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_jenjang_sekolah`
--

CREATE TABLE IF NOT EXISTS `r_jenjang_sekolah` (
  `id` bigint(20) DEFAULT NULL,
  `jenjang_sekolah` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `r_kabupaten_kota`
--

CREATE TABLE IF NOT EXISTS `r_kabupaten_kota` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `provinsi_id` bigint(20) NOT NULL,
  `kabupaten_kota` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provinsi_id_idx` (`provinsi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_kecamatan`
--

CREATE TABLE IF NOT EXISTS `r_kecamatan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kabupaten_kota_id` bigint(20) NOT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_kepala_sekolah`
--

CREATE TABLE IF NOT EXISTS `r_kepala_sekolah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `nip` varchar(10) DEFAULT NULL,
  `kepala_sekolah` varchar(100) DEFAULT NULL,
  `no_sk` varchar(20) DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL,
  `tmt_sk` date DEFAULT NULL,
  `status_aktif` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `pangkat_golongan_id` bigint(20) DEFAULT NULL,
  `pendidikan_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `pangkat_golongan_id_idx` (`pangkat_golongan_id`),
  KEY `pendidikan_id_idx` (`pendidikan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_kondisi_ruangan`
--

CREATE TABLE IF NOT EXISTS `r_kondisi_ruangan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kondisi_ruangan` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_kriteria_psb`
--

CREATE TABLE IF NOT EXISTS `r_kriteria_psb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `kriteria` varchar(30) DEFAULT NULL,
  `bobot` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_pangkat_golongan`
--

CREATE TABLE IF NOT EXISTS `r_pangkat_golongan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pangkat` varchar(5) DEFAULT NULL,
  `golongan` varchar(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_pekerjaan`
--

CREATE TABLE IF NOT EXISTS `r_pekerjaan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pekerjaan` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_pemberi_beasiswa`
--

CREATE TABLE IF NOT EXISTS `r_pemberi_beasiswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pemberi_beasiswa` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_pendidikan`
--

CREATE TABLE IF NOT EXISTS `r_pendidikan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pendidikan` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_perguruan_tinggi`
--

CREATE TABLE IF NOT EXISTS `r_perguruan_tinggi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `perguruan_tinggi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_pihak_komunikasi`
--

CREATE TABLE IF NOT EXISTS `r_pihak_komunikasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pihak_komunikasi` varchar(64) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_program_pengajaran`
--

CREATE TABLE IF NOT EXISTS `r_program_pengajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `program_pengajaran` varchar(128) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_provinsi`
--

CREATE TABLE IF NOT EXISTS `r_provinsi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `provinsi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_range_penghasilan`
--

CREATE TABLE IF NOT EXISTS `r_range_penghasilan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `range_penghasilan` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_ruang`
--

CREATE TABLE IF NOT EXISTS `r_ruang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ruang` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_semester`
--

CREATE TABLE IF NOT EXISTS `r_semester` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `semester` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_status_anak`
--

CREATE TABLE IF NOT EXISTS `r_status_anak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_anak` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_status_pegawai`
--

CREATE TABLE IF NOT EXISTS `r_status_pegawai` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_status_pernikahan`
--

CREATE TABLE IF NOT EXISTS `r_status_pernikahan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` varchar(30) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_status_sekolah`
--

CREATE TABLE IF NOT EXISTS `r_status_sekolah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status_sekolah` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_tahun_ajaran`
--

CREATE TABLE IF NOT EXISTS `r_tahun_ajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_awal` bigint(20) NOT NULL,
  `tahun_akhir` bigint(20) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_tingkat_kelas`
--

CREATE TABLE IF NOT EXISTS `r_tingkat_kelas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tingkat_kelas` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `r_tingkat_wilayah`
--

CREATE TABLE IF NOT EXISTS `r_tingkat_wilayah` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tingkat_wilayah` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `profil` varchar(255) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `spp` bigint(20) DEFAULT NULL,
  `uang_tahunan` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_agenda_kelas`
--

CREATE TABLE IF NOT EXISTS `t_agenda_kelas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `materi` varchar(255) DEFAULT NULL,
  `proses_belajar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_agenda_kelas_absen`
--

CREATE TABLE IF NOT EXISTS `t_agenda_kelas_absen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `agenda_kelas_id` bigint(20) DEFAULT NULL,
  `siswa_id` bigint(20) DEFAULT NULL,
  `jenis_absen_id` bigint(20) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `agenda_kelas_id_idx` (`agenda_kelas_id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `jenis_absen_id_idx` (`jenis_absen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_butir_supervisi`
--

CREATE TABLE IF NOT EXISTS `t_butir_supervisi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_supervisi_id` bigint(20) DEFAULT NULL,
  `butir_id` bigint(20) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `butir_id_idx` (`butir_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_dokumen_kurikulum`
--

CREATE TABLE IF NOT EXISTS `t_dokumen_kurikulum` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenis_dokumen_id` bigint(20) DEFAULT NULL,
  `nama_dokumen` text,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_dokumen_id_idx` (`jenis_dokumen_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_ekstra_kurikuler_fasilitas`
--

CREATE TABLE IF NOT EXISTS `t_ekstra_kurikuler_fasilitas` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ekstra_kurikuler_fasilitas` varchar(255) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `kondisi_ruangan_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kondisi_ruangan_id_idx` (`kondisi_ruangan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_ekstra_kurikuler_fasilitas_ekstra_kurikuler`
--

CREATE TABLE IF NOT EXISTS `t_ekstra_kurikuler_fasilitas_ekstra_kurikuler` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ekstra_kurikuler_fasilitas_id` bigint(20) DEFAULT NULL,
  `ekstra_kurikuler_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ekstra_kurikuler_fasilitas_id_idx` (`ekstra_kurikuler_fasilitas_id`),
  KEY `ekstra_kurikuler_id_idx` (`ekstra_kurikuler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_absen`
--

CREATE TABLE IF NOT EXISTS `t_guru_absen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `jenis_absen_id` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `jenis_absen_id_idx` (`jenis_absen_id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_dppp`
--

CREATE TABLE IF NOT EXISTS `t_guru_dppp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `unit_organisasi` varchar(255) DEFAULT NULL,
  `pejabat_penilai_id` bigint(20) DEFAULT NULL,
  `jabatan_penilai` varchar(255) DEFAULT NULL,
  `unit_organisasi_penilai` varchar(255) DEFAULT NULL,
  `atasan_id` bigint(20) DEFAULT NULL,
  `jabatan_atasan` varchar(255) DEFAULT NULL,
  `unit_organisasi_atasan` varchar(255) DEFAULT NULL,
  `periode_mulai` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `keberatan` text,
  `tanggapan` text,
  `keputusan` text,
  `lain_lain` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_jabatan`
--

CREATE TABLE IF NOT EXISTS `t_guru_jabatan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `status` varchar(1) DEFAULT NULL,
  `jenis_jabatan_id` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `no_sk` varchar(30) DEFAULT NULL,
  `tgl_sk` date DEFAULT NULL,
  `tmt_sk` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_jabatan_id_idx` (`jenis_jabatan_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_mata_pelajaran`
--

CREATE TABLE IF NOT EXISTS `t_guru_mata_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_orientasi`
--

CREATE TABLE IF NOT EXISTS `t_guru_orientasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tanggal` date DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_orientasi_peserta`
--

CREATE TABLE IF NOT EXISTS `t_guru_orientasi_peserta` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `guru_orientasi_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `guru_orientasi_id_idx` (`guru_orientasi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_orientasi_pj`
--

CREATE TABLE IF NOT EXISTS `t_guru_orientasi_pj` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `guru_orientasi_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `guru_orientasi_id_idx` (`guru_orientasi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_penataran`
--

CREATE TABLE IF NOT EXISTS `t_guru_penataran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun` bigint(20) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `penataran` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_pendidikan`
--

CREATE TABLE IF NOT EXISTS `t_guru_pendidikan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jenjang_pendidikan_id` bigint(20) DEFAULT NULL,
  `program_studi` varchar(255) DEFAULT NULL,
  `nama_instansi` varchar(100) DEFAULT NULL,
  `tahun_mulai` bigint(20) DEFAULT NULL,
  `tahun_selesai` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenjang_pendidikan_id_idx` (`jenjang_pendidikan_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_pengalaman`
--

CREATE TABLE IF NOT EXISTS `t_guru_pengalaman` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pengalaman` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_guru_prestasi`
--

CREATE TABLE IF NOT EXISTS `t_guru_prestasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tingkat_wilayah_id` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `tahun` bigint(20) DEFAULT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tingkat_wilayah_id_idx` (`tingkat_wilayah_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_international_conferences`
--

CREATE TABLE IF NOT EXISTS `t_international_conferences` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) DEFAULT NULL,
  `vanue` varchar(255) DEFAULT NULL,
  `organizing_institution` varchar(255) DEFAULT NULL,
  `year` date DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `kind` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_international_cooperation`
--

CREATE TABLE IF NOT EXISTS `t_international_cooperation` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `partner` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_international_visit_program`
--

CREATE TABLE IF NOT EXISTS `t_international_visit_program` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) DEFAULT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `admision` date DEFAULT NULL,
  `start` date DEFAULT NULL,
  `end` date DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `kind` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_jumlah_minggu_per_bulan`
--

CREATE TABLE IF NOT EXISTS `t_jumlah_minggu_per_bulan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bulan_id` bigint(20) DEFAULT NULL,
  `jumlah_minggu` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulan_id_idx` (`bulan_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_keuangan_beasiswa`
--

CREATE TABLE IF NOT EXISTS `t_keuangan_beasiswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `pemberi_beasiswa_id` bigint(20) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `pemberi_beasiswa_id_idx` (`pemberi_beasiswa_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_keuangan_keringan_siswa`
--

CREATE TABLE IF NOT EXISTS `t_keuangan_keringan_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `jenis_pembayaran_id` bigint(20) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `bulan_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `jenis_pembayaran_id_idx` (`jenis_pembayaran_id`),
  KEY `bulan_id_idx` (`bulan_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_keuangan_pembayaran_siswa`
--

CREATE TABLE IF NOT EXISTS `t_keuangan_pembayaran_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `bulan_id` bigint(20) DEFAULT NULL,
  `jenis_pembayaran_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `jumlah_dibayar` double DEFAULT NULL,
  `tunggakan` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `bulan_id_idx` (`bulan_id`),
  KEY `jenis_pembayaran_id_idx` (`jenis_pembayaran_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_keuangan_sirkulasi`
--

CREATE TABLE IF NOT EXISTS `t_keuangan_sirkulasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_transaksi` varchar(255) DEFAULT NULL,
  `debit` double DEFAULT NULL,
  `kredit` double DEFAULT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `jumlah_satuan` double DEFAULT NULL,
  `harga_satuan` double DEFAULT NULL,
  `biaya_operasional` double DEFAULT NULL,
  `penanggung_jawab` varchar(255) DEFAULT NULL,
  `jenis_transaksi` varchar(255) DEFAULT NULL,
  `keterangan` text,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kompetensi_guru`
--

CREATE TABLE IF NOT EXISTS `t_kompetensi_guru` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penilaian_kinerja_guru_id` bigint(20) DEFAULT NULL,
  `butir_kompetensi_guru_id` bigint(20) DEFAULT NULL,
  `nilai_angka` double DEFAULT NULL,
  `keterangan` text,
  `kesimpulan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_kinerja_guru_id_idx` (`penilaian_kinerja_guru_id`),
  KEY `butir_kompetensi_guru_id_idx` (`butir_kompetensi_guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kompetensi_kepsek`
--

CREATE TABLE IF NOT EXISTS `t_kompetensi_kepsek` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `penilaian_kinerja_kepsek_id` bigint(20) DEFAULT NULL,
  `butir_kompetensi_kepsek_id` bigint(20) DEFAULT NULL,
  `nilai_angka` double DEFAULT NULL,
  `keterangan` text,
  `kesimpulan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penilaian_kinerja_kepsek_id_idx` (`penilaian_kinerja_kepsek_id`),
  KEY `butir_kompetensi_kepsek_id_idx` (`butir_kompetensi_kepsek_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_detail_jp`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_detail_jp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `jp` bigint(20) DEFAULT NULL,
  `bulan_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `minggu` bigint(20) DEFAULT NULL,
  `kurikulum_kompetensi_dasar_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulan_id_idx` (`bulan_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `kurikulum_kompetensi_dasar_id_idx` (`kurikulum_kompetensi_dasar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_indikator`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_indikator` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurikulum_kompetensi_dasar_id` bigint(20) DEFAULT NULL,
  `indikator` text,
  `rpp_id` bigint(20) DEFAULT NULL,
  `kompleksitas` double DEFAULT NULL,
  `sarana_pendukung` double DEFAULT NULL,
  `intake` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kurikulum_kompetensi_dasar_id_idx` (`kurikulum_kompetensi_dasar_id`),
  KEY `rpp_id_idx` (`rpp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_kompetensi_dasar`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_kompetensi_dasar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurikulum_standar_kompetensi_id` bigint(20) DEFAULT NULL,
  `kompetensi_dasar` text,
  `materi_pokok` varchar(255) DEFAULT NULL,
  `kegiatan_pembelajaran` varchar(255) DEFAULT NULL,
  `indikator` varchar(255) DEFAULT NULL,
  `teknik` varchar(255) DEFAULT NULL,
  `bentuk_instrumen` varchar(255) DEFAULT NULL,
  `waktu` double DEFAULT NULL,
  `sumber` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kurikulum_standar_kompetensi_id_idx` (`kurikulum_standar_kompetensi_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_mata_pelajaran`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_mata_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `semester_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `jenis_kurikulum_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `jenis_kurikulum_id_idx` (`jenis_kurikulum_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_minggu_tak_efektif`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_minggu_tak_efektif` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kegiatan` text,
  `jumlah_minggu` bigint(20) DEFAULT NULL,
  `bulan_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bulan_id_idx` (`bulan_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_kurikulum_standar_kompetensi`
--

CREATE TABLE IF NOT EXISTS `t_kurikulum_standar_kompetensi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurikulum_mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `standard_kompetensi` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kurikulum_mata_pelajaran_id_idx` (`kurikulum_mata_pelajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_networking`
--

CREATE TABLE IF NOT EXISTS `t_networking` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `partner` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_nilai_psb`
--

CREATE TABLE IF NOT EXISTS `t_nilai_psb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sekolah_psb_id` bigint(20) DEFAULT NULL,
  `kriteria_psb_id` bigint(20) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_psb_id_idx` (`sekolah_psb_id`),
  KEY `kriteria_psb_id_idx` (`kriteria_psb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_nilai_raport_siswa`
--

CREATE TABLE IF NOT EXISTS `t_nilai_raport_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `periode_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `aspek_penilaian_id` bigint(20) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_rombongan_belajar_id_idx` (`siswa_rombongan_belajar_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_nilai_siswa`
--

CREATE TABLE IF NOT EXISTS `t_nilai_siswa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `jenis_nilai_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `status` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `nilai_siswa_id` bigint(20) DEFAULT NULL,
  `jml_perbaikan` bigint(20) DEFAULT NULL,
  `tanggal_evaluasi` date DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_rombongan_belajar_id_idx` (`siswa_rombongan_belajar_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `jenis_nilai_id_idx` (`jenis_nilai_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `nilai_siswa_id_idx` (`nilai_siswa_id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_penilaian_butir_dppp`
--

CREATE TABLE IF NOT EXISTS `t_penilaian_butir_dppp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_dppp_id` bigint(20) DEFAULT NULL,
  `butir_dppp_id` bigint(20) DEFAULT NULL,
  `angka` bigint(20) DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_dppp_id_idx` (`guru_dppp_id`),
  KEY `butir_dppp_id_idx` (`butir_dppp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_penilaian_kinerja_guru`
--

CREATE TABLE IF NOT EXISTS `t_penilaian_kinerja_guru` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `periode_awal` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `penilai_id` bigint(20) DEFAULT NULL,
  `keterangan` text,
  `kesimpulan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_penilaian_kinerja_kepsek`
--

CREATE TABLE IF NOT EXISTS `t_penilaian_kinerja_kepsek` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `periode_awal` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `penilai` text,
  `keterangan` text,
  `kesimpulan` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_persyaratan`
--

CREATE TABLE IF NOT EXISTS `t_persyaratan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `persyaratan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_persyaratan_sekolah_psb`
--

CREATE TABLE IF NOT EXISTS `t_persyaratan_sekolah_psb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sekolah_psb_id` bigint(20) DEFAULT NULL,
  `persyaratan_id` bigint(20) DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_psb_id_idx` (`sekolah_psb_id`),
  KEY `persyaratan_id_idx` (`persyaratan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_psb_info_daftar`
--

CREATE TABLE IF NOT EXISTS `t_psb_info_daftar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `info_daftar` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_psb_info_registrasi`
--

CREATE TABLE IF NOT EXISTS `t_psb_info_registrasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `info_registrasi` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_psb_info_umum`
--

CREATE TABLE IF NOT EXISTS `t_psb_info_umum` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `info_umum` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_publication`
--

CREATE TABLE IF NOT EXISTS `t_publication` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id_idx` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_rombongan_belajar_mata_pelajaran`
--

CREATE TABLE IF NOT EXISTS `t_rombongan_belajar_mata_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_rpp`
--

CREATE TABLE IF NOT EXISTS `t_rpp` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tujuan_pembelajaran` text,
  `alokasi_waktu` double DEFAULT NULL,
  `materi_pembelajaran` text,
  `langkah` text,
  `sumber_pembelajaran` text,
  `media` text,
  `evaluasi` text,
  `guru_id` bigint(20) DEFAULT NULL,
  `pertemuan_ke` text,
  `kurikulum_standar_kompetensi_id` bigint(20) DEFAULT NULL,
  `metode_pembuka` text,
  `metode_inti` text,
  `metode_penutup` text,
  `aktivitas_pembuka` text,
  `aktivitas_inti` text,
  `aktivitas_penutup` text,
  `sumber_pembuka` text,
  `sumber_inti` text,
  `sumber_penutup` text,
  `waktu_pembuka` double DEFAULT NULL,
  `waktu_inti` double DEFAULT NULL,
  `waktu_penutup` double DEFAULT NULL,
  `soal` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `kurikulum_standar_kompetensi_id_idx` (`kurikulum_standar_kompetensi_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_rpp_indikator`
--

CREATE TABLE IF NOT EXISTS `t_rpp_indikator` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rpp_id` bigint(20) DEFAULT NULL,
  `kurikulum_indikator_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rpp_id_idx` (`rpp_id`),
  KEY `kurikulum_indikator_id_idx` (`kurikulum_indikator_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sarana_pembelajaran`
--

CREATE TABLE IF NOT EXISTS `t_sarana_pembelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `sarana` varchar(100) DEFAULT NULL,
  `jumlah` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_agenda`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_agenda` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `jenis_agenda_sekolah_id` bigint(20) DEFAULT NULL,
  `tanggal_awal` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `jenis_agenda_sekolah_id_idx` (`jenis_agenda_sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_buku`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_buku` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `buku` varchar(100) DEFAULT NULL,
  `jenis_buku_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `jumlah_eks` double DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_buku_id_idx` (`jenis_buku_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_jadwal_pelajaran`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_jadwal_pelajaran` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `jam_pelajaran_id` bigint(20) DEFAULT NULL,
  `guru_mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `guru_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `kode_guru` varchar(10) DEFAULT NULL,
  `kode_mata_pelajaran` varchar(10) DEFAULT NULL,
  `nama_guru` varchar(200) DEFAULT NULL,
  `nama_mata_pelajaran` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `jam_pelajaran_id_idx` (`jam_pelajaran_id`),
  KEY `guru_mata_pelajaran_id_idx` (`guru_mata_pelajaran_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_kalender_akademik`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_kalender_akademik` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kegiatan` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_kebijakan`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_kebijakan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(100) DEFAULT NULL,
  `perihal` varchar(255) DEFAULT NULL,
  `alamat_file` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_komunikasi`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_komunikasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `komunikasi` varchar(255) DEFAULT NULL,
  `pihak_komunikasi_id` bigint(20) DEFAULT NULL,
  `tgl` date DEFAULT NULL,
  `hasil` text,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pihak_komunikasi_id_idx` (`pihak_komunikasi_id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_pertemuan`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_pertemuan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `hasil_pertemuan` text,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_program_kerja`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_program_kerja` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `program_kerja` varchar(255) DEFAULT NULL,
  `jenis_prog_kerja_id` bigint(20) DEFAULT NULL,
  `realisasi` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_prog_kerja_id_idx` (`jenis_prog_kerja_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_psb`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_psb` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_tlp` char(20) DEFAULT NULL,
  `no_registrasi` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin_id` bigint(20) DEFAULT NULL,
  `agama_id` bigint(20) DEFAULT NULL,
  `golongan_darah_id` bigint(20) DEFAULT NULL,
  `anak_ke` bigint(20) DEFAULT NULL,
  `jumlah_sdr` bigint(20) DEFAULT NULL,
  `status_anak_id` bigint(20) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `kabupaten_kota_id` bigint(20) DEFAULT NULL,
  `kecamatan_id` bigint(20) DEFAULT NULL,
  `provinsi_id` bigint(20) DEFAULT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `asal_sekolah_id` bigint(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `status` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `jenis_kelamin_id_idx` (`jenis_kelamin_id`),
  KEY `agama_id_idx` (`agama_id`),
  KEY `golongan_darah_id_idx` (`golongan_darah_id`),
  KEY `status_anak_id_idx` (`status_anak_id`),
  KEY `kabupaten_kota_id_idx` (`kabupaten_kota_id`),
  KEY `kecamatan_id_idx` (`kecamatan_id`),
  KEY `provinsi_id_idx` (`provinsi_id`),
  KEY `asal_sekolah_id_idx` (`asal_sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_sekolah_sub_program_kerja`
--

CREATE TABLE IF NOT EXISTS `t_sekolah_sub_program_kerja` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sekolah_program_kerja_id` bigint(20) DEFAULT NULL,
  `sub_program_kerja` varchar(255) DEFAULT NULL,
  `realisasi` double DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_akhir` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `alokasi_dana` double DEFAULT NULL,
  `sumber_dana` text,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `pendanaan` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_program_kerja_id_idx` (`sekolah_program_kerja_id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_silabus`
--

CREATE TABLE IF NOT EXISTS `t_silabus` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kurikulum_standar_kompetensi_id` bigint(20) DEFAULT NULL,
  `kurikulum_kompetensi_dasar_id` bigint(20) DEFAULT NULL,
  `indikator` text,
  `materi_pokok` text,
  `kegiatan_pembelajaran` text,
  `waktu` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kurikulum_standar_kompetensi_id_idx` (`kurikulum_standar_kompetensi_id`),
  KEY `kurikulum_kompetensi_dasar_id_idx` (`kurikulum_kompetensi_dasar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_absen`
--

CREATE TABLE IF NOT EXISTS `t_siswa_absen` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `siswa_id` bigint(20) DEFAULT NULL,
  `jenis_absen_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `jenis_absen_id_idx` (`jenis_absen_id`),
  KEY `semester_id_idx` (`semester_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_catatan_bk`
--

CREATE TABLE IF NOT EXISTS `t_siswa_catatan_bk` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `tanggal_catatan` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_ekstra_kurikuler`
--

CREATE TABLE IF NOT EXISTS `t_siswa_ekstra_kurikuler` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `ekstra_kurikuler_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `ekstra_kurikuler_id_idx` (`ekstra_kurikuler_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_hobby`
--

CREATE TABLE IF NOT EXISTS `t_siswa_hobby` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `hobby_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `hobby_id_idx` (`hobby_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_kelulusan`
--

CREATE TABLE IF NOT EXISTS `t_siswa_kelulusan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tahun` bigint(20) DEFAULT NULL,
  `jumlah_lulus` bigint(20) DEFAULT NULL,
  `persen_lulus` double DEFAULT NULL,
  `ratarata_nem` double DEFAULT NULL,
  `jumlah_lanjut` bigint(20) DEFAULT NULL,
  `persen_lanjut` double DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_mutasi`
--

CREATE TABLE IF NOT EXISTS `t_siswa_mutasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `tanggal_mutasi` date DEFAULT NULL,
  `jenis_mutasi_siswa_id` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `jenis_mutasi_siswa_id_idx` (`jenis_mutasi_siswa_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_perguruan_tinggi`
--

CREATE TABLE IF NOT EXISTS `t_siswa_perguruan_tinggi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `perguruan_tinggi_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `jalur_masuk_pt_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `perguruan_tinggi_id_idx` (`perguruan_tinggi_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`),
  KEY `jalur_masuk_pt_id_idx` (`jalur_masuk_pt_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa_rombongan_belajar`
--

CREATE TABLE IF NOT EXISTS `t_siswa_rombongan_belajar` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) DEFAULT NULL,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id_idx` (`siswa_id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_student_exchange`
--

CREATE TABLE IF NOT EXISTS `t_student_exchange` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `sin` varchar(15) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `admision` date DEFAULT NULL,
  `completion` date DEFAULT NULL,
  `sekolah_id` bigint(20) DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) DEFAULT NULL,
  `status` bigint(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sekolah_id_idx` (`sekolah_id`),
  KEY `tahun_ajaran_id_idx` (`tahun_ajaran_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_supervisi`
--

CREATE TABLE IF NOT EXISTS `t_supervisi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `materi` varchar(255) DEFAULT NULL,
  `hasil` text,
  `mata_pelajaran_id` bigint(20) DEFAULT NULL,
  `semester_id` bigint(20) DEFAULT NULL,
  `rombongan_belajar_id` bigint(20) DEFAULT NULL,
  `kode` varchar(32) DEFAULT NULL,
  `edisi` varchar(32) DEFAULT NULL,
  `tanggal_terbit` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id_idx` (`guru_id`),
  KEY `mata_pelajaran_id_idx` (`mata_pelajaran_id`),
  KEY `semester_id_idx` (`semester_id`),
  KEY `rombongan_belajar_id_idx` (`rombongan_belajar_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_supervisi_butir`
--

CREATE TABLE IF NOT EXISTS `t_supervisi_butir` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `supervisi_id` bigint(20) DEFAULT NULL,
  `butir_id` bigint(20) DEFAULT NULL,
  `nilai` varchar(3) DEFAULT NULL,
  `bobot` bigint(20) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supervisi_id_idx` (`supervisi_id`),
  KEY `butir_id_idx` (`butir_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
