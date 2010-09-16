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

// Get shared language strings
$this->loadLanguageFile('tl_jblocations');

/**
 * Fields
 */
// Map locations chooser
$GLOBALS['TL_DCA']['tl_jblocations']['locations_list'] = array (	
    'exclude'   => true,
    'inputType' => 'jb_locations_wizard',
    'eval'      => array(
        'style'			=> 'width:200px;',
        'labels'		=> array (
            &$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['css_name'], 
            &$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['css_class']
        ),
        'fields' => array (
            'tl_jblocations_coords.title',
            'tl_jblocations_types.title'
        )
    )
);
// Locations published?
$GLOBALS['TL_DCA']['tl_jblocations']['locations_published'] = array (    
    'inputType' => 'checkbox',
	'eval'      => array('submitOnChange'=>true)
);
// Map published?
$GLOBALS['TL_DCA']['tl_jblocations']['map_published'] = array (    
    'inputType' => 'checkbox',
	'eval'      => array('submitOnChange'=>true)
);
// Map chooser
$GLOBALS['TL_DCA']['tl_jblocations']['map_chooser'] = array (
    'label'         => &$GLOBALS['TL_LANG']['tl_jblocations']['map']['chooser'],
	'exclude'       => true,
	'inputType'     => 'select',
	'foreignKey'    => 'tl_jblocations_maps.title',
);
?>