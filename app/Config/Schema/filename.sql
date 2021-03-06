

DROP TABLE IF EXISTS `test_mediax`.`contactus`;
DROP TABLE IF EXISTS `test_mediax`.`durations`;
DROP TABLE IF EXISTS `test_mediax`.`emaildb`;
DROP TABLE IF EXISTS `test_mediax`.`enduser`;
DROP TABLE IF EXISTS `test_mediax`.`engines`;
DROP TABLE IF EXISTS `test_mediax`.`extra`;
DROP TABLE IF EXISTS `test_mediax`.`keywords`;
DROP TABLE IF EXISTS `test_mediax`.`logs`;
DROP TABLE IF EXISTS `test_mediax`.`m_rankhistories`;
DROP TABLE IF EXISTS `test_mediax`.`nocontractkey`;
DROP TABLE IF EXISTS `test_mediax`.`notice`;
DROP TABLE IF EXISTS `test_mediax`.`orders`;
DROP TABLE IF EXISTS `test_mediax`.`quote_supportor`;
DROP TABLE IF EXISTS `test_mediax`.`rankhistory`;
DROP TABLE IF EXISTS `test_mediax`.`rankkeywords`;
DROP TABLE IF EXISTS `test_mediax`.`resell_endcustom`;
DROP TABLE IF EXISTS `test_mediax`.`sendemail`;
DROP TABLE IF EXISTS `test_mediax`.`seohistory`;
DROP TABLE IF EXISTS `test_mediax`.`servicelog`;
DROP TABLE IF EXISTS `test_mediax`.`syslog`;
DROP TABLE IF EXISTS `test_mediax`.`tmp_rankhistory`;
DROP TABLE IF EXISTS `test_mediax`.`user`;


