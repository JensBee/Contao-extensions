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

// tl_page root palette
$GLOBALS['TL_DCA']['tl_page']['palettes']['root'] .= ';{jblocations_maps_legend:hide}, jblocations_map_bing, jblocations_map_google, jblocations_map_yahoo';

// Fields
$GLOBALS['TL_DCA']['tl_page']['fields']['jblocations_map_google'] =  array (
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['jblocations_map_google'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>false, 'maxlength'=>255)
);
$GLOBALS['TL_DCA']['tl_page']['fields']['jblocations_map_yahoo'] =  array (
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['jblocations_map_yahoo'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>false, 'maxlength'=>255)
);
$GLOBALS['TL_DCA']['tl_page']['fields']['jblocations_map_bing'] =  array (
    'label'     => &$GLOBALS['TL_LANG']['tl_page']['jblocations_map_bing'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>false, 'maxlength'=>255)
);

?>
