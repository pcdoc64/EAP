<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$con=mysqli_connect(DB_HOST,DBC_USER,DBC_PASSWORD,DBC_NAME);
if (!$conaap || !$con) {echo 'access denied<br>';}
if (isset($_GET['rts'])) {$rights=$_GET['rts'];} else {$rights=0;}
include('js/risklist.js');
include('php/risk_show.php');

//include 'resource/dbinclude_test.inc';
$remov='0';
$sql="SELECT idact_type, act_name FROM act_class ORDER by act_name";
$queryact = mysqli_query($conaap,$sql);
$rowcnt=mysqli_num_rows($queryact);
$parent_type="P";          // parent_type and parent_id are for risk_show.php

if (isset($_GET['id'])) {$parent_id=$_GET['id'];} else {$parent_id=0;}
$act_cls = array();
while($rowact = mysqli_fetch_assoc($queryact)) {
 $act_cls[] = $rowact;
}
$queryact = mysqli_query($conaap,$sql);
if ($PageName=='actv_edit' || $PageName=='page') {
  include('js/dnd.js');
}


if (isset($_GET['del'])) {$remov=$_GET['del'];}

?>

 <script>
 function checkLog() {
    var phpSessionId = document.cookie.match(/PHPSESSID=[A-Za-z0-9]+\;/i);
    //   alert (phpSessionId[0]);
    //  if(CheckUserSession('username') == false){
    //    window.location.replace("Location:../index.php?pg=log");

   }

function actvupdate(actid) {        // get all data from info page, push into formd array, then send through ajax call
  var rghts=<?php Print($rights); ?>;
  if (rghts) {
    if (!($("#joeys").prop('checked') || $("#cubs").prop('checked') || $("#scouts").prop('checked') || $("#vents").prop('checked') || $("#rovers").prop('checked') || $("#leaders").prop('checked') || $("#family").prop('checked'))) {
      alert ('Please tick which section this program is for.');
      $(".flipbook").turn("page",1);
    }

    var data=[];
    var formd=[];
    formd.push(document.getElementById('uid').value);
    formd.push(document.getElementById("actv").value);
    formd.push(document.getElementById("fromdate").value);
    formd.push(document.getElementById("fromtime").value);
    formd.push(document.getElementById("todate").value);
    formd.push(document.getElementById("totime").value);
    formd.push(document.getElementById("cost").value);
    formd.push(document.getElementById("woodbead").checked);
    formd.push(document.getElementById("special").checked);
    formd.push(document.getElementById("joeys").checked);
    formd.push(document.getElementById("cubs").checked);
    formd.push(document.getElementById("scouts").checked);
    formd.push(document.getElementById("vents").checked);
    formd.push(document.getElementById("rovers").checked);
    formd.push(document.getElementById("leaders").checked);
    formd.push(document.getElementById("family").checked);
    formd.push(document.getElementById("acttypepr").value);
    formd.push(document.getElementById("acttypeqbsi").value);
    formd.push(document.getElementById("acttypeqbsoa").value);
    formd.push(document.getElementById("acttypeother").value);
    formd.push(document.getElementById("swim").checked);
    formd.push(document.getElementById("pion").checked);
    formd.push(document.getElementById("arch").checked);
    formd.push(document.getElementById("cano").checked);
    formd.push(document.getElementById("bush").checked);
    formd.push(document.getElementById("4WD0").checked);
    formd.push(document.getElementById("abse").checked);
    formd.push(document.getElementById("snor").checked);
    formd.push(document.getElementById("boat").checked);
    formd.push(document.getElementById("rock").checked);
    formd.push(document.getElementById("cavi").checked);
    formd.push(document.getElementById("notes").value);

//    alert(idact);
//actid=80;formd='hello';
    $.ajax({
          url :"json/actupd.php",
          type: "post",
          datatype:'JSON',
          async: false,
          data:{
            activ:actid,
            data:formd,                  // all info form data
          },
          success:function(data){
//            alert (data);
//            logit('program', 'update1', 'actvupdate', document.getElementById("actv").value, 'all', '<?php echo $_SESSION['realname']; ?>');
          },
          error: function(XMLHttpRequest, textStatus, errorThrown){

            alert ('actvupdate:error');
          }
        });
      }
    }

 function popup_canc(){
   document.querySelector('#popup').style="display:none";
 }

 function popup_upd() {
   txt=document.getElementById('text_input').value;
   table1.rows[rowno].cells[colno].innerHTML=txt;          // put text back in td as innerHTML
   document.querySelector('#popup').style="display:none";
 }

 function prepRisk(riskno) {
   var data=["request:0"];
   getrisky('P',idact, riskno, 0, data)
 }

 </script>
