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
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class JBLocations extends Frontend {

    // map types
    const MAPPROVIDER_DEFAULT   = 0; // default to OSM (free & no key needed)
    const MAPPROVIDER_GOOGLE    = 3; // google maps
    const MAPPROVIDER_MS        = 1; // bing maps
    const MAPPROVIDER_YAHOO     = 2; // yahoo maps
    const MAPPROVIDER_OSM       = 0; // open streetmap
    public static $arrMapProvider = array(
        JBLocations::MAPPROVIDER_GOOGLE  => 'Google Maps',
        JBLocations::MAPPROVIDER_MS      => 'Bing Maps',
        JBLocations::MAPPROVIDER_YAHOO   => 'Yahoo Maps',
        JBLocations::MAPPROVIDER_OSM     => 'OpenStreetMap',
    );

    /**
	 * List of supported map providers
	 * @var array
	 */
    protected $arrSupportedMapProviders = array(JBLocations::MAPPROVIDER_DEFAULT);

    /**
     * Query for map provider API keys
     * @return array Query assoc
     */
    public function getAvailableMapKeys() {
        $arrMapProviders =  $this->Database->prepare('SELECT jblocations_map_google, jblocations_map_yahoo, jblocations_map_bing FROM tl_page')
            ->limit(1)
            ->execute()
            ->fetchAssoc();
        return $arrMapProviders;
    }

    /**
     * Generate dynamic DCA for tl_jblocations_maps on load
     * @param String Current value
     * @param object DataContainer
     */
    public function dcaMapsOnLoad() {
        $this->queryMapProviders();
        if (count($this->arrSupportedMapProviders) > 1) {
            $GLOBALS['TL_DCA']['tl_jblocations_maps']['palettes']['default'] = str_replace(
                'title',
                'title,provider',
                $GLOBALS['TL_DCA']['tl_jblocations_maps']['palettes']['default']
            );
            $GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['provider']['options'] = array();
            foreach ($this->arrSupportedMapProviders as $mapProvider) {
                $GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['provider']['options'][$mapProvider] = 
                	JBLocations::$arrMapProvider[$mapProvider];
            }
        }
    }

    /**
     * Generate dynamic DCA for tl_jblocations_maps.map_template on load
     * @param String Current value
     * @param object DataContainer
     * @return String Current value passed on
     */
    public function dcaMapsOnLoad_mapTemplate($varValue, DataContainer $dc) {
        $strTpl = 'jbloc_imap_';
        switch ($dc->activeRecord->provider) {
            case JBLocations::MAPPROVIDER_GOOGLE:
                $strTpl .= 'google';
                break;
            case JBLocations::MAPPROVIDER_MS:
                $strTpl .= 'bing';
                break;
            case JBLocations::MAPPROVIDER_YAHOO:
                $strTpl .= 'yahoo';
                break;
            case JBLocations::MAPPROVIDER_OSM:
                $strTpl .= 'osm';
                break;
        }    	
        $GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_template']['options'] = 
        	$this->getTemplateGroup('jb_imap_'.$strTpl, $dc->activeRecord->pid);
        return $varValue;
    }

    /**
     * Generate dynamic DCA for tl_jblocations_maps.map_types on load
     * @param String Current value
     * @param object DataContainer
     * @return String Current value passed on
     */
    public function dcaMapsOnLoad_mapTypes($varValue, DataContainer $dc) {
        switch ($dc->activeRecord->provider) {
            case JBLocations::MAPPROVIDER_GOOGLE:
            	$map = new JBLocationsMapGoogle();
                break;
            case JBLocations::MAPPROVIDER_MS:
                $map = new JBLocationsMapBing();
                break;
            case JBLocations::MAPPROVIDER_YAHOO:
                $map = new JBLocationsMapYahoo();
                break;
            case JBLocations::MAPPROVIDER_OSM:
				$map = new JBLocationsMapOSM();
                break;
        }
        // create check- & radioboxes        
        foreach ($map->arrSupportedMapTypes as $intMapType) {
        	$name = $GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_'. 
        				JBLocationsMap::$arrMapTypes[$map->arrSupportedMapTypes[$intMapType]]
        			];
        	$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_types']['options']['mt_'.$intMapType] = $name;
        	$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_type_default']['options']['mt_'.$intMapType] = $name;	    	
        }
        return $varValue;
    }
    
    /**
     * Query for supported map providers. Sets $arrSupportedMapProviders
     */
    protected function queryMapProviders() {
        $arrMapProviders = $this->getAvailableMapKeys();
        $this->arrSupportedMapProviders = array(JBLocations::MAPPROVIDER_DEFAULT);
        if ($arrMapProviders['jblocations_map_google']) {
            array_push($this->arrSupportedMapProviders, JBLocations::MAPPROVIDER_GOOGLE);
        }
        if ($arrMapProviders['jblocations_map_yahoo']) {
            array_push($this->arrSupportedMapProviders, JBLocations::MAPPROVIDER_YAHOO);
        }
        if ($arrMapProviders['jblocations_map_bing']) {
            array_push($this->arrSupportedMapProviders, JBLocations::MAPPROVIDER_MS);
        }
    }
    
    /**
     * Query settings for this map
     * @param integer $intMapId The id for this map
     */
    protected function queryMapSettings($intMapId) {
    	return $this->Database->prepare('SELECT * FROM tl_jblocations_maps WHERE id=?')
			->execute(intval($intMapId));
    }

    /**
     * Get location details by location id
     * @param string Location id or CSV list of ids to query for
     * @param string (Optional) Selected fields as CSV
     * @param int (Optional) SQL Limit
     * @return object Database result
     */
    protected function getLocationDataById($strLocationId, $strSelect='*', $limit='') {
        $query = 'SELECT '.$strSelect.' FROM tl_jblocations_coords WHERE id IN ('.$strLocationId.')';
        if ($limit) {
            return $this->Database->prepare($query)->limit($limit)->execute();
        }
        return $this->Database->prepare($query)->execute();
    }
    
    /**
     * Get location details by location id
     * @param string Location id
     * @return array Location details
     */
    public function getLocationDataArrayById($strLocationId) {
        $objData = $this->getLocationDataById($strLocationId, 'title, description, coords, zoom');
        return array (
        	'title' 		=> &$objData->title,
        	'description' 	=> &$objData->description,
        	'coords'		=> &$objData->coords,
        	'zoom'			=> &$objData->zoom,
        );
    }

    /**
     * Get location type by location id
     * @param string LocationType id or CSV list of ids to query for
     * @param string (Optional) Selected fields as CSV
     * @param int (Optional) SQL Limit
     * @return object Database result
     */
    public function getLocationTypeById($strLocationTypeId, $strSelect='*', $limit='') {
        $query = 'SELECT '.$strSelect.' FROM tl_jblocations_types WHERE id IN ('.$strLocationTypeId.')';
        if ($limit) {
            return $this->Database->prepare($query)->limit($limit)->execute();
        }
        return $this->Database->prepare($query)->execute();
    }

    /**
     * Get location type by location id
     * @param string LocationType id
     * @return array Location type details
     */
    public function getLocationTypeArrayById($strLocationTypeId, $strSelect='*', $limit='') {
        $objData = $this->getLocationTypeById($strLocationTypeId);
        if ($objData->icon) {
        	$arrIconSize = getimagesize($this->Environment->base.$objData->icon);
        	if ($arrIconSize !== false) {
        		$icon = $this->Environment->base.$objData->icon;
        		$icon_width = $arrIconSize[0];
        		$icon_height = $arrIconSize[1];
        	}
        }
    	if ($objData->icon_alt) {
        	$arrIconSize_alt = getimagesize($this->Environment->base.$objData->icon_alt);
        	if ($arrIconSize_alt !== false) {
        		$icon_alt = $this->Environment->base.$objData->icon_alt;
        		$icon_alt_width = $arrIconSize_alt[0];
        		$icon_alt_height = $arrIconSize_alt[1];
        	}
        }
    	if ($objData->icon_shadow) {
        	$arrIconSize_shadow = getimagesize($this->Environment->base.$objData->icon_shadow);
        	if ($arrIconSize_shadow !== false) {
        		$icon_shadow = $this->Environment->base.$objData->icon_shadow;
        		$icon_shadow_width = $arrIconSize_shadow[0];
        		$icon_shadow_height = $arrIconSize_shadow[1];
        	}
        }
        return array (
			'css'       		=> &$objData->css_class,
			'title'     		=> &$objData->title,
			'teaser'    		=> &$objData->teaser,
			'details'   		=> &$objData->details,
        	'icons'				=> array(
        		'default'	=> array(        		
        			'url'		=> &$icon,
        			'anchor_x'	=> &$objData->icon_anchor_x,
        			'anchor_y'	=> &$objData->icon_anchor_y,
        			'width'		=> &$icon_width,
        			'height'	=> &$icon_height,
        		),
        		'alternate'	=> array(
        			'url'		=> &$icon_alt,
        			'anchor_x'	=> &$objData->icon_alt_anchor_x,
        			'anchor_y'	=> &$objData->icon_alt_anchor_y,
        			'width'		=> &$icon_alt_width,
        			'height'	=> &$icon_alt_height,
        		),
        		'shadow'	=> array(        		
        			'url'		=> &$icon_shadow,
        			'anchor_x'	=> &$objData->icon_shadow_anchor_x,
        			'anchor_y'	=> &$objData->icon_shadow_anchor_y,
        			'width'		=> &$icon_shadow_width,
        			'height'	=> &$icon_shadow_height,
        		),
        	),
        );
    }
    
    /**
     * Generate link to map and event details
     * @param integer page id
     * @param string name for the url part
     */
    function generateMapLink($pid, $name) {
        if (!$this->targetObj) {
            $objTarget = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=(SELECT jblocations_jumpTo FROM tl_calendar WHERE id=?)")
                ->limit(1)
                ->execute($pid);
            $this->targetObj = $objTarget->fetchAssoc();
        }
        return $this->generateFrontendUrl($this->targetObj, '/details/'.$name);
    }

    /**
     * Generate the map
     * @param integer Id for the map
     * @param integer Map provider
     */
    function generateMap($intMapId, $intMapSettings) {
    	$objMapData = $this->queryMapSettings($intMapSettings);
        // trigger default map as fallback, if needed
        $this->queryMapProviders();
        if (!in_array($objMapData->provider, $this->arrSupportedMapProviders)) {
            $intMapProvider = JBLocations::MAPPROVIDER_DEFAULT;
        }
        // generate map
        switch ($objMapData->provider) {
            case JBLocations::MAPPROVIDER_GOOGLE:
                $objMap = new JBLocationsMapGoogle($intMapId, $objMapData);                
                break;
            case JBLocations::MAPPROVIDER_MS:
                $objMap = new JBLocationsMapMS($intMapId, $objMapData);
                break;
            case JBLocations::MAPPROVIDER_YAHOO:
                $objMap = new JBLocationsMapYahoo($intMapId, $objMapData);
                break;
            case JBLocations::MAPPROVIDER_OSM:
                $objMap = new JBLocationsMapOSM($intMapId, $objMapData);
                break;
        }
        return $objMap;
    }

	/**
	 * Compile location data into associative array	 
	 * @param string Serialized location array
	 * @return array Structured location data
	 */
	protected function compileLocations(&$strLocations) {	
		$arrLocations = unserialize($strLocations);
		$arrLocationData = array();
		// loop through locations
		for($i = 0; $i < sizeof($arrLocations); $i++){
			$arrLocationData[$i] = $this->getLocationDataArrayById($arrLocations[$i][0]);
			$arrLocationData[$i]['class'] =
				$this->getLocationTypeArrayById($arrLocations[$i][1]);
		}
		return $arrLocationData;
	}
    
	/**
	 * Replace JBLocations inserttags
	 * @param string
	 * @return string
	 */
	public function replaceJBLocationsInsertTags($strTag) {
		$elements = explode('::', $strTag);

		if (strtolower($elements[0]) == 'jbloc_mapfile' && intval($elements[1]) && intval($elements[2])) {
			$objPage = $this->Database->prepare("SELECT id, alias FROM tl_page WHERE id=?")
				->limit(1)
				->execute($elements[1]);
			$strUrl = $this->generateFrontendUrl($objPage->fetchAssoc(), '/item/'.$elements[2]);
	
			return $strUrl;
		}		
		return false;
	}    
}

?>
