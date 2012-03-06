<?php
  $out='';
?>

<div id="jblocations_mapselector_map" style="width:490px;height:300px;border:1px solid #cccccc;display:inline-block;">MAP HERE</div>
<div id="jblocations_mapselector_mapsearch" style="width:180px;height:300px;border:1px solid #cccccc;display:inline-block;">
  <div style="text-align:center;margin-top:5px;height:30px;">
    <form>
      <input type="text" id="jblocations_mapselector_mapsearch_entry" style="width:100px;" class="tl_text"/>
      <input type="submit" id="jblocations_mapselector_mapsearch_submit" style="width:65px;" class="tl_submit" value="Suchen"/>
    </form>
  </div>
  <div id="jblocations_mapselector_mapsearch_results" style="overflow-y:auto;height:255px;padding:5px;">
  </div>
</div>

<script src="http://maps.google.com/maps/api/js?&key=<?php echo $this->map_key;?>&hl=<?php echo $this->map_language;?>&sensor=false" type="text/javascript"></script>

<script type="text/javascript">
//<![CDATA[
var jblocations_mapselector = undefined;
var JBLocationsMapSelector = function() {
  self = this; // backref
  this.geocoder = new google.maps.Geocoder();
  this.mkr = undefined; // dragable marker
  this.eCoords = $('ctrl_coords');
  this.eZoomLevel = $('ctrl_zoom');
  this.eAdressEntry = $('jblocations_mapselector_mapsearch_entry');
  this.eAdressSubmit = $('jblocations_mapselector_mapsearch_submit');
  this.eAdressResults = $('jblocations_mapselector_mapsearch_results');
 
  /* generate map */
  this.mapTools = new MapTools_google({
  	containerId:'jblocations_mapselector_map',
  	defaultMapType:'normal',
  	center:'<?php echo $this->map_details['coords'];?>',
  	zoom:(<?php echo ($this->map_details['zoom']==0) ? 8 : $this->map_details['zoom'];?>*2)
  });  
  google.maps.event.addListener(this.mapTools.map_obj, "zoom_changed", function() {
    self.map_zoomed();
  });

  /* setup map & search */
  this.init = function() {
    this.mkr = new google.maps.Marker({
    	clickable:false,
    	draggable:true,
    	map:this.mapTools.map_obj,
    	position:new google.maps.LatLng(<?php echo ($this->map_details['coords']) ? $this->map_details['coords'] : '52.5234051, 13.4113999';?>), // default to berlin, germany
    	visible:true,
    });
    this.mapTools.map_obj.setCenter(this.mkr.getPosition());
    google.maps.event.addListener(this.mkr, "dragend", function() {
      self.mkr_draged();
  	});

    // adress search
    this.eAdressSubmit.addEvent('click', function(event) {
      event.stop();
      self.geocode_adress();      
    });
    this.eAdressEntry.addEvent('keydown', function(event){    	
      if (event.key == 'enter') {
        return false;        
      }      
    });  
  	
    // get initial data
    this.data_update();    
  }

  this.data_update = function() {
    console.log('update..');
  	this.map_zoomed();
    this.mkr_draged();    
  }
  
  this.jump_to = function(coords0, coords1) {
    var coords = new google.maps.LatLng(coords0, coords1);    
  	self.mapTools.map_obj.setCenter(coords);
  	self.mkr.setPosition(coords);
    self.data_update();    
  }

  /* geocode an adress */
  this.geocode_adress = function() {    
    var address = this.eAdressEntry.value;
    var results = [];
    if (this.geocoder) {
      this.geocoder.geocode( { 'address': address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          self.eAdressResults.empty();
          var elDiv = undefined;
          var elA = undefined;          
            results.each(function(e, i){
          	  elDiv = new Element('div', {style:'border-bottom:1px dotted #ccc;padding:3px;'});
          	  elA = new Element('a', {href: 'javascript:jblocations_mapselector.jump_to('+results[i].geometry.location.toString().replace(/\((.*)\)/, '$1')+');'});
          	  elA.set('text', e.formatted_address);
          	  elA.inject(elDiv);
          	  elDiv.inject(self.eAdressResults, 'bottom');
            });
          if (results.length == 1) {
          	self.jump_to(results[0].geometry.location);            
          }          
        } else {
          alert("Geocode was not successful for the following reason: " + status);
        }
      });
    }
    return false;
  }
  
  /* marker drag finished */
  this.mkr_draged = function() {
    coords = self.mkr.getPosition().toString();
    this.eCoords.value = coords.replace(/\((.*)\)/, '$1');
  }

  /* map zoomlevel changed */
  this.map_zoomed = function() {
    console.log('Zoom: '+this.mapTools.map_obj.getZoom());
  	this.eZoomLevel.value = this.mapTools.map_obj.getZoom()/2;
  }
  
  this.init();  
}
// load map
window.addEvent('domready', function() {  
  jblocations_mapselector = new JBLocationsMapSelector();
});
//]]>
</script>

<?php
  echo $out;
?>
