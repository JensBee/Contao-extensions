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
 * @package    Calendar 
 * @license    LGPL 
 * @filesource
 */

// Get shared DCA
$this->loadDataContainer('tl_jblocations');

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['jblocations_map'] = 
	'{title_legend},'.
		'name,'.
		'headline,'.
		'type;'.
	'{jblocations_mapconfig_legend},'.
		'jblocations_map,'.
		'jblocations_published;'.
	'{template_legend:hide},'.
		'jblocations_map_template;'.
	'{protected_legend:hide},'.
		'protected;'.
	'{expert_legend:hide},'.
		'guests,'.
		'cssID,space';

/**
 * Selectors
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'][] = 'jblocations_published';

/**
 * Subpalettes
 */
$GLOBALS['TL_DCA']['tl_module']['subpalettes']['jblocations_published'] = 'jblocations_list';

/**
 * Fields
 */
// Map locations chooser
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_list'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['locations_list'];
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_list']['label'] 	= &$GLOBALS['TL_LANG']['tl_jblocations']['locationtype']['chooser'];
// Locations published?
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_published'] 			= $GLOBALS['TL_DCA']['tl_jblocations']['locations_published'];
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_published']['label']	= &$GLOBALS['TL_LANG']['tl_jblocations']['locations']['publish'];
// Map chooser
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_map'] = $GLOBALS['TL_DCA']['tl_jblocations']['map_chooser'];
// Template
$GLOBALS['TL_DCA']['tl_module']['fields']['jblocations_map_template'] = array (
	'label'				=> &$GLOBALS['TL_LANG']['tl_jblocations']['map']['Template'],
	'default'			=> 'mod_jbloc_map',
	'exclude'			=> true,
	'inputType'			=> 'select',
	'options_callback'	=> array('tl_module_jb_locations', 'getTemplates'),
);

class tl_module_jb_locations extends Backend {
	/**
	 * Get template over theme id
	 * @param DataContainer $dc
	 */
	public function getTemplates(DataContainer $dc) {
		return $this->getTemplateGroup('mod_jbloc_map', $dc->activeRecord->pid);
	}
}
?>