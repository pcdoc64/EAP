<script>

$(document).ready(function () {
  //                              Turn off corner action and animation on all corners
  $("#flipbook").bind("start", function(event, pageObject, corner) {
      if (corner=="tl" || corner=="bl" || corner=="br" || corner=="tr" ) {
        event.preventDefault();
      }
   });

  timedif=30; timestrt=420-timedif; // time start activities, time diff between activities
//  var table=document.getElementById('table1');
  autosize(document.querySelectorAll('textarea'));

  var innerH="";var startme="<tr id='drop'><td><img height='20px' src='resource/return.png'></td><td id='time'>";
  var startme2="</td><td colspan='5'><span class='dropev'><input id='class' Placeholder='Enter Activity'></input></span></td>";
  startme2+="<td></td><td></td><td></td>";
  startme2+="<td></td><td class='tabicon'><img height='20px' src='resource/del.png'></td></tr>";
  for (var i=1;i<2;i++) {
    var hrs1=Math.floor((timestrt+timedif*i) / 60); hrs=pad(hrs1);
    var mns1=(timestrt+timedif*i) % 60;mns=pad(mns1);
    innerH+=startme+hrs+":"+mns+startme2;
  }
  document.getElementById('tableP').innerHTML=innerH;

  slide_dif();
  slide_timdif();

  $('.event').on("dragstart", function (event) {
    var dt = event.originalEvent.dataTransfer;
    var datam=$(this).attr('id');
    var txt=$(this).attr('data-text');
    var strt=datam.substring(0,5);
    if (!(strt=="class")) {var ts="class-"+datam;} else {var ts=datam;}
    dt.setData('Text',ts);
    dt.setData('name',txt);
  });

  $('#tableP').on("dragstart",".dropped", function (event) {
    var dt = event.originalEvent.dataTransfer;
    var datam=$(this).attr('id');
    var txt=$(this).attr('data-text');
    var strt=datam.substring(0,5);
    if (!(strt=="activ")) {var ts="activ-"+datam;} else {var ts=datam;}
    dt.setData('Text', ts);
    dt.setData('name',txt);
  });

  $('#tableP').on("drop",".dropev", function (event) {
    rowno=pad(this.parentNode.parentNode.rowIndex);
    event.preventDefault();
    if (event.type === 'drop') {
      var datam = event.originalEvent.dataTransfer.getData('Text');
      var named = event.originalEvent.dataTransfer.getData('name');
      if (named=="Swimming") document.getElementById("swim").checked=true;
      if (named=="Pioneering") document.getElementById("pion").checked=true;
      if (named=="Archery") document.getElementById("arch").checked=true;
      if (named=="Canoeing") document.getElementById("cano").checked=true;
      if (named=="Bushwalking") document.getElementById("bush").checked=true;
      if (named=="4WD") document.getElementById("4WD0").checked=true;
      if (named=="Abseiling") document.getElementById("abse").checked=true;
      if (named=="Snorkling") document.getElementById("snor").checked=true;
      if (named=="Boating") document.getElementById("boat").checked=true;
      if (named=="Rock Climbing") document.getElementById("rock").checked=true;
      if (named=="Caving") document.getElementById("cavi").checked=true;
      var strt=datam.substring(0,5);
      var rw=datam.substring(6,8);
      var sect=datam.substring(8,9);
      var data=datam.substring(10,(datam.length));
      var dta=datam.substring(10,(datam.length));
      clssno=datam.substring(14,(datam.length));
      de = $('#' + rw+sect+"-"+dta);                // dropped section item info = # + rowid +
      de2=('activ-'+rowno+sect+"-"+dta);
      drp=event.originalEvent.target.parentNode;
      if (strt==='class') {
        de.clone().insertAfter($(drp));
        $("#tableP .event").attr("id",de2);         // change item id from class to activ (use this for moving and deleting)
        $("#tableP .event").addClass("dropped");    // clange class (color etc) for the item
        $("#tableP .dropped").removeClass("event");
      }
    };
  });

  $('#tableP').on("drop",".dropped", function (event) {
    rowno=pad(this.parentNode.parentNode.rowIndex);
    event.preventDefault();
    if (event.type === 'drop') {
      var datam = event.originalEvent.dataTransfer.getData('Text');
      var named = event.originalEvent.dataTransfer.getData('name');
      if (named=="Swimming") document.getElementById("swim").checked=true;
      if (named=="Pioneering") document.getElementById("pion").checked=true;
      if (named=="Archery") document.getElementById("arch").checked=true;
      if (named=="Canoeing") document.getElementById("cano").checked=true;
      if (named=="Bushwalking") document.getElementById("bush").checked=true;
      if (named=="4WD") document.getElementById("4WD0").checked=true;
      if (named=="Abseiling") document.getElementById("abse").checked=true;
      if (named=="Snorkling") document.getElementById("snor").checked=true;
      if (named=="Boating") document.getElementById("boat").checked=true;
      if (named=="Rock Climbing") document.getElementById("rock").checked=true;
      if (named=="Caving") document.getElementById("cavi").checked=true;
      var strt=datam.substring(0,5);
      var rw=datam.substring(6,8);
      var sect=datam.substring(8,9);
      var dta=datam.substring(10,(datam.length));
      de = $('#' + rw+sect+"-"+dta);
      de2=('activ-'+rowno+sect+"-"+dta);
      drp=event.originalEvent.target;
      if (strt==='class') {
        de.clone().insertAfter($(drp));
        $("#tableP .event").attr("id",de2);
        $("#tableP .event").addClass("dropped");
        $("#tableP .dropped").removeClass("event");
      }
    };
  });

$('#tbody2').on("drop", function (event, ui) {
  event.preventDefault();
  var datam = event.originalEvent.dataTransfer.getData('Text');
  var strt=datam.substring(0,5);
  de = $('#' + datam);
  if (strt==='activ') {
    de.remove();
  }
});

  $(document.body).bind("dragover", function(e) {
            e.preventDefault();
            return false;
       });

   $(document.body).bind("drop", function(e){
        e.preventDefault();
        return false;
    });

    $('#tableP').on("click", "#drop td", function() {

    rowno=this.parentNode.rowIndex;
    colno=this.cellIndex;
    slid1=document.getElementById("slidrs").offsetLeft+document.getElementById("slidrs").offsetWidth;
    slid1+=this.offsetLeft+220;
    if (colno==0){
      var oldtm=table1.rows[rowno].cells[1].innerHTML;
      var hrsmin=parseInt(oldtm.substring(0,2)*60)+parseInt(oldtm.substring(3,5))+timedif;
      var hrs1=Math.floor(hrsmin / 60); var hrs=pad(hrs1);
      var mns1=(hrsmin) % 60;var mns=pad(mns1);
      hrsmin=hrs+":"+mns;
      var tableRef = document.getElementById('tableP');
      var rown=tableRef.insertRow(rowno);
      rown.id="drop";
      var cell0=rown.insertCell(0);cell0.innerHTML='<img height="20px" src="resource/return.png">';
      var cell1=rown.insertCell(1);cell1.innerHTML=hrsmin;
      var cell2=rown.insertCell(2);cell2.colSpan=5;cell2.innerHTML="<span class='dropev' draggable='true'><input id='class' Placeholder='Enter Activity'></input></span>";
      var cell3=rown.insertCell(3);cell3.innerHTML="";
      var cell4=rown.insertCell(4);cell4.innerHTML="";
      var cell5=rown.insertCell(5);cell5.innerHTML="";
      var cell6=rown.insertCell(6);cell6.innerHTML="";
      var cell7=rown.insertCell(7);cell7.innerHTML='<img height="20px" src="resource/del.png">';

    }
    if (colno==1){
      var styl="top:"+(this.parentNode.offsetTop+50)+"px;left:"+slid1+"px";
      document.querySelector('#poptime').style=styl;
      oldtm=table1.rows[rowno].cells[colno].innerHTML;
      timestrt=parseInt(oldtm.substring(0,2)*60)+parseInt(oldtm.substring(3,5));  // raw number to set value of time slider
      document.getElementById("strt_amt").innerHTML =oldtm;
      $('#poptime').show();
      slide_timdif();
    }
    if (colno>2 && colno<7) {
      if (!(document.getElementById("poptime").style.display=="none")) {poptime_canc();}
      var styl="top:"+(this.parentNode.offsetTop+50)+"px;left:"+slid1+"px";
      document.querySelector('#popup').style=styl;
      switch (colno) {
        case 3:
          boxtype="Where is activity run?";
          break;
        case 4:
          boxtype="What equip is needed?";
          break;
        case 5:
          boxtype="Youth should bring?";
          break;
        case 6:
          boxtype="Who is in charge?";
          break;

      }
      $('#popup').show();
      document.querySelector('#popup').addEventListener('keydown', function(evt) {
         evt = evt || window.event;
         if (evt.keyCode == 27) {
             popup_canc();
         }
      });
      $('#text_input').attr('Placeholder',boxtype);
      var owntxt=table1.rows[rowno].cells[colno].innerHTML;
      if (owntxt=="") {document.getElementById('text_input').value=""} else {document.getElementById('text_input').value=owntxt;}
      document.getElementById('text_input').focus();
    }
    if (colno==7) {
      var tableRef = document.getElementById('tableP');
      tableRef.deleteRow(rowno-1);
    }
  });

});   //                 End document ready section

  //                       Functions start here

 function slide_dif() {
    $( "#dif_slide" ).slider({
      value:30,
      min: 5,
      max: 120,
      step: 5,
      orientation:'vertical',
      slide: function( event, ui ) {
        var timr=ui.value+" m";
        timedif=ui.value;
        document.getElementById("dif_amt").innerHTML =timr;
        $("#strt_slide").slider({step:timedif});
      }
    });
  };
    function slide_timdif() {
    $( "#strt_slide" ).slider({
      value:timestrt,
      min: 0,
      max: 1440,
      step: timedif,
      orientation:'horizontal',
      slide: function( event, ui ) {
        var strtm=ui.value;
        var hrs1=Math.floor(strtm / 60); hrs=pad(hrs1);
        var mns1=(strtm) % 60;mns=pad(mns1);
        stimr=hrs+":"+mns;
        document.getElementById("strt_amt").innerHTML =stimr;
        table1.rows[rowno].cells[1].innerHTML=stimr;
      }
    });
  };
  function poptime_canc(){
    document.querySelector('#poptime').style="display:none";
  }

  function pad(str) {
    if (str<10) {
      str="0"+str;
    }
    return str;
  }

  function showme(stDate) {
    var rghts=<?php Print($rights); ?>;
    if (rghts) {
      idact = (parseInt(document.querySelector('#actvid').value));
      colnos=$("#table1 th").length-1;
      var data = Array();

      $("#tableP tr").each(function(i, v){
          data[i] = Array();
          var sDate=stDate;
          $(this).children('td').each(function(ii, vv){
            if (ii>0 && ii<7) {                                 // range of <td> blocks in 1 row in program
              if (ii==2) {                                      // 2 = activity
                var inputtext=$(this).children('span').children('input')[0].value;  // get any text in input field
                if (inputtext.length==0 || inputtext=='undefined') {var inputtxt="nil";} else {var inputtxt=inputtext;} // if no text, ='nil'
                classf=Array();
                inputtxt="T"+inputtxt;                          // add 'T' in front of Text - to be read in progupd
                classf[0]=inputtxt;                             // add to position 0 in classf array
                if (vv.children.length>1) {
                  for (var s=1;s<vv.children.length;s++) {
                    var datam=vv.children[s].id;
                    idm=datam.substring(14,(datam.length));     // get activity class number
                    classf[s]="C"+idm;                          // add C in front of number for progupd.php and add to classf array
                  }
                }
                data[i][ii-1]=classf;                           // make position 2 in data array = classf array
              } else {
                var thistext=$(this).text();
                if (thistext=='undefined'||thistext=="") {thistext="";}
                data[i][ii-1] = thistext;                 // add all other items to data array
              }
            }
          });
      });

      $.ajax({
            url :"json/progupd.php",
            type: "post",
            datatype:'JSON',
            async: false,
            data:{
              activ:idact,
              dat:stDate,
              data:data
            },
            success:function(data){
  //            logit('program', 'update2', 'showme', document.getElementById("actv").value, 'all', '<?php echo $_SESSION['realname']; ?>');
  //              alert (data);

            },
            error: function(){
              alert ('showme:error');
            }
      });
    }
  }

  function getprog(idact,stDate) {
    var actclass = <?php echo json_encode($act_cls); ?>;
    $.ajax({
          url :"json/progget.php",
          type: "post",
          datatype:'JSON',
          data:{
            activ:idact,
            dat:old_stDate,
          },
          success:function(data){
//            alert (data);
//            logit('program', 'update3', 'getprog', document.getElementById("actv").value, 'all', '<?php echo $_SESSION['realname']; ?>');
            datam=jQuery.parseJSON(data);
            var ddat=1;
            var innerH="";
            var orgdateSource=document.getElementById('fromdate').value;
            if (orgdateSource.substr(4,1)=="-") orgDate=orgdateSource.substr(8,2)+orgdateSource.substr(5,2)+orgdateSource.substr(0,4);
            if (orgdateSource.substr(2,1)=="/") orgDate=orgdateSource.substr(0,2)+orgdateSource.substr(3,2)+orgdateSource.substr(6,4);
            if (Object.prototype.toString.call(datam[0]) ==='[object Array]' || Object.prototype.toString.call(datam[0]) === '[object Object]') {
              progdata=0;
              var curdate=datam[0].act_date.substr(8,2)+datam[0].act_date.substr(5,2)+datam[0].act_date.substr(0,4);
            } else {
              progdata=1;
              if (stDate==orgDate) {curdate=orgDate;} else {curdate=stDate;}
            }

            for (var ret=0, ln=datam.length;ret<ln;ret++) {
              retn=datam[ret];
              if (progdata==1) {
                if (curdate==orgDate) {var rtime=document.getElementById('fromtime').value;} else {rtime="07:00";}
              } else {
                var rtime=retn.act_time;
              }
              rtime=rtime.substr(0,5);
              innerH+="<tr id='drop'><td><img height='20px' src='resource/return.png'></td><td id='time'>"+rtime+"</td><td colspan='5'>";
              if (progdata==0) {
                classn=datam[ret].class
                if (retn.act_type="T") {
                  innerH+="<span class='dropev'><input id='class' Placeholder='Enter Activity' text='"+classn+"' value='"+classn+"'></input></span>";
                  if (ret+1<datam.length) {
                    while (datam[ret+1].act_type=="C") {
                      ret+=1;
                      for (i=0;i<actclass.length;i++) {
                        if (actclass[i].idact_type==datam[ret].act_numb) {
                          stnum=datam[ret].act_numb;
                          if (stnum<10) {stnum="00"+stnum;} else {if (stnum>10 && stnum<100) {stnum="0"+stnum;}}
                          innerH+="<span class='dropped' id='activ-"+stnum+"-item"+datam[ret].act_numb+"' draggable='true' data-text='"+actclass[i].act_name+"'>"+actclass[i].act_name+"</span>";
                          break;
                      } }
                      if (ret+1==datam.length) break;
                } } }
              } else {
                innerH+="<span class='dropev'><input id='class' Placeholder='Enter Activity' text='' value=''></input></span>"
              }
              var rloc="";var requip="";var rbring="";var rlead="";
              if (progdata==0) {
                rloc=retn.location;
                requip=retn.equip;
                rbring=retn.tobring;
                rlead=retn.leaders;
              }
              innerH+="</td><td Placeholder='location'>"+rloc+"</td><td Placeholder='equipment'>"+requip+"</td><td Placeholder='Youth to bring'>"+rbring+"</td><td Placeholder='leaders'>"+rlead+"</td><td class='tabicon'><img height='20px' src='resource/del.png'></td></tr>";
            }
            document.querySelector("#tableP").innerHTML=innerH;
          },
          error: function(){
            alert ('getprog:error');
          }
    });
  }


</script>
