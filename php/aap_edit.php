<?php
if (isset($_GET['rts'])) {$rights=$_GET['rts'];} else {$rights=0;}
include('js/risklist.js');
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$con=mysqli_connect(DB_HOST,DBC_USER,DBC_PASSWORD,DBC_NAME);
if (!$conaap) {echo 'access denied<br>';}
$remov='0';
if (isset($_GET['del'])) {$remov=$_GET['del'];}
if ($PageName=='aap_edit') {
  if ($remov=='1') {echo "<div id='PgTitle'>Delete Package</div>";} else {echo "<div id='PgTitle'>Edit Package</div>";}
  $query="SELECT * FROM AAP WHERE idAAP=".$_GET['id'];
  //echo $query;
  $result=mysqli_query($conaap,$query);
  $row=$result->fetch_row();

  // add php sent to sendto.php back here
} else {$sendmeto=NULL;
  echo "<div id='PgTitle'>New Package</div>";
  $result=FALSE;
}
$parent_type="E";           // parent_type and parent_id are for risk_show.php
if (isset($_POST['id'])) {$parent_id=$_GET['id'];} else {$parent_id=0;}
include('php/risk_show.php');
include ('php/sendto.php');
?>
<script>
var firstrun=0;

function openAAP(evt, itm) {
  nab=1;
  if (itm=="forms") {                                  //  Check Equip items are not all N/A before showing forms page
    var ckd=[]; var nab=0;
    $('input:radio').each(function () {
      var $this=$(this),
          id=$this.attr('id');
      if (($(this).prop('id')).substr(0,3)=='min') {
        if ($(this).prop('checked')) {
          if ($(this).prop('value')!=='3') {nab=1;}
//          alert ($(this).prop('id')+'-'+$(this).prop('value'));
        }
      }
    })

  }
  if (firstrun==1) {
    if (document.getElementById("siteid").value=="Select") {alert ('You need to select a Site first');itm="activity";}
    if (document.getElementById("C5_activ").value=="Select") {alert ('You need to select a Program first');itm="activity";}
  }
  if (nab==0) {alert ('Fill out F31 Equipment section first before printing');}
  else {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the link that opened the tab
    document.getElementById(itm).style.display = "block";
    evt.currentTarget.className += " active";
  }
}

function prepRisk(riskno) {
  var data=["request:0"];
  AAPid=document.getElementById("idAAP").value;
  getrisky('C',AAPid, riskno, 0, data)
}
</script>

  <form action="php/aap_save.php" class="aap_form" id="aapform" method="post">
    <?php
    if ($PageName=='aap_edit' && $remov=='0') {
      echo '<input type="submit" class="buttons" id="pgbutton" name="update" value="Save"></input>'; //   disable if add button pressed
      echo '<button class="buttons" id="send_open" type="button">Share this!</button>';
     echo '<button class="buttons" id="copy_open" type="button">Copy as new!</button>';
    } else {if ($remov=='0') {echo '<input type="submit" class="buttons" id="pgbutton" name="add" value="Add"></input>';
      echo '<button class="buttons" id="send_open" style="display:none" type="button">Share this!</button>';
      echo '<button class="buttons" id="copy_open" style="display:none" type="button">Copy as new!</button>';

    } }
    if ($remov=='1') {echo '<input type="submit" class="buttons" id="pgbutton" name="delete" value="Delete"></input>';}

   ?>
    <label style="width:400px; text-align:center; display:inline-block" id="event_name"></label>
    <input style="float:right" type="button" class="buttons" id="cancel" name="cancel" value="Cancel"></input>
    <?php if ($_SESSION["admin"]=='FALSE') {echo '<input style="float:left" disabled type="submit" class="buttons" name="Submit" value="submit"></input>';} ?>
