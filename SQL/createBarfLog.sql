'CREATE TABLE `barf_log` (
  `barf_log_id` int(11) NOT NULL AUTO_INCREMENT,
  `barf_log_location` varchar(50) NOT NULL,
  `barf_log_date` datetime DEFAULT NULL,
  PRIMARY KEY (`barf_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1'