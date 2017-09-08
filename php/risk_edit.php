<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
$remov='0';
if (isset($_GET['del'])) {$remov=$_GET['del'];}
if ($PageName=='risk_edit') {
  if ($remov=='1') {echo "<div id='PgTitle'>Delete Risk Item</div>";} else {echo "<div id='PgTitle'>Edit Risk Item</div>";}
  $cnti=0;
  $query="SELECT * FROM risk WHERE idrisk=".$_GET['id'];
  //echo $query;
  $result=mysqli_query($conaap,$query);
  $cnti=mysqli_num_rows($result);
  if ((!$result)||($cnti==0)) {echo "no result";}
  $row=$result->fetch_row();
} else {
  echo "<div id='PgTitle'>New Risk</div>";
  $result=FALSE;
}
include 'js/qbsi_add.js';
echo '<div class="centered_form2">
  <form action="php/risk_save.php" id="riskform" method="post">';
  include ("php/sel_risk_matrix.php");
    if ($PageName=='risk_edit' && $remov=='0') {
      echo '<input type="submit" class="buttons" name="update" value="Update"></input>'; //   disable if add button pressed
    } else {
      if ($remov=='0') {echo '<input type="submit" class="buttons" name="add" value="Add"></input>';} //   disable if edit button pressed
    }
    if ($remov=='1') {echo '<input type="submit" class="buttons" name="delete" value="Delete"></input>';}
?>
<input style="float:right" type="submit" class="buttons" name="cancel" value="Cancel"></input>
<script>
function show_risk() {
  document.querySelector('#risk_mat').style="display:visible ";
  lvel="B";
  $('#risk_mat').show();
//    $('#risk_mat').style.visibility='visible';
};
function show_risk2() {
  lvel="A";
  $('#risk_mat').show();
//    $('#risk_mat').style.visibility='visible';
};
function mat_close() {
  document.querySelector('#risk_mat').style="display:none";
}
function addQBSIrisk(caller, QBnum) {
  qbsval=document.getElementById("qbsi");
  if (qbsval.value>"") {
    qbsval.value+=", "+QBnum;
  } else {
    qbsval.value=QBnum;
  }
}
</script>
<div id="qbsibox" class="qbsi_form" style="display:none";>
  <a href="#" id="qbsi_close" title="Close" class="close">X</a>
  <div class="popupboxb" id="qbsi_list">
    <p>Select the item from QBSI, click the arrow to add</p>
    <table id="qbsipanel" class="scroll_table" style="max-height:400px;border: 1px solid #07839f;">

    </table>
  </div>
</div>

<div id="prbox" class="pr_form" style="display:none";>
  <a href="#" id="pr_close" title="Close" class="close">X</a>
  <div class="popupboxb" id="risk_list">
    <p>Select the P&R Item, then click the arrow to add </p>
    <table id="prtable" class="scroll_table" style="max-height:400px;" width="100%" border="1px solid black">
    </table>
  </div>
</div>

      <div style="border: 1px solid #07839f; padding:5px">
        </br></br>
      <input type="hidden" id="scr" name="scr" value='<?php
      if ($result) {
        if (isset($GET['scr'])) {
          echo "R"+$_GET['scr'];
        }
      } else {
        echo 'R';
      }

      ?>'>
      <input type="hidden" id="riskid" name="riskid" value='<?php if($result) {echo $row[0];}?>'>
      <label class="labela">Title of Risk : </label><td style="width:460px"><input type="text" id="riskname" name="riskname" style='width:460px' <?php if (!$result) {echo 'placeholder="Give the Risk a Title" ';} ?> value="<?php if($result) {echo $row[1];}?>"/><br>
    </div>
    <div style="border: 1px solid #07839f; padding:5px">
      <label class="labela" id="tpyE">Risk Type: </label>
      <select id = "typeE" name="typeE" style="width:170px"   value="<?php echo $row[8];?>">
        <?php
          $queryt="SELECT * FROM RiskType ORDER By risk_type";
          $resultt=mysqli_query($conaap,$queryt);
          $cntit=mysqli_num_rows($resultt);
          if ((!$resultt)||($cntit==0)) {echo "no result";}
