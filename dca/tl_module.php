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
 * @package    JB_TKJ_Contacts 
 * @license    LGPL 
 * @filesource
 */

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['jb_tkjcontacts'] = 
	'{title_legend},'.
		'name,'.
		'headline,'.
		'type;'.
	'{jb_tkjcontacts_groups_legend},'.
		'jb_tkjcontacts_groups,'.
		'jb_tkjcontacts_data;'.
	'{template_legend:hide},'.
		'jb_tkjcontacts_link,'.
		'jb_tkjcontacts_template;'.
	'{protected_legend:hide},'.
		'protected;'.
	'{expert_legend:hide},'.
		'guests,'.
		'cssID,space';

/**
 * Fields
 */
// Usergroups
$GLOBALS['TL_DCA']['tl_module']['fields']['jb_tkjcontacts_groups'] = array (
	'label' 		=> &$GLOBALS['TL_LANG']['tl_module']['jb_tkjcontacts_groups'],
	'exclude'   	=> true,
	'inputType' 	=> 'checkbox',
	'foreignKey'    => 'tl_member_group.name',
	'eval'			=> array('multiple'=>true),
);
// Template
$GLOBALS['TL_DCA']['tl_module']['fields']['jb_tkjcontacts_template'] = array (
	'label'		=> &$GLOBALS['TL_LANG']['tl_jblocations']['map']['Template'],
	'default'	=> 'mod_jbloc_map',
	'exclude'	=> true,
	'inputType'	=> 'select',
	'options'	=> $this->getTemplateGroup('jb_tkjcontacts')
);
// Visible data
$GLOBALS['TL_DCA']['tl_module']['fields']['jb_tkjcontacts_data'] = array (
	'label' 		=> &$GLOBALS['TL_LANG']['tl_module']['jb_tkjcontacts_data'],
	'exclude'   	=> true,
	'inputType' 	=> 'checkbox',
	'eval'			=> array('multiple'=>true),
	'options'		=> array(
		'firstname' 	=> 'Vorname', 
		'lastname'  	=> 'Nachname',
		'avatar'  		=> 'Foto',
		'description'	=> 'Details',
		'email'			=> 'E-Mail', 
		'website'		=> 'Website'
	),
);
// output contact link
$GLOBALS['TL_DCA']['tl_module']['fields']['jb_tkjcontacts_link'] = array (
	'label' 		=> &$GLOBALS['TL_LANG']['tl_module']['jb_tkjcontacts_link'],
	'exclude'   	=> true,
	'inputType' 	=> 'checkbox',
);
?>