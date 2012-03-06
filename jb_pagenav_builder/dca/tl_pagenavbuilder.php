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
 * @package    PageNavBuilder 
 * @license    LGPL 
 * @filesource
 */

$GLOBALS['TL_DCA']['tl_pagenavbuilder'] = array (
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
                'label' => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array (
                'label'         => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['delete'],
                'href'          => 'act=delete',
                'icon'          => 'delete.gif',
                'attributes'    => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
            ),
            'show' => array (
                'label' => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),

    // Palettes
    'palettes' => array (
        'default'   => 'title;c_left,c_center,c_right',
    ),

    // Fields
    'fields' => array (
        'title' => array (
            'label' => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['title'],
            'inputType' => 'text',
            'eval'      => array('mandatory'=>true, 'maxlength'=>200),
        ),
        'c_left' => array (
            'label'     => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['c_left'],
            'inputType' => 'textarea',
			'eval'      => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'editArea|html', 'helpwizard'=>true),
        ),
        'c_center' => array (
            'label'     => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['c_center'],
            'inputType' => 'textarea',
			'eval'      => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'editArea|html', 'helpwizard'=>true),
        ),
        'c_right' => array (
            'label'     => &$GLOBALS['TL_LANG']['tl_pagenavbuilder']['c_right'],
            'inputType' => 'textarea',
			'eval'      => array('allowHtml'=>true, 'class'=>'monospace', 'rte'=>'editArea|html', 'helpwizard'=>true),
        ),
    ),
);

?>
