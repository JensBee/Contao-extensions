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

// show in backend
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = 
    str_replace(
        '{teaser_legend:hide}',
        '{jblocations_legend:hide},jblocations_published;{teaser_legend:hide}',  
        $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

// selectors
$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'][] = 'jblocations_published';

// subpalettes
$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['jblocations_published'] = 'jblocations_list';

// field definitions
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_published'] = array (
    'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_published'],
    'inputType' => 'checkbox',
	'eval'      => array('submitOnChange'=>true)
);
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['jblocations_list'] = array (
	'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_list'],
    'exclude'   => true,
    'inputType' => 'jb_locations_wizard',
    'eval'      => array(
        'submitOnChange'    => true,
        'style'             => 'width:200px;',
        'labels'            => array (
            &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_cssname'], 
            &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_cssclass']
        ),
        'fields'        => array (
            'tl_jblocations_coords.title',
            'tl_jblocations_types.title'
        )
    )
);

?>
