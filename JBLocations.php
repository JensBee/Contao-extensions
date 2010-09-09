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
    protected $arrMapProvider = array(
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
                $GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['provider']['options'][$mapProvider] = $this->arrMapProvider[$mapProvider];
            }
        }
    }

    /**
     * Generate dynamic DCA for tl_jblocations_maps.map_template on load
     * @param String Current value
     * @param object DataContainer
     */
    public function dcaMapsOnLoad_mapTemplate($varValue, DataContainer $dc) {
        $arrTpl = array();
        switch ($dc->__get('activeRecord')->provider) {
            case JBLocations::MAPPROVIDER_GOOGLE:
                $arrTpl = $this->getTemplateGroup('jbloc_imap_google');
                break;
            case JBLocations::MAPPROVIDER_MS:
                $arrTpl = $this->getTemplateGroup('jbloc_imap_bing');
                break;
            case JBLocations::MAPPROVIDER_YAHOO:
                $arrTpl = $this->getTemplateGroup('jbloc_imap_yahoo');
                break;
            case JBLocations::MAPPROVIDER_OSM:
                $arrTpl = $this->getTemplateGroup('jbloc_imap_osm');
                break;
        }
        $GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_template']['options'] = $arrTpl;
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
     * Get location details by location id
     * @param string Location id or CSV list of ids to query for
     * @param string (Optional) Selected fields as CSV
     * @param int (Optional) SQL Limit
     * @return object Database result
     */
    public function getLocationDataById($strLocationId, $strSelect='*', $limit='') {
        $query = 'SELECT '.$strSelect.' FROM tl_jblocations_coords WHERE id IN ('.$strLocationId.')';
        if ($limit) {
            return $this->Database->prepare($query)->limit($limit)->execute();
        }
        return $this->Database->prepare($query)->execute();
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
    function generateMap($intMapId, $intMapProvider) {
        // trigger default map as fallback, if needed
        $this->queryMapProviders();
        if (!in_array($intMapProvider, $this->arrSupportedMapProviders)) {
            $intMapProvider = JBLocations::MAPPROVIDER_DEFAULT;
        }
        // generate map
        switch ($intMapProvider) {
            case JBLocations::MAPPROVIDER_GOOGLE:
                $objMap = new JBLocationsMapGoogle($intMapId);
                break;
            case JBLocations::MAPPROVIDER_MS:
                $objMap = new JBLocationsMapMS($intMapId);
                break;
            case JBLocations::MAPPROVIDER_YAHOO:
                $objMap = new JBLocationsMapYahoo($intMapId);
                break;
            case JBLocations::MAPPROVIDER_OSM:
                $objMap = new JBLocationsMapOSM($intMapId);
                break;
        }
        return $objMap;
    }
}

?>
