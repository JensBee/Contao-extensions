<?php
$mapId = 'jbloc_map_'.$this->map['id'];
$mapJs = 'jbloc_gmap_'.$this->map['id'];
$out='';

// main container
$out .= '<div class="jbloc_map_container jbloc_map_inc_container block">';

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
$out.='<img src="http://maps.google.com/staticmap?';
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
//$out.='&maptype='.$this->view;
$out.='&key='.$this->map['key'];
$out.='"/>';
$out.="\n".'</noscript>'."\n";
$out.='</div>'; // map container

// marker container
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

$out.='</div>'; // main container

/*
 * Dynamic map
 */
$out.='<script '.
	'src="http://maps.google.com/maps?'.
	'&file=api'.
	'&v=2'.
	'&key='.$this->map['key'].
	'&sensor='.$this->map['GPS'].
	'&hl='.$this->map['language'].
	'" type="text/javascript"></script>';

$out.="\n";
$out.='<script type="text/javascript">'."\n";
$out.='//<![CDATA['."\n";
// declare map global for external markers
$out.='var '.$mapJs.' = new GMap2(document.getElementById("'.$mapId.'"));';

// configure map
$out.='function load_'.$mapId.'() {';
$out.='if (GBrowserIsCompatible()) {';
// map types
$out.= (in_array('normal', $this->map['mapTypes'])) ?
	$mapJs.'.addMapType(G_NORMAL_MAP);' : $mapJs.'.removeMapType(G_NORMAL_MAP);';
$out .= (in_array('satellite', $this->map['mapTypes'])) ?
	$mapJs.'.addMapType(G_SATELLITE_MAP);' : $mapJs.'.removeMapType(G_SATELLITE_MAP);';
$out .= (in_array('normal_satellite', $this->map['mapTypes'])) ?
	$mapJs.'.addMapType(G_HYBRID_MAP);' : $mapJs.'.removeMapType(G_HYBRID_MAP);';
$out .= (in_array('terrain', $this->map['mapTypes'])) ?
	$mapJs.'.addMapType(G_PHYSICAL_MAP);' : $mapJs.'.removeMapType(G_PHYSICAL_MAP);';	
// default map type
switch ($this->map['mapTypeDefault']) {
	case 'normal':
		$out .= $mapJs.'.setMapType(G_NORMAL_MAP);';
		break;
	case 'satellite':
		$out .= $mapJs.'.setMapType(G_SATELLITE_MAP);';
		break;
	case 'normal_satellite':
		$out .= $mapJs.'.setMapType(G_HYBRID_MAP);';
		break;
	case 'terrain':
		$out .= $mapJs.'.setMapType(G_PHYSICAL_MAP);';
		break;
}
// map controller
if ($this->map['controller']) {
	switch ($this->map['controllerType']) {
		case 'normal':
			$out.=$mapJs.'.addControl(new GSmallMapControl());';
			break;
		case 'large':
			$out.=$mapJs.'.addControl(new GLargeMapControl());';
			break;
	}
}
// map type switch
if ($this->map['mapTypeSwitch'] && count($this->map['mapTypes']) > 1) {
	$out.=$mapJs.'.addControl(new GMapTypeControl());';
}
// markers
if ($this->map['markerMap'] && sizeof($this->marker) > 0) {
	$arrMarkerDetails = array();
	$out .= 'latlng = Array(); var latlngbounds = new GLatLngBounds();';
	$intIconNum = 1;
	for($i = 0; $i < sizeof($this->marker); $i++){
		if ($this->marker[$i]['class']['icon']) {
			$out .= 'var markerIcon = new GIcon();'.
				'markerIcon.image = "'.$this->marker[$i]['class']['icon'].'";'.
	        	'markerIcon.iconSize = new GSize('.$this->marker[$i]['class']['icon_width'].', '.$this->marker[$i]['class']['icon_height'].');'.
				// set anchor to center bottom
	        	'markerIcon.iconAnchor = new GPoint('.($this->marker[$i]['class']['icon_width']/2).', '.$this->marker[$i]['class']['icon_height'].');';	
		} else {
			$out .= 'var markerIcon = new GIcon(G_DEFAULT_ICON);'.
	        	'markerIcon.image = "http://www.geocodezip.com/mapIcons/marker'.$intIconNum.'.png";';
			$intIconNum++;
		}
		$out .=	'marker = new GLatLng('.$this->marker[$i]['coords'].');'.
			'latlng.push(new GMarker('.
				'marker,'.
				'{icon:markerIcon}'.
			'));'.
			'latlngbounds.extend(marker);';
	}
	$out .= 'for (var i=0; i<latlng.length; i++) {'.
		$mapJs.'.addOverlay(latlng[i]);'.
		'}'.
		$mapJs.'.setCenter(latlngbounds.getCenter(), '.$mapJs.'.getBoundsZoomLevel(latlngbounds));';
}
// zoom out one step to show markers that may be hidden under maptype-buttons
if (sizeof($this->map['mapTypes']) > 1) {
	$out .= $mapJs.'.zoomOut();';
}
$out.='}'; // GBrowserIsCompatible
$out.='}'; // function load_

// load map
$out.='window.setTimeout("load_'.$mapId.'()", 500);';
$out.="\n".'//]]>'."\n";
$out.='</script>';

// finished
$out.="\n";

echo $out;
?>
