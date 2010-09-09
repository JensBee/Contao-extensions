<?php
  $mapId = 'jbloc_map_'.$this->map['id'];
  $mapJs = 'jbloc_gmap_'.$this->map['id'];
  $out='';

  // ** map div
  $out.="\n";
  $out.='<div '.
        'class="jbloc_map jbloc_map_inc block" '.
        'id="'.$mapId.'" '.
        'style="'.
          'width:'.$this->map['mapWidth'].';'.
          'height:'.$this->map['mapHeight'].';'.
          'display:block;'.
          '"'.
        '>';
  $out.="\n";

    // ** include google js
    $out.='<script '.
            'src="http://maps.google.com/maps?'.
            '&file=api'.
            '&v=2'.
            '&key='.$this->map['key'].
            '&sensor='.$this->map['GPS'].
            '&hl='.$this->map['language'].
            '" type="text/javascript"></script>';

    // ** map config
    $out.="\n";
    $out.='<script type="text/javascript">'."\n";
    $out.='//<![CDATA['."\n";
      // declare map global for external markers
      $out.='var '.$mapJs.' = new GMap2(document.getElementById("'.$mapId.'"));';
      
      // configure map
      $out.='function load_'.$mapId.'() {';
        $out.=
        'if (GBrowserIsCompatible()) {';
          // map types
          $out .= (in_array('normal', $this->map['mapTypes'])) ?
            $mapJs.'.addMapType(G_NORMAL_MAP);' :
            $mapJs.'.removeMapType(G_NORMAL_MAP);';          
          $out .= (in_array('satellite', $this->map['mapTypes'])) ?
            $mapJs.'.addMapType(G_SATELLITE_MAP);' :
            $mapJs.'.removeMapType(G_SATELLITE_MAP);';
          $out .= (in_array('normal_satellite', $this->map['mapTypes'])) ?
            $mapJs.'.addMapType(G_HYBRID_MAP);' :
            $mapJs.'.removeMapType(G_HYBRID_MAP);';
          $out .= (in_array('terrain', $this->map['mapTypes'])) ?
            $mapJs.'.addMapType(G_PHYSICAL_MAP);' :
            $mapJs.'.removeMapType(G_PHYSICAL_MAP);';
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
          if ($this->map['markerMap']) {
	        $arrMarkerDetails = array();            
	        $out .= 'latlng = Array(); var latlngbounds = new GLatLngBounds();';
	        for($i = 0; $i < sizeof($this->marker); $i++){
	          $out .=
	            'var markerIcon = new GIcon(G_DEFAULT_ICON);'.
	            'markerIcon.image = "http://www.geocodezip.com/mapIcons/marker'.($i+1).'.png";'.
	            'marker = new GLatLng('.$this->marker[$i]['coords'].');'.
	            'latlng.push(new GMarker('.
	              'marker,'.
	                '{icon:markerIcon}'.
	            '));'.
	            'latlngbounds.extend(marker);';
	        }
	        $out .=
	          'for (var i=0; i<latlng.length; i++) {'.
	            $mapJs.'.addOverlay(latlng[i]);'.
	          '}'.
	          $mapJs.'.setCenter(latlngbounds.getCenter(), '.$mapJs.'.getBoundsZoomLevel(latlngbounds));';
          }
      $out.='}'; // GBrowserIsCompatible
    $out.='}'; // function load_

    // load map
    $out.='window.setTimeout("load_'.$mapId.'()", 500);';
    $out.="\n".'//]]>'."\n";
    $out.='</script>';

  // finished
  $out.="\n";
  $out.='</div>';

  echo $out;
?>
