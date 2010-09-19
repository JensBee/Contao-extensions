<?php
  $out='';

  $out.='<div style="height:'.$this->map['height'].';overflow-y:auto;">';
  
  $intMarkerCount = sizeof($this->marker);
  $intMarkerCurrent = 1;
  $arrJSMarkers = array(); // hold JS code for markers
  for($i = 0; $i < $intMarkerCount; $i++){
  	// TODO: make marker css configurable?
  	if ($i+1 >= $intMarkerCount) {
  		$out.='<div style="margin-bottom:1em;">';
  	} else {
  		$out.='<div style="margin-bottom:1em;border-bottom:1px dotted #757575;">';	
  	}
  	
  	// check & create cusom markers
  	$strMarkerIcon = $this->marker[$i]['class']['icon'];
  	if ($this->marker[$i]['class']['css'] == 'mid') {
  	  $arrImg = parse_url($this->marker[$i]['class']['icon']);
  	  $arrImgName = pathinfo($arrImg['path']);
      $strMarkerIcon = substr($arrImgName['dirname'],1).'/'.$arrImgName['filename'].$intMarkerCurrent.'.'.$arrImgName['extension'];
      if (!file_exists($strMarkerIcon)) {        
        $strMarkerIcon = $this->marker[$i]['class']['icon'];
      } else {
        $intMarkerCurrent++;
      }
    }
      
  	$out.='<img '.
  		'src="'.$strMarkerIcon.'" '.
  		'width="'.$this->marker[$i]['class']['icon_width'].'" '.
  		'height="'.$this->marker[$i]['class']['icon_height'].'" '.
  		'id="jbloc_gmap_'.$this->map['id'].'_marker_'.$i.'" '.
  		'style="padding-right:1em;" '.
  		'alt="'.$GLOBALS['TL_LANG']['MSC']['jblocations']['map_marker'].': '.$this->marker[$i]['class']['title'].'" ';      
  	$out.='/>';
  	$out.='<strong>'.$this->marker[$i]['class']['title'].': </strong>';
  	$out.='<span class="'.$this->marker[$i]['class']['css'].'">'.$this->marker[$i]['title'].'</span>';
  	$out.='<div style="margin-left:'.$this->marker[$i]['class']['icon_width'].'px; padding-left:1em;">'.$this->marker[$i]['description'].'</div>';  	
  	$out.='</div>';
  	// define marker events & attributes
  	$arrJSMarkers[$i] = array(
	  '.setStyle' 	  => "('cursor', 'pointer')",
	  '.setAttribute' => "('title', '".$GLOBALS['TL_LANG']['MSC']['jblocations']['show_marker_on_map']."')",
	  '.onclick'	  => " = function() {jbloc_gmap_".$this->map['id'].".panTo(new GLatLng(".$this->marker[$i]['coords']."));}",
	);
  }

  // set marker events & attributes
  $out.="\n".'<script type="text/javascript">'."\n";
  $out.='//<![CDATA['."\n";
  $out.='function jbloc_gmap_'.$this->map['id'].'_extMarker() {';
  foreach ($arrJSMarkers as $intMarkerNum => $arrMarkerSettings) {
    $out.="\nvar el = $('jbloc_gmap_".$this->map['id']."_marker_".$intMarkerNum."');"."\n";
    foreach ($arrMarkerSettings as $strFunction => $strFunctionData) {
      $out.='el'.$strFunction.$strFunctionData.';'."\n";
    }
  }
  $out.='};'."\n";

  // load marker code
  $out.="window.addEvent('domready', function() {jbloc_gmap_".$this->map['id']."_extMarker()});";
  $out.="\n".'//]]>'."\n";
  $out.='</script>'."\n";

  $out.='</div>';
    
  // all out
  echo '<!-- indexer::stop -->'.$out.'<!-- indexer::continue -->';
?>
