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
 * @package    IncludeGallery
 * @license    LGPL 
 * @filesource
 */

/**
 * Class ModuleJBIncludeGallery
 *
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Module
 */
class ModuleJBIncludeGallery extends ModuleGallery {
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_jbgalinc';
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new backendTemplate('be_wildcard');
			$objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['jb_includegallery'][0];

			return $objTemplate->parse();
		}
		return parent::generate();
	}
	
	/**
	 * Generate module
	 */
	protected function compile() {
		global $objPage;
		echo 'GAL-INC!';
	print_r($objPage);
	}
}

?>
