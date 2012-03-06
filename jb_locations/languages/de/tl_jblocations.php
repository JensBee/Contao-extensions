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
 * Legends
 */
$GLOBALS['TL_LANG']['tl_jblocations']['legend']['locations_maps'] = 'Orte & Karten';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['description_legend'] = 'Kartenbeschreibung';

/**
 * Fields
 */
// Maps
$GLOBALS['TL_LANG']['tl_jblocations_maps']['title'] = array(
	'Titel', 
	'Titel der Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['description'] = array(
	'Beschreibung', 
	'Beschreibung der Karte.');
$GLOBALS['TL_LANG']['tl_jblocations']['map']['chooser'] = array (
    'Kartenvorlage',
    'Legt fest, welche Karte als Vorlage für die Darstellung dienen soll.');
$GLOBALS['TL_LANG']['tl_jblocations']['map']['Template'] = array (
    'Template',
    'Template für die Kartendarstellung.');
// Location-types
$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['css_name'] 	= 'Name';
$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['css_class']	= 'Klasse';
$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['chooser'] = array(
	'Orte', 
	'Fügt der Karte Ortsmarken hinzu.');
// Locations
$GLOBALS['TL_LANG']['tl_jblocations']['locations']['publish'] = array(
    'Orte hinzufügen', 
    'Der Karte Ortsmarken hinzufügen.');

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_jblocations_maps']['edit'] = array(
	'Bearbeiten', 
	'Elemente der Navigation bearbeiten');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['copy'] = array(
	'Kopieren', 
	'Navigationselement kopieren');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['delete'] = array(
	'Löschen', 
	'Navigationselement löschen');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['show'] = array(
	'Anzeigen', 
	'Elemente des Navigationselementes anzeigen');

?>
