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
// Integrate in calendar
$GLOBALS['TL_DCA']['tl_calendar']['palettes']['default'] = 
    str_replace(
        '{comments_legend:hide}',
        '{jblocations_map_legend:hide},jblocations_map_published;{jblocations_jumpTo_legend:hide},jblocations_jumpTo;'.            
            '{comments_legend:hide}',  
        $GLOBALS['TL_DCA']['tl_calendar']['palettes']['default']
);

/**
 * Selectors
 */
$GLOBALS['TL_DCA']['tl_calendar']['palettes']['__selector__'][] = 'jblocations_map_published';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_calendar']['subpalettes']['jblocations_map_published'] = 'jblocations_map';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_calendar']['fields']['jblocations_jumpTo'] = array (
	'label'     => &$GLOBALS['TL_LANG']['tl_calendar']['jblocations_jumpTo'],
    'exclude'   => true,
    'inputType' => 'pageTree',
    'eval'      => array('fieldType'=>'radio')
);
// Map published?
$GLOBALS['TL_DCA']['tl_calendar']['fields']['jblocations_map_published'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['map_published'];
$GLOBALS['TL_DCA']['tl_calendar']['fields']['jblocations_map_published']['label']	= &$GLOBALS['TL_LANG']['tl_calendar']['jblocations_map_published']; 
// Map chooser
$GLOBALS['TL_DCA']['tl_calendar']['fields']['jblocations_map'] = $GLOBALS['TL_DCA']['tl_jblocations']['map_chooser'];

?>
