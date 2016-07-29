SET NAMES utf8;

-- ---------------------------------------------------------------------------
-- Tables
-- ---------------------------------------------------------------------------
DROP TABLE IF EXISTS `note`;
CREATE TABLE `note` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(127) NOT NULL DEFAULT '',
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `changed_by` varchar(127) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `created` (`created`),
  KEY `changed` (`changed`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------------
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL DEFAULT '' COMMENT 'Unique hash tag',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------------
DROP TABLE IF EXISTS `note_tag`;
CREATE TABLE `note_tag` (
  `note` int(10) unsigned NOT NULL,
  `tag` int(10) unsigned NOT NULL,
  PRIMARY KEY (`note`,`tag`),
  KEY `tag` (`tag`),
  CONSTRAINT `note_tag_ibfk_2` FOREIGN KEY (`tag`) REFERENCES `tag` (`id`) ON DELETE CASCADE,
  CONSTRAINT `note_tag_ibfk_1` FOREIGN KEY (`note`) REFERENCES `note` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---------------------------------------------------------------------------
-- Trigger
-- ---------------------------------------------------------------------------
DELIMITER ;;

CREATE TRIGGER `note_bi` BEFORE INSERT ON `note` FOR EACH ROW
BEGIN
    SET new.`created` = NOW();
    SET new.`changed` = new.`created`;
END;;

DELIMITER ;

-- ---------------------------------------------------------------------------
-- Views
-- ---------------------------------------------------------------------------
DROP VIEW IF EXISTS `tags`;
CREATE VIEW `tags` AS select `tag`.`id`,`tag`.`tag`,concat('[',group_concat(`note_tag`.`note`),']') AS `notes`,count(`note_tag`.`note`) AS `count` from `tag` left join `note_tag` on `tag`.`id` = `note_tag`.`tag` group by `note_tag`.`tag` having `count`;

-- ---------------------------------------------------------------------------
-- Example note
-- ---------------------------------------------------------------------------
INSERT INTO `note` (`id`, `name`, `text`, `created_by`, `changed_by`) VALUES (1, 'Example note', '# Header 1\n## Header 2\n### Header 3\n\n    pre\n \n> blockquote\n\n**bold** - __also bold__ \n\n*italic* - _also italic_ \n\n***bold italic*** - ___also bold italic___ \n\n- list\n- list\n- list\n\n1. ordered list\n1. ordered list\n1. ordered list\n\n#ExampleTag', 'system', 'system');

INSERT INTO `tag` VALUES (1, 'ExampleTag');

INSERT INTO `note_tag` VALUES (1, 1);
