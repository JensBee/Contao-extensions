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
 * @package    JBEventStaff
 * @license    LGPL
 * @filesource
 */

/**
 * Class CalendarLocations
 *
 * Display locations in calendar events
 * @copyright  Jens Bertram 2010
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class CalendarJBEventStaff extends JBEventStaff {

	/**
	 * Calendar event generate-hook
	 * @param object Template object
	 * @param string Template name
	 */
	function getEvent(&$objTemplate, $strTemplate) {
		// check if we are displaying events
		if (strncmp($strTemplate, 'event_', strlen('event_')) == 0) {
			if ($objTemplate->jbeventstaff_published) {				
				$objTemplate->jbeventstaff = $this->getStaffData($objTemplate->jbeventstaff_id);
			}
		}
	}
}
?>