-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_module`
-- 
CREATE TABLE `tl_module` (
  `jb_tkjcontacts_data` varchar(255) NOT NULL default '',
  `jb_tkjcontacts_template` varchar(255) NOT NULL default '',
  `jb_tkjcontacts_groups` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;