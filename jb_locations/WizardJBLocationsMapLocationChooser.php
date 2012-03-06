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
 * Class WizardJBLocationsMapLocationChooser
 *
 * Display lists of locations and location-types to select from
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class WizardJBLocationsMapLocationChooser extends Widget {

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
    protected $strWizardMapLocationsTemplate = 'be_jbloc_mapselector';

    /**
     * Parse the edit commands
     * @param string The command to perform
     */
    protected function parseCommand($strCommand) {
    }

	/**
	 * Generate the widget and return it as string
	 * @return string The parsed template
	 */
	public function generate() {
        $strCommand = 'cmd_' . $this->strField;
        $objTemplate = new BackendTemplate($this->strWizardMapLocationsTemplate);
        
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/jb_locations/js/map_tools.js';		
		$GLOBALS['TL_CSS'][] = 'http://www.google.com/uds/css/gsearch.css';
		$GLOBALS['TL_CSS'][] = 'http://www.google.com/uds/solutions/mapsearch/gsmapsearch.css';		
		
		// generate map
		$this->classJBLocations = new JBLocations();
		
		$objMap = $this->classJBLocations->generateMap(JBLocations::MAPPROVIDER_GOOGLE, Null);

		$objTemplate->map_details = $objMap->getLocationDataArrayById($this->currentRecord);
		$objTemplate->map_key = $objMap->getMapKey();
		$objTemplate->map_language = $objMap->strLanguage;

        // Catch empty state
		if (!is_array($this->varValue) || count($this->varValue) < 1) {            
			$this->varValue = array(array('0','0'));
        }

        return $objTemplate->parse();
    }
}

?>
