<div class="container">
	<p>Maps</p>
	<div class="row">
      <div id="content-window"></div>
      <div id="map" style="border:1px solid; height:960px; width: 100%;"></div>
    </div>
    <script type="text/javascript">
    console.log("llegue");
      var map;

      function initMap() {
      	console.log("inició el mapa");
        var pyrmont = {lat: -27.589849, lng: -48.488846};

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          zoom: 11
        });

        var kmlLayer = new google.maps.KmlLayer({
          url: 'https://raw.githubusercontent.com/manuelandresavalos/brasil/master/lab/floripa_map/floripa.kml',
          suppressInfoWindows: false,
          map: map
        });

        kmlLayer.addListener('click', function(kmlEvent) {
          var text = kmlEvent.featureData.description;
          console.log('info: ' , kmlEvent);
          showInContentWindow(text);
        });

        function showInContentWindow(text) {
          var sidediv = document.getElementById('content-window');
          sidediv.innerHTML = text;
        }
      }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDmRCIDKgIGyIq665TyraVfjNIYm4jZmdw&libraries=places&callback=initMap"></script>
</div>
