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
 * @package    JB_TKJ_EventPrintHook
 * @license    LGPL
 * @filesource
 */

/**
 * @copyright  Jens Bertram 2010
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class JB_TKJ_EventPrintHook extends Frontend {
	
	protected $cal_pid_wfahren = 5;
	protected $styleFontSize = '9';
	
	protected function queryAllEvents($id) {
		return $this->Database
			->prepare('SELECT id,title, startTime, endTime, startDate, endDate, teaser, details FROM tl_calendar_events WHERE pid=? AND published=1 ORDER BY startDate asc')
			->execute($id);
	}
	
	public function printArticleAsPdfHook(&$strArticle, &$objArticle) {
		//echo $strArticle;
		if ($objArticle->id == '145') {			
			$strArticle = '<h2 align="center" style="font-size:'.($this->styleFontSize + 3).'pt;"><u>Termine der Sparte Radwanderfahren des TKJ-Sarstedt e.v. 2010</u></h2>'; 
			$strArticle.= '<table border="1" cellpadding="3" style="font-size:'.$this->styleFontSize.'pt;" >';
			$strArticle.= '<tr style="font-weight:bold;font-size:'.($this->styleFontSize+2).'pt;">';
			$strArticle.= '<td>Datum</td><td>Uhrzeit</td><td>Veranstaltung</td><td>Hinweise</td>';
			$strArticle.= '</tr>';
			
			$objQuery = $this->queryAllEvents($this->cal_pid_wfahren);
			$objCalLoc = new CalendarJBLocations();
			
			while ($objQuery->next()) {
				$month = date('m', $objQuery->startDate);
				
				$strArticle.= ($month > $monthLast) ? 
					'<tr><td colspan="4"><b>'.date('F', $objQuery->startDate).'</b></td></tr>' :
					'';				
				$strArticle.= '<tr>';
				
				// date
				$strArticle.= '<td>'.date('d.m.Y', $objQuery->startDate).'</td>';
				
				// time
				$strArticle.= '<td>'.date('H:i', $objQuery->startTime);
				if ($objQuery->endTime != '' && intval($objQuery->startTime) < intval($objQuery->endTime)) {
					$strArticle.= ' - '.date('H:i', $objQuery->endTime);
				}
				$strArticle.= '</td>';
				
				// title
				$strArticle.= '<td>'.$objQuery->title.'</td>';
				
				// details
				$arrLoc = $objCalLoc->compileLocations($objCalLoc->getLocationListByEventId($objQuery->id, 1), 0);
				$strArticle.= '<td>';
				if ($arrLoc) {					
					foreach ($arrLoc['mapMarker'] as $marker) {
						$strArticle.= '<b>'.$marker['class']['title'].':</b> '.$marker['title'];	
					}					
				}
				$strArticle.= ($objQuery->teaser) ? '<p>'.$objQuery->teaser.'</p>' : '';				
				$strArticle.= ($objQuery->details) ? ''.$objQuery->details.'' : '';
				$strArticle.= '</td>';
	
				$strArticle.= '</tr>';
				
				$monthLast = $month;
			}
			
			$strArticle.= '</table></font>';
			//echo $strArticle;
		}
		//exit;
	}
}

?>