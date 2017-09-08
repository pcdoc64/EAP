<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$con=mysqli_connect(DB_HOST,DBC_USER,DBC_PASSWORD,DBC_NAME);
if (!$conaap || !$con) {echo 'access denied<br>';}
if ($slct=='actclass_edit' || $PageName=='page') {
  include('js/risklist.js');
  include('php/risk_show.php');
}

 ?>

<script>
// receive POST data - 1st item is type of query V=program, T=Act Class, S=site, C=C5 (into)
//                     2nd item is RiskID (riskid)
//                     3rd item is TypeID - ID from V, T, S or C (typeID)
//										 4th is siteid
//										 5th is AAPid
//                     6th is 0 for read, 1 for insert, 3 for delete (readit)
//										 7th is for risk name (name)
function getrisk(type,riskid,typeid,siteid,AAPid,readit,name) {
    var data=[];
    var newHTML=[];
//    alert ('fields are - '+type+', '+riskid+', '+typeid+', '+siteid+', '+AAPid+', '+readit+', '+name+'');
    if (typeid==undefined) {typeid='V';};
    $.ajax({
          url :"json/riskresp.php",
          type: "post",
          datatype:'JSON',
          data:{
            into:type,
            riskid:riskid,
            typeid:typeid,
            siteid:siteid,
            AAPid:AAPid,
            readit:readit,
            name:name,
          },
          success:function(data){
//            alert ("data :"+data+" -- into :"+type+" -- riskid :"+riskid+" -- typeid :"+typeid+" -- siteid :"+siteid+" -- readit :"+readit);
            if (jQuery.parseJSON(data).length) {
              if (type=='T' && readit==0) {                                // show risks for this activity type
                newHTML='<tr><td style="width:484px">Risk</td><td style="width:84px">Before</td><td class="tabicon";>Del</td></tr>';
                $(jQuery.parseJSON(data)).each(function() {
                    newHTML+=("<tr><td style='text-align:left'><a href='javascript:void(0)' onclick='prepRisk("+this.idrisk+")'>"+this.risk_name+"</a></td><td");
                    colr=this.matrix_before.substr(0,1);
                    if (colr=='L') {newHTML+=(" style='background-color:green' ")};
                    if (colr=='M') {newHTML+=(" style='background-color:yellow' ")};
                    if (colr=='H') {newHTML+=(" style='background-color:orange' ")};
                    if (colr=='E') {newHTML+=(" style='background-color:red' ")};
                    newHTML+=(">"+this.matrix_before+"</td><td onclick='getrisk(&#39;T&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;&#39;,&#39;&#39;,&#39;3&#39;,&#39;&#39;)' class='tabicon';><img src='resource/del.png' width=20></td></tr>");
                });
                $('#rtable').html(newHTML);
                risklst(idact);
              };
            } else {
              newHTML='<tr><td style="width:484px">Risk</td><td style="width:84px">Before</td><td class="tabicon";>Del</td></tr>';
              $('#rtable').html(newHTML);
              risklst(idact);
            }
            if (type=='T' && readit=='1') {
              var obj=data.toString();
              var q=parseInt(obj.search('qbsi'));var p=parseInt(obj.search('"pr":'));
              var qb=obj.substring((q+7),(p-q-1));
              var pr=obj.substring((p+6),(obj.length-3));
              var elem=document.getElementById("acttypeqbsi");
              elem.value=qb;
              var elem=document.getElementById("acttypepr");
              elem.value=pr;
              idact=document.querySelector('#idact_type').value;
              getrisk('T','0',idact,'','','0','');
            }
            if (type=='T' && readit=='3') {
              idact=document.querySelector('#idact_type').value;
              getrisk('T','0',idact,'','','0','');
            }
          },
          error: function(){
            alert ('error');
          }
      });
    }

    function risklst(idact) {
        var data=[];
        var newHTML=[];
        typ='T'; // - when this section repeated, set typ=T,V,S,C
    //    alert ('fields are - '+type+', '+riskid+', '+typeid+', '+readit+', '+name+'');
        $.ajax({
              url :"json/risklist.php",
              type: "post",
              datatype:'JSON',
              data:{
                typ:typ,
                typeid:idact,
              },
              success:function(data){
//              alert (data);
                if (jQuery.parseJSON(data).length) {
                  if (typ=='T') {                                // show risks for this activity type
                    newHTML='<tr><td>Add</td><td>Risk</td></tr>';
                    $(jQuery.parseJSON(data)).each(function() {
                      newHTML+=("<tr><td class='tabicon';><img onclick='getrisk(&#39;T&#39;,&#39;"+this.idrisk+"&#39;,&#39;"+idact+"&#39;,&#39;&#39;,&#39;&#39;,&#39;1&#39;,&#39;&#39;)' src='resource/send.png' width=20></td><td>"+this.risk_name+"</td></tr>")
                      $('#risktable').html(newHTML);
                    });
                  };
                }
              },
              error: function(){
                alert ('error');
              }
            });
          }

          function prepRisk(riskno) {
            var data=["request:0"];
            var idact=document.getElementById("idact_type").value;
            getrisky('T',idact, riskno, 0, data)
          }


