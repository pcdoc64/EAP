<?php
 include('js/risklist.js');
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
$remov='0';
if (isset($_GET['del'])) {$remov=$_GET['del'];}
if ($PageName=='site_edit') {
  if ($remov=='1') {echo "<div id='PgTitle'>Delete Camp Site</div>";} else {echo "<div id='PgTitle'>Edit Camp Site</div>";}
  $query="SELECT * FROM sites WHERE siteid=".$_GET['id'];
  //echo $query;
  $result=mysqli_query($conaap,$query);
  $row=$result->fetch_row();
} else {
  echo "<div id='PgTitle'>New Camp Site</div>";
  $result=FALSE;
}
$parent_type="S";           // parent_type and parent_id are for risk_show.php
if (isset($_GET['id'])) {$parent_id=$_GET['id'];} else {$parent_id=0;}
include('php/risk_show.php');
?>
<script>
function getLatLong() {
  var xmlhttp = new XMLHttpRequest();
  var showData = ('#showData');
  var locaddr=(document.getElementById('autocomplete').value)+", Australia";
  Uril = "https://maps.googleapis.com/maps/api/geocode/json?address="+ locaddr+"&sensor=true";

  var arr;
  var xmlhttp;
  // compatible with IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
  reslt="";
  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
        arr=xmlhttp.responseText;
        arb=(JSON.parse(arr)).results[0];
        locn=arr.search('"lat"');
        loct=arr.substr(locn, 55);
        if (document.getElementById("route").value=="") {
          for (i=0;i<arb.address_components.length;i++) {
            if (arb.address_components[i].types[0]=="street_number") {document.getElementById("street_number").value=arb.address_components[i].long_name;}
            if (arb.address_components[i].types[0]=="route") {document.getElementById("route").value=arb.address_components[i].long_name;}
          }
        }
        lat=loct.substr(8,11);
        locn=arr.search('"lng"');
        loct=arr.substr(locn, 55);
        longt=loct.substr(8,11);
        document.getElementById("longt").value=longt;
        document.getElementById('latt').value=lat;
  }}
xmlhttp.open("GET", Uril, true);
xmlhttp.send();
}

function getAddress() {
  var xmlhttp = new XMLHttpRequest();
  var showData = ('#showData');
  lgt=document.getElementById('longt').value.substring(0,10);
  ltt=document.getElementById('latt').value.substring(0,10);
  var latlong=ltt+','+lgt;
  Uril = "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ latlong+"&sensor=true";
  var arr;
  var xmlhttp;
  // compatible with IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
  reslt="";
  xmlhttp.onreadystatechange = function(){
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
        arr=xmlhttp.responseText;
        addn=arr.search('"formatted_address"');
        geom=arr.search('"geometry"');
        lent=geom-addn-35;
        addr=arr.substr(addn+23, lent);
        document.getElementById('autocomplete').value=addr;
        arl=JSON.parse(arr);
        addrl=arl['results'][0]['address_components'];
        if (parseInt(addrl[0]['long_name'])>0) {
          document.getElementById('street_number').value=addrl[0]['long_name'];
          document.getElementById('route').value=addrl[1]['long_name'];
          document.getElementById('locality').value=addrl[2]['long_name'];
        } else {
          document.getElementById('street_number').value='';
          document.getElementById('route').value=addrl[0]['long_name'];
          document.getElementById('locality').value=addrl[1]['long_name'];
        }
    document.getElementById('administrative_area_level_1').value=addrl[3]['short_name'];
    document.getElementById('postal_code').value=addrl[5]['long_name'];
    }
  }
  xmlhttp.open("GET", Uril, true);
  xmlhttp.send();
}

function prepRisk(riskno) {
  var data=["request:0"];
  siteid=document.getElementById("siteid").value;
  getrisky('S',idact, riskno, 0, data)
}
</script>
<!--<div class="centered_form" id="editinfo">
  <br><br> -->
  <form action="php/sites_save.php" class="centered_form2" id="sitesform" method="post">
    <?php
     if ($PageName=='site_edit' && $remov=='0') {
       echo '<input type="submit" class="buttons" name="update" value="Update"></input>'; //   disable if add button pressed
     } else {
       if ($remov=='0') {echo '<input type="submit" class="buttons" name="add" value="Add"></input>';} //   disable if edit button pressed
     }
     if ($remov=='1') {echo '<input type="submit" class="buttons" name="delete" value="Delete"></input>';}
    ?>
    <input style="float:right" type="submit" class="buttons" name="cancel" value="Cancel"></input>
