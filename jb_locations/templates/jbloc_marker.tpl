<?php
  $mapId        = 'jbloc_map_'.$this->map['id'];
  $mapMarkerId  = 'jbloc_marker_'.$this->map['id'];
  $mapJs        = 'jbloc_gmap_'.$this->map['id'];
  $mapTools     = 'mapClass_'.$mapId.'.mapTools';

  $out='';

  $out.='<div id="'.$mapMarkerId.'" style="height:'.$this->map['height'].';overflow-y:auto;overflow-x:hidden;">';
  
  $intMarkerCount = sizeof($this->marker);
  $intMarkerCurrent = 1;
  $arrJSMarkers = array(); // hold JS code for markers
  for($i = 0; $i < $intMarkerCount; $i++){
  	// TODO: make marker css configurable?
    $out.='<div id="'.$mapId.'_markerBlock_'.$i.'" ';
  	if ($i+1 >= $intMarkerCount) {
  		$out.='style="margin-bottom:1em;padding-right:25px;';
  	} else {
  		$out.='style="margin-bottom:1em;border-bottom:1px dotted #757575;padding-right:25px;';
  	}
    $out.='min-height:'.$this->marker[$i]['class']['icons']['default']['height'].'px;">';
  	
  	// check & create cusom markers
  	$strMarkerIcon = $this->marker[$i]['class']['icons']['default']['url'];
      
  	$out.='<img '.
  		'src="'.$strMarkerIcon.'" '.
  		'width="'.$this->marker[$i]['class']['icons']['default']['width'].'" '.
  		'height="'.$this->marker[$i]['class']['icons']['default']['height'].'" '.
  		'id="'.$mapId.'_marker_'.$i.'" '.
  		'style="padding-right:1em;float:left;" '.
  		'alt="'.$GLOBALS['TL_LANG']['MSC']['jblocations']['map_marker'].': '.$this->marker[$i]['class']['title'].'" ';      
  	$out.='/>';
  	$out.='<strong>'.$this->marker[$i]['class']['title'].': </strong>';
  	$out.='<span class="'.$this->marker[$i]['class']['css'].'">'.$this->marker[$i]['title'].'</span>';
  	$out.='<div style="margin-left:'.$this->marker[$i]['class']['icons']['default']['width'].'px; padding-left:1em;">'.$this->marker[$i]['description'].'</div>';  	
  	$out.='</div>';
  	// define marker events & attributes
  	$arrJSMarkers[$i] = array(
	  '.setStyle' 	  => "('cursor', 'pointer')",
	  '.setAttribute' => "('title', '".$GLOBALS['TL_LANG']['MSC']['jblocations']['show_marker_on_map']."')",
      '.onclick'	  => " = function() {".$mapTools.".marker_switchImage('".$mapId.'_marker_'.$i."'); ".$mapTools.".marker_panTo('".$mapId.'_marker_'.$i."');}",
	);
  }

  // set marker events & attributes
  $out.="\n".'<script type="text/javascript">'."\n";
  $out.='//<![CDATA['."\n";
  $out.='function '.$mapJs.'_extMarker() {';
  foreach ($arrJSMarkers as $intMarkerNum => $arrMarkerSettings) {
    $out.="\nvar el = $('".$mapId."_marker_".$intMarkerNum."');"."\n";
    foreach ($arrMarkerSettings as $strFunction => $strFunctionData) {
      $out.='el'.$strFunction.$strFunctionData.';'."\n";
    }
  }
  $out.='};'."\n";

  // load marker code
  $out.="window.addEvent('domready', function() {".$mapJs."_extMarker()});";
  $out.="\n".'//]]>'."\n";
  $out.='</script>'."\n";

  $out.='</div>';
    
  // all out
  echo '<!-- indexer::stop -->'.$out.'<!-- indexer::continue -->';
?>