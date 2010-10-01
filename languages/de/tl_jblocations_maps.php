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

// Legends
$GLOBALS['TL_LANG']['tl_jblocations_maps']['mapmarkers_legend'] = 'Ortsmarken';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['maptemplate_legend'] = 'Templates';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['mapsize_legend'] = 'Kartengröße';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['maptype_legend'] = 'Kartentypen';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['mapheadlines_legend'] = 'Überschriften';

// Fields
$GLOBALS['TL_LANG']['tl_jblocations_maps']['provider'] = array(
    'Kartenanbieter',
    'Legt fest, von welchem Anbieter die Karten dargestellt werden.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_map'] = array(
    'Überschrift Karte',
    'Überschrift der Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_marker'] = array(
    'Überschrift Ortsmarken',
    'Überschrift der externen Ortsmarken.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['markers_show'] = array(
    'Ortsmarken anzeigen',
    'Legt fest, ob Ortsmarken auf der Karte dargestellt werden sollen.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['markers_external_show'] = array(
    'Zusätzliche Ortsmarken anzeigen',
    'Legt fest, ob detaillierte Ortsmarken ausserhalb der Karte dargestellt werden sollen.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_template'] = array(
    'Template-Karte',
    'Template zurDarstellung der Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_marker_template'] = array(
    'Template-Ortsmarken',
    'Template zurDarstellung der Ortsmarken ausserhalb der Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_width'] = array(
    'Breite',
    'Breite der dargestellten Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_height'] = array(
    'Höhe',
    'Höhe der dargestellten Karte.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_types'] = array(
    'Kartentypen',
    'Legt fest, welche Darstellungsformen einer Karte gezeigt werden können.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_default'] = array(
    'Standard Kartentyp',
    'Legt fest, welche Darstellungsform bei der Anzeige der Karte gewählt wird.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_map_overwrite'] = array(
    'Kartenüberschrift überschreiben erlaubern',
    'Erlauben, anderen Datenquellen den Kartentitel zu ändern.');
$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_marker_overwrite'] = array(
    'Ortsmarkenüberschrift überschreiben erlaubern',
    'Erlauben, anderen Datenquellen den Ortsmarkentitel zu ändern.');

// Map types
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_normal'] = 'Standardkarte';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_satellite'] = 'Satellitenkarte';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_normal_satellite'] = 'Standardkarte & Satellit kombiniert';
$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_terrain'] = 'Geländekarte';
?>