<!--                                                                  Risk List goes here -->
    <div id="riskbox" class="riskl_form" style="display:none";>
      <a href="#" onclick="riskl_close()" title="Close" class="close">X</a>
      <div class="popupboxb" id="risk_list">
        <p>Select the Risk, then click the arrow to add to the list<a href="index.php?pg=risk_add&scr=S<?php if($result) {echo $row[0];}?>"><img align='right' src='resource/add.png' width=20><a></p>
        <table id="risktable" class="scroll_table2" style="max-height:400px;" width="100%" border="1px solid black">
        </table>
      </div>
    </div>

    <script>
    function riskl_close() {
      document.querySelector('#riskbox').style="display:none";
    }
    function riskl_open() {
      document.querySelector('#riskbox').style="display:visible";
    }
    </script>
    <div class="panele">
    	<div style="border: 1px solid #07839f; padding:5px">
      </br></br>
      <input type="hidden" id="siteid" name="siteid" value='<?php if($result) {echo $row[0];}?>'>
      <table id="address">
        <tr>
          <td class="labela required">Site: </td><td colspan="4" style="width:460px"><input type="text" <?php if (!$result) {echo 'placeholder="Name of Site" ';} ?> autofocus required id="clnt" name="site" style='width:330px' value="<?php if($result) {echo $row[1];}?>"/>
          <button style="background-color:lightblue" onclick="javascript:location.href='index.php?pg=dir&site=<?php echo $row[0]; ?>'" type="button">Directions</button></td>
        </tr>

        <tr>
          <td class='labela'>Location </td><td colspan="4" style="width:360px"><input type='text' <?php if (!$result) {echo 'placeholder="Enter your address" ';} ?> id='autocomplete' name='addr1' style='width:420px' onFocus="geolocate()" value='<?php if($result) {echo $row[2]." ".$row[3]." ".$row[4];}?>'><br></td>
        </tr>
        <tr>
          <td class="labelb required">Branch : </td><td>
          <select id = "brnch_name" name="brnch_name" style="width:150px"   value="<?php echo $row[31];?>">
            <?php
              $queryt="SELECT * FROM branch order by idbranch";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($brnch = mysqli_fetch_array($resultt)) {
                if (($result) and ($row[31]==$brnch[0])) {
                  echo "<option selected value= ".$brnch[0].">".$brnch[1]."</options>";
                } else {
                  echo "<option value= ".$brnch[0].">".$brnch[1]."</options>";
                }
              }
            ?>
          </select></td>
          <td class="labelb required">Region : </td>
          <td><select id = "regn_name" required name="regn_name" style="width:150px"   value="<?php echo $row[30];?>">
            <?php
              $queryt="SELECT * FROM region order by region";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($regn = mysqli_fetch_array($resultt)) {
                if (($result) and ($row[30]==$regn[0])) {
                  echo "<option selected value= ".$regn[0].">".$regn[1]."</options>";
                } else {
                  echo "<option value= ".$regn[0].">".$regn[1]."</options>";
                }
              }
            ?>
          </select></td>
        </tr>

        <tr style="display:none">
          <td class="labela">Address: </td><td colspan="1" style="width:80px"><input type="text" id="street_number" name="addr1" style="width:60px"   value="<?php if($result) {echo $row[2];}?>"><br></td>
          <td colspan="3" style="width:320px"><input type="text" id="route" name="addr2" style="width:318px"   value="<?php if($result) {echo $row[3];}?>"><br></td>
        </tr>
        <tr style="display:none">
          <td class="labela">City / Pcode: </td><td colspan="2" style="width:245px"><input type="text" id="locality" name="city" style="width:230px"
          value="<?php if($result) {
            $ct_pcode=substr(strrchr($row[4]," "),1);
            $ct_city=substr(trim($row[4]),0,strlen($row[4])-strlen($ct_pcode)-1);
            $ct_state=trim(substr(strrchr(trim($ct_city)," "),1));
            $ct_city=substr($ct_city,0,strlen($ct_city)-strlen($ct_state)-1);
            echo ''.trim($ct_city).'';
          } else {
            $ct_pcode="";$ct_city="";$ct_state="";$ct_city="";
          }
          ?>"></td>
					<td colspan="1" style="width:80px"><select id = "administrative_area_level_1" name="state" style="width:70px"   value="<?php echo $ct_state;?>">
												<option <?php if(($result) and ($ct_state=="QLD")){echo("selected");} ?> value = "QLD">QLD</option>
												<option <?php if(($result) and ($ct_state=="NSW")){echo("selected");} ?> value = "NSW">NSW</option>
												<option <?php if(($result) and ($ct_state=="ACT")){echo("selected");} ?> value = "ACT">ACT</option>
												<option <?php if(($result) and ($ct_state=="VIC")){echo("selected");} ?> value = "VIC">VIC</option>
												<option <?php if(($result) and ($ct_state=="TAS")){echo("selected");} ?> value = "TAS">TAS</option>
												<option <?php if(($result) and ($ct_state=="SA")){echo("selected");} ?> value = "SA">SA</option>
												<option <?php if(($result) and ($ct_state=="NT")){echo("selected");} ?> value = "NT">NT</option>
												<option <?php if(($result) and ($ct_state=="WA")){echo("selected");} ?> value = "WA">WA</option>
											</select>
          </td>
					<td colspan="1" style="width:77px"><input type="number,4" id="postal_code" name="pcode" style="width:67px"   value="<?php if($result) {echo $ct_pcode;}?>"></br></td>
        </tr>
      </table>
      </div>
				<div style="border: 1px solid #07839f; width:365px; float:left;padding:5px">
          <label class="labela" style="width:85px">Latitude: </label><input type="text" id="latt" name="latt" style="width:75px"   value="<?php if($result) {echo $row[15];}?>">
          <label class="labela" style="width:65px;">Longitude: </label><input type="text" id="longt" name="longt" style="width:75px"   value="<?php if($result) {echo $row[14];}?>"/>

