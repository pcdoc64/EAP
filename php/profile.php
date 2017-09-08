<?php
  $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  $con=mysqli_connect(DB_HOST,DBC_USER,DBC_PASSWORD,DBC_NAME);
  if (!$conaap) {echo 'access denied<br>';}
  echo "<div id='PgTitle'>Update Profile</div>";
  $cnti=0;
  $query="SELECT * FROM oc_users WHERE uid='".$_SESSION['user']."'";
//  echo $query;
  $result=mysqli_query($conaap,$query);
//  echo var_dump($result);
  $cnti=mysqli_num_rows($result);
  if (!$result || $cnti==0) {
//    echo "no result";
    $sql="INSERT INTO oc_users (uid) VALUES ('".$_SESSION['user']."')";
    $result=mysqli_query($conaap,$sql);
    $query="SELECT * FROM oc_users WHERE uid='".$_SESSION['user']."'";
    $result=mysqli_query($conaap,$query);
    $cnti=mysqli_num_rows($result);
  }
  $row=$result->fetch_row();

  $sendmeto[]=null;
  $grp=array("Group Leaders","IT","leaders","PLA", "Joeys","Cubs","Scouts","Venturers","Rovers");
  $queryg="SELECT gid FROM oc_group_user WHERE uid='".$_SESSION['uid']."'";
  $resultg=mysqli_query($con,$queryg);
  while($rowg= mysqli_fetch_array($resultg,MYSQLI_ASSOC)) {
//    if ($rowg['gid']<>"Group Leaders" || $rowg['gid']<>"IT" || $rowg['gid']<>"leaders" || $rowg['gid']<>"PLA") { array_push($sendmeto,$rowg);}
    if (!(in_array($rowg['gid'], $grp))) { array_push($sendmeto,$rowg);}
  }

?>
<div class="centered_form2">
<form action="php/prof_save.php" id="profform" method="post">
<input type="submit" class="buttons" name="update" value="Update"></input>
<input style="float:right" type="submit" class="buttons" name="cancel" value="Cancel"></input>
<div style="border: 1px solid #a7833f; padding:5px">
  </br></br>
  <input type="hidden" id="uid" name="uid" value="<?php echo $_SESSION['user'];?>">
  <label class="labela required">Name : </label><input type="text" id="name" required name="name" style='width:260px' <?php if (!$result) {echo 'placeholder="NAme of User" ';} ?> value="<?php if($result) {echo $row[1];}?>"/><br>
</div><br>
<div style="border: 1px solid #07839f; padding:5px">
  <label class="labela" id="position">Position: </label>
  <select id = "pos" name="pos" style="width:170px" value="<?php echo $row[2];?>">
    <?php
      $rank=array(1=>'Assistant Leader',2=>'Section Leader',3=>'Assist. Crew LEader',4=>'Crew Leader',5=>'Rover Adviser',6=>'Assistant GL',7=>'Group Leader',8=>'Assistant DC',9=>'District Comm',10=>'Assistant Section RC',11=>'Section RC',12=>'Assistant RC',13=>'Regional Comm',14=>'Assistant Section BC',15=>'Section BC',16=>'Assistant BC',17=>'Branch Comm');
      echo $row[2];
      foreach($rank as $k=>$v) {
        if ($row[2]==$v) {
          echo '<option selected value= "'.$v.'">'.$v.'</options>';
        } else {
          echo '<option value= "'.$v.'">'.$v.'</options>';
        }
      }
      ?>
  </select><br>
  <label class="labela" id="gapfiller"></label>
  <label class="labelf" id="branch">Branch</label>
  <label class="labelb" id="branch">Region</label>
  <label class="labeld" style="height:20px" id="branch"></label><label class="labelb" id="branch">District</label>
    <br>
  <label class="labela" id="gapfiller"></label>
    <select id = "brnch" name="brnch" style="width:120px" value="<?php echo $row[8];?>">
    <?php
      $queryt="SELECT * FROM branch order by idbranch";
      $resultt=mysqli_query($conaap,$queryt);
      $cnti=mysqli_num_rows($resultt);
      if ((!$resultt)||($cnti==0)) {echo "no result";}
      while ($brnch = mysqli_fetch_array($resultt)) {
        if (($result) and ($row[8]==$brnch[0])) {
          echo "<option selected value= ".$brnch[0].">".$brnch[1]."</options>";
        } else {
          echo "<option value= ".$brnch[0].">".$brnch[1]."</options>";
        }
      }
    ?>
    </select>
    <td><select id = "regn" name="regn" style="width:150px"   value="<?php echo $row[7];?>">
      <?php
        $queryt="SELECT * FROM region order by region";
        $resultt=mysqli_query($conaap,$queryt);
        $cnti=mysqli_num_rows($resultt);
        if ((!$resultt)||($cnti==0)) {echo "no result";}
        while ($regn = mysqli_fetch_array($resultt)) {
          if (($result) and ($row[7]==$regn[0])) {
            echo "<option selected value= ".$regn[0].">".$regn[1]."</options>";
          } else {
            echo "<option value= ".$regn[0].">".$regn[1]."</options>";
          }
        }
      ?>
    </select>
    <input type="text" id="district" name="district" style='width:160px' <?php if (!$result) {echo 'placeholder="District Name" ';} ?> value="<?php if($result) {echo $row[6];}?>"/>
    <br>
    <label class="labela required" id="branch">Group</label>
    <select id="group" name="group" data-group="<?php echo $row[5];?>">

    </select>

  </div><br>
  <div style="border: 1px solid #37234f; padding:5px">
    <label class="labela" id="branch">Best Phone</label><input type="text" id="phone1" name="phone1" style='width:160px' value="<?php if($result) {echo $row[9];}?>"/>
    <label class="labela" id="branch">2nd Phone</label><input type="text" id="phone2" name="phone2" style='width:160px' value="<?php if($result) {echo $row[10];}?>"/><br>
    <label class="labela required" id="branch">Best Email</label><input type="email" required id="email1" name="email1" style='width:160px' value="<?php if($result) {echo $row[11];}?>"/>
    <label class="labela" id="branch">2nd Email</label><input type="email" id="email2" name="email2" style='width:160px' value="<?php if($result) {echo $row[12];}?>"/><br>
    <label class="labela" id="branch">Emerg. Cont.</label><input type="text" id="emerg_name" name="emerg_name" style='width:160px' value="<?php if($result) {echo $row[13];}?>"/>
    <label class="labela" id="branch">Emerg. Ph.</label><input type="text" id="emerg_phone" name="emerg_phone" style='width:160px' value="<?php if($result) {echo $row[14];}?>"/><br>
  </div>

</form>
</div>


<script type="text/javascript">
$( document ).ready(function() {
  document.querySelector("#m7").style="Background-Color:black";

//                                                              Fill Group names
  gname = <?php echo json_encode($sendmeto); ?>;
  gname.splice(0,1);
  newHTML='';
  selgnm=document.querySelector('#group').dataset.group;
  for (var i in gname) {
    gnm=gname[i]['gid'];
    if (selgnm==gnm){newHTML+="<option selected value='"+gnm+"'>"+gnm+"</option>";} else {newHTML+="<option value='"+gnm+"'>"+gnm+"</option>";}
 };
  //          put the HTML options list into the dropdown for share this box
  $('#group').html(newHTML);  // groups
});
</script>
