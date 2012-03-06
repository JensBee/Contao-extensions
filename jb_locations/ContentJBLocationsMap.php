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
 * @package    JBLocations
 * @license    LGPL 
 * @filesource
 */


/**
 * Class ModulePageNavBuilder
 *
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram 
 * @package    Controller
 */
class ContentJBLocationsMap extends ContentElement {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_googlemaps_locations_default';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new backendTemplate('be_wildcard');
			$objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['MOD']['jblocations'][0].' ###<br>'.$this->title;

			return $objTemplate->parse();
		}
		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile() {
		if($this->pagenavbuilder_template) {
			$this->strTemplate = $this->googlemaps_locations_template;
			$this->Template = new FrontendTemplate($this->strTemplate);
		}

        $objElements = $this->Database->prepare("SELECT * FROM tl_jblocations_maps WHERE id=?")
            ->limit(1)
            ->execute($this->googlemaps_locations);

        if ($objElements->numRows < 1) {
			return;
		}

        $dlhGM = new GoogleMapsLocationsHelper($objElements);

        $dlhGMData = $dlhGM->generateDLHMap($objElements);

        $this->Template = $dlhGMData->Template;
	}
}

?>
