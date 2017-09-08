<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$query="SELECT * FROM F31equip ORDER By idequip";
$result=mysqli_query($conaap,$query);
//if ($result) {echo ' result found';} else {echo 'result not found';};
//echo 'rows '.mysqli_num_rows($result).'';
$cnti=mysqli_num_rows($result);
if((!$result)||($cnti==0)) {header('location:index.php?pg=admin&sel=equip_add');}
?>
<div id="aboutF31" class="centered_form" style="display:none";>
  <a href="index.php?pg=admin&sel=equip" id='close' title="Close" class="close">X</a>
  <div class="div_form" id="aboutF31" >
    <p>What is the F31 form for?</p>
  </div>
</div>

<div id='PgTitle2'>F31 Equipment</div>
<div id='buttdiv'>
<button class='buttona' id="show">About F31 Forms</button>
<input type="button" class="buttons" value="New F31 Item" onclick="location.href='index.php?pg=admin&sel=equip_add';"></input>
<!-- <input type="button" class="buttons" value="Edit Site" onclick="location.href='index.php?pg=site_edit';"></input> -->
</div>
<div class=centered_table>
<table class="scroll_table" style="width:100%" border='1'>
  <tr style="color:blue;">
    <th class="tabEitem">item</th>
    <th class="tabcomment">comments</th>
  </tr>
  <?php
  while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    echo ' <tr class="clickrow" data-url="index.php?pg=admin&sel=equip_edit&id='.$row["idequip"].'">
              <td>'.$row["item"].'</td>
              <td>'.$row["comments"].'</td>
           </tr>';
  }
  ?>

</table>
</div>

<!--  Mod popup starts here for equipment -->
<script>
$( document ).ready(function() {
  $('#aboutF31').hide('fast');

  document.querySelector('#show').onclick = function() {   // show about box
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
    $('#aboutF31').show('fast','linear');
  };
    document.querySelector('#close').onclick = function() {
      if (document.querySelector('#footer')) document.querySelector('#footer').style="display:initial";
      $('#aboutF31').hide('fast');
    };

    $(".clickrow").click(function() {
        window.location = $(this).data("url");
    });

  });
</script>
