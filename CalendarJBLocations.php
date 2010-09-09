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
 * Display locations in calendar events
 * @copyright  Jens Bertram 2010
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class CalendarJBLocations extends JBLocations {
	/**
	 * Get location data by event id
	 * @param string Location id or CSV list of ids to query for
	 * @param integer Query result limit
	 * @return object Database result
	 */
	protected function getLocationListByEventId($strEventId, $limit='') {
		$query = 'SELECT id, jblocations_list, jblocations_published FROM tl_calendar_events WHERE id IN ('.$strEventId.')';
		if ($limit) {
			return $this->Database->prepare($query)->limit(intval($limit))->execute();
		}
		return $this->Database->prepare($query)->execute();
	}

	/**
	 * Get the map associated with this calendar
	 * @param integer $intPid Calendar pid
	 */
	protected function getCalendarMap($intPid) {
		return $this->Database->prepare('SELECT jblocations_map, jblocations_map_published FROM tl_calendar WHERE id=?')
			->execute(intval($intPid));
	}
	
	/**
	 * Compile location data into associative array
	 * @param object Database result
	 * @param integer Page id
	 * @param boolean If true only return published data
	 * @return array Structured location data
	 */
	protected function compileLocations($objEventData, $pid, $boolPublished=true) {
		$jbLocations = new JBLocations();
		$arrEventIds = array();
		$arrEventLocations = array();
		$arrReturn = array();

		if ($objEventData->next() && $objEventData->jblocations_list) {
			if  ($objEventData->jblocations_published ||
				(!$objEventData->jblocations_published && !$boolPublished)
			) {
				$arrEventLocations = array();
				$arrLocationList = unserialize($objEventData->jblocations_list);
				$arrLocationIds = array();
				
				// loop through locations
				for($i = 0; $i < sizeof($arrLocationList); $i++){
					$arrLocationIds[] = $arrLocationList[$i][0];				
					$arrEventLocations[$i] = $jbLocations->
						getLocationDataArrayById($arrLocationList[$i][0]);
					$arrEventLocations[$i]['class'] =
						$jbLocations->getLocationTypeArrayById($arrLocationList[$i][1]);						
				}

				$arrReturn = array(
                    'mapLink'   => $this->generateMapLink($pid, implode('_', $arrLocationIds)),
                    'mapMarker' => $arrEventLocations
				);
			}
		}
		return $arrReturn;
	}

	/**
	 * Calendar event generate-hook
	 * @param object Template object
	 * @param string Template name
	 */
	function getEvent(&$objTemplate, $strTemplate) {
		// check if we are displaying events
		if (strncmp($strTemplate, 'event_', strlen('event_')) == 0) {
			$objMapData = $this->getCalendarMap($objTemplate->pid);
			if (!$objMapData->jblocations_map_published || $objMapData->jblocations_map <= 0) {
				return;
			}
			$arrEventData = $this->compileLocations(
				$this->getLocationListByEventId($objTemplate->id, 1),
				$objTemplate->pid
			);
			if (count($arrEventData) > 1) {				
				$arrTemplateMap = array();
				// check if we are on full event view, if so: render map
				if (!$objTemplate->link) {					
					$objMap = $this->generateMap($objTemplate->id, $objMapData->jblocations_map);					
					$objMap->setMapTypeSwitchAllowed(true);
					$objMap->addMarkers($arrEventData['mapMarker']);
					$objMap->compile();

					$arrTemplateMap['code'] = $objMap->getMapCode();
					$arrTemplateMap['data'] = $objMap->getMapData();
					if ($objMap->boolShowMarker || $objMap->boolShowExternalMarker) {
						$arrTemplateMap['marker'] = $arrEventData['mapMarker'];
					}
				}
				$arrTemplateMap['url'] = $arrEventData['mapLink'];
				$objTemplate->jblocations_map = $arrTemplateMap;
				$objTemplate->jblocations = $arrEventData['mapMarker'];
			}
		}
	}
}

?>