<!--                                                                  Risk List goes here -->
    <div id="riskbox" class="riskl_form" style="display:none";>
      <a href="#" id="riskl_close" title="Close" class="close">X</a>
      <div class="popupboxb" id="risk_list">
        <p>Select the Risk, then click the arrow to add to the list<a href="index.php?pg=risk_add&scr=S<?php if($result) {echo $row[0];}?>"><img align='right' src='resource/add.png' width=20><a></p>
        <table id="risktable" class="scroll_table" style="max-height:400px;" width="100%" border="1px solid black">
        </table>
      </div>
    </div>

    <input type="hidden" id="idAAP" name="idAAP" value='<?php if($result) {echo $row[0];}?>'>
    <input type="hidden" id="uid" name="uid" value='<?php if($result) {echo $row[35];}?>'>
    <div class="panele">
      </br></br>
      <ul class="tab">
        <li><a href="javascript:void(0)" class="tablinks" onclick="openAAP(event, 'activity')" id="defaultOpen">Event</a></li>
        <?php
         if ($PageName=='aap_edit') {
          echo '<li><a href="javascript:void(0)" class="tablinks" onclick="openAAP(event, &#39;equip&#39;)">F31 - Equip</a></li>';
          echo '<li><a href="javascript:void(0)" class="tablinks" onclick="openAAP(event, &#39;risks&#39;)">F31 - Risks</a></li>';
          if ($_SESSION['admin']=="TRUE") {echo '<li><a href="javascript:void(0)" class="tablinks" onclick="openAAP(event, &#39;approv&#39;)">F31 - Approval</a></li>';}
          echo '<li><a href="javascript:void(0)" class="tablinks" onclick="openAAP(event, &#39;forms&#39;)">Print Forms</a></li>';
        }
        ?>
      </ul>
    	<div id="activity" class="tabcontent">
        <h3>C5 and General Information</h3>
        <div>
          <label class="labeld">Joeys</label>
          <label class="labeld">Cubs</label>
          <label class="labeld">Scouts</label>
          <label class="labeld">Vents</label>
          <label class="labeld">Rovers</label>
          <label class="labeld">Leaders</label>
          <label class="labeld">Others</label><br>
          <input type="number" id="C5_joeys" name="C5_joeys" style='width:64px' value="<?php if($result) {echo $row[12];}?>"/>
          <input type="number" id="C5_cubs" name="C5_cubs" style='width:64px' value="<?php if($result) {echo $row[13];}?>"/>
          <input type="number" id="C5_scouts" name="C5_scouts" style='width:64px' value="<?php if($result) {echo $row[14];}?>"/>
          <input type="number" id="C5_vents" name="C5_vents" style='width:64px' value="<?php if($result) {echo $row[15];}?>"/>
          <input type="number" id="C5_rovers" name="C5_rovers" style='width:64px' value="<?php if($result) {echo $row[16];}?>"/>
          <input type="number" id="C5_leaders" name="C5_leaders" style='width:64px' value="<?php if($result) {echo $row[17];}?>"/>
          <input type="number" id="C5_others" name="C5_others" style='width:64px' value="<?php if($result) {echo $row[18];}?>"/>
        </div>
        <div style="border: 1px solid #07839f; padding:5px">
          <label class="labelb required">Site</label>
          <select id="siteid" name="siteid" style="width:184px" value="<?php if ($result) {echo $row[1];}?>">
            <?php
              if (!($result)) {echo '<option value="Select">Select a Site</option>';}
              $queryt="SELECT * FROM sites order by site_name";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($sit = mysqli_fetch_array($resultt)) {
                if (($result) and ($row[1]==$sit[0])) {
                  $_SESSION['brnch']=$sit[31];
                  $_SESSION['rgn']=$sit[30];
                  $_SESSION['dstct']=$sit[29];
                  echo "<option selected data-branch=".$sit[31]." data-region=".$sit[30]." data-district=".$sit[29]." value= ".$sit[0].">".$sit[1]."</options>";
                } else {
                  echo "<option data-branch=".$sit[31]." data-region=".$sit[30]." data-district=".$sit[29]." value= ".$sit[0].">".$sit[1]."</options>";
              }}
            ?>
          </select>
          <b id="campers"></b>
          <a href="index.php?pg=site_add" title="Add new site"><img src="resource/addd.png"></a><br>
          <label class="labelb" style="width:113px;">Location</label><input type="text" id="C5_locat" name="C5_locat" style='width:480px' value="<?php if($result) {echo $row[2];}?>"/><br>
          <label class="labelb required">Program</label>
          <select id = "C5_activ" name="C5_activ" style="width:184px" value="<?php  if ($result) {echo $row[3];}?>">
            <?php
            if (!($result)) {echo '<option value="Select">Select a Program</option>';}
              $queryt="SELECT act.* FROM activities AS act INNER JOIN shareprog as sprog ON act.idact=sprog.idact WHERE sprog.uid='".$_SESSION['uid']."' order by act.activity_name";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              $pcost=0;$notes1=Array();
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($actv = mysqli_fetch_array($resultt)) {
                $pidact=$actv[0];
                if (($result) and ($row[3]==$actv[0])) {
                  echo "<option selected data-idact=".$actv[0]." data-fdate=".$actv[3]." data-ftime=".$actv[4]." data-tdate=".$actv[5]." data-ttime=".$actv[6]." data-tcost=".$actv[10]." value= ".$actv[0].">".$actv[1]."</options>";
                  $pcost=$actv[10];
                  $pnotes=$actv[11];
                } else {
                  echo "<option data-idact=".$actv[0]." data-fdate=".$actv[3]." data-ftime=".$actv[4]." data-tdate=".$actv[5]." data-ttime=".$actv[6]." data-tcost=".$actv[10]." value= ".$actv[0].">".$actv[1]."</options>";
                  if ($pcost==0) {$pcost=$actv[10];}
                }
              }
            ?>
          </select><a href="index.php?pg=actv_add" title="Add new program"><img src="resource/addd.png"></a>
          <label class="labelf" style="text-align:left; width:20px;"></label>
          <label class="labelb required" style="text-align:left">Type</label>
          <select id = "C5_type" name="C5_type" style="width:184px" value="<?php  if ($result) {echo $row[4];}?>">
            <?php
              $queryta="SELECT * FROM activType order by activ_name";
              $resultta=mysqli_query($conaap,$queryta);
              $cntia=mysqli_num_rows($resultta);
              if ((!$resultta)||($cntia==0)) {echo "no result";}
              while ($actt = mysqli_fetch_array($resultta)) {
                if (($result) and ($row[4]==$actt[0])) {
                  echo "<option selected value= ".$actt[0].">".$actt[1]."</options>";
                } else {
                  echo "<option value= ".$actt[0].">".$actt[1]."</options>";
              }}
            ?>
          </select> <br>
          <label class="labelb">Branch <?php  ?></label>
          <select id = "C5_branch" name="C5_branch" style="width:184px" value="<?php echo $_SESSION["brnch"];?>">
            <?php
              if ($result) {$sitid=intval($row[1]);} else {$sitid=0;}
              $sqlb="SELECT branch.idbranch, sites.branch, sites.siteid FROM branch INNER JOIN sites ON sites.branch=branch.idbranch WHERE sites.siteid=".$sitid;
              $resultb=mysqli_query($conaap,$sqlb);
