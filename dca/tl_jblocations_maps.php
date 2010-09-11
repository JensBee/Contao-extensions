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

$GLOBALS['TL_DCA']['tl_jblocations_maps'] = array (
    // Config
    'config' => array (
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
        'onload_callback'   => array (
            array('JBLocations', 'dcaMapsOnLoad')
        ),
    ),

    // List
    'list' => array (
        'sorting' => array (
            'mode'          => 1,
            'fields'        => array('title'),
            'flag'          => 1,
            'panelLayout'   => 'search,limit',
        ),
        'label' => array (
            'fields'    => array('title'),
            'format'    => '%s',
        ),
        'global_operations' => array (
            'all' => array (
                'label'         => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'          => 'act=select',
                'class'         => 'header_edit_all',
                'attributes'    => 'onclick="Backend.getScrollOffset();"',
            ),
        ),
        'operations' => array (
            'edit' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array (
                'label'         => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.gif',
                'attributes'    => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
            ),
            'show' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),
);

// Palettes (partly generated by callback)
$GLOBALS['TL_DCA']['tl_jblocations_maps']['palettes']['default'] = 
	'title;'.
	'{mapheadlines_legend:hide},'.
		'headline_map,'.
		'headline_marker;'.
	'{mapmarkers_legend:hide},'.
		'markers_show,'.
		'markers_external_show;'.
	'{maptype_legend:hide},'.
		'map_types,'.
		'map_type_default;'.
	'{maptemplate_legend:hide},'.
		'map_template,'.
		'map_marker_template;'.
	'{mapsize_legend:hide},'.
		'map_width,'.
		'map_height';

// Fields
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['title'] = array (
    'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_maps']['title'],
	'exclude'   => true,
	'search'    => true,
	'inputType' => 'text',
	'eval'      => array('mandatory'=>true, 'maxlength'=>255)
);

// (partly generated by callback)
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['provider'] = array (
    'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_maps']['provider'],
    'exclude'   => true,
    'search'    => false,
	'inputType' => 'select',
	'eval'      => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['headline_map'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_map'],
	'exclude'	=> true,
	'search'	=> true,
	'inputType'	=> 'inputUnit',
	'options'	=> array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
	'eval'		=> array('maxlength'=>255)
);
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['headline_marker'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['headline_marker'],
	'exclude'	=> true,
	'search'	=> true,
	'inputType'	=> 'inputUnit',
	'options'	=> array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
	'eval'		=> array('maxlength'=>255)
);

$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['markers_show'] = array (
    'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_maps']['markers_show'],
    'inputType' => 'checkbox',	
);

$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['markers_external_show'] = array (
    'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_maps']['markers_external_show'],
    'inputType' => 'checkbox',
);

// (partly generated by callback)
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_types'] = array (
	'label'			=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_types'],
	'exclude'		=> true,
	'inputType'		=> 'checkbox',
	'eval'      	=> array('mandatory'=>true, 'multiple'=>true),
    'load_callback' => array(
		array('JBLocations', 'dcaMapsOnLoad_mapTypes')
	)	
);
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_type_default'] = array (
	'label'			=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_type_default'],
	'exclude'		=> true,
	'inputType'		=> 'radio',
	'eval'      	=> array('mandatory'=>true),	
);

// (partly generated by callback)
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_template'] = array (
	'label'     	=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_template'],
	'exclude'   	=> true,
	'inputType' 	=> 'select',
    'load_callback' => array(
		array('JBLocations', 'dcaMapsOnLoad_mapTemplate')
	)
);

$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_marker_template'] = array (
	'label'     	=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_marker_template'],
	'exclude'   	=> true,
	'inputType' 	=> 'select',
	'options'		=> $this->getTemplateGroup('jbloc_marker'),
);

$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_width'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_width'],
	'inputType'	=> 'inputUnit',
	'options'	=> array('px','%','em','pt','pc','in','cm','mm'),
	'search'	=> false,
	'eval'		=> array('rgxp'=>digit,'maxlength'=>64)
);
$GLOBALS['TL_DCA']['tl_jblocations_maps']['fields']['map_height'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_maps']['map_height'],
	'inputType'	=> 'inputUnit',
	// FIXME: currently only px to allow static maps size calculation
	'options'	=> array('px'), //array('px','%','em','pt','pc','in','cm','mm'),
	'search'	=> false,
	'eval'		=> array('rgxp'=>digit,'maxlength'=>64)
);

?>