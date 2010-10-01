<!-- indexer::stop -->
<?php
// 
// DO NOT SAVE WITHIN CONTAO!
// HTML SPECIAL CHARS WILL BE LOST!
//
$mapId       = 'jbloc_map_'.$this->map['id'];
$mapJs       = 'jbloc_gmap_'.$this->map['id'];
$mapMarkerId = 'jbloc_marker_'.$this->map['id'];
$mapTools    = 'jbloc_maptools_'.$this->map['id'];
$out='';

// helper functions & main container
?>
<script type="text/javascript" src="/system/modules/jb_locations/js/map_tools.js"></script>
<div class="jbloc_map_container jbloc_map_inc_container block">
<?php

if ($this->map['headlineMap']) {
  $out .= '<'.$this->map['headlineMap']['unit'].'>';
  $out .= $this->map['headlineMap']['value'];
  $out .= '</'.$this->map['headlineMap']['unit'].'>';
}

// map container
$out.="\n";
$out.='<div '.
  'class="jbloc_map block" '.
  'id="'.$mapId.'" '.
  'style="'.
    'width:'.$this->map['mapWidth'].';'.
    'height:'.$this->map['mapHeight'].';'.
    'display:block;'.
    'margin-right:1em;'.
    'float:left;'.
    '"'.
  '>';
$out.="\n";

/*
 * Static map
 */
$out.='<noscript>'."\n";
$out.='<img alt="Google maps" src="http://maps.google.com/staticmap?';
$out.='&size='.preg_replace('/px/','',$this->map['mapWidth']).'x'.preg_replace('/px/','',$this->map['mapHeight']);
$out.='&format=png';
if ($this->map['markerMap'] && sizeof($this->marker) > 0) {
  $out.='&markers=';
  $intIconNum = 1;
  for($i = 0; $i < sizeof($this->marker); $i++){
   $out.=preg_replace('/\s/','',$this->marker[$i]['coords']);
   $out.=','.$intIconNum;
   $intIconNum++;
   if($marker != end($this->marker)) {
      $out.='|';
   }
  }
}    
$out.='&hl='.$this->map['language'];
$out.='&sensor='.$this->map['GPS'];
if ($this->map['zoom']) {
  $out.='&zoom='.$this->map['zoom'];
}
//$out.='&maptype='.$this->view;
$out.='&key='.$this->map['key'];
$out.='"/>';
$out.="\n".'</noscript>'."\n";
$out.='</div>'; // map container

// marker container
if ($this->map['markerExternal'] && sizeof($this->marker) > 0) {
  $out.='<div class="jbloc_map_marker block" style="float:left;">';
  if ($this->map['headlineMarker']) {
    $out .= '<'.$this->map['headlineMarker']['unit'].' class="s_small">';
    $out .= $this->map['headlineMarker']['value'];
    $out .= '</'.$this->map['headlineMarker']['unit'].'>';
  }
  // output external marker code
  if ($this->map['markerExternal'] && sizeof($this->marker) > 0) {
    $out .= $this->markerCode;
  }
  $out.='</div>'; // marker container
}

$out.='</div>'; // main container

/*
 * Dynamic map
 */
$out.='<script '.
  'src="http://maps.google.com/maps/api/js?'.
  '&key='.$this->map['key'].
  '&sensor='.$this->map['GPS'].
  '&hl='.$this->map['language'].
  '" type="text/javascript"></script>';

$out.='<script type="text/javascript">'."\n".'//<![CDATA['."\n";

// map class: start
$out.='var mapClass_'.$mapId.'=undefined;';
$out.='function '.$mapId.'() {'."\n";

// declare map
$out.="  this.mapTools = new MapTools_google({"."\n".
    "    containerId:'".$mapId."',"."\n".
    "    defaultMapType:'".$this->map['mapTypeDefault']."',"."\n".
    "    allowedMapTypes:'".implode(",", $this->map['mapTypes'])."',"."\n".
    "    center:'".($this->map['center'] ? implode(',', $this->map['center']) : '0,0')."',"."\n".
    "    zoom:".($this->map['zoom'] ? $this->map['zoom'] : 'undefined').","."\n".
    "    mapControl:'".$this->map['controllerType']."',"."\n".
    "    switchMarkerOnClick:true,"."\n".
    "    autoShowGeoXML:false,"."\n".
"  });\n";

$out.="  this.markerListId = document.getElementById('".$mapMarkerId."');\n";
$out.="  var self=this;\n";

// DUMP--|
echo $out;
$out='';
// ------|
?>

  this.init = function() {
    this.addMarker();
  }
  this.markerList_scrollTo = function(strId, active) {
    if (active) {
      var elTarget = $(strId);
      elTarget.set('tween', {duration: 1500});
      new Fx.Scroll($(this.markerListId)).toElement(elTarget).chain(function() {
        elTarget.highlight('#FFDD55');
      });
    }
  }

<?php
$out.='this.addMarker = function() {'."\n";
// markers
if ($this->map['markerMap'] && sizeof($this->marker) > 0) {
  $arrMarkerDetails = array(); //?
  $intIconNum = 1; //?
  $intMarkerCurrent = 1; //?
  $strMarkerTitle = '';
  for($i = 0; $i < sizeof($this->marker); $i++){
    if ($this->marker[$i]['class']['icons']) {
      $out.= "var objMarker=this.mapTools.marker_add({\n".
      $strMarkerCode = '';
      foreach ($this->marker[$i]['class']['icons'] as $iconType => $iconData) {
        switch($iconType) {
            case 'default':
                $strMarkerCode .= "icon:{";                 
                break;
            case 'alternate':
                if (!$iconData['url']) continue(2);
                $strMarkerCode .= "icon_alt:{";
                break;
            case 'shadow':
                if (!$iconData['url']) continue(2);
                $strMarkerCode .= "icon_shadow:{"; 
                break;
        }
        $strMarkerCode .= "file:'".$iconData['url']."', ";
        $strMarkerCode .= "width:'".$iconData['width']."', ";
        $strMarkerCode .= "height:'".$iconData['height']."', ";
        $strMarkerCode .= "anchor:'".$iconData['anchor_x'].",".$iconData['anchor_y']."',";
        $strMarkerCode .= "},\n";
      }
      $strMarkerCode .="id:'".$mapId."_marker_".$i."',\n";
      $strMarkerCode .="title:'".$this->marker[$i]['class']['title']."',\n";
      $strMarkerCode .="coords:'".$this->marker[$i]['coords']."',\n";
      $strMarkerCode .= "onClickFunc:function(active){self.markerList_scrollTo('".$mapId.'_markerBlock_'.$i."', active);},\n";
      $strMarkerCode .= "});\n";
      $out.=$strMarkerCode;
    }
  }
}

// DUMP--|
echo $out;
$out='';
// ------|

// add map files (overlays)
if ($this->map['files']) :
  foreach ($this->map['files'] as $geoFile) :
?>
var kml = this.mapTools.geoXML_add({file:'<?php echo $geoFile['file'];?>'});
kml.set('suppressInfoWindows', true);
<?php
  endforeach;
endif;
?>
this.mapTools.display();
}} // addMarker + class
// load map
window.addEvent('domready', function() {mapClass_<?php echo $mapId;?> = new <?php echo $mapId;?>(); mapClass_<?php echo $mapId;?>.init();});
//]]>
</script>
<!-- indexer::continue -->