<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    News
 * @license    LGPL 
 * @filesource
 */


// Modify Palettes
$GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader'] = str_replace(
    'imgSize;', 
    'imgSize; {jb_seqnav_legend:hide}, news_seqnav_show, news_seqnav_loadlatest, news_seqnav_template;', 
    $GLOBALS['TL_DCA']['tl_module']['palettes']['newsreader']
);

// Add Fields
$GLOBALS['TL_DCA']['tl_module']['fields']['news_seqnav_show'] = array (
		'label'		=> &$GLOBALS['TL_LANG']['tl_module']['jb_seqnav_show'],
		'exclude'	=> true,
		'inputType'	=> 'checkbox'
);

$GLOBALS['TL_DCA']['tl_module']['fields']['news_seqnav_loadlatest'] = array (
		'label'		=> &$GLOBALS['TL_LANG']['tl_module']['jb_seqnav_loadlatest'],
		'exclude'	=> true,
		'inputType'	=> 'checkbox'
);

$GLOBALS['TL_DCA']['tl_module']['fields']['news_seqnav_template'] = array (
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['jb_seqnav_template'],
	'default'			=> 'news_seqpager_default',
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_module_jb_newsseqpager', 'getTemplates'),
);

class tl_module_jb_newsseqpager extends Backend {
	/**
	 * Get template over theme id
	 * @param DataContainer $dc
	 */
	public function getTemplates(DataContainer $dc) {
		return (version_compare(VERSION.BUILD, '2.9.0', '>=')) ? 
        		$this->getTemplateGroup('news_seqpager', $dc->activeRecord->pid) : 
        		$this->getTemplateGroup('news_seqpager');
	}
}
?>
