<?php
  $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  $query="SELECT aap.idAAP, aap.siteid, aap.site_location, aap.idact, aap.idacttype, aap.incharge, aap.from_date, aap.C4_section,sact.rights FROM AAP AS aap JOIN shareevent as sact ON aap.idAAP=sact.idAAP WHERE sact.uid='".$_SESSION['uid']."'ORDER BY aap.from_date DESC";
  $result=mysqli_query($conaap,$query);
//  $rowsr=mysqli_num_rows($result);
//  echo 'rows '.$rowsr.'';
//  if(!$result) {header('location:index.php?pg=aap_add');}
?>
<div id="aboutAAP" class="centered_form" style="display:none";>
  <a href="index.php?pg=aap" id='close' title="Close" class="close">X</a>
  <div class="div_form" id="aboutAAP" >
    <p>What is the Event Package for?</p>
  </div>
</div>

<div id='PgTitle'>Event Packs</div>
<div id='buttdiv'>
  <button class='buttona' style="width:180px" id="show">About the Event Package</button>
  <input type="button" class="buttons" value="New Event Pack" onclick="location.href='index.php?pg=aap_add&rts=1';"></input>
</div>

<div class="aap_table">
  <input type="text" id="search" placeholder="Type to search">
  <table id="tabler" class="sortable scroll_table" style="width:100%" border='1'>
    <tr style="color:blue;">
      <th class="tabdate2">Date</th>
      <th class="tabsite">Site</th>
      <th class="tabloc">Location</th>
      <th class="tabtype">Type</th>
      <th class="tabactv">Activity</th>
      <th class="tabsect">Section</th>
      <th class="tabicon">Del</th>
    </tr>
    <?php
    $stmts = mysqli_prepare($conaap, "SELECT site_name FROM sites WHERE siteid = ?");
    $stmta = mysqli_prepare($conaap, "SELECT activity_name FROM activities WHERE idact = ?");
    $stmtt = mysqli_prepare($conaap, "SELECT activ_name FROM activType WHERE idacttype = ?");

    if($result) {
      while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
/*  get site name and location from idsite
    get activity name from activities
    get list of risks from RiskAAP using idAAP
*/
        mysqli_stmt_bind_param($stmts,'s',$row["siteid"]);
        mysqli_stmt_execute($stmts);
        mysqli_stmt_bind_result($stmts, $sname);
        mysqli_stmt_fetch($stmts);
        mysqli_stmt_free_result($stmts);
        mysqli_stmt_bind_param($stmta,'s',$row["idact"]);
        mysqli_stmt_execute($stmta);
        mysqli_stmt_bind_result($stmta, $aname);
        mysqli_stmt_fetch($stmta);
        mysqli_stmt_free_result($stmta);
        mysqli_stmt_bind_param($stmtt,'s',$row["idacttype"]);
        mysqli_stmt_execute($stmtt);
        mysqli_stmt_bind_result($stmtt, $tname);
        mysqli_stmt_fetch($stmtt);
        mysqli_stmt_free_result($stmtt);

        $sect=""; $sec=$row["C4_section"];
        if (substr($sec,0,1)=='1') {$sect='Joeys ';}
        if (substr($sec,1,1)=='1') {$sect.='Cubs ';}
        if (substr($sec,2,1)=='1') {$sect.='Scouts ';}
        if (substr($sec,3,1)=='1') {$sect.='Vents ';}
        if (substr($sec,4,1)=='1') {$sect.='Rovers';}
        if (substr($sec,5,1)=='1') {$sect.='Leaders ';}
        if (substr($sec,0,4)=="1111") {$sect="Group";}

        echo ' <tr class="clickrow" data-url="index.php?pg=aap_edit&id='.$row["idAAP"].'&rts='.$row["rights"].'">
                  <td>'.date("d/m/Y",strtotime($row["from_date"])).'</td>
                  <td>'.$sname.' - '.$row["incharge"].'</td>
                  <td>'.$row["site_location"].'</td>
                  <td>'.$tname.'</td>
                  <td>'.$aname.'</td>
                  <td>'.$sect.'</td>
                  <td><a href="index.php?pg=aap_edit&id='.$row["idAAP"].'&del=1"><img src="resource/del.png" width="30"></a></td>
                  </tr>
                </tr>';
      }
    }
    ?>
  </table>
</div>

<script>
$( document ).ready(function() {
  document.querySelector("#m1").style="Background-Color:black";
  var $rows=$('#tabler tr');

  document.querySelector('#show').onclick = function() {   // show about box
//    document.querySelector('#footer').style="display:none";
    $('#aboutAAP').show('fast','linear');
  };
    document.querySelector('#close').onclick = function() {
//      document.querySelector('#footer').style="display:initial";
      $('#aboutAAP').hide('fast');
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