<!--                                    Pop up Boxes    -->

 <div id="riskbox" class="riskl_form" style="width:180px; display:none">
   <a href="#" id="riskl_close" title="Close" class="close">X</a>
   <div class="popupboxb" id="risk_list">
     <p>Select the Risk, then click the arrow to add to the list
       </p>
     <table id="risktable" class="scroll_table" style="max-height:400px;" width="100%" border="1px solid black">
       <tr><td>Add</td><td>Risk</td></tr>
     </table>
   </div>
 </div>

 <div id="popup" class="popup">
   <a href="#" onclick="popup_canc()" title="Close" class="close">X</a>
   <textarea id="text_input" class="input"></textarea>
   <input type="submit" class="buttons" onclick="popup_upd()" name="update" value="Update"></input>
 </div>

<div id="poptime" class="time_slide">
 <a href="#" onclick="poptime_canc()" title="Close" class="close">X</a>
 <div class="timdif"><p class="slidrt" id="strt_slide"></p></div><div id="strt_amt">7:00</div>
</div>

<?php
$totpages=1;
if ($PageName=='actv_edit' || $PageName=='page') {

//                                    Get details of Activity and add to $row
  $cnti=0;
  $query="SELECT * FROM activities WHERE idact=".$_GET['id'];
  $result=mysqli_query($conaap,$query);
  $cnti=mysqli_num_rows($result);
  if ((!$result)||($cnti==0)) {echo "no result";}
//  $row=mysqli_fetch_array($result,MYSQLI_ASSOC)
  $row=$result->fetch_row();
  if ($remov=='1') {echo "<div id='PgTitle'>Delete Program</div>";} else {echo "<div id='PgTitle'>Program Edit - ".$row[1]."</div>";}
//                                    Get list of groups and name of ppl in groups select by name

} else {
  $sendmeto=array('1'=>'0');
  echo "<div id='PgTitle'>New Program</div>";
  $result=FALSE;
}
 ?>
<div class="flipbook-viewport">
	<div>
		<div id="fullbook" class="flipbook">
      <div class="hard" style="background-repeat: repeat; background-image:url('resource/leatherb.jpg');">          <!--                Front Cover     -->
        <br>
        <form action="php/actv_save.php" name="actvform" id="actvform" class="centered_form3" method="post">
            <div style="display:block; height:40px;">
<?php
              if ($rights==0) {$disp="none";} else {$disp="block";}
                if ($PageName=='actv_edit' && $remov=='0') {
                  echo '<input type="submit" id="butype" class="buttons" name="update" style="display:'.$disp.'" value="Update"></input>'; //   disable if add button pressed
                  echo '<button class="buttons" id="send_open" style="display:'.$disp.'" type="button">Share this!</button>';
                  echo '<button class="buttons" id="copy_open" style="display:'.$disp.'" type="button">Copy as new!</button>';
                } else {
                  echo '<button class="buttons" id="send_open" style="display:none" type="button">Share this!</button>';
                  echo '<button class="buttons" id="copy_open" style="display:none" type="button">Copy as new!</button>';
                  if ($remov=='0') { echo '<input type="submit" id="butype" class="buttons" name="add" style="display:'.$disp.'" value="Add"></input>';} //   disable if edit button pressed
                  if ($remov=='1') {echo '<input type="submit" class="buttons" id="delete" name="delete" style="display:'.$disp.'" value="Delete"></input>';}
                }

             echo '<input style="float:right" type="submit" class="buttons" id="cancel" name="cancel" value="Cancel"></input>';
?>
<?php
             include ('php/sendto.php');
