-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------


--
--		Table `tl_news`
--

CREATE TABLE `tl_module` (
	`news_seqnav_show` char(1) NOT NULL default '',
    `news_seqnav_template` varchar(32) NOT NULL default '',
	`news_seqnav_loadlatest` char(1) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
