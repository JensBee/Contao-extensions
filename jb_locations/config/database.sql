-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************

-- 
-- Table `tl_calendar`
-- 
CREATE TABLE `tl_calendar` (
  `jblocations_jumpTo` int(10) unsigned NOT NULL default '0',
  `jblocations_map` int(10) unsigned NOT NULL default '0',
  `jblocations_map_published` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_calendar_events`
-- 
CREATE TABLE `tl_calendar_events` (
  `jblocations_published` char(1) NOT NULL default '',
  `jblocations_list` blob NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_content`
-- 
CREATE TABLE `tl_content` (
  `jblocations_map` int(10) unsigned NOT NULL default '0',
  `jblocations_map_template` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_jblocation_coords`
-- 
CREATE TABLE `tl_jblocations_coords` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `zoom` int(4) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `description` text NULL,
  `coords` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_jblocation_maps`
-- 
CREATE TABLE `tl_jblocations_maps` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `provider` int(2) unsigned NOT NULL default '0',
  `markers_show` char(1) NOT NULL default '',
  `markers_external_show` char(1) NOT NULL default '',
  `map_template` varchar(255) NOT NULL default '',  
  `map_marker_template` varchar(255) NOT NULL default '',
  `map_width` varchar(64) NOT NULL default '400px',
  `map_height` varchar(64) NOT NULL default '300px',
  `map_types` blob NULL,
  `map_type_default` varchar(255) NOT NULL default '',
  `headline_map` varchar(255) NOT NULL default '',
  `headline_marker` varchar(255) NOT NULL default '',
  `headline_map_overwrite` char(1) NOT NULL default '',
  `headline_marker_overwrite` char(1) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_jblocation_types`
-- 
CREATE TABLE `tl_jblocations_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `css_class` varchar(255) NOT NULL default '',
  `teaser` text NULL,
  `details` mediumtext NULL,
  `icon` varchar(255) NOT NULL default '',
  `icon_anchor_x` int(4) unsigned NOT NULL default '0',
  `icon_anchor_y` int(4) unsigned NOT NULL default '0',
  `icon_alt` varchar(255) NOT NULL default '',
  `icon_alt_anchor_x` int(4) unsigned NOT NULL default '0',
  `icon_alt_anchor_y` int(4) unsigned NOT NULL default '0',
  `icon_shadow` varchar(255) NOT NULL default '',
  `icon_shadow_anchor_x` int(4) unsigned NOT NULL default '0',
  `icon_shadow_anchor_y` int(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_jblocation_data`
-- 
CREATE TABLE `tl_jblocations_data` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',  
  `filetype` varchar(10) NOT NULL default '',
  `category` varchar(255) NOT NULL default '',
  `headline` varchar(255) NOT NULL default '',
  `locations_published` char(1) NOT NULL default '',
  `locations_list` blob NULL,
  `description` mediumtext NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_module`
-- 
CREATE TABLE `tl_module` (
  `jblocations_published` char(1) NOT NULL default '',
  `jblocations_list` blob NULL,
  `jblocations_map` int(10) unsigned NOT NULL default '0',
  `jblocations_map_template` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 
-- Table `tl_page`
-- 
CREATE TABLE `tl_page` (
  `jblocations_map_google` varchar(255) NOT NULL default ''
  `jblocations_map_yahoo` varchar(255) NOT NULL default '',
  `jblocations_map_bing` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
