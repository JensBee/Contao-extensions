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
 * @package    JBPageIndex 
 * @license    LGPL 
 * @filesource
 */

// Get shared languages
$this->loadLanguageFile('tl_article');

/**
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['jb_pageindex'] = 
    '{title_legend},'.
    	'name,'.
    	'type;'.
    	'jbpageindex_section;'.
    '{template_legend:hide},'.
    	'jbpageindex_template;'.
    '{expert_legend:hide},'.
    	'align,'.
    	'space,'.
    	'cssID';

// Template
$GLOBALS['TL_DCA']['tl_content']['fields']['jbpageindex_template'] = array (	
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['jbpageindex']['template'],
	'default'			=> 'jb_pidx',
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('jb_pageindex_content', 'getTemplates')
);

// Page section
$GLOBALS['TL_DCA']['tl_content']['fields']['jbpageindex_section'] = array (
	'label'         	=> &$GLOBALS['TL_LANG']['tl_content']['jbpageindex']['section'],
	'default'			=> 'right',
	'exclude'       	=> true,
	'inputType'     	=> 'select',
	'options_callback'	=> array('jb_pageindex_content', 'getSections')
);

class jb_pageindex_content extends Backend {
	/**
	 * Get template over theme id
	 * @param DataContainer $dc
	 */
	public function getTemplates(DataContainer $dc) {
		return $this->getTemplateGroup('jb_pidx', $dc->activeRecord->pid);
	}

	/**
	 * Get page columns
	 * @param DataContainer $dc
	 */
	public function getSections(DataContainer $dc) {
		$objLayout = $this->Database->prepare('SELECT layout FROM tl_page WHERE id=?')
			->limit(1)
			->execute(intval($dc->activeRecord->pid));
		if ($objLayout->layout > 0) {
			$objCols = $this->Database->prepare('SELECT cols FROM tl_layout WHERE id=?')
				->limit(1)
				->execute(intval($dc->activeRecord->pid));
		} else {
			$objCols = $this->Database->prepare('SELECT cols FROM tl_layout WHERE fallback=1')
				->limit(1)
				->execute();
		}
		switch ($objCols->cols) {
			case '1cl':
				return array(
					'main' => &$GLOBALS['TL_LANG']['tl_article']['main']
				);
				break;
			case '2cll':
				return array(
					'main' => &$GLOBALS['TL_LANG']['tl_article']['main'],
					'left' => &$GLOBALS['TL_LANG']['tl_article']['left'],
				);
				break;
			case '2clr':
				return array(
					'main' 	=> &$GLOBALS['TL_LANG']['tl_article']['main'],
					'right' => &$GLOBALS['TL_LANG']['tl_article']['right'],
				);
				break;
			case '3cl':
				return array(
					'main' 	=> &$GLOBALS['TL_LANG']['tl_article']['main'],
					'left' 	=> &$GLOBALS['TL_LANG']['tl_article']['left'],
					'right' => &$GLOBALS['TL_LANG']['tl_article']['right'],
				);
				break;
		}
	}
}

?>
