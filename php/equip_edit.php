<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
if (!$conaap) {echo 'access denied<br>';}
$sel=$_GET['sel'];
if ($sel=='equip_edit') {
  echo "<div id='PgTitle'>Edit F31 Items</div>";
  $cnti=0;
  $query="SELECT * FROM F31equip WHERE idequip=".$_GET['id'];
  //echo $query;
  $result=mysqli_query($conaap,$query);
  $cnti=mysqli_num_rows($result);
  if ((!$result)||($cnti==0)) {echo "no result";}
  $row=$result->fetch_row();
} else {
  echo "<div id='PgTitle2'>New F31 Items</div>";
  $result=FALSE;
}
?>
<div class="centered_form2">
 <div id="equipform" class="risk_form">
  <form action="php/equip_save.php" class="div_form" id="equipform" method="post">
    <?php
     if ($sel=='equip_edit') {
       echo '<input type="submit" class="buttons" name="update" value="Update"></input>'; //   disable if add button pressed
     } else {
       echo '<input type="submit" class="buttons" name="add" value="Add"></input>'; //   disable if edit button pressed
     }
    ?>
    <input style="float:right" type="submit" class="buttons" name="cancel" value="Cancel"></input>
    <div style="border: 1px solid #07839f; padding:5px">
      </br></br>
      <input type="hidden" id="equipid" name="equipid" value='<?php if($result) {echo $row[0];}?>'>
      <label class="labela">Item     : </label><td style="width:400px"><input type="text" id="equipitem" name="equipitem" style='width:400px' <?php if (!$result) {echo 'placeholder="First Aid Kit, Sunscreen, EPIRB etc" ';} ?> value="<?php if($result) {echo $row[1];}?>"/><br>
      <label class="labela">Comments: </label><textarea cols="8" rows="6" wrap="soft" id="equip_comment" name="equip_comment" style="width:445px"><?php if($result) {echo $row[2];}?></textarea><br>
    </div>

    <a href="../index.php?pg=admin&sel=equip" id='close' title="Close" class="close">X</a>
  </form>
 </div>
</div>