CREATE TABLE `test_mediax`.`contactus` (
	`subject` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`body` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`userid` int(11) DEFAULT 0 NOT NULL,
	`date` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`id` int(20) NOT NULL AUTO_INCREMENT,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`durations` (
	`ID` int(10) NOT NULL AUTO_INCREMENT,
	`KeyID` int(8) DEFAULT 0 NOT NULL,
	`StartDate` int(8) DEFAULT 0 NOT NULL,
	`EndDate` int(8) DEFAULT 0 NOT NULL,
	`Flag` int(2) DEFAULT 0 NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=sjis,
	COLLATE=sjis_japanese_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`emaildb` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`company` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`time` int(12) DEFAULT 0 NOT NULL,
	`ip` varchar(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
	`supportor` int(4) DEFAULT 0 NOT NULL,
	`status` int(4) DEFAULT 0 NOT NULL,
	`userid` int(5) DEFAULT 0 NOT NULL,
	`subject` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`enduser` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`supportor` int(4) DEFAULT 0 NOT NULL,
	`pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`company` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`department` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`fax` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`homepage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`status` int(10) DEFAULT 0 NOT NULL,
	`date` int(12) DEFAULT 0 NOT NULL,
	`address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`zipcode` varchar(115) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`CHPCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`CHPTime` int(11) DEFAULT 0 NOT NULL,
	`hosyou` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`seikou` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`loginip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`logintime` int(14) DEFAULT 0 NOT NULL,
	`agent` int(1) DEFAULT 0 NOT NULL,
	`money_bank` tinyint(1) DEFAULT '0' NOT NULL,
	`sellremark` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`techremark` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`billlastday` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`parent` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`custom` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`keystr` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`engines` (
	`ID` int(2) NOT NULL AUTO_INCREMENT,
	`Name` varchar(20) CHARACTER SET sjis COLLATE sjis_japanese_ci NOT NULL,
	`ShowName` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Short` varchar(10) CHARACTER SET sjis COLLATE sjis_japanese_ci NOT NULL,
	`Code` int(4) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=sjis,
	COLLATE=sjis_japanese_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`extra` (
	`ID` int(8) NOT NULL AUTO_INCREMENT,
	`KeyID` int(6) DEFAULT 0 NOT NULL,
	`ExtraType` int(2) DEFAULT 0 NOT NULL COMMENT '1 - in top 5, 2 - in top 3',
	`Price` int(10) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`ID`),
	KEY `keyi` (`KeyID`)) 	DEFAULT CHARSET=sjis,
	COLLATE=sjis_japanese_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`keywords` (
	`ID` int(8) NOT NULL AUTO_INCREMENT,
	`UserID` int(6) DEFAULT 0 NOT NULL,
	`Keyword` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Url` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Engine` int(4) DEFAULT 0 NOT NULL,
	`g_local` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1' NOT NULL,
	`Price` int(10) DEFAULT 0 NOT NULL,
	`limit_price` int(10) DEFAULT NULL,
	`limit_price_group` int(1) DEFAULT NULL COMMENT 'set limit price group: 1,2,3',
	`upday` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,
	`goukeifee` int(11) DEFAULT 0 NOT NULL,
	`sengoukeifee` int(11) DEFAULT 0 NOT NULL,
	`Enabled` tinyint(1) DEFAULT '0' NOT NULL,
	`Strict` tinyint(1) DEFAULT '0' NOT NULL,
	`Extra` tinyint(1) DEFAULT '0' NOT NULL,
	`start` int(8) DEFAULT 0 NOT NULL,
	`rankstart` int(8) DEFAULT 0 NOT NULL,
	`rankend` int(8) DEFAULT 0 NOT NULL,
	`kaiyaku_reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`middle` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`middleinfo` int(11) NOT NULL,
	`seika` int(11) DEFAULT 0 NOT NULL,
	`nocontract` int(11) DEFAULT 0 NOT NULL,
	`csv_type` int(10) NOT NULL COMMENT '[1=直営,2=直営2 , 3=代理店,4=ビスカス,5=アサミ,6=エニー]',
	`penalty` tinyint(1) NOT NULL,
	`service` int(5) NOT NULL,
	`mobile` tinyint(1) NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,
	`sitename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'CSV',	PRIMARY KEY  (`ID`),
	KEY `ke` (`UserID`, `Enabled`),
	KEY `Price` (`Price`),
	KEY `Engine` (`Engine`),
	FULLTEXT KEY `Keyword` (`Keyword`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`logs` (
	`id` int(20) NOT NULL AUTO_INCREMENT,
	`user_id` int(20) NOT NULL,
	`log` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'pre&after data log',
	`ip` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`useragent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`mvc` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`read` tinyint(1) NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `test_mediax`.`m_rankhistories` (
	`id` int(20) NOT NULL AUTO_INCREMENT,
	`keyword_id` int(11) NOT NULL,
	`engine_id` int(1) NOT NULL,
	`keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rank` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`rankdate` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `test_mediax`.`nocontractkey` (
	`ID` int(8) NOT NULL AUTO_INCREMENT,
	`UserID` int(6) DEFAULT 0 NOT NULL,
	`Keyword` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Url` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Engine` int(4) DEFAULT 0 NOT NULL,
	`Price` int(10) DEFAULT 0 NOT NULL,
	`upday` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '0' NOT NULL,
	`goukeifee` int(11) DEFAULT 0 NOT NULL,
	`sengoukeifee` int(11) DEFAULT 0 NOT NULL,
	$sensengoukeifee int(11) DEFAULT 0 NOT NULL,
	`Enabled` tinyint(1) DEFAULT '0' NOT NULL,
	`Strict` tinyint(1) DEFAULT '0' NOT NULL,
	`Extra` tinyint(1) DEFAULT '0' NOT NULL,
	`start` int(8) DEFAULT 0 NOT NULL,
	`rankstart` int(8) DEFAULT 0 NOT NULL,
	`rankend` int(8) DEFAULT 0 NOT NULL,
	`kaiyaku_reason` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`middle` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`middleinfo` int(11) NOT NULL,	PRIMARY KEY  (`ID`),
	KEY `ke` (`UserID`, `Enabled`),
	KEY `Price` (`Price`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`notice` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`label` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`history` date NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`orders` (
	`ID` int(6) NOT NULL AUTO_INCREMENT,
	`UserID` int(6) DEFAULT 0 NOT NULL,
	`Keywords` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Url` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`TotalPrice` int(10) DEFAULT 0 NOT NULL,
	`Enabled` tinyint(1) DEFAULT '0' NOT NULL,
	`OrderDate` int(11) DEFAULT 0 NOT NULL,
	`EnableDate` int(11) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=sjis,
	COLLATE=sjis_japanese_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`quote_supportor` (
	`supportorid` int(12) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`fullname` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`supportorid`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`rankhistory` (
	`ID` int(11) NOT NULL AUTO_INCREMENT,
	`KeyID` int(8) DEFAULT 0 NOT NULL,
	`Url` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`Rank` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`RankDate` int(11) DEFAULT 0 NOT NULL,
	`params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`rankkeywords` (
	`ID` int(11) NOT NULL AUTO_INCREMENT,
	`Keyword` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`google_jp` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`yahoo_jp` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`google_en` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`yahoo_en` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`bing` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`resell_endcustom` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`resellid` int(11) DEFAULT 0 NOT NULL,
	`customid` int(11) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`sendemail` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`status` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`seohistory` (
	`ID` int(4) NOT NULL AUTO_INCREMENT,
	`KeyID` int(4) DEFAULT 0 NOT NULL,
	`Remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Finish` tinyint(1) DEFAULT '0' NOT NULL,
	`AddDate` int(11) DEFAULT 0 NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`servicelog` (
	`ID` int(10) NOT NULL AUTO_INCREMENT,
	`LogTime` int(11) DEFAULT 0 NOT NULL,
	`KeyID` int(8) DEFAULT 0 NOT NULL,
	`Content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`Type` int(2) DEFAULT 0 NOT NULL,
	`Checked` tinyint(1) DEFAULT '0' NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`syslog` (
	`ID` int(10) NOT NULL AUTO_INCREMENT,
	`LogTime` int(11) DEFAULT 0 NOT NULL,
	`Content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`ip` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,	PRIMARY KEY  (`ID`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

CREATE TABLE `test_mediax`.`tmp_rankhistory` (
	`ID` int(11) DEFAULT 0 NOT NULL,
	`KeyID` int(8) DEFAULT 0 NOT NULL,
	`Url` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`Rank` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`RankDate` int(11) DEFAULT 0 NOT NULL,
	`params` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL	) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `test_mediax`.`user` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`supportor` int(4) DEFAULT 0 NOT NULL,
	`pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`company` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`department` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`tel` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`fax` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`homepage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`status` int(10) DEFAULT 0 NOT NULL,
	`date` int(12) DEFAULT 0 NOT NULL,
	`address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`zipcode` varchar(115) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`CHPCode` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`CHPTime` int(11) DEFAULT 0 NOT NULL,
	`hosyou` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`seikou` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`loginip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`logintime` int(14) DEFAULT 0 NOT NULL,
	`agent` int(1) DEFAULT 0 NOT NULL,
	`money_bank` tinyint(1) DEFAULT '0' NOT NULL,
	`sellremark` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`techremark` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`billlastday` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '翌月末' NOT NULL,
	`password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`role` int(5) DEFAULT NULL,
	`created` datetime NOT NULL,
	`updated` datetime NOT NULL,
	`logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`limit_price_multi` int(10) DEFAULT NULL,
	`limit_price_multi2` int(10) DEFAULT NULL,
	`limit_price_multi3` int(10) DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_unicode_ci,
	ENGINE=MyISAM;

