<?php include ("php/sel_risk_matrix.php");
  include 'js/qbsi_add.js';
 ?>
<div id="risk_upd" style="display:none">
  <div>Edit Risk Item</div>
  <div class="centered_form2R">
    <a href="javascript:void(0)" class="buttons" onclick="postRisk()" id="updaterisk">Update</a>
    <a href="javascript:void(0)" class="buttons" onclick="canc_risk()" name="cancel" style="float:right">Cancel</a>

<script>
function addQBSIrisk(caller, QBnum) {
  qbsval=document.getElementById("qbsi");
  if (qbsval.value>"") {
    qbsval.value+=", "+QBnum;
  } else {
    qbsval.value=QBnum;
  }
}

$("#notes2").keypress(function(e) {
  var notesVal=$("#notes2").val();
  var notesLen=notesVal.length;
  if (notesLen>349) {
    $("#notes2").addClass("flash");
    setTimeout (function() {
      $("#notes2").removeClass("flash");
    },500);

  }
});

function getrisky(type, partnid, riskid, readit, datae) {           // type = S,P,E (Site, Program, Event)
                                                                    // readit= 0 to read, 1 to update
//  alert ('type='+type+", partnid="+partnid+", riskid="+riskid+", readit="+readit+", datae="+datae);
  $.ajax({                                               // partnid=id or site,program or event
        url :"json/riskupd.php",                           // datae= if 0 no data, if 1 data to display risk item
        type: "post",
        datatype:'JSON',
        data:{
          type:type,
          partnid:partnid,
          riskid:riskid,
          readit:readit,
          dat:datae,
        },
        success:function(data){
          var datam=jQuery.parseJSON(data);
          if (readit==0 && type=="C" && datam.length==0) {alert ("caught it");return;}
//          alert (data);
          if (readit==1) {document.getElementById("risk_upd").style="display:none"; return;}  // risk data updated, return and close risk popup
          document.querySelector("#riskid").value=datam[0].idrisk;
          document.querySelector("#riskname").value=datam[0].risk_name;
          document.querySelector("#task").value=datam[0].task;
          document.querySelector("#risk").value=datam[0].risk;
          var colra=colrb="";
          lvb=datam[0].matrix_before.charAt(0);
          lva=datam[0].matrix_after.charAt(0);
          if (lva=="L") {colra="green";};
          if (lva=="M") {colra="yellow";};
          if (lva=="H") {colra="orange";};
          if (lva=="E") {colra="red";};
          if (lvb=="L") {colrb="green";};
          if (lvb=="M") {colrb="yellow";};
          if (lvb=="H") {colrb="orange";};
          if (lvb=="E") {colrb="red";};
          document.querySelector("#mat_before").value=datam[0].matrix_before;
          document.querySelector("#mitig").value=datam[0].mitigation;
          document.querySelector("#mat_after").value=datam[0].matrix_after;
          document.querySelector("#mat_before").style.backgroundColor=(colrb);
          document.querySelector("#mat_after").style.backgroundColor=(colra);
          if (datam[0].refer=="2") {document.querySelector("#refsr").checked=true;}
          if (datam[0].refer=="1") {document.querySelector("#refsb").checked=true;}
          document.querySelector("#notes2").value=datam[0].notes;
          document.querySelector("#qbsi").value=datam[0].QBSI;
          document.querySelector("#pr").value=datam[0].PR;
          document.querySelector("#other").value=datam[0].other;

        },
        error: function(xhr, status, error){
          var err = "(" + xhr.responseText + ")";
          alert ('getrisky:error - '+err.message);
        }
      });
//      if (readit==0 && type=="C" && datam.length==0) {alert ("caught exit");}
      document.getElementById("risk_upd").style="display:visible";
    }

function postRisk() {
  var datae=Array();
  datae[0]=document.getElementById('mat_after').value;
  datae[1]=document.getElementById('mitig').value;
  if (document.getElementById('refsb').checked==true) {datae[2]='1';}
  if (document.getElementById('refsr').checked==true) {datae[2]='2';}
  if (document.getElementById('refsb').checked==false && document.getElementById('refsr').checked==false) {datae[2]='0';}
  datae[3]=document.getElementById('notes2').value;
  datae[4]=document.getElementById('qbsi').value;
  datae[5]=document.getElementById('pr').value;
  datae[6]=document.getElementById('other').value;
  var riskid=document.getElementById('riskid').value;
  if (document.getElementById("actvid")) {var type="P"; var partnid=document.getElementById('actvid').value;}
  if (document.getElementById("siteid")) {var type="S"; var partnid=document.getElementById('siteid').value;}
  if (document.getElementById("idAAP")) {var type="E"; var partnid=document.getElementById('idAAP').value;}
  if (document.getElementById("idact_type")) {var type="T"; var partnid=document.getElementById('idact_type').value;}
//  alert ("type - "+type+", partnid - "+partnid+", riskid - "+riskid+", datae - "+datae.mat_after);
  getrisky(type, partnid, riskid, 1, datae)
}

function show_risk() {
  document.querySelector('#risk_mat').style="display:visible ";
  lvel="B";
  $('#risk_mat').show();
};

function show_risk2() {
  lvel="A";
  $('#risk_mat').show();
};

function mat_close() {
  document.querySelector('#risk_mat').style="display:none";
}

function canc_risk() {
  document.getElementById("risk_upd").style="display:none";
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
    <table id="prpanel" class="scroll_table" style="max-height:400px;" width="100%" border="1px solid black">
    </table>
  </div>
</div>

    <div style="padding:5px">
    </br></br><input type="hidden" id="riskid"></input>
      <label class="labela">Title of Risk : </label><td style="width:460px"><input type="text" id="riskname" name="riskname" style='width:460px'></input><br>
    </div>
    <div style="padding:5px">

      <label class="labela" id="tsk">Task: </label><textarea rows="3" wrap="soft" id="task" name="task" style="width:460px"></textarea>
      <label class="labela" id="rsk">Risk: </label><textarea rows="3" wrap="soft" id="risk" name="risk" style="width:460px"></textarea>
      <label class="labela" id="mt_before">Level before: </label><input onclick='show_risk()' type="text" id="mat_before" name="mat_before" style="width:70px;" value=""><br>
      <label class="labela" id="mtigate">Mitigation: </label><textarea rows="3" wrap="soft" id="mitig" name="mitig" style="width:460px"></textarea>
      <label class="labela" align="top" id="mt_after">Level After: </label><input onclick='show_risk2()'type="text" id="mat_after" name="mat_after" style="width:70px" value=""><br>
      <label class="labela" id="refr">Refer to: </label>
      <input type="checkbox" id="refsb" name="refsb" value=""  {echo 'checked';}>Branch</input>
      <input type="checkbox" id="refsr" name="refsr" value=""  {echo 'checked';}>Region</input>
    </div>
    <div>
      <label class="labela">Notes:</label><textarea maxlength-"350" cols="2" rows="3" wrap="soft" id="notes2" name="notes2" style="width:460px"></textarea>
      <label id="qbsid" class="labela plusd">QBSI:</label><textarea cols="2" rows="2" wrap="soft" id="qbsi" name="qbsi" style="width:460px"></textarea>
      <label id="prd" class="labela plusd">P&R : </label><textarea cols="2" rows="2" wrap="soft" id="pr" name="pr" style="width:460px"></textarea>
      <label class="labela">Other: </label><textarea cols="2" rows="2" wrap="soft" id="other" name="other" style="width:460px"></textarea>
    </div>
  </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
  lvel="";
  rlvel=""
  $('#risk_mat').hide();

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

  //add P&R items to prtable
  Phtml="";
});
</script>
