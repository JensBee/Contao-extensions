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
class ModuleJBLocationsMap extends Module {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_jbloc_map';

	/**
	 * JBLocations instance for this class
	 * @var unknown_type
	 */
	protected $classJBLocations;
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new backendTemplate('be_wildcard');
			$objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['jblocations_map'][0].' ###<br>'.$this->name;

			return $objTemplate->parse();
		}
		return parent::generate();
	}

	/**
	 * Generate module
	 */
	protected function compile() {
		if($this->jblocations_map_template) {
			$this->strTemplate = $this->jblocations_map_template;
			$this->Template = new FrontendTemplate($this->strTemplate);			
		}
		
		$this->classJBLocations = new JBLocations();
		$objMap = $this->classJBLocations->generateMap($this->id, $this->jblocations_map);
				
		// add map file settings
		if ($this->Input->get('item')) {
			$items = $this->Input->get('item');
			$objMap->addFilesById($items);
			$arrItemLocations = $objMap->getLocationListById('mapData', $items)->fetchAllAssoc();
			foreach ($arrItemLocations as $arrItemLocation) {								
				if ($arrItemLocation['locations_published']) {
					$arrLocationData = $this->classJBLocations->compileLocations($arrItemLocation['locations_list']);
					$objMap->addMarkers($arrLocationData);
				}
			}
		}
		
		// add map settings
		if ($this->jblocations_published) {
			$arrLocationData = $this->classJBLocations->compileLocations($this->jblocations_list);
			if (sizeof($arrLocationData) == 1) {
				$objMap->intMapZoom = $arrLocationData[0]['zoom'];
			}
			if (sizeof($arrLocationData) >= 1) {
				$objMap->addMarkers($arrLocationData);
			}
		}
		
		$objMap->compile();

		$this->Template->map = array(			
			'code' 	=> $objMap->getMapCode()
		);
	}
}
?>
