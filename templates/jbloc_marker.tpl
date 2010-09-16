<?php
  $out='';

  $out.='<div style="height:'.$this->map['height'].';overflow-y:scroll;">';
  
  $intMarkerCount = sizeof($this->marker);
  for($i = 0; $i < $intMarkerCount; $i++){
  	if ($i+1 >= $intMarkerCount) {
  		$out.='<div style="margin-bottom:1em;">';
  	} else {
  		$out.='<div style="margin-bottom:1em;border-bottom:1px dotted #757575;">';	
  	}
  	$out.='<img src="'.$this->marker[$i]['class']['icon'].'" width="'.$this->marker[$i]['class']['icon_width'].'" height="'.$this->marker[$i]['class']['icon_height'].'" style="padding-right:1em;" '.
		'onload="setAttribute(\'title\', \''.$GLOBALS['TL_LANG']['MSC']['jblocations']['show_marker_on_map'].'\'); this.style.cursor=\'pointer\'; return false;" '.
		'onclick="jbloc_gmap_'.$this->map['id'].'.panTo(new GLatLng('.$this->marker[$i]['coords'].'));" ';
  	$out.='/>';
  	$out.='<strong>'.$this->marker[$i]['class']['title'].': </strong>';
  	$out.='<span class="'.$this->marker[$i]['class']['css'].'">'.$this->marker[$i]['title'].'</span>';
  	$out.='<div style="margin-left:'.$this->marker[$i]['class']['icon_width'].'px; padding-left:1em;">'.$this->marker[$i]['description'].'</div>';  	
  	$out.='</div>';
  }

  $out.='</div>';
  
  echo '<!-- indexer::stop -->'.$out.'<!-- indexer::continue -->';
?>
