<script>
// getbranch and getreg function
// send POST data - 1st item is number for 1=country, 2=branch, 3=region, 4=district (type)
//                     2nd item is id for branch / region (id)
//                     3rd item is name (name)
//                     4th is 0 for read, 1 for update, 2 for new (pst)
function getbranch(typet,idt,namet,pstt) {
    var data=[];
    var newHTML=[];
    if (typet==undefined) {typet=2;};
//    alert ('fields are - '+typet+' '+idt+' '+namet+' '+pstt);
    $.ajax({
          url :"json/branchresp.php",
          type: "post",
          datatype:'JSON',
          data:{
            type:typet,
            id:idt,
            name:namet,
            pst:pstt,
          },
          success:function(data){
  //          alert (data);
            if (pstt==0) {
               $(jQuery.parseJSON(data)).each(function() {
                if (typet==2) {
                  newHTML+=('<tr> <td id="idbranch" style="width:240px"><a href="#" id="idbranchh" onclick="getbranch(3,'+this.idbranch+',&quot;'+(this.branch).trim()+'&quot;,0);">'+this.branch+'</a></td><td><a href="#" onclick="edtbrnch(2,'+this.idbranch+',&quot;'+this.branch+'&quot;,1);"><img src="resource/edit.png" width="30"></a></td></tr>');
                  $('#tbbranch').html(newHTML)
                }
                if (typet==3) {
                  branchid=this.idbranch;
                  newHTML+=('<tr> <td id="idregn" name="idregn" style="width:200px">'+this.region+'</td><td><a id="idregon" href="#" onclick="edtreg(3,'+this.idbranch+",&quot;"+this.region+'&quot;,1);"><img src="resource/edit.png" width="30"></a></td></tr>');
                  $('#tbregion').html(newHTML)
                  document.getElementById('regadd').style.display='inline';
                }
              });
              if (!jQuery.parseJSON(data).length) {
                newHTML="<tr><td>Click Branch to list Regions</td></tr>";
                $('#tbregion').html(newHTML)
                document.getElementById('regadd').style.display='inline';
              }
//                  alert (this.branch);
            } else {
              $('#popupboxb').hide('fast');
              $('#popupboxr').hide('fast');
              brchid=branchid;
              getbranch(2,1,"",0);
              if (brchid>=1) {getbranch(3,brchid," ",0);}
            }
          },
          error: function(){
            alert ('error');
          }
      });
    }

        function brnchedit(){
          type=document.getElementById('popbtype').value;
          id=document.getElementById('popbid').value;
          name=document.getElementById('brnchname').value;
          pst=document.getElementById('popbpst').value;
          getbranch(type,id,name,pst);
        }
        function regchedit(){
          type=document.getElementById('poprtype').value;
          id=document.getElementById('poprid').value;
          name=document.getElementById('regchname').value;
          pst=document.getElementById('poprpst').value;
          getbranch(type,id,name,pst);
        }


        function addbrnch() {
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('brncheditbtn').innerHTML='Add';
          document.getElementById('popbtype').value=2;
          document.getElementById('popbid').value=1;
          document.getElementById('popbpst').value=2;
          $('#popupboxb').show('fast','linear');
        }
        function edtbrnch(type,id,name,pst){
          var rwbe = document.getElementById('idbranch');
          if(rwbe.style.background == "" || rwbe.style.background =="white") {
            $(rwbe).css('background', 'lightblue');
            } else {
            $(rwbe).css('background', 'white');
          }
          document.getElementById('brnchname').value=name;
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('popbtype').value=type;
          document.getElementById('popbid').value=id;
          document.getElementById('popbpst').value=pst;
          $('#popupboxb').show('fast','linear');
        }

        function addreg() {
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('regeditbtn').innerHTML='Add';
          document.getElementById('poprtype').value=3;
          document.getElementById('poprid').value=branchid;
          document.getElementById('poprpst').value=2;
          $('#popupboxr').show('fast','linear');
        }
        function edtreg(type,id,name,pst){
          var rwre = document.getElementById('idregn');
          if(rwre.style.background == "" || rwre.style.background =="white") {
            $(rwre).css('background', 'lightblue');
            } else {
            $(rwre).css('background', 'white');
          }
          document.getElementById('regchname').value=name;
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('poprtype').value=type;
          document.getElementById('poprid').value=id;
          document.getElementById('poprpst').value=pst;
          $('#popupboxr').show('fast','linear');;
        }

