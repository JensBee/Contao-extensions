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
 * @package    Calendar 
 * @license    LGPL 
 * @filesource
 */

// Get shared DCA
$this->loadDataContainer('tl_jblocations');

/**
 * Palettes
 */
// Integrate in calendar events
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = 
    str_replace(
        '{teaser_legend:hide}',
        '{jblocations_legend:hide},'.
    		'jblocations_published,'.
        	'jblocations_list;'.
        '{teaser_legend:hide}',  
        $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

/**
 * Selectors
 */
//$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'][] = 'jblocations_published';

/**
 * Subpalettes
 */
//$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['jblocations_published'] = 'jblocations_list';

/**
 * Field definitions
 */ 
// Locations published?
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_published'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['locations_published'];
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_published']['label']	= &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_published'];
// Map locations chooser
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_list'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['locations_list'];
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_list']['label'] = &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_list'];

?>
