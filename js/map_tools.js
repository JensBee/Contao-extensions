function MapTools_google(oArgs) {
    // shotcuts
    var self = this;   
    var GMaps = google.maps;
    
    /* geo calculations */
    var objLatLngBounds = new GMaps.LatLngBounds();

    /* currently switched markers (alternate icon shown) */
    var markers_switched_array = new Array();
    /* all markers added to this map */
    var markers_hash = new Hash();
    /* all geoXML for this map */
    var geoXML_hash = new Hash();

    /* base map elements */
    this.map_obj = undefined;

    // toggle, if loaded GeoXML should be automaticly shown
    this.bool_autoShowGeoXML = true;
    // toggle, if marker should be automaticly shown
    this.bool_autoShowMarker = true;
    // toggle, if marker images should be switched onClick
    this.bool_switchMarkerOnClick = true;
    // zoomlevel for map, if single marker is shown
    this.map_zoomLevel = 12;
  	
    /**V3
     * Initialize class
     */
    this.init = function(oArgs) {
    	console.log('maptools init');
        // check mandatory parameters
        if (!$defined(oArgs.containerId)) throw new Error('Required Parameter containerId not given');
        if (!$defined(oArgs.defaultMapType)) throw new Error('Required Parameter defaultMapType not given');
        if (!$defined(oArgs.center)) throw new Error('Required Parameter center not given');

        var arrCenter = oArgs.center.split(",");        
        this.bool_autoShowMarker = $defined(oArgs.autoShowMarker) ? oArgs.autoShowMarker : this.bool_autoShowMarker;
        this.bool_autoShowGeoXML = $defined(oArgs.autoShowGeoXML) ? oArgs.autoShowGeoXML : this.bool_autoShowGeoXML;
        this.bool_switchMarkerOnClick = $defined(oArgs.switchMarkerOnClick) ? oArgs.switchMarkerOnClick : this.bool_switchMarkerOnClick;
        this.map_zoomLevel = (oArgs.zoom) ? oArgs.zoom : this.map_zoomLevel;

        // init map
        this.map_obj = new GMaps.Map(
            document.getElementById(oArgs.containerId), {
                zoom: this.map_zoomLevel,
                mapTypeId: (this.mapTypes_translate(oArgs.defaultMapType))[0],
                navigationControlOptions: {
                    style: this.mapControl_translate(oArgs.mapControl),
                },
                center: new GMaps.LatLng(arrCenter[0], arrCenter[1]),
            }
        );
        this.mapTypes_set(this.mapTypes_translate(oArgs.allowedMapTypes), false);
        
        // init marker cache
        markers_hash.set('__unnamed__', 0);
    };

    /**V3
     * Finalize map for displaying
     */
    this.display = function() {
        this.marker_publish();
    }

    /**V3
     * Add switch onClick handler to marker
     */
    this.marker_onClickSwitch_add = function(objMarker, strId, boolReset) {
        if (!$defined(boolReset)) {
            boolReset = true;
        }
        objMarker.setClickable(true);
        GMaps.event.addListener(objMarker, "click", function(event) {
            self.marker_switchImage(strId, boolReset);
        });
    }

    /**V3
     * Switch marker image
     */
    this.marker_switchImage = function(strId, boolResetOther, state) {
        var newState = state;

        if (!markers_hash.has(strId)) return;
        // check states & icons
        if (!newState) {
            if (markers_switched_array.contains(strId)) {
                newState = 'default';
            } else {
                newState = 'alternate';
            }
        }

        // reset all other markers to default? (default = true)
        if (!$defined(boolResetOther) || boolResetOther==true) {
            markers_switched_array.each(function(a, i){
                self.marker_switchImage(markers_switched_array[i], 'default');
            });
        }
        
        if (newState == 'default' && !markers_hash.get(strId).icon) return;
        if (newState == 'alternate' && !markers_hash.get(strId).icon_alt) return;

        // switch it
        switch (newState) {
            case 'default':
                markers_hash.get(strId).marker.setIcon(markers_hash.get(strId).icon);
                markers_hash.get(strId).marker.setZIndex(1);
                markers_switched_array.erase(strId);
                break;
            case 'alternate':
                markers_hash.get(strId).marker.setIcon(markers_hash.get(strId).icon_alt);
                markers_hash.get(strId).marker.setZIndex(10);
                markers_switched_array.push(strId);
                break;
        }
    }

    /**V3
     * Add a marker
     * (worker function)
     */
    this.marker_add = function(oArgs) {
        var coords = oArgs.coords.split(",");
        var markerId = oArgs.icon.id;

        // icon setup function
        var IconData = function(oArgs) {
            var anchor = oArgs.anchor.split(",");
            return new GMaps.MarkerImage(
                oArgs.file,
                new GMaps.Size(oArgs.width, oArgs.height),
                new GMaps.Point(0,0),
                new GMaps.Point(anchor[0], anchor[1])
            );
        }

        // give markers an id if needed to
        if (!$defined(markerId)) {
            markerId = 'mkr_' + markers_hash.__unnamed__;
            markers_hash.__unnamed__++;
        }

        // default icon
        if ($defined(oArgs.icon) && $defined(oArgs.icon.file)) {
            var icon = new IconData(oArgs.icon);
        }
        // alternate icon
        if ($defined(oArgs.icon_alt) && $defined(oArgs.icon_alt.file)) {
            var icon_alt = new IconData(oArgs.icon_alt);        
        }
        // shadow icon
        if ($defined(oArgs.icon_shadow) && $defined(oArgs.icon_shadow.file)) {
            var icon_shadow = new IconData(oArgs.icon_shadow);        
        }

        // setup marker
        var marker = new GMaps.Marker({
            position: new GMaps.LatLng(coords[0], coords[1]),
            map: this.map_obj,
            icon: icon,
            clickable: $defined(icon_alt) ? this.bool_switchMarkerOnClick : false,
            shadow: icon_shadow,
            zIndex: 1,
        });

        // store new marker
        markers_hash.set(markerId, {
            marker: marker,
            icon: $defined(icon) ? icon : undefined,
            icon_alt: $defined(icon_alt) ? icon_alt : undefined,
            icon_shadow: $defined(icon_shadow) ? icon_shadow : undefined,
        });

        if (this.bool_switchMarkerOnClick && $defined(icon_alt)) {
          this.marker_onClickSwitch_add(marker, markerId);
        }

        if (oArgs.onClickFunc) {
            marker.setClickable(true);
            GMaps.event.addListener(marker, "click", function(event) {
               oArgs.onClickFunc(markers_switched_array.contains(markerId));
            });
        }
        objLatLngBounds.extend(marker.getPosition());
    }

    /**V3
     * Translate general maptype names to target format
     */
    this.mapTypes_translate = function(oType) {
        if (!oType) return;
        var arrTypes = undefined;
        var arrReturn = new Array();

        if ($type(oType) == 'string') {
            arrTypes = oType.split(",");
        } else if ($type(oType) == 'array') {
            arrTypes = oType;
        } else {
            return;
        }
        
        arrTypes.each(function(e,i){
            arrReturn.push(self.mapTypes_translate_func(e));
        });
        return arrReturn;
    }

    /**V3
     * Translate general maptype names to target format
     * (worker function)
     */
    this.mapTypes_translate_func = function(strType) {
        switch (strType) {
            case 'normal_satellite':
                return GMaps.MapTypeId.HYBRID;
            case 'normal':
                return GMaps.MapTypeId.ROADMAP;
            case 'satellite':
                return GMaps.MapTypeId.SATELLITE;
            case 'terrain':
                return GMaps.MapTypeId.TERRAIN;
        }
    }

    /**V3
     * Set allowed map types
     */
    this.mapTypes_set = function(objType, boolTranslate) {
        if (!$defined(boolTranslate)) {
            boolTranslate = true;
        }
        this.map_obj.setOptions({
            mapTypeControlOptions: {
                mapTypeIds: (boolTranslate ? this.mapTypes_translate(objType) : objType),
            }
        });
    }

    /**V3
     * Set default map type
     */
    this.mapTypes_setDefault = function(strType) {
        this.mapTypes_setup({action:'set', type:strType});
    }

    /**V3
     * Set map ZoomLevel
     */
    this.zoom_setLevel = function(intZoom) {
        this.map_obj.setZoom(intZoom);
    }

    /**V3
     * Show markers
     */
    this.marker_publish = function() {
        // single marker here?
        if (markers_hash.getLength() == 2) {
            // set center & zoom
            this.map_obj.setCenter(objLatLngBounds.getCenter());
            this.map_obj.setZoom(this.map_zoomLevel);
        } else {
            this.map_obj.fitBounds(objLatLngBounds);
        }
    };

    /**V3
     * Pan a marker into view
     */
    this.marker_panTo = function(strId) {
        if ($defined(markers_hash.get(strId).marker)) {
            this.map_obj.panTo(markers_hash.get(strId).marker.getPosition());
        }
    };

    /**V3
     * Translate general mapcontrol names to target format
     */
    this.mapControl_translate = function(strControl) {
        switch(strControl) {
            case 'normal':
                return GMaps.NavigationControlStyle.SMALL;
            case 'large':
                return GMaps.NavigationControlStyle.DEFAULT;
        }
    }

    /**
     * Show geoXML
     */
/*    this.geoXML_show = function(index) {
        geoXML_hash[index].show();
        alert('show: '+geoXML_hash[index]);
    }
*/
    /**
     * Hide geoXML
     */
/*    this.geoXML_hide = function(index) {
        geoXML_hash[index].hide();
    }
*/
    /**
     * Show all geoXML
     */
/*    this.geoXML_showAll = function() {
//alert('Sa: '+geoXML_hash.length);
        geoXML_hash.each(function(e, i){
            self.geoXML_show(i);
        });
    }
*/
    /**
     * Hide all geoXML
     */
/*    this.geoXML_hideAll = function() {
        geoXML_hash.each(function(e, i){
            self.geoXML_hide(i);
        });
    }
*/
    /**V3
     * Add geoXML to the map
     */
    this.geoXML_add = function(oArgs) {
        var oKml = undefined;
        if (oArgs.file) {
            oKml = new GMaps.KmlLayer(oArgs.file);
        } else if (oArgs.kml) {
            oKml = oArgs.kml;
        } else {
            return;
        }
        oKml.setMap(this.map_obj);
        oKml.preserveViewport = $defined(oArgs.autoZoom) ? oArgs.autoZoom : false;
        return oKml;
    }
    
    this.init(oArgs);
}
