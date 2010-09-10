-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_calendar_staff`
-- 

CREATE TABLE `tl_jbeventstaff` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(200) NOT NULL default '',
  `details` text NULL,
  `link` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_calendar_events`
-- 
CREATE TABLE `tl_calendar_events` (
  `jbeventstaff_published` char(1) NOT NULL default '',
  `jbeventstaff_id` int(10) unsigned NOT NULL default '0',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
