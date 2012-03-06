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
 * @package    JB_Locations
 * @license    LGPL 
 * @filesource
 */

// Get shared DCA
$this->loadDataContainer('tl_jblocations');

$GLOBALS['TL_DCA']['tl_jblocations_data'] = array (
    // Config
    'config' => array (
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
    ),

    // List
    'list' => array (
        'sorting' => array (
            'mode'          => 1,
            'fields'        => array('category'),
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
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array (
                'label'         => &$GLOBALS['TL_LANG']['tl_jblocations']['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.gif',
                'attributes'    => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
            ),
            'show' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_jblocations']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),
);

// Palettes
$GLOBALS['TL_DCA']['tl_jblocations_data']['palettes']['default'] = 'title,headline,category;{file_legend},file,filetype;{locations_legend},locations_published,locations_list;description';

// Fields
$GLOBALS['TL_DCA']['tl_jblocations_data']['fields'] = array (
    'file' => array (
    	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_data']['file'],
		'exclude'	=> true,
		'inputType'	=> 'fileTree',
		'eval'      => array('fieldType'=>'radio', 'files'=>true, 'tl_class'=>'clr')
    ),
    'category' => array (
        'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_data']['category'],
		'exclude'   => true,		
		'inputType' => 'select',
    	'foreignKey'    => 'tl_jblocations_types.title',
    ),
    'filetype' => array (
        'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_data']['filetype'],
		'exclude'   => true,		
		'inputType' => 'select',
    	'options'	=> array('kh' => 'Keyhole Markup (KMZ/KML)'),	
    ),
    'title' => array (
        'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_data']['title'],
		'exclude'   => true,		
		'inputType' => 'text',
		'eval'      => array('mandatory'=>true, 'maxlength'=>255)
    ),
    'headline' => array (
		'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_data']['headline'],
		'exclude'	=> true,
		'search'	=> true,
		'inputType'	=> 'inputUnit',
		'options'	=> array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
		'eval'		=> array('maxlength'=>255)
    ),
	'description' => array (
		'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_data']['description'],
		'exclude'   => true,
		'search'    => true,
		'inputType' => 'textarea',
		'eval'      => array('rte'=>'tinyMCE')
	),
);
// Locations published?
$GLOBALS['TL_DCA']['tl_jblocations_data']['fields']['locations_published'] = array (    
    'inputType' => 'checkbox',
	'label'		=> &$GLOBALS['TL_LANG']['tl_calendar_events']['jblocations_published'], 
);
// Map locations chooser
$GLOBALS['TL_DCA']['tl_jblocations_data']['fields']['locations_list'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['locations_list'];
$GLOBALS['TL_DCA']['tl_jblocations_data']['fields']['locations_list']['label']  = &$GLOBALS['TL_LANG']['tl_jblocations_data']['locations_list'];
?>