</script>

<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
$sel=$_GET['sel'];
if ($sel=='actclass_edit') {
  echo "<div id='PgTitle'>Edit Activity Class</div>";
  $cnti=0;
  $query="SELECT * FROM act_class WHERE idact_type=".$_GET['id'];
  $result=mysqli_query($conaap,$query);
  $cnti=mysqli_num_rows($result);

  $row=$result->fetch_row();
//  if ((!$resultr)||($cntir==0)) {echo "no result";}
} else {
  echo "<div id='PgTitle2'>New Activity Class</div>";
  $result=FALSE;
}
?>
<div class="centered_form2">

 <div id="acttypeform" class="risk_form">
  <form action="php\actclass_save.php" class="div_form" id="acttypeform" method="post">
    <?php
     if ($sel=='actclass_edit') {
       echo '<input type="submit" class="buttons" name="update" value="Update"></input>'; //   disable if add button pressed
     } else {
       echo '<input type="submit" class="buttons" name="add" value="Add"></input>'; //   disable if edit button pressed
     }
    ?>
    <input style="float:right" type="submit" class="buttons" name="cancel" value="Cancel"></input>

    <div id="riskbox" class="riskl_form" style="display:none";>
      <a href="#" onclick="riskl_close()" title="Close" class="close">X</a>
      <div class="popupboxb" id="risk_list">
        <p>Select the Risk, then click the arrow to add to the list<a href="index.php?pg=risk_add&scr=T<?php if($result) {echo $row[0];}?>"><img align='right' src='resource/add.png' width=20><a></p>
        <table id="risktable" class="scroll_table" style="max-height:400px;" width="100%" border="1px solid black">

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


    <div style="border: 1px solid #07839f; padding:5px">
      </br></br>
      <input type="hidden" id="idact_type" name="idact_type" value='<?php if($result) {echo $row[0];}?>'>
      <label class="labelb">Class     : </label><td style="width:400px"><input type="text" id="acttypen" name="acttypename" style='width:400px' <?php if (!$result) {echo 'placeholder="What Type of Activity?" ';} ?> value="<?php if($result) {echo $row[1];}?>"/><br>
      <label class="labelb">Certs required: </label><input type="checkbox" id="woodbead" name="woodbeads" value="W" <?php if ($result) {if ($row[2]=="W") {echo 'checked';};}?>>Woodbeads</input>
      <input type="checkbox" id="special" name="special" value="S" <?php if ($result) {if ($row[3]=="S") {echo 'checked';};}?>>Special</input><br>
      <label class="labelb">P&R Sections  : </label><td style="width:460px"><input type="text" id="acttypepr" name="acttypepr" style='width:440px' <?php if (!$result) {echo 'placeholder="Relevant P&R Sections?" ';} ?> value="<?php if($result) {echo $row[4];}?>"/><br>
      <label class="labelb">QBSI Sections : </label><td style="width:460px"><input type="text" id="acttypeqbsi" name="acttypeqbsi" style='width:440px' <?php if (!$result) {echo 'placeholder="Relevant QBSI Sections?" ';} ?> value="<?php if($result) {echo $row[5];}?>"/><br>
      <label class="labelb">QB SOA P&P :</label><td style="width:460px"><input type="text" id="acttypeqbsoa" name="acttypeqbsoa" style='width:440px' <?php if (!$result) {echo 'placeholder="Relevant QB SOA P&P Sections?" ';} ?> value="<?php if($result) {echo $row[6];}?>"/><br>
    </div>
    <div style="border: 1px solid #07839f; padding:5px">
      <table id='rtable' class="scroll_table" style="width:100%" border='1'>

    </table>
    <a href="#" id="sel_risk" onclick="riskl_open()" ><button style="background-color:lightblue" onclick="riskl_open()" type="button">Click here to select from the Risk list</a>
    </div>

<!--    <a href="index.php?pg=admin&sel=actclass" id='close' title="Close" class="close">X</a> -->
  </form>
 </div>
</div>

<script>
$( document ).ready(function() {
  idact=document.querySelector('#idact_type').value;
//  debugger;
  if (!(idact>0)) {
    document.querySelector("#sel_risk").style="display:none";
  } else {
    getrisk('T','0',idact,'','','0','');
    risklst(idact);
  }

  function show_risk() {
    document.querySelector('#riskbox').style="display:visible ";
    $('#riskbox').show();
  };

});
</script>
