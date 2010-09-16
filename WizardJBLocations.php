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
 * Class WizardJBLocations
 *
 * Display lists of locations and location-types to select from
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class WizardJBLocations extends Widget {

	/**
	 * Templates
	 * @var string
	 */
    protected $strTemplate = 'be_widget';

	/**
	 * Submit user input
	 * @var boolean
	 */
	protected $blnSubmitInput = true;

	/**
	 * Content template
	 * @var string
	 */
    protected $strWizardCalendarLocationsTemplate = 'be_jbloc_selector';

	/**
	 * HTML select-boxes to display
	 * @var array
	 */
    protected $arrSelectBoxes = array();

    /**
     * Sort queried data
     * @var boolean
     */
    protected $sort = true;

	/**
	 * Add specific attributes
	 * @param string Attribute key
	 * @param mixed Attribute value
	 */
	public function __set($strKey, $varValue) {
        switch ($strKey) {
            case 'sort':
                $this->sort = $varValue;
                break;
            case 'value':
				$this->varValue = deserialize($varValue);
				break;
            case 'fields':
                $this->dbFields = array_values($varValue);
                break;
            case 'labels':
				$this->arrLabels = array_values($varValue);
				break;
            case 'width':
                $this->arrSelectBoxes['width'] = $varValue;
                break;
			default:
				parent::__set($strKey, $varValue);
				break;
        }
    }

    /**
     * Query the DB-tables
     * @return object Database result object
     */
    protected function queryFields() {
        $arrSelectData = array();
        foreach ($this->dbFields as $dbField) {
            $dbData = preg_split('/\./', $dbField);
            if (count($dbData) == 2) {
                $arrData = array();
                $this->import('Database');
                if ($this->sort) {      
                    $objData = $this->Database->prepare('SELECT id, '.$dbData[1].' FROM '.$dbData[0].' ORDER BY '.$dbData[1].' asc')
                        ->execute();
                } else {
                    $objData = $this->Database->prepare('SELECT id, '.$dbData[1].' FROM '.$dbData[0])
                        ->execute();
                }

                while ($objData->next()) {
                     $arrData[] = array('0'=>$objData->id, '1'=>$objData->$dbData[1]);
                }

                $arrSelectData[] = $arrData;
            }
        }
        return $arrSelectData;
    }

    /**
     * Create widget buttons
     * @param string The widget command string
     * @param array Button commands as string-array
     * @return array Button HTML code
     */
    protected function createButtons($strCommand, $arrButtons) {
        // create buttons
        $arrButtonsCode = array();
		foreach ($arrButtons as $button) {
			array_push($arrButtonsCode, array (
                'href' => $this->addToUrl(
                    '&amp;'.$strCommand.'='.$button.
                    '&amp;cid=%s'.
                    '&amp;id='.$this->currentRecord
                ),
				'title' => specialchars($GLOBALS['TL_LANG'][$this->strTable][$button][0]),
				'onclick' => 'WizardJBLocations.wizardJBLocations(this, \''.$button.'\', \'ctrl_'.$this->strId.'\');return false;',
				'img' => $this->generateImage(
                    substr($button, 1).'.gif', 
                    $GLOBALS['TL_LANG'][$this->strTable][$button][0], 
                    'class="tl_wizardjblocations_img"'
                )
			));
		}
        return $arrButtonsCode;
    }

    /**
     * Parse the edit commands
     * @param string The command to perform
     */
    protected function parseCommand($strCommand) {
        // Change the order
		$this->import('Database');
        $arrEmpty = array(0,0);

		switch ($strCommand) {
			case 'rnew':
				array_insert($this->varValue, $this->Input->get('cid') + 1, array($arrEmpty));
				break;
			case 'rcopy':
				$this->varValue = array_duplicate($this->varValue, $this->Input->get('cid'));
				break;
			case 'rup':
				$this->varValue = array_move_up($this->varValue, $this->Input->get('cid'));
				break;
			case 'rdown':
				$this->varValue = array_move_down($this->varValue, $this->Input->get('cid'));
				break;
			case 'rdelete':
				$this->varValue = array_delete($this->varValue, $this->Input->get('cid'));
				break;
        }
		$this->Database->prepare("UPDATE ".$this->strTable." SET ".$this->strField."=? WHERE id=?")
            ->execute(serialize($this->varValue), $this->currentRecord);
        $this->redirect(
            preg_replace(
                '/&(amp;)?cid=[^&]*/i', 
                '', 
                preg_replace(
                    '/&(amp;)?'.preg_quote(
                        $strCommand, 
                        '/'
                    ).'=[^&]*/i', 
                    '', 
                    $this->Environment->request
                )
            )
        );
    }

	/**
	 * Generate the widget and return it as string
	 * @return string The parsed template
	 */
	public function generate() {
        $strCommand = 'cmd_' . $this->strField;
        $objTemplate = new BackendTemplate($this->strWizardCalendarLocationsTemplate);

		if (is_array($GLOBALS['TL_JAVASCRIPT'])) {
			array_insert($GLOBALS['TL_JAVASCRIPT'], 1, 'system/modules/jb_locations/js/wizard_jb_locations.js');
		} else {
			$GLOBALS['TL_JAVASCRIPT'] = array('system/modules/jb_locations/js/wizard_jb_locations.js');
		}

        // Catch empty state
		if (!is_array($this->varValue) || count($this->varValue) < 1) {            
			$this->varValue = array(array('0','0'));
        }

        // look if we have something to do
        if ($this->Input->get($strCommand) && is_numeric($this->Input->get('cid')) && $this->Input->get('id') == $this->currentRecord) {
            $this->parseCommand($this->Input->get($strCommand));
        }

        // fill template
		$objTemplate->arrButtons = $this->createButtons($strCommand, array('rnew','rcopy', 'rup', 'rdown', 'rdelete'));
		$objTemplate->arrSelect = $this->queryFields();
		$objTemplate->arrSelectStates = $this->varValue;
        $objTemplate->attributes = $this->getAttributes();
        $objTemplate->strId = $this->strId;
        $objTemplate->arrLabels = $this->arrLabels;
        $objTemplate->arrSelectBoxes = $this->arrSelectBoxes;

        return $objTemplate->parse();
    }
}

?>
