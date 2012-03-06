-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- 
-- Table `tl_content`
-- 

CREATE TABLE `tl_news` (
  `jb_includegallery_modid` int(4) unsigned NOT NULL default '0',
  `jb_includegallery_galid` int(4) unsigned NOT NULL default '0',
  `jb_includegallery_published` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
