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
 * @copyright  Jens Bertram 2010
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class ModuleJB_TKJ_Contacts extends Module {
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_jbtkj_contact';
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new backendTemplate('be_wildcard');
			$objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['FMD']['jb_tkjcontacts'][0].' ###<br>'.$this->name;

			return $objTemplate->parse();
		}
		return parent::generate();
	}
	
	protected function queryStaffData($strSelect, $arrIds) {
		// Filter groups
		$strWhere = '';
		$arrValues = array();
		$count = sizeof($arrIds)-1;		
		for ($i=0; $i<=$count; $i++) {
			if ($i < $count) {
				$strWhere .= "groups LIKE ? OR ";
				$arrValues[] = '%"' . $arrIds[$i] . '"%';
			} else {
				$strWhere .= "groups LIKE ? ";
				$arrValues[] = '%"' . $arrIds[$i] . '"%';
			}
		}
		return $this->Database->prepare('SELECT '.$strSelect.' FROM tl_member WHERE ('.$strWhere.')')
			->execute($arrValues);		
	}
	
	/**
	 * Generate module
	 */
	protected function compile() {
		if($this->jb_tkjcontacts_template) {
			$this->strTemplate = $this->jb_tkjcontacts_template;
			$this->Template = new FrontendTemplate($this->strTemplate);			
		}

		$arrStaffGroups = unserialize($this->jb_tkjcontacts_groups);
		$strStaffData = implode(', ', unserialize($this->jb_tkjcontacts_data));

		$objStaffData = $this->queryStaffData($strStaffData, $arrStaffGroups);
		
		$this->Template->showLink = $this->jb_tkjcontacts_link;
		$this->Template->headline = unserialize($this->headline);
		$this->Template->jb_tkj_contacts = $objStaffData->fetchAllAssoc();
	}
}

?>