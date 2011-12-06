-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 06, 2011 at 07:45 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vdpi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `con_ret_rtt`
--

CREATE TABLE IF NOT EXISTS `con_ret_rtt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prot_type` tinytext NOT NULL COMMENT 'protocol type',
  `src_addr` tinytext NOT NULL COMMENT 'ipv4 and ipv6 (maybe)',
  `dst_addr` tinytext NOT NULL COMMENT 'ipv4 and ipv6 (maybe)',
  `dst_port` varchar(10) NOT NULL,
  `src_port` varchar(10) NOT NULL,
  `com_conn` tinytext NOT NULL COMMENT 'completed connection (yer/no)',
  `first_pkt` tinytext NOT NULL COMMENT 'first packet sent (in time) e.g. Sun Dec 4 05:46:19.550389 2011',
  `last_pkt` tinytext NOT NULL COMMENT 'last packet sent (in time) e.g. Sun Dec 4 05:46:19.550389 2011',
  `elpsd_time` tinytext NOT NULL COMMENT 'in time format hh:mm:ss.ssssssss',
  `total_pkt` int(11) NOT NULL COMMENT 'total packet',
  `src_addr_pkt_sent` int(11) NOT NULL,
  `dst_addr_pkt_sent` int(11) NOT NULL,
  `src_addr_ack_sent` int(11) NOT NULL,
  `dst_addr_ack_sent` int(11) NOT NULL,
  `src_addr_actl_pkt` int(11) NOT NULL,
  `dst_addr_actl_pkt` int(11) NOT NULL,
  `src_addr_actl_byte` int(11) NOT NULL,
  `dst_addr_actl_byte` int(11) NOT NULL,
  `src_addr_ret_pkt` int(11) NOT NULL,
  `dst_addr_ret_pkt` int(11) NOT NULL,
  `src_addr_ret_byte` int(11) NOT NULL,
  `dst_addr_ret_byte` int(11) NOT NULL,
  `src_addr_syn_fin_sent` tinytext NOT NULL,
  `dst_addr_syn_fin_sent` tinytext NOT NULL,
  `src_addr_throughput` int(11) NOT NULL COMMENT 'in byte per second',
  `dst_addr_throughput` int(11) NOT NULL COMMENT 'in byte per second',
  `src_addr_rtt_avg` int(11) NOT NULL COMMENT 'in miliseconds',
  `dst_addr_rtt_avg` int(11) NOT NULL COMMENT 'Dont show this field',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

-- --------------------------------------------------------

--
-- Table structure for table `con_ses`
--

CREATE TABLE IF NOT EXISTS `con_ses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prot_type` tinytext NOT NULL,
  `session_start` tinytext NOT NULL COMMENT 'in time e.g. Sun Dec  4 05:46:29.023410 2011',
  `session_end` tinytext NOT NULL COMMENT 'in time e.g. Sun Dec  4 05:46:29.023410 2011',
  `src_ip_addr` tinytext NOT NULL,
  `src_port_addr` tinytext NOT NULL,
  `src_fqdn` tinytext NOT NULL,
  `dst_ip_addr` tinytext NOT NULL,
  `dst_port_addr` tinytext NOT NULL,
  `dst_fqdn` tinytext NOT NULL,
  `src_sent_byte` int(11) NOT NULL,
  `dst_sent_byte` int(11) NOT NULL,
  `src_sent_pkt` int(11) NOT NULL,
  `dst_sent_pkt` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198 ;

-- --------------------------------------------------------

--
-- Table structure for table `thresholds`
--

CREATE TABLE IF NOT EXISTS `thresholds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `threshold_name` varchar(128) NOT NULL,
  `app` varchar(128) NOT NULL,
  `table_name` varchar(128) NOT NULL,
  `column_name` varchar(128) NOT NULL,
  `time_column_name` varchar(255) NOT NULL,
  `time_interval` bigint(20) NOT NULL,
  `shot_type` varchar(10) NOT NULL,
  `min` bigint(20) NOT NULL,
  `max` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