//          $rowt=$resultt->fetch_row();

          while($rowt= mysqli_fetch_array($resultt,MYSQLI_ASSOC)) {
//          echo var_dump($rowt);
              echo '<option ';
              if(($result) and ($row[8]==$rowt['idTypeE'])){echo("selected");}
              echo " value = ".$rowt['idTypeE'].">".$rowt['risk_type']."</option>";
          }
        ?>
      </select><br>
      <label class="labela" id="tsk">Task: </label><textarea rows="3" wrap="soft" id="task" name="task" style="width:460px"><?php if($result) {echo $row[3];}?></textarea>
      <label class="labela" id="rsk">Risk: </label><textarea rows="3" wrap="soft" id="risk" name="risk" style="width:460px"><?php if($result) {echo $row[4];}?></textarea>
      <label class="labela" id="mt_before">Level before: </label><input onclick='show_risk()' type="text" id="mat_before" name="mat_before" style="width:70px;" value="<?php if($result) {echo $row[2];}?>"><br>
      <label class="labela" id="mtigate">Mitigation: </label><textarea rows="3" wrap="soft" id="mitig" name="mitig" style="width:460px"><?php if($result) {echo $row[6];}?></textarea>
      <label class="labela" align="top" id="mt_after">Level After: </label><input onclick='show_risk2()'type="text" id="mat_after" name="mat_after" style="width:70px"   value="<?php if($result) {echo $row[5];}?>"><br>
      <label class="labela" id="refr">Refer to: </label>
      <input type="checkbox" id="refsb" name="refsb" value="" <?php if ($result) {if($row[7]==1||$row[7]==3) {echo 'checked';}}?>>Branch</input>
      <input type="checkbox" id="refsr" name="refsr" value="" <?php if ($result) {if($row[7]==2||$row[7]==3) {echo 'checked';}}?>>Region</input>
    </div>
    <div style='border: 1px solid'>
      <label class="labela">Notes:</label><textarea cols="2" rows="3" wrap="soft" id="notes" name="notes" style="width:460px"><?php if($result) {echo $row[9];}?></textarea>
      <label id="qbsid" class="labela plusd">QBSI:</label><textarea cols="2" rows="2" wrap="soft" id="qbsi" name="qbsi" style="width:460px"><?php if($result) {echo $row[10];}?></textarea>
      <label id="prd" class="labela plusd">P&R : </label><textarea cols="2" rows="2" wrap="soft" id="pr" name="pr" style="width:460px"><?php if($result) {echo $row[11];}?></textarea>
      <label class="labela">Other: </label><textarea cols="2" rows="2" wrap="soft" id="other" name="other" style="width:460px"><?php if($result) {echo $row[12];}?></textarea>
    </div>
</form>
</div>

<script type="text/javascript">
$( document ).ready(function() {
  document.querySelector("#m4").style="Background-Color:black";
  lvel="";
  rlvel=""
  $('#risk_mat').hide();

  getQBSI('R');
  getPR('R');

var acc = document.getElementsByClassName("accordian");
var i;
for (i = 0; i < acc.length; i++) {
  acc[i].onclick = function(){
    this.classList.toggle("active");
    /* Toggle between hiding and showing the active panel */
    var panel = this.nextElementSibling;
    if (panel.style.display === "inline-block") {
        panel.style.display = "none";
    } else {
        panel.style.display = "inline-block";
    }
  }
}

  blvel=document.querySelector('#mat_before').value;
  alvel=document.querySelector('#mat_after').value;
  var lvb=blvel.charAt(0);
  var lva=alvel.charAt(0);
  colra=colrb="";

  if (lva=="L") {colra="green";};
  if (lva=="M") {colra="yellow";};
  if (lva=="H") {colra="orange";};
  if (lva=="E") {colra="red";};
  if (lvb=="L") {colrb="green";};
  if (lvb=="M") {colrb="yellow";};
  if (lvb=="H") {colrb="orange";};
  if (lvb=="E") {colrb="red";};
  document.getElementById("mat_before").style.backgroundColor=(colrb);
  document.getElementById("mat_after").style.backgroundColor=(colra);

  $("#qbsid").click(function() {
    $('#qbsibox').show();
  })
  document.querySelector('#qbsi_close').onclick = function() {
    $('#qbsibox').hide();
  };
  $("#prd").click(function() {
    $('#prbox').show();
  })
  document.querySelector('#pr_close').onclick = function() {
    $('#prbox').hide();
  };
  $(".brder td").click(function() {
    rlvel=(this.innerHTML);
    var lv=rlvel.charAt(0);
    colr="";
    if (lv=="L") {colr="green";};
    if (lv=="M") {colr="yellow";};
    if (lv=="H") {colr="orange";};
    if (lv=="E") {colr="red";};
    if (lvel=="B") {
      document.querySelector('#mat_before').value=rlvel;
      document.getElementById("mat_before").style.backgroundColor=(colr);
    } else {
      document.querySelector('#mat_after').value=rlvel;
      document.getElementById("mat_after").style.backgroundColor=(colr);

      if (lv=='L') {document.querySelector("#refsr").checked=false;document.querySelector("#refsb").checked=false;}
      if (lv=='M') {document.querySelector("#refsr").checked=true;document.querySelector("#refsb").checked=false;}
      if (lv=='H'||lv=='E') {document.querySelector("#refsb").checked=true;document.querySelector("#refsr").checked=false;}
    }
    $('#risk_mat').hide();
  });
});
</script>
