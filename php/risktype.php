<script>
// getbranch and getreg function
// send POST data - 1st item is id for risk type (id)
//                     2nd item is name (name)
//                     3rd is 0 for read, 1 for update, 2 for new (pst)
function getregtype(idt,namet,pstt) {
    var data=[];
    var newHTML=[];
//    alert ('fields are - '+idt+', '+namet+', '+pstt);
    $.ajax({
          url :"json/risktyperesp.php",
          type: "post",
          datatype:'JSON',
          data:{
            id:idt,
            name:namet,
            pst:pstt,
          },
          success:function(data){
//            alert (data+' - pst '+pstt);
            if (pstt==0) {
               $(jQuery.parseJSON(data)).each(function() {
                newHTML+=('<tr> <td id="idbranch" style="width:240px">'+this.risk_type+'</td><td><a href="#" onclick="edtbrnch('+this.idTypeE+',&quot;'+this.risk_type+'&quot;,2);"><img src="resource/edit.png" width="30"></a></td></tr>');
                $('#tbbranch').html(newHTML)
              });

            } else {
              $('#popupboxb').hide('fast');
              brchid=0;
              getregtype(1,"",0);
              if (brchid>=1) {getregtype(brchid," ",0);}
            }
          },
          error: function(){
            alert ('error function');
          }
      });
    }

        function brnchedit(){
          id=document.getElementById('popbid').value;
          name=document.getElementById('risktname').value;
          pst=document.getElementById('popbpst').value;
          getregtype(id,name,pst);
        }

        function addbrnch() {
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('brncheditbtn').innerHTML='Add';
          document.getElementById('popbtype').value=2;
          document.getElementById('popbid').value=1;
          document.getElementById('popbpst').value=1;
          $('#popupboxb').show('fast','linear');
        }
        function edtbrnch(id,name,pst){
          var rwbe = document.getElementById('idbranch');
          if(rwbe.style.background == "" || rwbe.style.background =="white") {
            $(rwbe).css('background', 'lightblue');
            } else {
            $(rwbe).css('background', 'white');
          }
          document.getElementById('risktname').value=name;
          if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
          document.getElementById('popbid').value=id;
          document.getElementById('popbpst').value=pst;
          $('#popupboxb').show('fast','linear');
        }

</script>

<div id="aboutbox" class="centered_form" style="display:none";>
  <a href="index.php?pg=admin&sel=risktype" id='close' title="Close" class="close">X</a>
  <div class="div_form" id="aboutrisktype">
    <p>What are Risk Types</p>
  </div>
</div>
<div id='PgTitle2'>Risk Types</div>
<div id='buttdiv'>
  <button class='buttona' id="show">About Risk Types etc</button>
</div>
<div class=centered_form2>
  <div style="width:100%; display:table; border: 1px solid #07839f;">
    <div style="width:33%; display:table-cell;">
      <b>Select Type</b><a href="#" onclick="addbrnch(2,1,'',2)"><img src="resource/add.png" width="30"></a>
      <table id="tbbranch" style="display:block">
      </table>
    </div>
  </div>
</div>
<!--   Popup box for Branch -->
<div id="popupboxb" class="pop_form" style="display:none";>
  <a href="index.php?pg=admin&sel=risktype" id='closebe' title="Close" class="close">X</a>
  <div class="div_form" id="editriskt" >
    <label class="labelb">Risk Type :</label><input id="risktname" style="width:250px"></input>
    <input type="hidden" id="popbtype"></input>
    <input type="hidden" id="popbid"></input>
    <input type="hidden" id="popbpst"></input><br>
    <button id="brncheditbtn" onclick="brnchedit()">Update</button>
  </div>
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

// send POST data - 1st item is number for 1=country, 2=branch, 3=region (type)
//                     2nd item is id for branch / region (id)
//                     3rd item is name (name)
//                     4th is 0 for read, 1 for update, 2 for new (pst)

  getregtype(1,"",0);


});
</script>
