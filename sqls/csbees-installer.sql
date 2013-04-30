SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

/* import this file for complete installation */
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csbees`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL COMMENT '(YY-MM-DD) time of visit (indian time)',
  `ip` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userAgent` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `refID` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10256 ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `log_LoggedInUsers`
--
DROP VIEW IF EXISTS `log_LoggedInUsers`;
CREATE TABLE IF NOT EXISTS `log_LoggedInUsers` (
`time` datetime
,`name` varchar(500)
,`refID` varchar(180)
,`ip` varchar(2000)
,`userAgent` varchar(2000)
);
-- --------------------------------------------------------

--
-- Table structure for table `repoEvents`
--

DROP TABLE IF EXISTS `repoEvents`;
CREATE TABLE IF NOT EXISTS `repoEvents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `repoChange` int(10) DEFAULT '0' COMMENT 'change in the reputation eg 5, -5, etc',
  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'type of repo change. eg., UPLOAD, BOUNTY, MISC ',
  `referral` int(10) DEFAULT NULL COMMENT 'reference id to the cause of change (mostly a file id in table uploads). eg., in case of upload by this user, this value will be id of the upoaded file in uploads table',
  `message` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'additional message for reference to the cause of change',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tagsAvailable`
--

DROP TABLE IF EXISTS `tagsAvailable`;
CREATE TABLE IF NOT EXISTS `tagsAvailable` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(190) COLLATE utf8_unicode_ci NOT NULL,
  `acronym` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `valid` tinyint(4) NOT NULL DEFAULT '1',
  `addedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `addedBy` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user id of the user who created the tag',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`acronym`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='list of available tags' AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

DROP TABLE IF EXISTS `uploads`;
CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `descr` text COLLATE utf8_unicode_ci,
  `fileID` varchar(780) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fileSize` float unsigned NOT NULL DEFAULT '0' COMMENT 'fileSize in KB',
  `path` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `uploader` varchar(780) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'if this upload is allowed for display',
  `downloadCount` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'no. of downloads of this file',
  `extension` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'file extension',
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `descr` (`descr`),
  FULLTEXT KEY `topic` (`topic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=134 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploads2`
--

DROP TABLE IF EXISTS `uploads2`;
CREATE TABLE IF NOT EXISTS `uploads2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time` datetime NOT NULL,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `descr` text COLLATE utf8_unicode_ci,
  `fileID` varchar(780) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fileSize` float unsigned NOT NULL DEFAULT '0' COMMENT 'fileSize in KB',
  `path` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `uploader` varchar(780) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'if this upload is allowed for display',
  `downloadCount` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'no. of downloads of this file',
  `extension` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'file extension',
  `votes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `descr` (`descr`),
  FULLTEXT KEY `topic` (`topic`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=123 ;

-- --------------------------------------------------------

--
-- Table structure for table `uploadsTags`
--

DROP TABLE IF EXISTS `uploadsTags`;
CREATE TABLE IF NOT EXISTS `uploadsTags` (
  `uploadID` int(10) unsigned NOT NULL COMMENT 'uploadId of the file which has been tagged',
  `tagID` int(10) unsigned NOT NULL COMMENT 'tagId to identify the tags',
  `taggedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'tagging time',
  PRIMARY KEY (`uploadID`,`tagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tags associated with the uploads';

-- --------------------------------------------------------

--
-- Table structure for table `uploadsTags2`
--

DROP TABLE IF EXISTS `uploadsTags2`;
CREATE TABLE IF NOT EXISTS `uploadsTags2` (
  `uploadID` int(10) unsigned NOT NULL COMMENT 'uploadId of the file which has been tagged',
  `tagID` int(10) unsigned NOT NULL COMMENT 'tagId to identify the tags',
  `taggedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'tagging time',
  PRIMARY KEY (`uploadID`,`tagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tags associated with the uploads';

-- --------------------------------------------------------

--
-- Stand-in structure for view `uploadsTagsView`
--
DROP VIEW IF EXISTS `uploadsTagsView`;
CREATE TABLE IF NOT EXISTS `uploadsTagsView` (
`uploadID` int(10) unsigned
,`tagID` int(10) unsigned
,`taggedOn` timestamp
,`tagName` varchar(190)
,`tagAcronym` varchar(50)
,`tagType` varchar(10)
);
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'FB' COMMENT 'fb, native, twitter, open id, etc',
  `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `profileURL` varchar(500) COLLATE utf8_unicode_ci DEFAULT '#',
  `email` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `college` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `branch` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `reputation` int(10) DEFAULT '0',
  `refID` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `userAccessLevel` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'account creation time',
  `blocked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `indexed_refID` (`refID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `usersTags`
--

DROP TABLE IF EXISTS `usersTags`;
CREATE TABLE IF NOT EXISTS `usersTags` (
  `userID` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `tagID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`userID`,`tagID`),
  KEY `fk_userstag_tagid` (`tagID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `usersTagsView`
--
DROP VIEW IF EXISTS `usersTagsView`;
CREATE TABLE IF NOT EXISTS `usersTagsView` (
`userID` varchar(180)
,`tagID` int(10) unsigned
,`id` int(10) unsigned
,`name` varchar(190)
,`acronym` varchar(50)
,`type` varchar(10)
,`valid` tinyint(4)
,`addedOn` timestamp
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `validUploadsView`
--
DROP VIEW IF EXISTS `validUploadsView`;
CREATE TABLE IF NOT EXISTS `validUploadsView` (
`id` int(10) unsigned
,`time` datetime
,`topic` text
,`downloadCount` bigint(20) unsigned
,`path` varchar(2000)
,`fileSize` float unsigned
,`descr` text
,`votes` int(11)
,`allowed` tinyint(1)
,`uploader` varchar(500)
,`uploaderRefID` varchar(180)
,`uploaderProfileURL` varchar(500)
,`reputation` int(10)
,`userAccessLevel` varchar(20)
);
-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `uploadID` int(10) unsigned NOT NULL COMMENT 'uploadId of the file which has been voted',
  `voteNature` int(10) NOT NULL,
  `votedOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'voting time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_votes_userId_uploadId_voteNature` (`userID`,`uploadID`,`voteNature`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Structure for view `log_LoggedInUsers`
--
DROP TABLE IF EXISTS `log_LoggedInUsers`;

CREATE  VIEW `log_LoggedInUsers` AS (select `log`.`time` AS `time`,`users`.`name` AS `name`,`users`.`refID` AS `refID`,`log`.`ip` AS `ip`,`log`.`userAgent` AS `userAgent` from (`log` join `users` on((`users`.`refID` = `log`.`refID`))) group by `log`.`time`,`log`.`refID` order by `log`.`time` desc);

-- --------------------------------------------------------

--
-- Structure for view `uploadsTagsView`
--
DROP TABLE IF EXISTS `uploadsTagsView`;

CREATE  VIEW `uploadsTagsView` AS select `uploadsTags`.`uploadID` AS `uploadID`,`uploadsTags`.`tagID` AS `tagID`,`uploadsTags`.`taggedOn` AS `taggedOn`,`tagsAvailable`.`name` AS `tagName`,`tagsAvailable`.`acronym` AS `tagAcronym`,`tagsAvailable`.`type` AS `tagType` from (`uploadsTags` join `tagsAvailable`) where (`uploadsTags`.`tagID` = `tagsAvailable`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `usersTagsView`
--
DROP TABLE IF EXISTS `usersTagsView`;

CREATE  VIEW `usersTagsView` AS select `usersTags`.`userID` AS `userID`,`usersTags`.`tagID` AS `tagID`,`tagsAvailable`.`id` AS `id`,`tagsAvailable`.`name` AS `name`,`tagsAvailable`.`acronym` AS `acronym`,`tagsAvailable`.`type` AS `type`,`tagsAvailable`.`valid` AS `valid`,`tagsAvailable`.`addedOn` AS `addedOn` from (`usersTags` join `tagsAvailable` on((`tagsAvailable`.`id` = `usersTags`.`tagID`))) where (`tagsAvailable`.`valid` = 1);

-- --------------------------------------------------------

--
-- Structure for view `validUploadsView`
--
DROP TABLE IF EXISTS `validUploadsView`;

CREATE  VIEW `validUploadsView` AS (select `uploads`.`id` AS `id`,`uploads`.`time` AS `time`,`uploads`.`topic` AS `topic`,`uploads`.`downloadCount` AS `downloadCount`,`uploads`.`path` AS `path`,`uploads`.`fileSize` AS `fileSize`,`uploads`.`descr` AS `descr`,`uploads`.`votes` AS `votes`,`uploads`.`allowed` AS `allowed`,`users`.`name` AS `uploader`,`users`.`refID` AS `uploaderRefID`,`users`.`profileURL` AS `uploaderProfileURL`,`users`.`reputation` AS `reputation`,`users`.`userAccessLevel` AS `userAccessLevel` from (`uploads` left join `users` on((`uploads`.`uploader` = `users`.`refID`))) where (`uploads`.`allowed` = 1));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usersTags`
--
ALTER TABLE `usersTags`
  ADD CONSTRAINT `fk_userstag_tagid` FOREIGN KEY (`tagID`) REFERENCES `tagsAvailable` (`id`),
  ADD CONSTRAINT `fk_userstag_userid` FOREIGN KEY (`userID`) REFERENCES `users` (`refID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