<!--          <button style="background-color:lightblue" onclick="find_latlong()" type="button">Find</button> --><br>
					<label class="labela" style="width:85px;">Map Name: </label><input type="text" id="map_name" name="map_name" style="width:75px"   value="<?php if($result) {echo $row[34];}?>"/>
          <label class="labela" style="width:65px">Grid Ref: </label><input type="text" id="grid_ref" name="grid_ref" style="width:75px"   value="<?php if($result) {echo $row[35];}?>"/>
          <label class="labela" style="width:95px;">Nearest Town</label><input type="text" id="near_town" name="near_town" style="width:245px" value="<?php if($result) {if ($row[36]=="") {echo $ct_city;} else {echo $row[36];}}?>"/>
<!--          <label class="labela">Google map: </label> -->
          <div id="map" style="width:360px;height:220px;"></div>
<!--          <input type="text" id="sitemap" name="google" style="width:260px;height:200px;"/> -->
				</div>
        <div style="border: 1px solid #07839f; width:211px; float:left;padding:5px">Attributes<br>
          <label class="labelb required">Type:</label>
          <select id = "sitetype" name="sitetype" required style="width:90px" value="<?php if($result) {echo $row[37];}?>">
            <option <?php if(($result) and ($row[37]==1)){echo("selected");} ?> value = "1">Camp Site</option>
            <option <?php if(($result) and ($row[37]==2)){echo("selected");} ?> value = "2">Offsite Visit</option>
            <option <?php if(($result) and ($row[37]==3)){echo("selected");} ?> value = "3">Scout Den</option>
          </select><br>
          <label class="labelb">Max Campers:</label><input type="text" id="maxcamp" name="maxcamp" style="width:60px" value="<?php if($result) {echo $row[16];}?>"/>
          <label class="labelb">Time Open: </label><input type="text" id="timeopen" name="timeopen" style="width:60px" value="<?php if($result) {echo $row[17];}?>"/>
          <label class="labelb">Time Closed:</label><input type="text" id="timeclose" name="timeclose" style="width:60px" value="<?php if($result) {echo $row[18];}?>"/>
          <label class="labelb">$Cost pp: </label><input type="text" id="costpp" name="costpp" style="width:60px" value="<?php if($result) {echo $row[21];}?>">
          <label class="labelb">Food included?</label><input type="checkbox" name="food" id="food" value="food">
        </div>
        <div style="border: 1px solid #07839f; width:211px; float:left;padding:5px">Accomodation<br>
          <table>
            <tr>
              <td><input type="checkbox" name="accom[]" id="idtentbyo" value="tentb"<?php if ($result and (substr($row[20],0,1)=="1")) {echo 'checked';} ?>>Tent - BYO</td>
              <td><label >Extra Cost</label></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="accom[]" id="idtentsup" value="tents"<?php if ($result and (substr($row[20],1,1)=="1")) {echo 'checked';} ?>>Tent - supplied</td>
              <td><input type="text" id="costtent" name="costtent" style="width:60px" value="<?php if($result) {echo $row[22];}?>"></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="accom[]" id="cabins" value="cabin" <?php if ($result and (substr($row[20],2,1)=="1")) {echo 'checked';} ?>>Cabins</td>
              <td><input type="text" id="costcabin" name="costcabin" style="width:60px" value="<?php if($result) {echo $row[23];}?>"></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="accom[]" id="dorms" value="dorms" <?php if ($result and (substr($row[20],3,1)=="1")) {echo 'checked';} ?>>Dormitory</td>
              <td><input type="text" id="costdorm" name="costdorm" style="width:60px" value="<?php if($result) {echo $row[24];}?>"></td>
            </tr>
          </table>
        </div>
        <div style="border: 1px solid #07839f; padding:5px">
          <?php
            if ($PageName=='site_edit')
            {echo '<div style="border: 1px solid #07839f; padding:5px">';echo '<table id="rtableS" class="scroll_table2" style="width:100%" border="1"></table>';echo '<a name="selrisk" href="#" onclick="riskl_open()" ><button style="background-color:lightblue" onclick="riskl_open()" type="button">Click here to select from the Risk list</a>';} else
            {echo '<div style="border: 1px solid #07839f; padding:5px;;display:none;">';echo '<table id="rtableS" class="scroll_table" style="width:100%" border="1"></table>';}
          ?>
        </div>
				<div style="display:inline-block">
					<div style="border: 1px solid #07839f; width:188px; float:left; padding:3px">First Contact<br>
						<label class="labelc">Name: </label><input type="text" id="clcont1nmt" name="cont1n" style="width:110px" value="<?php if($result) {echo $row[5];}?>"><br>
						<label class="labelc">Phone:</label><input type="text" id="clcont1ph1t" name="cont1p" style="width:110px" value="<?php if($result) {echo $row[6];}?>"><br>
						<label class="labelc">Email: </label><input type="text" id="clcont1emailt" name="cont1e" style="width:110px" value="<?php if($result) {echo $row[7];}?>"><br>
					</div>
          <div style="border: 1px solid #07839f; width:188px; float:left;padding:3px">Second Contact<br>
						<label class="labelc">Name: </label><input type="text" id="clcont2nmt" name="cont2n" style="width:110px" value="<?php if($result) {echo $row[8];}?>"><br>
						<label class="labelc">Phone:</label><input type="text" id="clcont2ph1t" name="cont2p" style="width:110px" value="<?php if($result) {echo $row[9];}?>"><br>
						<label class="labelc">Email: </label><input type="text" id="clcont2emailt" name="cont2e" style="width:110px" value="<?php if($result) {echo $row[10];}?>"><br>
					</div>
					<div style="border: 1px solid #07839f; width:188px; float:right;padding:3px">Third Contact<br>
						<label class="labelc">Name: </label><input type="text" id="clcont3nmt" name="cont3n" style="width:110px" value="<?php if($result) {echo $row[11];}?>"><br>
						<label class="labelc">Phone:</label><input type="text" id="clcont3ph1t" name="cont3p" style="width:110px" value="<?php if($result) {echo $row[12];}?>"><br>
						<label class="labelc">Email: </label><input type="text" id="clcont3emailt" name="cont3e" style="width:110px" value="<?php if($result) {echo $row[13];}?>"><br>
					</div>
        </div>
        <div style="display:inline-block; width:100%">
          <div style="border: 1px solid #07839f; padding:2px">Emergency Contacts<br>
            <label class="labeld">Hospital: </label><input type="text" id="phhosp" name="phhosp" style="width:70px" value="<?php if($result) {echo $row[25];}?>">
            <label class="labeld">Ambulance: </label><input type="text" id="phambl" name="phambl" style="width:65px" value="<?php if($result) {echo $row[26];}?>">
            <label class="labeld">Police: </label><input type="text" id="phpolc" name="phpolc" style="width:65px" value="<?php if($result) {echo $row[27];}?>">
            <label class="labele">Ranger: </label><input type="text" id="phrang" name="phrang" style="width:70px" value="<?php if($result) {echo $row[28];}?>"><br>
				</div>
				<div style="vertical-align:top">
					<label class="labela">Notes: </label><textarea cols="8" rows="6" wrap="soft" id="clnotet" name="notes" style="width:445px"><?php if($result) {echo $row[33];}?></textarea><br>
				</div>
      </div>
			</form>

