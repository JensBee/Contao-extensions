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
abstract class JBLocationsMap extends Frontend {

    // map types
    const MAP_DEFAULT           = 0; // normal map type
    const MAP_NORMAL            = 0; // normal map type
    const MAP_SATTELLITE        = 1; // sattelite view
    const MAP_NOMAL_SATELLITE   = 2; // satellite & map combined
    const MAP_TERRAIN           = 3; // terrain map
    public static $arrMapTypes = array(
        JBLocationsMap::MAP_NORMAL          => 'normal',
        JBLocationsMap::MAP_SATTELLITE      => 'satellite',
        JBLocationsMap::MAP_NOMAL_SATELLITE => 'normal_satellite',
        JBLocationsMap::MAP_TERRAIN         => 'terrain',
    );

    // map controls
    const MAPCONTROL_DEFAULT = 0;
    const MAPCONTROL_NORMAL  = 0;
    const MAPCONTROL_LARGE   = 1;
    public static $arrMapControlTypes = array(
        JBLocationsMap::MAPCONTROL_NORMAL   => 'normal',
        JBLocationsMap::MAPCONTROL_LARGE    => 'large',
    );
    
	/**
	 * List of supported map control types
	 * @var array
	 */
    protected $arrSupportedMapControlTypes = array(JBLocationsMap::MAPCONTROL_DEFAULT);

	/**
	 * List of supported map types
	 * @var array
	 */
    public $arrSupportedMapTypes = array(JBLocationsMap::MAP_DEFAULT);

	/**
	 * List of supported map types
	 * @var array
	 */
    protected $arrAllowedMapTypes = array(JBLocationsMap::MAP_DEFAULT);

	/**
	 * Compiled array with settings for this map
	 * @var array
	 */
    protected $arrCompiledMap = array();

	/**
	 * List of map-marker objects
	 * @var array
	 */
    protected $arrMapMarkers = array();

	/**
     * Headline for the map
     * @var array (unit, value)
     */
    protected $arrHeadlineMap;
    
	/**
     * Headline for the map-markers
     * @var array (unit, value)
     */
    protected $arrHeadlineMarker;
    
    /**
     * Show external markers?
     * @var boolean
     */
    protected $boolShowExternalMarker = true;
    
    /**
     * Show markers on map?
     * @var boolean
     */
    // FIXME: no markers lead to no viewpoint - do some calculation here
    protected $boolShowMarker = true;
    
  	/**
	 * Should a map controller be used?
	 * @var boolean default false
	 */
    // TODO: make useMapController configurable in UI
    protected $boolUseMapController = false;

  	/**
	 * Allow map types to be switched?
	 * @var boolean default false
	 */
    // TODO: make useMapSwitch configurable in UI
    protected $boolUseMapTypeSwitch = true;

  	/**
	 * Is map type switching supported?
	 * @var boolean default false
	 */
    protected $boolHasMapTypeSwitch = false;

  	/**
	 * Should a GPS sensor be used?
	 * @var boolean default false
	 */
    // TODO: make useGPSSensor configurable in UI
    protected $boolUseGPSSensor = false;

  	/**
	 * Should be the map auto zoomed?
	 * @var boolean default true
	 */
    // TODO: make autoZoom configurable in UI
    protected $boolMapAutoZoom = true;
    
	/**
	 * Id for this map
	 * @var integer
	 */
    protected $intMapId;
    
	/**
	 * The default map zoom factor
	 * @var integer
	 */
    //protected $intMapZoom;
    
	/**
	 * The default map type to show
	 * @var integer
	 */
    protected $intDefaultMapType = JBLocationsMap::MAP_DEFAULT;

	/**
	 * The default map type to show
	 * @var integer
	 */
    protected $intControllerType = JBLocationsMap::MAPCONTROL_DEFAULT;
 
  	/**
	 * Map language
	 * @var string
	 */
    protected $strLanguage = 'en';

	/**
	 * Map API Key
	 * @var string
	 */
    protected $strMapKey;
    
    /**
     * Template for this map
     * @var string Template name
     */
    protected $strMapTemplate;
    
    /**
     * Marker-template for this map
     * @var string Template name
     */
    protected $strMapMarkerTemplate = 'jbloc_marker';
    
	/**
	 * Map width
	 * @var string
	 */
    protected $strMapWidth = '400px';

	/**
	 * Map height
	 * @var string
	 */
    protected $strMapHeight = '300px';	

  	/**
	 * Additional map code
	 * @var string
	 */
    // TODO: add user map code
    //protected $strMapUserCode;

  	/**
	 * Additional map url parameters
	 * @var string
	 */
    // TODO: add user map url code
    //protected $strMapURLParams;

    /**
     * Constructor
     * @param $intMapId Id for this map
     * @param $objMapData tl_jblocations_maps query result for this map
     */
    function __construct($intMapId=null, &$objMapData=null) {	
    	parent::__construct();
    	$this->strLanguage = &$GLOBALS['TL_LANGUAGE'];
    	if ($intMapId) {
    		$this->intMapId = $intMapId;
    	}    	
    	if ($objMapData) {
    		if ($objMapData->map_width) {
    			$arrMapWidth = unserialize($objMapData->map_width);
				$this->strMapWidth = $arrMapWidth['value'].$arrMapWidth['unit'];
    		}
    		if ($objMapData->map_height) {
    			$arrMapHeight = unserialize($objMapData->map_height);
				$this->strMapHeight = $arrMapHeight['value'].$arrMapHeight['unit'];
    		}
    		if ($objMapData->map_types) {
	    		$this->arrAllowedMapTypes = array();
	    		foreach (unserialize($objMapData->map_types) as $mt) {
	    			array_push($this->arrAllowedMapTypes, preg_replace('/mt_/', '', $mt));
	    		}
    		}
    		if ($objMapData->map_marker_template) {
    			$this->strMapMarkerTemplate = $objMapData->map_marker_template;
    		}
			if ($objMapData->map_type_default) {				
				$this->intDefaultMapType = preg_replace('/mt_/', '', $objMapData->map_type_default);				
    		}
    		if ($objMapData->headline_map) {
				$this->arrHeadlineMap = unserialize($objMapData->headline_map);				
    		}
    		if ($objMapData->headline_marker) {				
				$this->arrHeadlineMarker = unserialize($objMapData->headline_marker);;
    		}
    		$this->strMapTemplate = $objMapData->map_template ? $objMapData->map_template : null;
    		$this->boolShowMarker = $objMapData->markers_show ? true : false;
    		$this->boolShowExternalMarker = $objMapData->markers_external_show ? true : false;      
    	}
    }
    
