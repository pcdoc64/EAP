<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$query="SELECT act.idact, act.activity_name, act.activity_type, act.fromdate, act.fromtime, act.todate, act.totime, act.section, act.req_woodbead, act.req_special, act.cost, sprog.rights FROM activities AS act INNER JOIN shareprog as sprog ON act.idact=sprog.idact WHERE sprog.uid='".$_SESSION['uid']."' ORDER By act.activity_name";
$result=mysqli_query($conaap,$query);
//echo 'rows '.mysqli_num_rows($result).'';
$cnti=mysqli_num_rows($result);
//if((!$result)||($cnti==0)) {header('location:index.php?pg=actv_add');}
if((!$result)||($cnti==0)) {echo '<script type="text/javascript"> window.location="index.php?pg=actv_add"</script>';}
?>
<div id='PgTitle'>Program</div>
<div id='buttdiv'>
<input type="button" class="buttons" value="New Program" onclick="location.href='index.php?pg=actv_add&rts=1';"></input>
<!-- <input type="button" class="buttons" value="Edit Site" onclick="location.href='index.php?pg=site_edit';"></input> -->
</div>
<div class=centered_table>
  <input type="text" id="search" placeholder="Type to search">

<table id="tabler" class="sortable scroll_table" style="width:100%" border='1'>
  <tr style="color:blue;">
    <th class="tabactv">Program</th>
    <th class="tabdays">Days</th>
    <th class="tabsection">Section</th>
    <th class="tabcost">Cost</th>
    <th class="tabrequires">Requires</th>
    <th class="tabicon">Del</th>
  </tr>
  <?php
  while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    $days=(strtotime($row['todate'])-strtotime($row['fromdate']))/(60*60*24);
    if ($days>0) {$days+=1;}

    echo ' <tr class="clickrow" data-url="index.php?pg=actv_edit&id='.$row["idact"].'&rts='.$row["rights"].'">
              <td>'.$row["activity_name"].'</td>
              <td>'.$days.'</td>
              <td>';
              if (substr($row["section"],0,1)=="1") {echo 'Joeys ';};
              if (substr($row["section"],1,1)=="1") {echo 'Cubs ';};
              if (substr($row["section"],2,1)=="1") {echo 'Scouts ';};
              if (substr($row["section"],3,1)=="1") {echo 'Venturers ';};
              if (substr($row["section"],4,1)=="1") {echo 'Rovers ';};
              if (substr($row["section"],5,1)=="1") {echo 'Leaders ';};
              if (substr($row["section"],6,1)=="1") {echo 'Family ';};
        echo '</td>
              <td>$'.$row["cost"].'</td>
              <td>';
              if ($row["req_woodbead"]) {echo 'WoodBeads ';};
              if ($row["req_special"]) {echo 'Special';};
        echo '</td>
              <td><a href="index.php?pg=actv_edit&id='.$row["idact"].'&rts='.$row["rights"].'&del=1"><img src="resource/del.png" width="30"></a></td>
           </tr>';
  }
   ?>

</table>
</div>

<script type="text/javascript">
$( document ).ready(function() {
  document.querySelector("#m2").style="Background-Color:black";
  var $rows=$('#tabler tr');

  $('#search').keyup(function() {
    var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
        reg = RegExp(val, 'i'),
        text;
    $rows.show().filter(function() {
        text = $(this).text().replace(/\s+/g, ' ');
        return !reg.test(text);
    }).hide();
  });

  $(".clickrow").click(function() {
      window.location = $(this).data("url");
  });
});
</script>
