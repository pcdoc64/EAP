<?php
    $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    $siteno=$_GET['site'];
    $query="SELECT siteid, site_name, address1, address2, city, contact1_name, contact1_phone, sitetype, lattude, longtude, max_ppl FROM sites WHERE siteid=".$siteno." ORDER by site_name";
    $result=mysqli_query($conaap,$query);
    $rowd=mysqli_fetch_array($result);
    $locat=trim($rowd['lattude']).",".trim($rowd['longtude']);
//    $locat=trim($rowd['address1'])." ".trim($rowd['address2']).', '.trim($rowd['city']);
 ?>
 <div><br><br><br></div>
<div id="direction" style="height:100%; top=100px">
  <input id="origin-input" class="controls" style="width:250px" type="text"
      placeholder="Enter an origin location">
  <input id="destination-input" class="controls" style="display:none" type="text" value="<?php echo $locat; ?>">
  <input id = "destn" class="controls" name="site_name" disabled style="width:250px" type="text" value=" to <?php echo $rowd['site_name']; ?>">

  <div id="panel" style="width: 25%; float: right; background-color: #dad4d4;"></div>
  <div id="map" style="width:75%; float:left;"></div>
</div>

    <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {

          center: {lat: -19.2688, lng: 146.8265},
          zoom: 13
        });

        new AutocompleteDirectionsHandler(map);
      }
       /**
        * @constructor
       */
      function AutocompleteDirectionsHandler(map) {
        this.map = map;
        this.originPlaceId = null;
        this.destinationPlaceId = null;
        this.travelMode = 'DRIVING';
        var originInput = document.getElementById('origin-input');
        var destinationInput = document.getElementById('destination-input');

        this.directionsService = new google.maps.DirectionsService;
        this.directionsDisplay = new google.maps.DirectionsRenderer;
        this.directionsDisplay.setMap(map);
        this.directionsDisplay.setPanel(document.getElementById('panel'));
        var originAutocomplete = new google.maps.places.Autocomplete(
            originInput);
        var destinationAutocomplete = new google.maps.places.Autocomplete(
            destinationInput);

        this.setupPlaceChangedListener(originAutocomplete, 'ORIG');
        this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');

        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(originInput);
        this.map.controls[google.maps.ControlPosition.TOP_LEFT].push(destn);
      }


      AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function(autocomplete, mode) {

        var me = this;
        autocomplete.bindTo('bounds', this.map);
        autocomplete.addListener('place_changed', function() {
          var place = autocomplete.getPlace();
          if (!place.place_id) {
            window.alert("Please select an option from the dropdown list.");
            return;
          }
          me.originPlaceId = place.formatted_address;
          me.route();
        });

      };

      AutocompleteDirectionsHandler.prototype.route = function() {
        if (!this.originPlaceId) {
          return;
        }
        var me = this;
        locat=document.getElementById('destination-input').value;
        this.directionsService.route({
          origin: me.originPlaceId,
          destination: locat,
          travelMode: 'DRIVING'
        }, function(response, status) {
          if (status === 'OK') {
            me.directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      };

      function get_dir() {
        var originInput = document.getElementById('origin-input').value;
        var d = document.getElementById("destination-input").value;
        var request = {
          origin: originInput,
          destination: d,
          travelMode: 'DRIVING'
        };

        }

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3UiSb7GvmU0I3_Cx5Za06EgANgVCbiQ4&libraries=places&callback=initMap" async defer></script>

    <script>
    $( document ).ready(function() {
      var body=document.body, html=document.documentElement;
      var hght=Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight );
      hght=hght-115;
      document.getElementById('map').style="height:"+hght+"px; width:75%; float:left;";

    });
    </script>
