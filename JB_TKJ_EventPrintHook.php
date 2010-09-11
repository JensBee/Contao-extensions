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

require_once('tl_files/tkj-radsport/php/dateFormat.php');

/**
 * @copyright  Jens Bertram 2010
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    Controller
 */
class JB_TKJ_EventPrintHook extends Frontend {
	
	protected $cal_pid_wfahren = 5;
	protected $styleFontSize = '9';
	protected $colWidth = array (
		'date' 		=> 50,
		'time'		=> 75,
		'title'		=> 140,
		'staff'		=> 100,
		'details'	=> '*'
	);
	
	protected function queryAllEvents($id) {
		return $this->Database
			->prepare('SELECT id, pid, title, startTime, endTime, startDate, endDate, teaser, details, jbeventstaff_id FROM tl_calendar_events WHERE pid=? AND published=1 ORDER BY startDate asc')
			->execute($id);
	}
	
	protected function queryTargetPage($id) {
		return $this->Database
			->prepare('SELECT * FROM tl_page WHERE id=(SELECT jumpTo FROM tl_calendar WHERE id=?)')
			->execute($id)->fetchAssoc();
	}
	
	protected function getPageHeader($strTitle, $strYear) {
		return 	'<table border="0" cellpadding="3" style="font-size:'.$this->styleFontSize.'pt;" >'.
					'<tr>'.
						'<td width="110">'.
							'<img width="100" src="/tl_files/tkj-radsport/upload/bilder/logos/logo_tkj-radsport_print.png"/>'.
						'</td><td width="*" align="center" valign="middle">'.
							'<br/>'.
							'<h2>'.
								'<span style="font-size:'.($this->styleFontSize + 1).'pt;">TKJ-Sarstedt e.V. - Radsportabteilung</span><br/>'.
								'<span style="font-size:'.($this->styleFontSize + 2).'pt;">Termine der Sparte '.$strTitle.' - '.$strYear.'</span>'.
							'</h2>'.
							'<span style="font-size:'.($this->styleFontSize - 1).'pt;">'.
								'<a href="http://www.tkj-radsport.de">www.TKJ-Radsport.de</a>'.
							'</span>'.							
						'</td>'.
					'</tr>'.
				'</table>';
	}
	
	public function printArticleAsPdfHook(&$strArticle, &$objArticle) {
		if ($objArticle->id == '145') {
			$arrDateNow = jb_formatDate(time());
			
			$strArticle = $this->getPageHeader('Radwanderfahren', $arrDateNow['year']);
			$strArticle.= '<table border="1" cellpadding="3" style="font-size:'.$this->styleFontSize.'pt;" >';
			$strArticle.= '<tr style="font-weight:bold;font-size:'.($this->styleFontSize+1).'pt;">'.
								'<td width="'.$this->colWidth['date'].'">Datum</td>'.
								'<td width='.$this->colWidth['time'].'>Uhrzeit</td>'.
								'<td width='.$this->colWidth['title'].'>Veranstaltung</td>'.
								'<td width='.$this->colWidth['staff'].'>Veranstalter</td>'.
								'<td width='.$this->colWidth['details'].'>Hinweise</td>'.
							'</tr>';
			
			$objQueryEvent = $this->queryAllEvents($this->cal_pid_wfahren);
			$objQueryTarget = $this->queryTargetPage($this->cal_pid_wfahren);
			$objCalLoc = new CalendarJBLocations();
			$objStaff = new JBEventStaff();
			
			while ($objQueryEvent->next()) {
				$arrDateStart = jb_formatDate($objQueryEvent->startDate);
				$arrDateEnd = jb_formatDate($objQueryEvent->endDate);				
				
				$month = $arrDateStart['month'];
				
				$strArticle.= ($month > $monthLast) ? 
					'<tr><td colspan="5"><b>'.$arrDateStart['monthName'].'</b></td></tr>' :
					'';				
				$strArticle.= '<tr>';
				
				// date
				$strArticle.= '<td width='.$this->colWidth['date'].'>'.$arrDateStart['Day'].'.'.$arrDateStart['Month'].'.</td>';
				
				// time
				$strArticle.= '<td width='.$this->colWidth['time'].'>'.date('H:i', $objQueryEvent->startTime);
				if ($objQueryEvent->endTime != '' && intval($objQueryEvent->startTime) < intval($objQueryEvent->endTime)) {
					$strArticle.= ' - '.date('H:i', $objQueryEvent->endTime);
				}
				$strArticle.= '</td>';
				
				// title
				$strArticle.= '<td width='.$this->colWidth['title'].'>';
				$strArticle.= $objQueryEvent->title.'<br/>';				
				$strArticle.= 	'<a title="Deteils online lesen.." style="font-size:'.($this->styleFontSize - 1).'pt; font-style:italic;" href="'.$this->Environment->base.$this->generateFrontendUrl($objQueryTarget,'/events/'.$objQueryEvent->id).'">'.
									'(online lesen)'.
								'</a>';
				$strArticle.= '</td>';		
				
				
				// staff
				$strArticle.= '<td width='.$this->colWidth['staff'].'>';
				if ($objQueryEvent->jbeventstaff_id) {				
					$arrStaff = $objStaff->getStaffData($objQueryEvent->jbeventstaff_id);
					$strArticle.= $arrStaff['title'];
				}
				$strArticle.='</td>';				
				
				// details
				$arrLoc = $objCalLoc->compileLocations($objCalLoc->getLocationListByEventId($objQueryEvent->id, 1), 0);
				$strArticle.= '<td width='.$this->colWidth['details'].'>';
				if ($arrLoc) {
					$intLocCount = sizeof($arrLoc['mapMarker']);
					for($i = 0; $i < $intLocCount; $i++){
						$strArticle.= '<b>'.$arrLoc['mapMarker'][$i]['class']['title'].':</b> '.$arrLoc['mapMarker'][$i]['title'];
  						if ($i+1 < $intLocCount) {
  							$strArticle.= '<br/>';
  						}
					}					
				}
				$strArticle.= ($objQueryEvent->teaser) ? '<p>'.$objQueryEvent->teaser.'</p>' : '';				
				$strArticle.= ($objQueryEvent->details) ? ''.$objQueryEvent->details.'' : '';
				$strArticle.= '</td>';
	
				$strArticle.= '</tr>';
				
				$monthLast = $month;
			}
			
			$strArticle.= '</table>';
			
			// footer			
			$strArticle .= '<span style="font-size:'.($this->styleFontSize).'pt;">Weitere Informationen unter <a href="http://www.tkj-radsport.de">www.TKJ-Radsport.de</a>.</span><br/>';			
			$strArticle .= '<i style="font-size:'.($this->styleFontSize - 1).'pt;">Stand: '.$arrDateNow['Day'].'.'.$arrDateNow['monthName'].' '.$arrDateNow['year'].'</i>';			
			
			// debug
			//echo $strArticle;
		}
	}
}

?>