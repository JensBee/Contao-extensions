function MapTools_google(oArgs) {
    var self = this;
    var arrLatLng = Array(); 
    var objLatLngBounds = new GLatLngBounds();
    var arrMapTypes = Array(G_NORMAL_MAP, G_SATELLITE_MAP, G_HYBRID_MAP, G_PHYSICAL_MAP);

    this.mapJs = undefined;
    this.mapId = undefined;
    // toggle if loaded GeoXML should be automaticly shown
    this.autoShowGeoXML = true;

    /**
     * Initialize class
     */
    this.__init = function(oArgs) {
        this.mapJs = oArgs.mapJs;
        this.mapId = oArgs.mapId;
        // wont work
        if (oArgs.autoShowGeoXML) {
            this.autoShowGeoXML = oArgs.autoShowGeoXML;
        }
    };

    /** 
     * Add a marker
     */
    this.addMarker = function(oArgs) {
        var icon = oArgs.icon;
        var width = oArgs.width;
        var height = oArgs.height;
        var anchor = oArgs.anchor.split(",");
        var coords = oArgs.coords.split(",");

        if (oArgs.default == true) {
            var markerIcon = new GIcon(G_DEFAULT_ICON);
        } else {
            var markerIcon = new GIcon();
        }

        markerIcon.image = icon;
        markerIcon.iconSize = new GSize(width, height);
        markerIcon.iconAnchor = new GPoint(anchor[0], anchor[1]);

        marker = new GLatLng(coords[0], coords[1]);
        arrLatLng.push(new GMarker(marker, {icon:markerIcon}));
        objLatLngBounds.extend(marker);
    };

    /**
     * Handle map Types
     */
    this.confMapType = function(oArgs) {
        var mapFunc = undefined;
        switch (oArgs.action) {
            case 'set':
                mapFunc = 'setMapType';
                break;
            case 'add':
                mapFunc = 'addMapType';
                break;
            case 'rem':
                mapFunc = 'removeMapType';
                break;
        }
        if (mapFunc) {
            switch (oArgs.type) {        
                case 'normal':
                    this.mapJs[mapFunc](G_NORMAL_MAP);
                    break;
                case 'satellite':
                    this.mapJs[mapFunc](G_SATELLITE_MAP);
                    break;
                case 'normal_satellite':
                    this.mapJs[mapFunc](G_HYBRID_MAP);
                    break;
                case 'terrain':
                    this.mapJs[mapFunc](G_PHYSICAL_MAP);
                    break;
            }
        }
    }

    /**
     * Set allowed map types
     */
    this.setMapTypes = function(strTypes) {
        var arrMapAddTypes = strTypes.split(",");
        for (type in arrMapTypes) {
            this.confMapType({action:'rem', type:type});
        }
        for (type in arrMapAddTypes) {
            this.confMapType({action:'add', type:type});
        }
    }

    /**
     * Set default map type
     */
    this.setDefaultMapType = function(strType) {
        this.confMapType({action:'set', type:strType});
    }

    /**
     * Set map ZoomLevel
     */
    this.setZoomLevel = function(intZoom) {
        this.mapJs.setZoom(intZoom);
    }

    /** 
     * Show markers
     */
    this.publishMarker = function() {
      for (var i=0; i<arrLatLng.length; i++) {
        this.mapJs.addOverlay(arrLatLng[i]);
      }
      this.mapJs.setCenter(objLatLngBounds.getCenter(), this.mapJs.getBoundsZoomLevel(objLatLngBounds));
    };

    /**
     * Load & display GeoXML
     */
    this.geoCallBack = function() {
        self.mapJs.setCenter(this.getDefaultCenter());
        this.gotoDefaultViewport(self.mapJs);
        if (!self.autoShowGeoXML) {
            this.hide();
        }
        self.mapJs.addOverlay(this);
    };

    this.__init(oArgs);
}