</script>

<div id="aboutbox" class="centered_form popup" style="display:none";>
  <a href="index.php?pg=admin&sel=branch" id='close' title="Close" class="close">X</a>
  <div class="div_form" id="aboutbranch">
    <p>Why have all Branches, Regions and Districts?</p>
  </div>
</div>
<div id='PgTitle2'>Branch / Region / District Records</div>
<div id='buttdiv'>
  <button class='buttona' id="show">About Branch etc</button>
</div>
<div class=centered_form2>
  <div style="width:100%; display:table; border: 1px solid #07839f;">
    <div style="width:33%; display:table-cell;">
      <b>Select Branch</b><a href="#" onclick="addbrnch(2,1,'',2)"><img src="resource/add.png" width="30"></a>
      <table id="tbbranch" style="display:block">
      </table>
    </div>
    <div style="width:33%; display:table-cell;">
      <b>Select Region</b><a id="regadd" style="display:none" href="#" onclick="addreg(3,0,'',2);"><img src="resource/add.png" width="30"></a>
      <table id="tbregion" style="display:block">
        <tr>
          <td>Click Branch to list Regions</td>
        </tr>
      </table>
    </div>
<!--    <div style="width:33%; display:table-cell;">
      <b>Select District</b>
      <table id="tbdistrict" border=1 style="display:block">
        <tr>
        </tr>
      </table> -->
    </div>

  </div>
</div>
<!--   Popup box for Branch -->
<div id="popupboxb" class="pop_form" style="display:none";>
  <a href="index.php?pg=admin&sel=branch" id='closebe' title="Close" class="close">X</a>
  <div class="div_form" id="editbrnch" >
    <label class="labelb">Branch :</label><input id="brnchname"></input>
    <input type="hidden" id="popbtype"></input>
    <input type="hidden" id="popbid"></input>
    <input type="hidden" id="popbpst"></input>
    <button id="brncheditbtn" onclick="brnchedit()">Update</button>
  </div>
</div>
<!--   Popup box for Region -->
<div id="popupboxr" class="pop_form" style="display:none";>
  <a href="index.php?pg=admin&sel=branch" id='closere' title="Close" class="close">X</a>
  <div class="div_form" id="editregion" >
    <label class="labelb">Region :</label><input id="regchname"></input>
    <input type="hidden" id="poprtype"></input>
    <input type="hidden" id="poprid"></input>
    <input type="hidden" id="poprpst"></input>
    <button id="regeditbtn" onclick="regchedit()">Update</button>
  </div>
</div>
<div>
  <p></p>
</div>
<!--  Mod popup starts here for equipment -->
<script type="text/javascript">
$( document ).ready(function() {
  branchid=1;

  document.querySelector('#show').onclick = function() {   // show about box
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
    $('#aboutbox').show();
  };
  document.querySelector('#close').onclick = function() {  // close about box
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:initial";
    $('#aboutbox').hide();
  };
  document.querySelector('#closebe').onclick = function() {  // close branch edit / add box
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:initial";
    $('#popupboxb').hide();

  };
  document.querySelector('#closere').onclick = function() {   // close region edit / add box
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:initial";
    $('#popupboxr').hide();
  };
// getbranch and getreg function
// send POST data - 1st item is number for 1=country, 2=branch, 3=region (type)
//                     2nd item is id for branch / region (id)
//                     3rd item is name (name)
//                     4th is 0 for read, 1 for update, 2 for new (pst)

  getbranch(2,1,"",0);


});
</script>
