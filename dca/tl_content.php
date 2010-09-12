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

/**
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['pagenavbuilder'] = 
    '{title_legend},name,type;'.
    'pagenavbuilder;'.
    '{template_legend:hide},pagenavbuilder_template;'.
    '{expert_legend:hide},align,space,cssID';

$GLOBALS['TL_DCA']['tl_content']['fields']['pagenavbuilder_template'] = array (
    'label'             => &$GLOBALS['TL_LANG']['tl_module']['tl_pagenavbuilder']['template'],
    'default'           => 'mod_pagenavbuilder_default',
    'exclude'           => true,
    'inputType'         => 'select',
    'options'           => $this->getTemplateGroup('mod_pagenavbuilder'),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['pagenavbuilder'] = array (
	'label'         => &$GLOBALS['TL_LANG']['tl_module']['pagenavbuilder'],
	'exclude'       => true,
	'inputType'     => 'select',
	'foreignKey'    => 'tl_pagenavbuilder.title',
	'eval'          => array('mandatory'=>true)
);

?>