    /**
	 * Sets an attribute of this map
	 * @param string The property name
	 * @param mixed The property value
	 * @return boolean True if successfull
	 */
    public function __set($strKey, $val) {
    	return false;    	
    }
    
    /**
	 * Return an attribute of this map
	 * @param  string The property name
	 * @return mixed The property value or null
	 */
	public function __get($strKey) {
		switch ($strKey) {
			default:
				if(isset($this->$var)) {
					return $this-$var;
				}
				return null;
				break;
		}
	}
    
    /*
     * Get the Maps key, if theres one needed
     * @return string Maps key
     */
    protected function getMapKey() {
        return '';
    }

	/*
	 * Generate the code for this map
	 * @param string The map template
	 * @param string The map-marker template
	 * @return string The map code
	 */
	public function getMapCode($strTemplate=null, $strTemplateMarker=null) {
		if (!$strTemplate) {
			$strTemplate = &$this->strMapTemplate;
		}
		if (!$strTemplateMarker) {
			$strTemplateMarker = &$this->strMapMarkerTemplate;
		}
		
		$objTemplateMap = new FrontendTemplate($strTemplate);
		$objTemplateMap->map = $this->arrCompiledMap;
		
		if ($this->boolShowExternalMarker || $this->boolShowMarker) {
			$objTemplateMap->marker = $this->arrMapMarkers;
			if ($this->boolShowExternalMarker) {
				$objTemplateMapMarker = new FrontendTemplate($strTemplateMarker);
				$objTemplateMapMarker->map = array(
					'width' 	=> &$this->strMapWidth,
					'height'	=> &$this->strMapHeight,
					'id'		=> &$this->intMapId
				);
				$objTemplateMapMarker->marker = $this->arrMapMarkers;				
				$objTemplateMap->markerCode = $objTemplateMapMarker->parse();
			}			
		}
		return $objTemplateMap->parse();
	}

	/**
	 * Returns the compiled map data array
     * @return array
	 */
	protected function getMapData() {
        return $this->arrCompiledMap;
    }

	/**
	 * Generates the compiled map array
	 */
	public function compile() {
        $arrMapTypes = array();
        foreach ($this->arrAllowedMapTypes as $intMapType) {
            if (isset($this->arrSupportedMapTypes[$intMapType])) {
                array_push($arrMapTypes, JBLocationsMap::$arrMapTypes[$intMapType]);
            }
        }        
        $this->arrCompiledMap = array(
            'key'           => $this->getMapKey(),
            'language'      => &$this->strLanguage,
            'id'            => &$this->intMapId,
            'mapTypeSwitch' => &$this->boolUseMapTypeSwitch,
            'mapTypes'      => &$arrMapTypes,
        	'mapTypeDefault'=> &JBLocationsMap::$arrMapTypes[$this->intDefaultMapType],
            'GPS'           => ($this->boolUseGPSSensor === true) ? 'true' : 'false',
            'controller'    => ($this->boolUseMapController === true) ? 'true' : 'false',
            'controllerType'=> &JBLocationsMap::$arrMapControlTypes[$this->intControllerType],
            // TODO: add user map code
            //'userCode'      => &$this->strMapUserCode,
            // TODO: add user url code
            //'URLparams'     => &$this->strMapURLParams,
            'zoom'          => &$this->intMapZoom,
            'autoZoom'      => &$this->boolMapAutoZoom,
            'mapWidth'      => &$this->strMapWidth,
            'mapHeight'     => &$this->strMapHeight,
        	'markerMap'		=> &$this->boolShowMarker,
        	'markerExternal'=> &$this->boolShowExternalMarker,
        	'headlineMap'	=> &$this->arrHeadlineMap,
        	'headlineMarker'=> &$this->arrHeadlineMarker,
        );
    }

    /**
     * Set the allowed map types for the current map
     * @param array
     */
    public function setAllowedMapTypes($arrMapTypes) {
        foreach ($arrMapTypes as $intMapType) {
            if (isset(JBLocationsMap::$arrMapTypes[$intMapType]) && !isset($this->arrAllowedMapTypes[$intMapTypes])) {
                array_push($this->arrAllowedMapTypes, $intMapType);
            }
        }
    }

    /**
     * Set the default map controller for the current map
     * @param integer
     */
    public function setControllerType($intType) {
        if (isset($this->arrSupportedMapControlTypes[$intType])) {
            $this->intControllerType = $intType;
        }
    }

    /**
     * Set the default map controller for the current map
     * @param integer
     */
    public function setMapTypeSwitchAllowed($boolAllowed) {
        if ($this->boolHasMapTypeSwitch === true) {
            $this->boolUseMapTypeSwitch = $boolAllowed;
        }
    }

    /**
     * Add an array with map-markers
     * @param array $arrMarkers
     */
    public function addMarkers(&$arrMarkers) {
        $this->arrMapMarkers = $arrMarkers;
    }
}

?>
