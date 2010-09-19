<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    JBIncludeGallery
 * @license    LGPL 
 * @filesource
 */

// show in backend
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = 
	str_replace(
        '{image_legend}',
        '{jb_includegallery:hide},jb_includegallery_published;{image_legend}',  
        $GLOBALS['TL_DCA']['tl_news']['palettes']['default']
);

/**
 * Selectors
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['__selector__'][] = 'jb_includegallery_published';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_news']['subpalettes']['jb_includegallery_published'] = 'jb_includegallery_modid,jb_includegallery_galid';

// field definitions
$GLOBALS['TL_DCA']['tl_news']['fields']['jb_includegallery_published'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_news']['jb_includegallery_published'],
    'inputType' => 'checkbox',
	'eval'      => array('submitOnChange'=>true)
);
$GLOBALS['TL_DCA']['tl_news']['fields']['jb_includegallery_modid'] = array (
    'label'         	=> &$GLOBALS['TL_LANG']['tl_news']['jb_includegallery_modid'],
	'exclude'       	=> true,
	'inputType'     	=> 'select',
	'options_callback'	=> array('tl_news_jb_includegallery', 'getGalleries'),
);
$GLOBALS['TL_DCA']['tl_news']['fields']['jb_includegallery_galid'] = array (
    'label'         	=> &$GLOBALS['TL_LANG']['tl_news']['jb_includegallery_galid'],
	'exclude'       	=> true,
	'inputType'     	=> 'select',
	'reference'			=> &$GLOBALS['TL_LANG']['tl_module']['galleries'],
	'options_callback'  => array('tl_news_jb_includegallery', 'getGalleryGroups'),
);

class tl_news_jb_includegallery extends Backend {
	/**
	 * Get page columns
	 * @param DataContainer $dc
	 */
	public function getGalleries(DataContainer $dc) {
		$objGalleryModule = $this->Database->prepare("SELECT id, name FROM tl_module WHERE type='gallerysingle'")			
			->execute();

		$arrOptions = array();		
		while ($objGalleryModule->next()) {
			$arrOptions[$objGalleryModule->id] = $objGalleryModule->name;
		}
		return $arrOptions;
	}
	
	public function getGalleryGroups() {
		$objGalleries = $this->Database->prepare("SELECT pid, id, title, (SELECT title FROM tl_gallery_archive WHERE tl_gallery_archive.id=tl_gallery.pid) AS archive FROM tl_gallery")
			->execute();
			
		$groups = array();
		while ($objGalleries->next()) {
			$groups['archive_'.$objGalleries->pid][] = $objGalleries->id;
			$GLOBALS['TL_LANG']['tl_module']['galleries']['archive_'.$objGalleries->pid] = $objGalleries->archive;
			$GLOBALS['TL_LANG']['tl_module']['galleries'][$objGalleries->id] = $objGalleries->title;
		}
		return $groups;
	}
}
?>
