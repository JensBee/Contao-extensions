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
	wizardJBLocations: function(el, command, id) {
		var table = $(id);
		var thead = table.getFirst();
		var tbody = thead.getNext();
		var rows = tbody.getChildren();
		var parentTd = $(el).getParent();
		var parentTr = parentTd.getParent();
		var cols = parentTr.getChildren();
		var index = 0;
		var selectElement = null;
		for (var i=0; i<cols.length; i++) {
			if (cols[i] == parentTd) {
				break;
			}
			index++;
		}

		Backend.getScrollOffset();

		switch (command) {
			case 'rnew':
				var tr = new Element('tr');
				var childs = parentTr.getChildren();

				for (var i=0; i<childs.length; i++) {
					var next = childs[i].clone(true).injectInside(tr);
					if (!selectElement) selectElement = next.getFirst();
					next.getFirst().value = '';
				}
				tr.injectAfter(parentTr);
				break;

			case 'rcopy':
				var tr = new Element('tr');
				var childs = parentTr.getChildren();

				for (var i=0; i<childs.length; i++) {
					var next = childs[i].clone(true).injectInside(tr);
					if (!selectElement) selectElement = next.getFirst();
					next.getFirst().value = childs[i].getFirst().value;
				}
				tr.injectAfter(parentTr);
				break;

			case 'rup':
				parentTr.getPrevious() ? parentTr.injectBefore(parentTr.getPrevious()) : parentTr.injectInside(tbody);
				break;

			case 'rdown':
				parentTr.getNext() ? parentTr.injectAfter(parentTr.getNext()) : parentTr.injectBefore(tbody.getFirst().getNext());
				break;

			case 'rdelete':
				(rows.length > 1) ? parentTr.dispose() : null;
				break;
		}

		rows = tbody.getChildren();

		for (var i=0; i<rows.length; i++) {
			var childs = rows[i].getChildren();

			for (var j=0; j<childs.length; j++) {
				var first = childs[j].getFirst();
				if (first && first.type.toLowerCase() == 'text') {
					first.name = first.name.replace(/\[[0-9]+\][[0-9]+\]/ig, '[' + i + '][' + j + ']')
				}
			}
		}
		if (selectElement) {
			selectElement.select();
		}
	}
};
