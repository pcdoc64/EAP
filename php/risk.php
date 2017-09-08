<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$query="SELECT idrisk, risk_name, matrix_before, task, risk, typeE FROM risk ORDER By risk_name";
$result=mysqli_query($conaap,$query);
$cnti=mysqli_num_rows($result);
if((!$result)||($cnti==0)) {header('location:index.php?pg=risk_add&scr=R');}
//echo 'rows '.mysqli_num_rows($result).'';

?>
<div id='PgTitle'>Risk Items</div>
<?php
include ("php/mod_risk_matrix.php");
 ?>
<div id='buttdiv'>
  <button class="buttona" id="show">Risk Matrix</button>
  <input type="button" class="buttons" value="New Risk" onclick="location.href='index.php?pg=risk_add';"></input>
</div>
<div class=centered_table>
  <input type="text" id="search" placeholder="Type to search">
<table  id="tabler" class="sortable scroll_table" style="width:100%" border='1'>
  <tr style="color:blue;">
    <th class="tabactv" style='width:200px'>Risk Name</th>
    <th class="tabdays" style='width:260px'>Task</th>
    <th class="tabdays" style='width:220px'>Risk</th>
    <th class="tabsection" style='width:70px';>Lvl Before</th>
    <th class="tabdays" style='width:80px';>Type</th>
<!--     <th class="tabrequires" style='width:35px';>Edit</th> -->
    <th class="tabicon" style='width:35px';>Del</th>
  </tr>
  <?php             // idrisk, risk_name, matrix_before, task, typeE
  while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    echo ' <tr class="clickrow" data-url="index.php?pg=risk_edit&id='.$row["idrisk"].'&scr=R">
              <td>'.$row["risk_name"].'</td>
              <td>'.$row["task"].'</td>
              <td>'.$row["risk"].'</td>';
              $lvl=substr($row["matrix_before"],0,1);
              if ($lvl=="L") {echo '<td style="background-color:green">'.$row["matrix_before"];};
              if ($lvl=="M") {echo '<td style="background-color:yellow">'.$row["matrix_before"];};
              if ($lvl=="H") {echo '<td style="background-color:orange">'.$row["matrix_before"];};
              if ($lvl=="E") {echo '<td style="background-color:red">'.$row["matrix_before"];};
        echo '</td>';
              $queryt="SELECT * FROM RiskType Where idTypeE=".$row["typeE"];
              $resultt=mysqli_query($conaap,$queryt);
              $rowt= mysqli_fetch_array($resultt,MYSQLI_ASSOC);
              echo '<td>'.$rowt["risk_type"].'</td><td>';
              if ($_SESSION['admin']=='TRUE') {echo '<a href="index.php?pg=risk_edit&id='.$row["idrisk"].'&del=1"><img src="resource/del.png" width="30"></a>';}
              else {echo '<img src="resource/del_off.png" width="30">';}
                echo '</td>
           </tr>';
  }
  ?>
</table>
</div>

<script type="text/javascript">
$( document ).ready(function() {
  document.querySelector("#m4").style="Background-Color:black";
//	$('#risk_mat').hide();
  var $rows=$('#tabler tr');
//  $('#risk_mat').style.visibility='hidden';

  document.querySelector('#show').onclick = function() {
//    document.querySelector('#footer').style="display:none";
    $('#risk_mat').show();
//    $('#risk_mat').style.visibility='visible';
  };

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