?>

          </div>

          <div style="border: 0px solid #07839f; padding:5px">
            <input type="hidden" id="actvid" name="actvid" value='<?php if($result) {echo $row[0];}?>'>
            <input type="hidden" id="uid" name="uid" value='<?php if($result) {echo $_SESSION['uid'];}?>'>
            <br><br><label class="labela required" style="color:yellow">Program: </label>
            <input type="text" class="engraved" required id="actv" name="actv" style='text-align:center; height:50px; width:550px' <?php if (!$result) {echo 'placeholder="Enter your Program" ';} ?> value="<?php if($result) {echo $row[1];}?>"/></input>
            <br><br>
            <div style="width:660px">
              <div style="border: 1px solid #07839f; background-color: #dad4d4; width:300px; height:120px; float:left;padding:10px 10px 10px 10px;">
                <label class="labelas required" id="from">From:</label><input type="date" id="fromdate" name="fromdate" required style='width:115px' value="<?php if($result) {echo $row[3];} else {echo date("d/m/Y");}?>"/>
                <input type="time" id="fromtime" name="fromtime" style='width:95px' value="<?php if($result) {echo $row[4];} else {echo '00:00';}?>"/>
                <label class="labelas required" id="too">To: </label><input type="date" id="todate" required name="todate" style='width:115px' value="<?php if($result) {echo $row[5];} else {echo date("d/m/Y");}?>"/>
                <input type="time" id="totime" name="totime" style='width:95px' value="<?php if($result) {echo $row[6];} else {echo '00:00';}?>"/>
                <br><label class="labelas">Cost pp</label><input type="text" id="cost" name="cost" style="width:40px"   value="<?php if($result) {echo $row[10];} else {echo '0';}?>"><br><br>
                <label class="labelas">Requires: </label><input type="checkbox" id="woodbead" name="woodbead" value="wood" <?php if ($result) {if($row[8]) {echo 'checked';}}?>>Woodbeads</input>
                <input type="checkbox" id="special" name="special" value="spec" <?php if ($result) {if($row[9]) {echo 'checked';}}?>>Special</input>
              </div>

              <div name="sections" style="border: 1px solid #07839f; background-color: #dad4d4; width:310px; height:120px; float:right;padding:10px 10px 10px 10px;"><label class="labela required">Sections </label><br>
                <table>
                  <tr>
                    <td><input type="checkbox" name="section[]" id="joeys" value="joeys" <?php if ($result and (substr($row[7],0,1)=="1")) {echo 'checked';} ?>>Joeys</td>
                    <td><input type="checkbox" name="section[]" id="cubs" value="cubs" <?php if ($result and (substr($row[7],1,1)=="1")) {echo 'checked';} ?>>Cubs</td>
                    <td><input type="checkbox" name="section[]" id="scouts" value="scouts" <?php if ($result and (substr($row[7],2,1)=="1")) {echo 'checked';} ?>>Scouts</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="section[]" id="vents" value="vents" <?php if ($result and (substr($row[7],3,1)=="1")) {echo 'checked';} ?>>Venturers</td>
                    <td><input type="checkbox" name="section[]" id="rovers" value="rovers" <?php if ($result and (substr($row[7],4,1)=="1")) {echo 'checked';} ?>>Rovers</td>
                    <td><input type="checkbox" name="section[]" id="leaders" value="leaders" <?php if ($result and (substr($row[7],5,1)=="1")) {echo 'checked';} ?>>Leaders</td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="section[]" id="family" value="family" <?php if ($result and (substr($row[7],6,1)=="1")) {echo 'checked';} ?>>Family</td>
                  </tr>
                </table>
              </div>
              <div style="border: 1px solid #07839f; background-color: #dad4d4; height:110px; width:300px; float:left;padding:10px 10px 10px 10px;margin-top:10px;">
                <label class="labelb">P&R Sections  : </label><td style="width:200px"><input type="text" id="acttypepr" name="acttypepr" style='width:177px' <?php if (!$result) {echo 'placeholder="Relevant P&R Sections?" ';} ?> value="<?php if($result) {echo $row[12];}?>"/><br>
                <label class="labelb">QBSI Sections : </label><td style="width:200px"><input type="text" id="acttypeqbsi" name="acttypeqbsi" style='width:177px' <?php if (!$result) {echo 'placeholder="Relevant QBSI Sections?" ';} ?> value="<?php if($result) {echo $row[13];}?>"/><br>
                <label class="labelb">QB SOA P&P :</label><td style="width:200px"><input type="text" id="acttypeqbsoa" name="acttypeqbsoa" style='width:177px' <?php if (!$result) {echo 'placeholder="Relevant QB SOA P&P Sections?" ';} ?> value="<?php if($result) {echo $row[14];}?>"/><br>
                <label class="labelb">Other :</label><td style="width:200px"><input type="text" id="acttypeother" name="acttypeother" style='width:177px' <?php if (!$result) {echo 'placeholder="Relevant Other Rules and Regs?" ';} ?> value="<?php if($result) {echo $row[15];}?>"/><br>
              </div>

              <div style="border: 1px solid #07839f; background-color: #dad4d4; width:310px; height:110px; float:right;padding:10px 10px 10px 10px;margin-top:10px;">
                <label class="labelb" style="width:250px;">Check which Activities are included</label><br>
                <table>
                  <tr>
                    <td><input type="checkbox" name="activs[]" id="swim" value="swim" <?php if ($result and (substr($row[16],0,1)=="1")) {echo 'checked';}?>>Swimming</input></td>
                    <td><input type="checkbox" name="activs[]" id="pion" value="pion" <?php if ($result and (substr($row[16],1,1)=="1")) {echo 'checked';}?>>Pioneering</input></td>
                    <td><input type="checkbox" name="activs[]" id="arch" value="arch" <?php if ($result and (substr($row[16],2,1)=="1")) {echo 'checked';}?>>Archery</input><br></td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="activs[]" id="cano" value="cano" <?php if ($result and (substr($row[16],3,1)=="1")) {echo 'checked';}?>>Canoe/Kayak</input></td>
                    <td><input type="checkbox" name="activs[]" id="bush" value="bush" <?php if ($result and (substr($row[16],4,1)=="1")) {echo 'checked';}?>>Bushwalking</input></td>
                    <td><input type="checkbox" name="activs[]" id="4WD0" value="4WD0" <?php if ($result and (substr($row[16],5,1)=="1")) {echo 'checked';}?>>4WD</input><br></td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="activs[]" id="abse" value="abse" <?php if ($result and (substr($row[16],6,1)=="1")) {echo 'checked';}?>>Abseiling</input></td>
                    <td><input type="checkbox" name="activs[]" id="snor" value="snor" <?php if ($result and (substr($row[16],7,1)=="1")) {echo 'checked';}?>>Snorkeling</input></td>
                    <td><input type="checkbox" name="activs[]" id="boat" value="boat" <?php if ($result and (substr($row[16],8,1)=="1")) {echo 'checked';}?>>Boating</input></td>
                  </tr>
                  <tr>
                    <td><input type="checkbox" name="activs[]" id="rock" value="rock" <?php if ($result and (substr($row[16],9,1)=="1")) {echo 'checked';}?>>Rockclimbing</input></td>
                    <td><input type="checkbox" name="activs[]" id="cavi" value="cavi" <?php if ($result and (substr($row[16],10,1)=="1")) {echo 'checked';}?>>Caving</input></td>
                  </tr>
                </table>
              </div>
            </div>


            <div style="padding-top:295px">
              <textarea maxlength="450" cols="2" rows="8" wrap="soft" id="notes" name="notes" placeholder="add notes here" style="width:655px"><?php if($result) {echo $row[11];}?></textarea>
            </div>

          </div>
        </form>
      </div>