//              $cnti=mysqli_num_rows($resultb);
              $sit=mysqli_fetch_array($resultb);
              $queryt="SELECT * FROM branch order by idbranch";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($brnch = mysqli_fetch_array($resultt)) {
                if (($result) and ($sit[0]==$brnch[0])) {
                  echo "<option selected value= ".$brnch[0].">".$brnch[1]."</options>";
                } else {
                  echo "<option value= ".$brnch[0].">".$brnch[1]."</options>";
              }}
            ?>
          </select>
          <label class="labelf" style="text-align:left; width:40px;"></label>
          <label class="labelb" style="text-align:left">Region </label>
          <select id = "C5_region" name="C5_region" style="width:184px"   value="<?php echo $_SESSION["rgn"];?>">
            <?php
              $sqlr="SELECT region.idregion, sites.region, sites.siteid FROM region INNER JOIN sites ON sites.region=region.idregion WHERE sites.siteid=".$sitid;
              $resultr=mysqli_query($conaap,$sqlr);
              $sit=mysqli_fetch_array($resultr);
              $queryt="SELECT * FROM region order by region";
              $resultt=mysqli_query($conaap,$queryt);
              $cnti=mysqli_num_rows($resultt);
              if ((!$resultt)||($cnti==0)) {echo "no result";}
              while ($regn = mysqli_fetch_array($resultt)) {
                if (($result) and ($sit[0]==$regn[0])) {
                  echo "<option selected value= ".$regn[0].">".$regn[1]."</options>";
                } else {
                  echo "<option value= ".$regn[0].">".$regn[1]."</options>";
              }}
            ?>
          </select><br>
          <label class="labelb">District </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="District" ';} ?> disabled id="C5_district" name="C5_district" style='width:181px' value="<?php echo "To be added later";//if($result) {echo $row[30];}?>"/>
          <label class="labelf" style="text-align:left; width:40px;"></label>
          <label class="labelb required" style="text-align:left">Group </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Group" ';} ?> id="C5_group" name="C5_group" style='width:182px' value="<?php if($result) {echo $row[5];}?>"/><br>
        </div>
        <div style="border: 1px solid #07839f; padding:3px; vertical-align:top">
          <label class="labelb ">From </label>
          <input type="date" id="C5_datefrom" name="C5_datefrom" style='width:135px' value="<?php if($result) {echo $row[19];} else {echo date("d/m/Y");}?>"/>
          <input type="time" id="C5_timefrom" name="C5_timefrom" style='width:90px' value="<?php if($result) {echo $row[20];} else {echo '00:00';}?>"/>
          <label class="labelb required" style="width:35px">To </label>
          <input type="date" id="C5_dateto" name="C5_dateto" style='width:135px' value="<?php if($result) {echo $row[21];} else {echo date("d/m/Y");}?>"/>
          <input type="time" id="C5_timeto" name="C5_timeto" style='width:90px' value="<?php if($result) {echo $row[22];} else {echo '00:00';}?>"/><br>
          <label class="labelb required">Assemble </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Assemble at" ';} ?> id="C4_assemble" name="C4_assemble" style='width:200px' value="<?php if($result) {echo $row[26];}?>"/>
          <input type="time" <?php if (!$result) {echo 'placeholder="Time" ';} ?> id="C4_ass_time" name="C4_ass_time" style='width:90px' value="<?php if($result) {echo $row[27];} else {echo '00:00';}?>"/><br>
          <label class="labelb required">Return </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Return to" ';} ?> id="C4_return" name="C4_return" style='width:200px' value="<?php if($result) {echo $row[28];}?>"/>
          <input type="time" <?php if (!$result) {echo 'placeholder="Time" ';} ?> id="C4_ret_time" name="C4_ret_time" style='width:90px' value="<?php if($result) {echo $row[29];} else {echo '00:00';}?>"/>
        </div>
        <div style="border: 1px solid #07839f; padding:5px; vertical-align:top">
          <label class="labelb">Cost </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Cost $" ';} ?> id="C4_cost" name="C4_cost" style='width:80px' value="<?php if($result) {echo $row[30];} else {echo $pcost;}?>"/><br>
          <label class="labelb" style="vertical-align:top">What to bring</label>
          <?php if (isset($pnotes)) {if ($pnotes=="") {$pnotes="";}} else {$pnotes="";}?>
          <textarea title="text is from Program notes - edit it there." readonly maxlength="450" cols="8" rows="3" wrap="soft" name="C4_bring" id="C4_bring" style="width:480px"><?php if($result) {echo $row[31];} else {echo $pnotes;}?></textarea><br>
          <label class="labelb">Nearest Med.</label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Nearest Medical" ';} ?> id="C5_medical" name="C5_medical" style='width:350px' value="<?php if($result) {echo $row[23];}?>"/>
        </div>
        <div style="border: 1px solid #07839f; padding:5px; vertical-align:top">
          <label class="labelb">In Charge</label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Person in Charge"';} ?> id="C5_incharge" name="C5_incharge" style='width:200px' value="<?php if($result) {echo $row[6];}?>"/>
          <label class="labelb" style="text-align:right">Appt </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Appointment"';} ?> id="C5_incharge_appt" name="C5_incharge_appt" style='width:140px' value="<?php if($result) {echo $row[7];}?>"/><br>
          <label class="labelb">Address </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Address"';} ?> id="C5_incharge_addr" name="C5_incharge_addr" style='width:200px' value="<?php if($result) {echo $row[9];}?>"/>
          <label class="labelb" style="text-align:right">Phone </label>
          <input type="text" <?php if (!$result) {echo 'placeholder="Phone"';} ?> id="C5_incharge_ph" name="C5_incharge_ph" style='width:140px' value="<?php if($result) {echo $row[11];}?>"/>
        </div>
      </div>
      <?php
      if ($PageName=='aap_edit') {
        include 'php/aap_F31.php';
        include 'php/aap_F31risks.php';
        include 'php/aap_F31approv.php';
        include 'php/aap_forms.php';
      }
      ?>

    </div>
	</form>


