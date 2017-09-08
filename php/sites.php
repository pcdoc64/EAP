<script>
  var expanded = false;

  function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
      checkboxes.style.display = "block";
      expanded = true;
    } else {
      checkboxes.style.display = "none";
      expanded = false;
    }
  }
</script>

<?php
  $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  $query="SELECT siteid, site_name, city, contact1_name, contact1_phone, sitetype, max_ppl FROM sites ORDER BY site_name";
  $result=mysqli_query($conaap,$query);
  //echo 'rows '.mysqli_num_rows($result).'';
  if(!$result) {header('location:index.php?pg=site_add');}
?>
<div id='PgTitle'>Camp Sites</div>
<div id='buttdiv'>
  <input type="button" class="buttons" value="New Site" onclick="location.href='index.php?pg=site_add';"></input>
<!-- <input type="button" class="buttons" value="Edit Site" onclick="location.href='index.php?pg=site_edit';"></input> -->
</div>
<div class=centered_table>
  <input type="text" id="search" placeholder="Type to search">
  <div class="multiselect">
    <div class="selectBox" onclick="showCheckboxes()">
      <select>
        <option>Filter the list</option>
      </select>
      <div class="overSelect"></div>
    </div>
    <div id="checkboxes">
      <label for="ck1">
        <input type="checkbox" checked id="ck1">Camp Sites</label>
      <label for="ck2">
        <input type="checkbox" checked id="ck2">Offsite Visits</label>
      <label for="ck3">
        <input type="checkbox" checked id="ck3">Scout Dens</label>
    </div>
  </div>
  <table id="tabler" class="sortable scroll_table" style="width:100%" border='1'>
    <thead>
  		<tr style="color:blue;">
  			<th style="width:232;" class="tabsite">Site</th>
  			<th style="width:240;" class="tabcity">City</th>
  		  <th style="width:167;" class="sorttable_nosort tabcontact">Contact</th>
        <th style="width:80;" class="tabcontact">Type</th>
   			<th style="width:60;" class="tabmaxcamp">Max ppl</th>
  			<th class="tabicon">Del</th>
  		</tr>
    </thead>
    <tbody id="tablerbody">
      <?php
        while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
          echo ' <tr class="clickrow" data-url="index.php?pg=site_edit&id='.$row["siteid"].'">
                    <td>'.$row["site_name"].'</td>
                    <td>'.$row["city"].'</td>
                    <td>'.$row["contact1_name"].'</td>
                    <td class="col1">';
                    if ($row["sitetype"]=="1") {echo "Camp Site";}
                    if ($row["sitetype"]=="2") {echo "Offsite Visit";}
                    if ($row["sitetype"]=="3") {echo "Scout Den";}
                    echo '</td>
                    <td>'.$row["max_ppl"].'</td>
                    <td>';
                    if ($_SESSION['admin']=='TRUE') {$sit=$row["siteid"];echo '<a href="index.php?pg=site_edit&id='.$sit.'&del=1"><img src="resource/del.png" width="30"></a>';}
                     else {echo '<img src="resource/del_off.png" width="30">';}
                    echo '</td>
                 </tr>';
        }
       ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
$( document ).ready(function() {
  document.querySelector("#m3").style="Background-Color:black";


  $('#search').keyup(function() {
    var $rows=$('#tablerbody tr');
    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
        reg = RegExp(val, 'i'),
        text;
    $rows.show().filter(function() {
        text = $(this).text().replace(/\s+/g, ' ');
        return !reg.test(text);
    }).hide();
  });

  document.querySelector('#ck1').onclick = function() {filterrow();}
  document.querySelector('#ck2').onclick = function() {filterrow();}
  document.querySelector('#ck3').onclick = function() {filterrow();}

  $(".clickrow").click(function() {
      window.location = $(this).data("url");
  });

  function filterrow() {
    ck1=$("#ck1").prop('checked');
    ck2=$("#ck2").prop('checked');
    ck3=$("#ck3").prop('checked');
    if (ck1==true) {$("#tabler td.col1:contains('Camp')").parent().show();}
    if (ck2==true) {$("#tabler td.col1:contains('Offsite')").parent().show();}
    if (ck3==true) {$("#tabler td.col1:contains('Scout')").parent().show();}
    if (ck1==false) {$("#tabler td.col1:contains('Camp')").parent().hide();}
    if (ck2==false) {$("#tabler td.col1:contains('Offsite')").parent().hide();}
    if (ck3==false) {$("#tabler td.col1:contains('Scout')").parent().hide();}
  }
});
</script>