<?php
if ($PageName=='actv_edit' || $PageName=='page') {
  $totpages+=1;
  echo '<div><br>
          <div id="butbar"></div>
            <div id="slidrs">
              <div class="timdif">
                <div>Interval</div>
                <p class="slidr" id="dif_slide"></p>
                <div id="dif_amt">30 m</div>
              </div>
            </div>
            <div style="display:inline-block">
              <table id="table2" class="mytable2" style="max-height:600px";>
                <thead>
                  <tr class="tabhead">
                    <th>activity</th>
                  </tr>
                </thead>
                <tbody id="tbody2">';
    while($row= mysqli_fetch_assoc($queryact)) {
            echo '<tr class="tab2">
                    <td><span class="event" id="000-item'.$row["idact_type"].'" draggable="true" data-text="'.$row["act_name"].'">'.$row["act_name"].'</span></td>
                  </tr>';
    }
          echo '</tbody>
              </table>
            </div>
            <div style="display:inline-block;vertical-align:top;width:80%">
              <table id="table1" class="mytable">
                <thead>
                  <tr class="tabhead">
                    <th class="tabicon">Add</th>
                    <th class="tabicon">time</th>
                    <th colspan="5" style="width:120px;">activity</th>
                    <th style="width:80px;">location</th>
                    <th style="width:100px;">equip needed</th>
                    <th style="width:100px;">youth to bring</th>
                    <th style="width:80px;">leaders</th>
                    <th class="tabicon">Remove</th>
                  </tr>
                </thead>
                <tbody id="tableP">';
          echo '</tbody>
              </table>
            </div>
            <br><br>
            <div style="display:block"><input type="submit" class="buttons" onclick="showme()" name="showme" value="Save"></input><br><br></div>
            <div id="result" style="display:block"></div>
          </div>';

}
?>
<?php
if ($PageName=='actv_edit' || $PageName=='page') {
  $totpages+=1;
  echo '<div id="Risks" name="Risks">
          <div style="border: 1px solid #07839f; padding:5px">
            <table id="rtable" class="sorttable scroll_table" style="width:100%" border="1">
            </table>';
            if ($rights==1) {echo '<button style="background-color:lightblue" id="riskl_open" type="button">Click here to select from the Risk list</button>';}
                      else  {echo '<button style="background-color:lightblue" id="riskl_open" disabled type="button">Click here to select from the Risk list</button>';}
          echo '</div>
        </div>';
}
?>

		</div>
	</div>
