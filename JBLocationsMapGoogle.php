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
 * Class CalendarLocations
 *
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram 
 * @package    Controller
 */
class JBLocationsMapGoogle extends JBLocationsMap {

	/**
	 * List of supported map types
	 * @var array
	 */
    protected $arrSupportedMapTypes = array (
        JBLocationsMap::MAP_NORMAL,
        JBLocationsMap::MAP_SATTELLITE,
        JBLocationsMap::MAP_NOMAL_SATELLITE,
        JBLocationsMap::MAP_TERRAIN
    );

	/**
	 * List of supported map control types
	 * @var array
	 */
    protected $arrSupportedMapControlTypes = array (
        JBLocationsMap::MAPCONTROL_NORMAL,
        JBLocationsMap::MAPCONTROL_LARGE,
    );

  	/**
	 * Is map type switching supported?
	 * @var boolean
	 */
    protected $boolHasMapTypeSwitch = true;

    /*
     * Constructor
     * @param Id for this map
     */
    function __construct($intMapId) {
        parent::__construct();
        $this->intMapId = $intMapId;
    }

    /*
     * Get the Google-Maps id
     * @return string Google-Maps id
     */
    protected function getMapKey() {
        $rootPageDetails = $this->getPageDetails($this->getRootIdFromUrl());
        if ($rootPageDetails->jblocations_map_google) {
            return $rootPageDetails->jblocations_map_google;
        }
        return; // nothing found
    }

    /*
     * Generate the code for Google-Maps
     * @param object A JBLocationsMap configuration object
     * @return string The map code
     */
    public function getMapCode($strTemplate='jbloc_imap_google') {
        $objTemplate = new FrontendTemplate($strTemplate);
        $objTemplate->map = $this->arrCompiledMap;
        $objTemplate->marker = $this->arrMapMarkers;
		return $objTemplate->parse();
    }
}

?>
