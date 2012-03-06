<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    JBLocations 
 * @license    LGPL 
 * @filesource
 */

// Get shared language strings
$this->loadLanguageFile('tl_calendar_events');

/**
 * Backend module
 */
$GLOBALS['TL_LANG']['MOD']['jb_locations_group'] = 'Events & Orte'; 
$GLOBALS['TL_LANG']['MOD']['jb_locations_coords'] = array(
	'Orte', 
	'Orte für die Darstellung auf Karten verwalten.');
$GLOBALS['TL_LANG']['MOD']['jb_locations_types'] = array(
	'Kategorien', 
	'Kategorien für Orte verwalten.');
$GLOBALS['TL_LANG']['MOD']['jb_locations_maps'] = array(
	'Karten', 
	'Karten mit Orten verwalten.');
$GLOBALS['TL_LANG']['MOD']['jb_locations_data'] = array(
	'Kartendateien', 
	'Dateien für Karten verwalten.');

/**
 * Frontend modules
 */
$GLOBALS['TL_LANG']['FMD']['jb_locations_group'] = &$GLOBALS['TL_LANG']['tl_jblocations']['legend']['locations_maps'];
$GLOBALS['TL_LANG']['FMD']['jblocations_map'] = array(
	'Karte', 
	'Fügt eine Karte mit Orten ein.');

/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['jblocations_mapconfig_legend'] = &$GLOBALS['TL_LANG']['tl_jblocations']['legend']['locations_maps'];
?>