<!--   </div> -->
<script>
$( document ).ready(function() {

  $().maxlength();
  var rghts=<?php Print($rights); ?>;if (!rghts) {$(':input').attr('readonly', 'readonly');}

  function convertDate(inputFormat) {
    function pad(s) { return (s < 10) ? '0' + s : s; }
    var d = new Date(inputFormat);
    return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('/');
  }

  if (isFirefox) {
    var df=document.getElementById("C5_datefrom").value;
    var dt=document.getElementById("C5_dateto").value;
    var da=document.getElementById("approv_date").value;
    if (document.getElementById("idAAP").value<1) {
      var fd=new Date();
      var mths=((fd.getMonth().length+1)===1)? (fd.getMonth()+1) : '0'+(fd.getMonth()+1);
      var nd=fd.getFullYear()+"-"+mths+"-"+fd.getDate();
      df=dt=da=nd;
    };
    df=convertDate(df);document.getElementById("C5_datefrom").value=df;
    dt=convertDate(dt);document.getElementById("C5_dateto").value=dt;
    da=convertDate(da);document.getElementById("approv_date").value=da;
    document.getElementById("approv_date").className="datepick";
    document.getElementById("C5_datefrom").className="datepick";
    document.getElementById("C5_dateto").className="datepick";
    $(function() { $( ".datepick" ).datepicker({ dateFormat: 'dd/mm/yy' }); });
    $("#activity div label").width(77);
  }
  var firstrun=1;
  //                get data from php array $sendmeto and load into two Jscript arrays
    pgbutt=document.querySelector('#pgbutton').value;
    if (pgbutt=='Save') {
      gname = <?php echo json_encode($sendmeto); ?>;
      gname.splice(0,1);
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
    }

    sel=document.querySelector('#siteid');
//    lname=sel.options[sel.selectedIndex].text;
    if (document.querySelector('#pgbutton').value=='Save') {
        document.querySelector('#copy_name').value=<?php echo date("Y-m-d"); ?>;
    }

  document.querySelector("#m1").style="Background-Color:black";
  document.querySelector("#defaultOpen").click();

      if ($('#siteid').text>"") {
        var sitename=document.getElementById('siteid');
        var bname=sitename.options[sitename.selectedIndex].text;
        var progname=document.getElementById('C5_activ');
        var pname=sitename.options[sitename.selectedIndex].text;
        document.getElementById('event_name').innerHTML=bname+" - "+pname+" - "+document.getElementById('C5_incharge').value;
      }
      idAAP= (parseInt(document.querySelector('#idAAP').value));
      idSite=(parseInt(document.querySelector('#siteid').value));
      se=document.querySelector('#C5_activ');
      idact= (parseInt(se.attributes.value.value));

      if (idAAP>0) getrisk('C','0',idact,idSite,idAAP,'0','');

    $('#PDFall').change ( function() {
      if (this.checked) {
        $('#C5').prop('checked',true);
        $('#C43').prop('checked',true);
        $('#F31').prop('checked',true);
        $('#PDFprog').prop('checked',true);
        $('#PDFmenu').prop('checked',true);
        $('#PDFnote').prop('checked',true);
      }
    })
    $('#C5').change ( function()    {$('#PDFall').prop('checked',false); })
    $('#C43').change ( function()   {$('#PDFall').prop('checked',false); })
    $('#F31').change ( function()   {$('#PDFall').prop('checked',false); })
    $('#PDFprog').change(function() {$('#PDFall').prop('checked',false); })
    $('#PDFmenu').change(function() {$('#PDFall').prop('checked',false); })
    $('#PDFnote').change(function() {$('#PDFall').prop('checked',false); })

    var doesExist=document.querySelector('#EmailCreate');
    if (doesExist!==null) {
      document.querySelector('#EmailCreate').onclick = function() {
        if (document.getElementById("addLabel").style.visibility=="hidden") {
          document.getElementById("PDFcreate").style.visibility="hidden";
          document.getElementById("addLabel").style.visibility="visible";
          document.getElementById("emailAddr").style.visibility="visible";
          document.getElementById("EmailSub").style.visibility="visible";
        } else {
          document.getElementById("addLabel").style.visibility="hidden";
          document.getElementById("emailAddr").style.visibility="hidden";
          document.getElementById("EmailSub").style.visibility="hidden";
          document.getElementById("PDFcreate").style.visibility="visible";
        }
      }
    }


    function checkemail(){
      var testresults;
      var str=document.validation.emailcheck.value;
      var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      if (filter.test(str))
        testresults=true;
      else{
        alert("Please input a valid email address!");
        testresults=false;
      }
      return (testresults);
    }

    document.querySelector('#C5_activ').onchange = function() {
      var selectd=$(this).find('option:selected');
      document.getElementById('C5_datefrom').value=selectd.data('fdate');
      document.getElementById('C5_timefrom').value=selectd.data('ftime');
      document.getElementById('C4_ass_time').value=selectd.data('ftime');
      document.getElementById('C5_dateto').value=selectd.data('tdate');
      document.getElementById('C5_timeto').value=selectd.data('ttime');
      document.getElementById('C4_ret_time').value=selectd.data('ttime');
      document.getElementById('C4_cost').value=selectd.data('tcost');
      idct=selectd.data('idact');
      $.ajax({
        url :"json/AAPnote.php",
        type: "post",
        datatype:'JSON',
        data:{
          typ:idct
        },
        success:function(data){
          datm=jQuery.parseJSON(data)[0].notes;
          document.getElementById('C4_bring').value=datm;
        },
        error: function(){
          alert ('error');
        }
      });

//      selectd.data('tnotes');
    }

    if (doesExist!==null) {
      document.querySelector('#EmailSub').onclick = function() {
        emaila=document.querySelector('#emailAddr').value;
        var filter=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
        if (filter.test(emaila)) { var gg; } else {
          alert("Please input a valid email address!");
          return;
        }
        var frm=""
        if ($('#C5').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#C43').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#F31').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFprog').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFmenu').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFnote').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if (parseInt(frm)==0) {alert("You need to select some forms first!"); return; }
  //      alert (frm+" - "+idAAP);
        window.open('php/PDF/pdfreport.php?frm='+frm+'&id='+idAAP+'&OP=E&email='+emaila,'_blank');
      }
    }
    if (doesExist!==null) {
      document.querySelector('#PDFcreate').onclick = function() {
        var frm=""
        if ($('#C5').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#C43').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#F31').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFprog').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFmenu').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if ($('#PDFnote').is(":checked")) { frm=frm+"1";} else {frm=frm+"0";}
        if (parseInt(frm)==0)  {alert("You need to select some forms first!"); return; }

  //      alert (frm+" - "+idAAP);
        window.open('php/PDF/pdfreport.php?frm='+frm+'&id='+idAAP+'&OP=C&email=none','_blank');
      }
    }

    document.querySelector('#C5_incharge').onchange = function() {
      var sitename=document.getElementById('siteid');
      var bname=sitename.options[sitename.selectedIndex].text;
      var sitename=document.getElementById('C5_activ');
      var pname=sitename.options[sitename.selectedIndex].text;
      document.getElementById('event_name').innerHTML=bname+" - "+pname+" - "+document.getElementById('C5_incharge').value;
    }

  var bugg=document.getElementById("pgbutton").value;
  if (document.getElementById("pgbutton").value=="Add") {
    document.querySelector('#C5_group').value="<?php echo $_SESSION['group']?>";
    document.querySelector('#C5_incharge_appt').value="<?php echo $_SESSION['role']?>";
    document.querySelector('#C5_incharge').value="<?php echo $_SESSION['realname']?>";
    document.querySelector('#C5_incharge_ph').value="<?php echo $_SESSION['phone1']?>";
  }

document.querySelector('#C5_datefrom').onchange = function() {
  if (document.querySelector('#C5_dateto').value=="") {document.querySelector('#C5_dateto').value=this.value;}
}
document.querySelector('#C5_timefrom').onchange = function() {
  if (document.getElementById('C4_ass_time').value="00:00") {document.getElementById('C4_ass_time').value=this.value; }
}
document.querySelector('#C5_timeto').onchange = function() {
  if (document.getElementById('C4_ret_time').value="00:00") { document.getElementById('C4_ret_time').value=this.value; }
}

  document.querySelector('#siteid').onchange = function() {   // get site details and put location, branch, region etc in box
    var sitename=document.getElementById('siteid');
    var bname=sitename.options[sitename.selectedIndex].text;
    var sitename=document.getElementById('C5_activ');
    var pname=sitename.options[sitename.selectedIndex].text;
    document.getElementById('event_name').innerHTML=bname+" - "+pname+" - "+document.getElementById('C5_incharge').value;
    var data=[];  var newHTML=[];  typ='T';
    var site=$("#siteid").val();
    $.ajax({
      url :"json/C5resp.php",
      type: "post",
      datatype:'JSON',
      data:{
        typ:typ,
        siteid:site,
      },
      success:function(data){
//        alert (data);
        if (jQuery.parseJSON(data).length) {
          $(jQuery.parseJSON(data)).each(function() {
            document.querySelector('#C5_locat').value=(this.address1+" "+this.address2+", "+this.city);
            document.querySelector('#C5_branch').value=this.branch;
            document.querySelector('#C5_region').value=this.region;
            if (document.getElementById('C4_assemble').value=="") {
              document.getElementById('C4_assemble').value=this.site_name;
            }
            if (document.getElementById('C4_return').value=="") {
              document.getElementById('C4_return').value=this.site_name;
            }
//            document.querySelector('#C5_district').value=this.district;
            $('#campers').text(" Max campers - "+this.max_ppl);
          });
        }
      },
      error: function(){
        alert ('error');
      }
    });
  }
  if (doesExist!==null) {
    document.querySelector('#riskl_open').onclick = function() {
      $('#riskbox').show();
    };
    document.querySelector('#riskl_close').onclick = function() {
      $('#riskbox').hide();
    };

    if ($('#send_open').length>0) document.querySelector('#send_open').onclick = function() {
      $('#sendbox').show();
      $('#copybox').hide();
    };
    document.querySelector('#send_close').onclick = function() {
      $('#sendbox').hide();
    };
    if ($('#copy_open').length>0) document.querySelector('#copy_open').onclick = function() {
      $('#copybox').show();
      $('#sendbox').hide();

    };
    document.querySelector('#copy_close').onclick = function() {
      $('#copybox').hide();
    };
  }
  document.querySelector('#cancel').onclick = function() {
    window.open('index.php?pg=aap', '_self')
  };

  getQBSI('E');
  getPR('E');
});
</script>
