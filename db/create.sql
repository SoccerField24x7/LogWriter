SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for Log
-- ----------------------------
DROP TABLE IF EXISTS `Log`;
CREATE TABLE `Log` (
  `LogId` bigint(20) NOT NULL AUTO_INCREMENT,
  `LogLevel` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1 = debug, 2 = informational, 3= error, 4 = fatal',
  `SourcePage` text,
  `SQL` text,
  `Message` text NOT NULL,
  `Generated` datetime NOT NULL,
  `Dispositioned` tinyint(4) NOT NULL DEFAULT '0',
  `DispositionDate` datetime DEFAULT NULL,
  PRIMARY KEY (`LogId`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
SET FOREIGN_KEY_CHECKS=1;