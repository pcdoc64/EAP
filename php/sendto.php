<?php
$cntin=0;$sendmeto[]=null;
$queryg="SELECT gid FROM oc_group_user WHERE uid='".$_SESSION['uid']."'";
$resultg=mysqli_query($con,$queryg);
while($rowg= mysqli_fetch_array($resultg,MYSQLI_ASSOC)) {
  $queryn="SELECT uid FROM oc_group_user WHERE gid='".$rowg['gid']."'";
  $resultn=mysqli_query($con,$queryn);
  $rown=null;
  while($ragn= mysqli_fetch_array($resultn,MYSQLI_ASSOC)) {
    if ($ragn['uid']<>$_SESSION['uid'] &&
        $ragn['uid']<>'test' &&
        (strpos($ragn['uid'],'admin')!==0) &&
        (strpos($ragn['uid'],'member')!==0))
          {$rown[]= $ragn['uid'];}
  }
  array_push($rowg,$rown);
  array_push($sendmeto,$rowg);
}
 ?>
<script>
function sendthis() {
  sname=Array();lname=Array();
  lnm=document.getElementById('lsname');
  for (i=lnm.options.length - 1; i>=0; i--)
  {
      lname.push(lnm.options[i].text);
  }
//  sel=document.querySelector('#lname');         //    work out who the event or program is being shared with
//  lname=sel.options[sel.selectedIndex].text;    //    name to be shared with
  rname=document.querySelector('#copy_name').value; // what the event or program is being copied to
  sname.push(document.querySelector('#uid').value);
  if (document.getElementById('copybox').style.display=="") {sende='C';} // none means it is hidden - copy active
  if (document.getElementById('sendbox').style.display=="") {sende='S';} //                           send active
  urll=window.location.href;
  regex=new RegExp("[?&]pg(=([^&#]*)|&|#|$)"), results=regex.exec(urll)   //  strip this page url and find what pg
  pagx=decodeURIComponent(results[2].replace(/\+/g, " "));                //  you started the page on, gives program or event.
  if (pagx=='actv_edit') {typid=parseInt(document.querySelector('#actvid').value);typee='V';
	if (sende=="C") {lname=sname;}
	}
     // ID of program item
  if (pagx=='aap_edit') {typid=parseInt(document.querySelector('#idAAP').value);typee='C';
	if (sende=="C") {lname=sname;}
	}     // ID of event item
  if ($("input:radio[name='radio-1']")[0].checked) shr=1;
  if ($("input:radio[name='radio-1']")[1].checked) shr=2;
  if ($("input:radio[name='radio-1']")[2].checked) shr=3;

  $.ajax({
    type:"POST",
    url:"json/sharing.php",
    data: { typid:typid,      //  ID of the event or program
            typee:typee,      //  auto either V for program, or C for event
	           sende:sende,       //  Send or Copy - S or C
            lname:lname,       //  for share - what uid to go under
            rname:rname,      //  for copy - what to rename the event or program to
            shar:shr},        // what type of share

    success:function(data){
//      alert(data);
      if (typee=='V') {typr='program';} else {typr='event';}
      if (sende=='C') {sendr='copied';} else {sendr='shared';}
      typid='ID='+typid;
      if (sende=='C') {cval=rname;} else {cval='with '+lname;}
      logit(typr, sendr, typid, 'all', cval, '<?php echo $_SESSION['realname'] ?>');
      recum=data;
    }
  })
  .done(function(msg) {
    alert ('Shared with '+lname+'. Thank you!');
    lname=rname=sname='';
    if (pagx=='actv_edit') {
      if (sende=='C') {
        location.href="index.php?pg=actv_edit&id="+recum+"&rts=1";
      }
    } else {
      if (sende=='C') {
        location.href="index.php?pg=aap_edit&id="+recum+"&rts=1";
      }
    }
    $('#copybox').hide();
    $('#sendbox').hide();
  });

}

function nameMoveRows(SS1,SS2)
{
    var SelID='';
    var SelText='';
    if (SS1.options.length>0) {
      // Move rows from SS1 to SS2 from bottom to top
      for (i=SS1.options.length - 1; i>=0; i--)
      {
          if (SS1.options[i].selected == true)
          {
              SelID=SS1.options[i].value;
              SelText=SS1.options[i].text;
              var newRow = new Option(SelText,SelID);
              SS2.options[SS2.length]=newRow;
              SS1.options[i]=null;
          }
      }
      SelectSort(SS2);
    }
}
function SelectSort(SelList)
{
    var ID='';
    var Text='';
    for (x=0; x < SelList.length - 1; x++)
    {
        for (y=x + 1; y < SelList.length; y++)
        {
            if (SelList[x].text > SelList[y].text)
            {
                // Swap rows
                ID=SelList[x].value;
                Text=SelList[x].text;
                SelList[x].value=SelList[y].value;
                SelList[x].text=SelList[y].text;
                SelList[y].value=ID;
                SelList[y].text=Text;
            }
        }
    }
}
</script>

 <div id="sendbox" class="send_form" style="display:none;width:450px;">
   <a href="#" id="send_close" title="Close" class="close">X</a>
     <fieldset style="width:auto;">
       <legend>Select how to share: </legend>
       <label for="radio-1" title="Your copy will be Master, others can see it, but not edit. Your changes are update to their copy">as Master</label>
       <input class="butradio" type="radio" name="radio-1" id="radio-1">
       <label for="radio-2" title="Copy this to others, and they can also edit it. All changes are updated in your copy">as Common</label>
       <input class="butradio" type="radio" name="radio-1" id="radio-2">
       <label for="radio-3" title="Copy this to others, and they can edit as a new item. Your copy will not be affected">as Duplicate</label>
       <input class="butradio" type="radio" name="radio-1" checked="checked" id="radio-3">
     </fieldset>
   <div id="popup" class="popupboxb" id="send_list">
     <p>Select which group, then who you want to share with
     <select id="gname" style="vertical-align:top" name="gname" on Change="selectGname();">

     </select></p>
     <table border="0" cellpading="3" cellspacing="0">
       <tr>
         <td valign="top">
           <select id="lname" name="lname" size="7" style="width:150px" title="hold CTRL down to select more than one" multiple="multiple">

           </select>
          </td>
          <td align="center" valign="middle">
            <button onclick="nameMoveRows(lname,lsname)" style="width:100px" type="button"> Add >></button><br>
            <br><br>
            <button onclick="nameMoveRows(lsname,lname)" style="width:100px" type="button"><< Remove </button><br>
          </td>
          <td  valign="top">
            <select id="lsname" size="7" name="lsname" style="width:150px" multiple="multiple">

            </select>
          </td>
        </tr>
      </table>
     <button style="float:right;background-color:lightblue" onclick="sendthis()" type="button">Share</button>
   </div>
 </div>

 <!-- //                                                   Popup for copy event or program - ie copy with rename -->
 <div id="copybox" class="send_form" style="display:none">
   <a href="#" id="copy_close" title="Close" class="close">X</a>
   <div class="popupboxb" id="copy_list">
     <?php if ($PageName=='aap_edit') {
       $dte=date("Y-m-d");
       echo '<p>Please enter the start date</p>';
       echo '<input type="date" value='.$dte.' id="copy_name"></input>';
     } else {
       echo '<p>Please give this a new name</p>';
       echo '<input type="text" id="copy_name"></input>';
     } ?>

     <button style="background-color:lightblue" onclick="sendthis()" type="button">Copy</button>
   </div>
 </div>
 <script>
 $( function() {
     $( ".butradio" ).checkboxradio({
       icon: false
     });
   } );
 </script>