</div>
<div id="tabholder" class="tabholder">
  <div id="tabinfo" class="tabinfo"><img src="resource/tabinfo.png"></div>
<?php
  if ($PageName=='actv_edit' || $PageName=='page') {
    echo '<div id="tabprog" class="tabprog"><img src="resource/tabprog.png"></div>          <div id="tabrisk" class="tabrisk"><img src="resource/tabrisk.png"></div>';
  }
?>
</div>
<script type="text/javascript">
function  dayz(stDate) {
  sDate=stDate.substr(0,2)+"/";
  $('#day'+stDate).addClass('active');
  $('#day'+old_stDate).removeClass('active');
  if (old_stDate>0) {checkLog();showme(old_stDate);}
  if (PageName=='update') {
    old_stDate=stDate;getprog(idact,stDate);
  }
}
</script>

<script type="text/javascript">
$( document ).ready(function() {

  var rghts=<?php Print($rights); ?>;if (!rghts) {$(':input').attr('readonly', 'readonly');}
  $().maxlength();
  if (document.body.contains(document.getElementById("butype"))) {
    if (document.getElementById("butype").name=="add") {PageName='add';} else {PageName='update';};
  } else {PageName='delete';}
  progdata=0;           // number of lines in program. 0 = new program, 0> = program exists
  var totpages = <?php echo json_encode($totpages); ?>;
  var book=document.getElementById('fullbook');
  var holder=document.getElementById('tabholder');
  var infoo=document.getElementById('tabinfo');
  var widt=book.offsetWidth/2;
  var hight=0-book.offsetHeight+100;
  holder.style["top"]=hight+'px';
  if (totpages>1) {
    var risk=document.getElementById('tabrisk');
    var prog=document.getElementById('tabprog');
    infoo.style["z-index"]=2;
    prog.style["z-index"]=1;
  }
  function pad(n) {return n<10 ? "0"+n:n;}

  function convertDate(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
  }
  if (document.getElementById("fromdate").value=="") {
    dt=Date.now();
    dd=dt.getDate();
    dm=dt.getMonth()+1;
    dy=dt.getFullYear();
    dty=pad(dy)+"-"+pad(dm)+"-"+pad(dd);
    document.getElementById("fromdate").value=dty;
    document.getElementById("todate").value=dty;
    document.getElementById("fromtime").value="07:00";
    document.getElementById("totime").value="18:00";

  }

  $("#notes").keypress(function(e) {
    var notesVal=$("#notes").val();
    var notesLen=notesVal.length;
    if (notesLen>449) {
      $("#notes").addClass("flash");
      setTimeout (function() {
        $("#notes").removeClass("flash");
      },500);

    }
  });

  numbdayz();

  function numbdayz() {
    var todat=document.getElementById("todate").value;
    if (todat.substr(0,2)=="00") {                              // if the date - 0000-00-00 then make it current date
      datme=new Date(pad(Date.now().getDate())+"/"+pad(Date.now().getMonth()+1)+"/"+Date.now().getFullYear());                            // if the date - 0000-00-00 then make it current date);
      document.getElementById("todate").value=datme.substr(0,10);
      var todat=(document.getElementById("todate").value);
    }
    if (todat.substr(2,1)=="/") {todat=todat.substr(6,4)+"-"+todat.substr(3,2)+"-"+todat.substr(0,2);}
    var todat1=Date.parseExact(todat,"yyyy-MM-dd");
    var fintodate=(pad(todat1.getDate())+"/"+pad(todat1.getMonth()+1)+"/"+todat1.getFullYear()).substr(0,10);
    var todat=document.getElementById("fromdate").value;
    if (todat.substr(0,2)=="00") {
      datme=new Date(pad(Date.now().getDate())+"/"+pad(Date.now().getMonth()+1)+"/"+Date.now().getFullYear());                            // if the date - 0000-00-00 then make it current date);
      document.getElementById("fromdate").value=datme.substr(0,10);
      var todat=(document.getElementById("fromdate").value);
    }
    orgDate=todat.substr(8,2)+todat.substr(5,2)+todat.substr(0,4);
    if (todat.substr(2,1)=="/") {todat=todat.substr(6,4)+"-"+todat.substr(3,2)+"-"+todat.substr(0,2);}
    var todat2=Date.parseExact(todat,"yyyy-MM-dd");
    var finfromdate=pad(todat2.getDate())+"/"+pad(todat2.getMonth()+1)+"/"+todat2.getFullYear();;
    var totday=((todat1-todat2)/(60*60*24*1000)); // Date.parse produces result in milliseconds, convert back with /(60*60*24*1000)
    var butHTML="";
    for (i=0;i<=totday;i++) {
      if (i>0) {
        var strdate=todat2.addDays(1);
      } else {
        strdate=todat2;
      }
      var sdate=pad(strdate.getDate())+"/"+pad(strdate.getMonth()+1)+"/"+strdate.getFullYear();
      var stdate=sdate.substr(0,2)+sdate.substr(3,2)+sdate.substr(6,4);
      butHTML+='<input type="button" class="buttdayz" onclick="dayz(&apos;'+stdate+'&apos;)" id="day'+stdate+'" name="dayz_butt" value="'+sdate+'"></input>';
    }
    $('#butbar').html(butHTML);
    active_date();
  }

    // set first tab on program page active
  function active_date() {
    var tdt=document.getElementById("fromdate").value;
    if (tdt.substr(2,1)=="/") {tdt=tdt.substr(6,4)+"-"+tdt.substr(3,2)+"-"+tdt.substr(0,2);}
    var dt=Date.parseExact(tdt,"yyyy-MM-dd");
    var sdt=pad(dt.getDate())+"/"+pad(dt.getMonth()+1)+"/"+dt.getFullYear();
    old_stDate=sdt.substr(0,2)+sdt.substr(3,2)+sdt.substr(6,4);
    $('#day'+old_stDate).addClass('active');
  }
  $("#fromtime").change(function() {
    if (progdata==1) {
      document.getElementById('time').textContent=document.getElementById('fromtime').value;
    }
  });

  $(window).bind("unload", function () {
  //window.onunload = function (e) {
  //  e = e || window.event;
  // For IE and Firefox
  //  if (e) {
      message="saved";
      if (PageName=='update' || PageName=='add') {
        document.getElementById('butype').click();
        if (totpages>1) {
          actvupdate(idact);
            checkLog();
            showme(old_stDate);
        }
        if (PageName=='update') pgn="update";
        if (PageName=='add') pgn="add";
        if (PageName=='delete') pgn="delete";
        logit('program', pgn, document.getElementById("actv").value, 'all', 'all', '<?php echo $_SESSION['realname']; ?>');
      }

    return message;
  });

loadApp();

function loadApp() {
	$('.flipbook').turn({
			width:900,
			height:1300,
			elevation: 0,
		  gradients: true,
			autoCenter: true,
      display:'single'

	  });
    $(".flipbook").bind("start", function(event, pageObject, corner) {
        if (corner != null) {
          $('.flipbook').turn('data').hover=true;
          return event.preventDefault();
        }
    });
    $(".flipbook").bind("turning", function(event, pageObject, corner) {
        if ($(".flipbook").turn('data').hover) {
          $(".flipbook").turn('data').hover=false;
          event.preventDefault();
        }
      });
    $(".flipbook").bind("turned", function(event, pageObject, corner) {
        if (pageObject==1) {
          if (totpages>1) {
            checkLog();
            actvupdate(idact);
            showme(old_stDate);
            numbdayz();
          }
        }
        if (pageObject==2) {
          if (totpages>1) {
            getprog(idact,old_stDate);
            actvupdate(idact);
            numbdayz();
          }
        }
        if (pageObject==3) {
          checkLog();
          getrisk('V','0',idact,'','','0','');
          risklst('V',idact);
          actvupdate(idact);
          showme(old_stDate);
          numbdayz();
        }
    });

  }

  idact = (parseInt(document.querySelector('#actvid').value));
  if (PageName=='update') {
    getprog(idact,old_stDate);
  }

  $('#fromdate').change(function() {
    trickDate();
  });
  $('#todate').change(function() {
    trickDate();
  });

  function trickDate() {
    fromD=Date.parseExact(document.getElementById("fromdate").value,"yyyy-MM-dd");
    toD=Date.parseExact(document.getElementById("todate").value,"yyyy-MM-dd");
    if (fromD>toD) {document.getElementById('todate').value=document.getElementById("fromdate").value;}
    if (toD<fromD) {document.getElementById('fromdate').value=document.getElementById("todate").value;}
  }

  document.querySelector('#tabinfo').onclick = function() {
    $(".flipbook").turn("page",1);
  }

  if (totpages>1) {
    document.querySelector('#tabprog').onclick = function() {
      $(".flipbook").turn("page",2);
    }
    document.querySelector('#tabrisk').onclick = function() {
      $(".flipbook").turn("page" , totpages);
    }
  }

  document.querySelector("#m2").style="Background-Color:black";

  if (PageName=='Update') {document.querySelector('#copy_name').value="Copy of "+document.querySelector('#actv').value;}

//                get data from php array $sendmeto and load into two Jscript arrays
  if (idact>0) {
    var gname = <?php echo json_encode($sendmeto); ?>;
    gname.splice(0,2);
    var SelGName={};  var SelGroup={};  newHTML=newHTMLn='';
    for (var i in gname) {
      newHTML+='<option value='+i+'>'+gname[i]['gid']+'</option>';
      SelGName[i]=gname[i][0];
      if (i==0) {
        for (var j in gname[i][0]) {
          newHTMLn+='<option value='+i+'>'+gname[i][0][j]+'</option>';
    } } };

//          put the HTML options list into the dropdown for share this box
    $('#gname').html(newHTML);  // groups
    $('#lname').html(newHTMLn); // names
  }

  if (isNaN(idact)) idact=0;
  if (idact>0) {
    getrisk('V','0',idact,'','','0','');
    risklst('V',idact);
  }

  document.querySelector('#gname').onclick = function() {
    Selnum=this.value;
        // remove all items in names dropdown list for 'share with' box
    lnm=document.getElementById("lname");
    len=lnm.options.length;
    $("#lname").empty();
    newHTMLn='';
    for (var j in gname[Selnum][0]) {
      newHTMLn+='<option value='+i+'>'+gname[Selnum][0][j]+'</option>';
    }
    $('#lname').html(newHTMLn); // write names to select dropdown
  }

  if (idact>0) {
    document.querySelector('#riskl_open').onclick = function() {
      $('#riskbox').show();
    };
    document.querySelector('#riskl_close').onclick = function() {
      $('#riskbox').hide();
    };
    document.querySelector('#send_open').onclick = function() {
      $('#sendbox').show();
      $('#copybox').hide();
    };
    document.querySelector('#send_close').onclick = function() {
      $('#sendbox').hide();
    };
    document.querySelector('#copy_open').onclick = function() {
      $('#copybox').show();
      $('#sendbox').hide();
    };
    document.querySelector('#copy_close').onclick = function() {
      $('#copybox').hide();
    };
    document.querySelector('#cancel').onclick = function() {
      window.open('index.php?pg=actv', '_self')
    };
  }

  if (isFirefox) {
    var df=document.getElementById("fromdate").value;
    var dt=document.getElementById("todate").value;
    if (document.getElementById("actvid").value<1) {
      var fd=new Date();
      var mths=((fd.getMonth().length+1)===1)? (fd.getMonth()+1) : '0'+(fd.getMonth()+1);
      var nd=fd.getFullYear()+"-"+mths+"-"+fd.getDate();
      df=dt=nd;
    };
    df=convertDate(df);document.getElementById("fromdate").value=df;
    dt=convertDate(dt);document.getElementById("todate").value=dt;
    document.getElementById("fromdate").className="datepick";
    document.getElementById("todate").className="datepick";
    $(function() { $( ".datepick" ).datepicker({ dateFormat: 'dd/mm/yy' }); });
//    $("#activity div label").width(77);
  }
  getQBSI('P');
  getPR('P');


})
</script>
