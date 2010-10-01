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

$GLOBALS['TL_DCA']['tl_jblocations_coords'] = array (
    // Config
    'config' => array (
        'dataContainer'     => 'Table',
        'enableVersioning'  => true,
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

// Palettes
$GLOBALS['TL_DCA']['tl_jblocations_coords']['palettes']['default'] = 'title,coords,zoom;{description_legend:hide},description;';

// Fields
$GLOBALS['TL_DCA']['tl_jblocations_coords']['fields']['title'] = array (
    'label'                   => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['title'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_jblocations_coords']['fields']['zoom'] = array (
    'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations_coords']['zoom'],
	'exclude'	=> true,
	'inputType'	=> 'select',
	'options'	=> array('0', '1','2','3','4','5','6','7','8','9','10'),	
);

$GLOBALS['TL_DCA']['tl_jblocations_coords']['fields']['description'] = array (
	'label'         => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['description'],
	'inputType'     => 'textarea',
	'search'        => false,
	'eval'          => array('rte'=>'tinyMCE', 'helpwizard'=>true),
    'explanation'   => 'insertTags'
);

$GLOBALS['TL_DCA']['tl_jblocations_coords']['fields']['coords'] = array (
	'label'     => &$GLOBALS['TL_LANG']['tl_jblocations_coords']['coords'],
	'inputType' => 'text',
	'search'    => false,
	'eval'      => array('mandatory'=>true, 'maxlength'=>128),
);

?>