<script>
      onDomChange=function() {geolocate();}



        function initialize() {
          <?php if ($result) {
            echo 'geolocate();';
          } else {
            echo 'initMap(-19.240,146.791);';
          }
          ?>
          initAutocomplete();
        }
        var map, marker;

        function initMap(latt, longt) {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {
              lat: latt,
              lng: longt
          },
          zoom: 12
        });
        var marker = new google.maps.Marker({
          position: {
            lat:latt,
            lng:longt
          },
          map:map,
          draggable:true,
        })
        google.maps.event.addListener(marker, 'dragend', function(event) {
          document.getElementById('longt').value=event.latLng.lng();
          document.getElementById('latt').value=event.latLng.lat();
          getAddress();
        });
        }

        var placeSearch, autocomplete;
        var componentForm = {
          street_number: 'short_name',
          route: 'long_name',
          locality: 'long_name',
          administrative_area_level_1: 'short_name',
//          country: 'long_name',
          postal_code: 'short_name',
          longt: 'short_name',
          latt: 'short_name'
        };

        function initAutocomplete() {
          // Create the autocomplete object, restricting the search to geographical
          // location types.
          autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */
            (document.getElementById('autocomplete')), {
              types: ['geocode']
          });

          // When the user selects an address from the dropdown, populate the address
          // fields in the form.
          autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
          // Get the place details from the autocomplete object.
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(27); // Why 17? Because it looks good.
          }
          if (!marker) {
            marker = new google.maps.Marker({
              map: map,
              draggable:true,
              anchorPoint: new google.maps.Point(0, -29)
            });
            google.maps.event.addListener(marker, 'dragend', function(event) {
              document.getElementById('longt').value=event.latLng.lng();
              document.getElementById('latt').value=event.latLng.lat();
              getAddress();
    //            console.debug('final position is '+event.latLng.lat()+' / '+event.latLng.lng());
            });
          } else marker.setMap(null);
          marker.setOptions({
            position: place.geometry.location,
            map: map
          });

          for (var component in componentForm) {
            document.getElementById(component).value = '';
            document.getElementById(component).disabled = false;
          }

          // Get each component of the address from the place details
          // and fill the corresponding field on the form.
          for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
              var val = place.address_components[i][componentForm[addressType]];
              document.getElementById(addressType).value = val;
            }
          }
//          debugger;
          var town=document.getElementById('locality').value;
          document.getElementById('near_town').value=town;
          if (document.getElementById('locality').value) {
            getLatLong();
          } else {alert("no City");}
        }

        // Bias the autocomplete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        function geolocate() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
              });
              autocomplete.setBounds(circle.getBounds());
            });
            lgt=document.getElementById('longt').value;
            ltt=document.getElementById('latt').value;
            plgt=Number(lgt);
            pltt=Number(ltt);

            <?php if ($result) {echo "initMap(pltt,plgt);";} ?>
          }
        }

      </script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3UiSb7GvmU0I3_Cx5Za06EgANgVCbiQ4&libraries=places&callback=initialize" async defer></script>
<!--  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script> -->

<!--   </div> -->
<script>
$( document ).ready(function() {
  document.querySelector("#m3").style="Background-Color:black";
  idact=document.querySelector('#siteid').value;
  getrisk('S','0',idact,idact,'','0','');
  risklst('S',idact);

  function show_risk() {
    toprisk=$("#selrisk").offset().top;
    document.querySelector('#riskbox').style="display:visible; top:"+toprisk+"px;";
    $('#riskbox').show();
  };

  getQBSI('S');
  getPR('S');
});
</script>
