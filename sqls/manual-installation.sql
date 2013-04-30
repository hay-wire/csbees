CREATE TABLE uploads (
 id int(10) unsigned NOT NULL AUTO_INCREMENT,
 time datetime NOT NULL,
 topic varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
 descr text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 fileID varchar(780) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 fileSize float unsigned NOT NULL DEFAULT '0' COMMENT 'fileSize in KB',
 path varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
 uploader varchar(780) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 ip varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
 allowed tinyint(1) NOT NULL DEFAULT '1' COMMENT 'if this upload is allowed for display',
 downloadCount bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'no. of downloads of this file',
 extension varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'file extension',
 votes INT DEFAULT 0,
 PRIMARY KEY (id),
 FULLTEXT KEY descr (descr)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci



CREATE TABLE tagsAvailable (
 id int(10) unsigned NOT NULL AUTO_INCREMENT,
 name varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
 acronym varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
 type varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
 valid tinyint(4) NOT NULL DEFAULT 1,
 addedOn timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (id),
 UNIQUE KEY name (name,acronym)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='list of available tags'






CREATE TABLE uploadsTags (
 uploadID int(10) UNSIGNED NOT NULL COMMENT 'uploadId of the file which has been tagged',
 tagID int(10) UNSIGNED NOT NULL COMMENT 'tagId to identify the tags',
 taggedOn timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'tagging time'
  --CONSTRAINT fk_uploadstags_uploadId FOREIGN KEY (uploadID) REFERENCES uploads(id),
  --CONSTRAINT fk_uploadstags_tagid FOREIGN KEY (tagID) REFERENCES tagsAvailable(id),
  CONSTRAINT pk_userid_tagid PRIMARY KEY (uploadID, tagID) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='tags associated with the uploads'



CREATE VIEW uploadsTagsView 
AS 
   SELECT uploadsTags.uploadID         AS uploadID, 
          uploadsTags.tagID 	       AS tagID, 
          uploadsTags.taggedOn 	       AS taggedOn, 
          tagsAvailable.name	       AS tagName, 
          tagsAvailable.acronym        AS tagAcronym, 
          tagsAvailable.type           AS tagType 
   FROM uploadsTags 
           JOIN tagsAvailable 
   WHERE  ( uploadsTags.tagID = tagsAvailable.id )



/*CREATE VIEW tagsAvailableview 
AS 
  SELECT tagsAvailable.id      AS tagId, 
         tagsAvailable.name    AS tagName, 
         tagsAvailable.acronym AS tagAcronym, 
         tagsAvailable.type    AS tagType 
  FROM   tagsAvailable 
  WHERE  ( tagsAvailable.valid = 1 ) 

*/



CREATE TABLE users (
 id int(10) unsigned NOT NULL AUTO_INCREMENT,
 type varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FB' COMMENT 'fb, native, twitter, open id, etc',
 name varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
 profileURL varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '#',
 email varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 course varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 college varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 branch varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 semester int(11) DEFAULT NULL,
 reputation int(10) DEFAULT '0',
 refID varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
 userAccessLevel varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
 creation_time timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'account creation time',
 blocked tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (id),
 KEY indexed_refID (refID)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci



CREATE TABLE usersTags
(	userID VARCHAR(180) NOT NULL,
	tagID INT(10) UNSIGNED NOT NULL,
	CONSTRAINT pk_userid_tagid PRIMARY KEY (userID, tagID),
	CONSTRAINT fk_userstag_userid FOREIGN KEY (userID) REFERENCES users(refID),
	CONSTRAINT fk_userstag_tagid FOREIGN KEY (tagID) REFERENCES tagsAvailable(id)
		
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci


CREATE VIEW usersTagsView 
AS
SELECT usersTags.* , tagsAvailable.* 
FROM usersTags
INNER JOIN tagsAvailable ON tagsAvailable.id = usersTags.tagID
WHERE valid=1

CREATE TABLE votes 
(	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,	
	userID VARCHAR(180) NOT NULL,
	uploadID int(10) UNSIGNED NOT NULL COMMENT 'uploadId of the file which has been voted',
	voteNature INT(10) NOT NULL,
	votedOn timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'voting time',
	CONSTRAINT uni_votes_userId_uploadId_voteNature UNIQUE INDEX(userID, uploadID, voteNature)
	--CONSTRAINT fk_votes_userid FOREIGN KEY (userID) REFERENCES users(refID)
	--CONSTRAINT fk_votes_uploadid FOREIGN KEY (uploadID) REFERENCES uploads(id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci




CREATE VIEW validUploadsView
AS ( SELECT 
          uploads.id            AS id, 
          uploads.time          AS time, 
          uploads.topic         AS topic, 
          uploads.downloadcount AS downloadCount, 
          uploads.path          AS path, 
          uploads.filesize      AS fileSize,
          uploads.descr         AS descr, 
          uploads.votes         AS votes, 
          uploads.allowed       AS allowed, 
          users.name            AS uploader,
          users.refID		AS uploaderRefID, 
          users.profileurl      AS uploaderProfileURL, 
          users.reputation      AS reputation, 
          users.useraccesslevel AS userAccessLevel 
    FROM  uploads 
    		LEFT JOIN users ON (uploads.uploader = users.refid)
    WHERE uploads.allowed=1
  )





CREATE TABLE log (
 id int(11) NOT NULL AUTO_INCREMENT,
 time datetime NOT NULL COMMENT '(YY-MM-DD) time of visit (indian time)',
 ip varchar(2000) DEFAULT NULL,
 userAgent varchar(2000) DEFAULT NULL,
 refID varchar(250) DEFAULT NULL,
 PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci




CREATE VIEW log_LoggedInUsers 
AS ( 
	select log.time AS time,
		users.name AS name,
		users.refID AS refID,
		log.ip AS ip,
		log.userAgent AS userAgent 
	from log 
		join users on users.refID = log.refID
	group by log.time,log.refID order by log.time desc
)




CREATE TABLE repoEvents
(	id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	userID varchar(180) NOT NULL,
	repoChange INT(10) DEFAULT 0 COMMENT 'change in the reputation eg 5, -5, etc',
	type VARCHAR(50) NOT NULL COMMENT 'type of repo change. eg., UPLOAD, BOUNTY, MISC ',
	reference INT(10) DEFAULT NULL COMMENT 'reference id to the cause of change (mostly a file id in table uploads). eg., in case of upload by this user, this value will be id of the upoaded file in uploads table',
	message VARCHAR(2000) DEFAULT NULL COMMENT 'additional message for reference to the cause of change',
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci



























  
SELECT validUploadsView9.*, usersTags.* FROM validUploadsView9, usersTags
WHERE validUploadsView9.id IN (SELECT uploadID FROM uploadsTags) AND
      usersTags.tagId IN (SELECT tagID FROM uploadsTags) AND
      usersTags.userID=100000550866165
GROUP BY validUploadsView.id
      
SELECT validUploadsView.*, usersTags.* FROM uploads, usersTags
WHERE validUploadsView.id IN (SELECT uploadID FROM uploadsTags) AND
      usersTags.tagId IN (SELECT tagID FROM uploadsTags) AND
      usersTags.userID=
      
SELECT * FROM validUploadsView 
WHERE id IN (  SELECT uploadsTags.uploadId
	       FROM usersTags
	       		INNER JOIN uploadsTags ON(uploadsTags.tagId=usersTags.tagID)
	       	WHERE usersTags.userID=100000550866165
	    )

