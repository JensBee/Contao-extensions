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
 * Provide methods to handle back end tasks.
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Backend
 */
var WizardJBLocations = {
	/**
	 * Multitext wizard
	 * @param object
	 * @param string
	 * @param string
	 */
	wizardJBLocations: function($el, $command, $id) {
		var $elTBody 				= $($id).getFirst().getNext();
		var $arrRows 				= $elTBody.getChildren();
		var $elTParentTd 		= $($el).getParent();
		var $elTParentTr 		= $elTParentTd.getParent();		
		var $arrTCols 			= $elTParentTr.getChildren();
		var $intIndex 			= 0;
		
		for (var $i=0; $i<$arrTCols.length; $i++) {
			if ($arrTCols[$i] == $elTParentTd) {
				break;
			}
			$intIndex++;
		}

		Backend.getScrollOffset();
		
		switch ($command) {
			case 'rnew':
				var $elTr = new Element('tr');
				var $childs = $elTParentTr.getChildren();				
				// reset new form elements
				for (var $i=0; $i<$childs.length; $i++) {					
					var $elNext = $childs[$i].clone().injectInside($elTr);
					$elNext.getElements('select').each(function($el) {
						$el.value = '';
					});					
				}
				$elTr.injectAfter($elTParentTr);
				// give new element the focus
				$elTr.getElement('select').focus();
				break;
			case 'rcopy':
				var $elTr = new Element('tr');
				var $arrChilds = $elTParentTr.getChildren();
				// clone current row
				for (var $i=0; $i<$arrChilds.length; $i++) {
					$arrChilds[$i].clone(true).injectInside($elTr);
				}
				$elTr.injectAfter($elTParentTr);
				break;
			case 'rup':
				$elTParentTr.getPrevious() ? $elTParentTr.injectBefore($elTParentTr.getPrevious()) : $elTParentTr.injectInside($elTBody);
				break;
			case 'rdown':
				$elTParentTr.getNext() ? $elTParentTr.injectAfter($elTParentTr.getNext()) : $elTParentTr.injectBefore($elTBody.getFirst().getNext());
				break;
			case 'rdelete':
				($arrRows.length > 1) ? $elTParentTr.dispose() : null;
				break;
		}
		
		$arrRows = $elTBody.getChildren();
		for (var $i=0; $i<$arrRows.length; $i++) {
			$arrRows[$i].getElements('select').each(function($el, $idx) {
				alert($el.name.replace(/\[[0-9]+\][[0-9]+\]/ig, '[' + $i + '][' + $idx + ']'));
				$el.name = $el.name.replace(/\[[0-9]+\][[0-9]+\]/ig, '[' + $i + '][' + $idx + ']');
			});
		}

		// avoid page loading
		return false;
	}
};
