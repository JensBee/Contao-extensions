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
 * Backend modules
 */
array_insert($GLOBALS['BE_MOD'], 1, array (
    'jb_locations_group' => array (
        'jb_locations_coords' => array (
            'tables' => array('tl_jblocations_coords'),
            'icon'   => 'system/modules/jb_locations/img/icon_locations.png'
        ),
        'jb_locations_types' => array (
            'tables' => array('tl_jblocations_types'),
            'icon'   => 'system/modules/jb_locations/img/icon_location_types.png'
        ),
        'jb_locations_maps' => array (
            'tables' => array('tl_jblocations_maps'),
            'icon'   => 'system/modules/jb_locations/img/icon_location_maps.png'
        ),
    )
));
// integrate events
if ($GLOBALS['BE_MOD']['content']['calendar']) {
    array_insert($GLOBALS['BE_MOD']['jb_locations_group'], 0, array (
        'calendar' => $GLOBALS['BE_MOD']['content']['calendar']
    ));
    unset($GLOBALS['BE_MOD']['content']['calendar']);
}
// integrate event-staff
if (is_array($GLOBALS['BE_MOD']['content']['jb_eventstaff'])) {
	$GLOBALS['BE_MOD']['jb_locations_group']['jb_eventstaff'] = $GLOBALS['BE_MOD']['content']['jb_eventstaff'];
    unset($GLOBALS['BE_MOD']['content']['jb_eventstaff']);
}

/**
 * Backend form fields
 */
$GLOBALS['BE_FFL']['jb_locations_wizard'] = 'WizardJBLocations';

/**
 * Frontend modules
 */
array_insert($GLOBALS['FE_MOD']['jb_locations_group'] = array (
	'jblocations_map'   => 'ModuleJBLocationsMap',
));

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['includes']['jblocations_map'] = 'ContentJBLocationsMap';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['generateFrontendTemplate'][] = array('CalendarJBLocations', 'getEvent');

?>
