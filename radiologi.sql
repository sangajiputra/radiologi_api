-- Adminer 4.6.2 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `radiologi_job`;
CREATE TABLE `radiologi_job` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code_job` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `name_other` varchar(256) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `radiologi_job` (`id`, `code_job`, `code`, `name`, `name_other`, `created_date`, `is_del`) VALUES
(1,	0,	12345,	'aji',	'ajie',	'2019-06-22 16:11:38',	0);

DROP TABLE IF EXISTS `radiologi_job_order`;
CREATE TABLE `radiologi_job_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `no_paket` int(11) DEFAULT NULL,
  `id_radiologi_job_parent` int(11) DEFAULT NULL,
  `id_radiologi_job` int(11) DEFAULT NULL,
  `tarif` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `radiologi_job_parent`;
CREATE TABLE `radiologi_job_parent` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code_parent` int(11) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `name_other` varchar(256) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ref_rad_hasil_expertise`;
CREATE TABLE `ref_rad_hasil_expertise` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `hasil_expertise` varchar(256) DEFAULT NULL,
  `hasil_baca` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `ref_rad_jenis_film`;
CREATE TABLE `ref_rad_jenis_film` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `ref_rad_jenis_film` (`id`, `name`) VALUES
(1,	'Film Besar'),
(2,	'Film Kecil');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `email`, `password`, `create_at`, `update_at`) VALUES
(2,	'ajiganteng@gmail.com',	'd41d8cd98f00b204e9800998ecf8427e',	'2019-06-23 17:09:17',	'0000-00-00 00:00:00'),
(3,	'ajigitu@gmail.com',	'd41d8cd98f00b204e9800998ecf8427e',	'2019-06-23 17:43:16',	'2019-06-23 17:43:16');

DROP TABLE IF EXISTS `workorders`;
CREATE TABLE `workorders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_visit_ori` int(11) DEFAULT NULL,
  `id_visit_dest` int(11) DEFAULT NULL,
  `id_dokter` int(11) DEFAULT NULL,
  `id_klinis_pasien` int(11) DEFAULT NULL,
  `no_work_order` int(11) DEFAULT NULL,
  `is_kritis` tinyint(1) NOT NULL DEFAULT '0',
  `is_cito` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = new, 1, processing, 2 = done',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `is_del` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `workorders` (`id`, `id_visit_ori`, `id_visit_dest`, `id_dokter`, `id_klinis_pasien`, `no_work_order`, `is_kritis`, `is_cito`, `status`, `created_date`, `created_by`, `update_time`, `update_by`, `is_del`) VALUES
(8,	NULL,	NULL,	NULL,	NULL,	1,	0,	0,	0,	'2019-06-09 12:38:24',	NULL,	NULL,	NULL,	0),
(9,	NULL,	NULL,	NULL,	NULL,	2,	0,	0,	0,	'2019-06-10 01:45:09',	NULL,	NULL,	NULL,	0),
(10,	NULL,	NULL,	NULL,	NULL,	3,	0,	0,	0,	'2019-06-10 01:47:30',	NULL,	NULL,	NULL,	0),
(11,	NULL,	NULL,	NULL,	NULL,	4,	0,	0,	0,	'2019-06-10 01:47:40',	NULL,	NULL,	NULL,	0),
(12,	NULL,	NULL,	NULL,	NULL,	5,	0,	0,	0,	'2019-06-10 02:05:24',	NULL,	NULL,	NULL,	0);

DROP TABLE IF EXISTS `wo_radiologi_details`;
CREATE TABLE `wo_radiologi_details` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_workorder` int(11) NOT NULL,
  `id_radiologi_job_order` int(11) NOT NULL,
  `id_radiologi_job` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  `is_del` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `wo_radiologi_results`;
CREATE TABLE `wo_radiologi_results` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_wo_radiologi_details` int(11) NOT NULL,
  `id_ref_rad_result` int(11) NOT NULL,
  `result` varchar(256) NOT NULL DEFAULT 'NO RESULT YET.',
  `kV` int(11) DEFAULT NULL,
  `mA` int(11) DEFAULT NULL,
  `s` int(11) DEFAULT NULL,
  `mAs` int(11) DEFAULT NULL,
  `id_ref_rad_hasil_expertise` int(11) DEFAULT NULL,
  `jml_film` int(11) DEFAULT NULL,
  `id_ref_rad_jenis_film` int(11) DEFAULT NULL,
  `id_ref_klinis_pasien` int(11) DEFAULT NULL,
  `tingkat_dosis_radiasi` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2019-06-29 01:56:02
