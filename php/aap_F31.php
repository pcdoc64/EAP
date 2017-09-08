<div id="equip" class="tabcontent">
  <div style="border: 1px solid #07839f; padding:5px; vertical-align:top">
    <h3>F31 - Minimum Equipment / Facilities</h3>
    <div>
      <label class="labelb" style="width:80px">Safety Officer</label>
      <input type="text" <?php if (!$result) {echo 'placeholder="Safety Officer"';} ?> id="F31_safety" name="F31_safety" style='width:200px' value="<?php if($result) {echo $row[32];}?>"/><br>
      <table><tr>
      <td><label style="width:350px">Are there sufficient leaders with minimum qualifications supervising the activity?</label></td><td><input type="radio" name="F31_qual_leaders" id="F31_qual_leaders" value="1" <?php if ($result and ($row[33]=="1")) {echo 'checked';} ?>>YES<input type="radio" name="F31_qual_leaders" id="F31_qual_leadersn" value="0" <?php if ($result and ($row[33]=="0")) {echo 'checked';} ?>>NO</td></tr>
      <tr><td><label style="width:350px" >Are there sufficient leaders with current First Aid including CPR?</label></td><td><input type="radio" name="F31_firstaid" id="F31_firstaid" value="1" <?php if ($result and ($row[34]=="1")) {echo 'checked';} ?>>YES<input type="radio" name="F31_firstaid" id="F31_firstaidn" value="0" <?php if ($result and ($row[34]=="0")) {echo 'checked';} ?>>NO</td></tr>
    </table>
      <table class="scroll_table" style="width:100%" border='1'>
        <tr style="background-color:lightgrey">
          <th><b>Minimum Equipment/Facilities</b></th>
          <th><b>YES</b></th>
          <th><b>NO</b></th>
          <th><b>N/A</b></th>
          <th><b>Comment / Further info</b></th>
        </tr>
        <?php
        if ($result) { $stmts = mysqli_prepare($conaap, "SELECT req, comments FROM AAPequip WHERE idAAP = ? AND idequip = ?"); }
        $queryf="SELECT idequip, item, comments FROM F31equip ORDER By idequip";
        $resultf=mysqli_query($conaap,$queryf);
        $cntif=mysqli_num_rows($resultf);
        while($rowf= mysqli_fetch_array($resultf,MYSQLI_ASSOC)) {
          $ide=$rowf["idequip"];
          if ($ide==10) {echo '<tr style="background-color:lightgrey">
                                <th><b>Governing Bodies/ Associations/ Legislation</b></th>
                                <th><b>YES</b></th>
                                <th><b>NO</b></th>
                                <th><b>N/A</b></th>
                                <th><b>Comment / Further info</b></th>
                              </tr>';}
          if ($ide==12) {echo '<tr style="background-color:lightgrey">
                                  <th><b>Scout-specific policies and rules</b></th>
                                  <th><b>YES</b></th>
                                  <th><b>NO</b></th>
                                  <th><b>N/A</b></th>
                                  <th><b>Comment / Further info</b></th>
                                </tr>';}
          if ($result) {
            mysqli_stmt_bind_param($stmts,'ii',$row[0],$ide);
            mysqli_stmt_execute($stmts);
            mysqli_stmt_bind_result($stmts, $reqe, $commente);
            mysqli_stmt_fetch($stmts);
            mysqli_stmt_free_result($stmts);
          }
  //    $reqe='1';$commente='';
          $seton=0;
          echo ' <tr>
                    <td>'.$rowf["item"].'</td>
                    <td><input type="radio" id="min['.$ide.']" name="min['.$ide.']" value=1 ';
                    if ($result and ($reqe=="1")) {echo 'checked';$seton=1;}
                    echo '></td>
                    <td><input type="radio" id="min['.$ide.']" name="min['.$ide.']" value=2 ';
                    if ($result and ($reqe=="2")) {echo 'checked';$seton=1;}
                    echo '></td>
                    <td><input type="radio" id="min['.$ide.']" name="min['.$ide.']" value=3 ';
                    if ($result and ($reqe=="3")) {echo 'checked';$seton=1;}
                    if ($seton==0) {echo 'checked';}
                    echo '></td>
                    <td><textarea cols="8" rows="2" wrap="soft" style="width:400px" name="cmnt['.$ide.']">';
                    if ($result) {echo $commente;} else {echo $rowf["comments"];}
                    echo '</textarea></td>
                </tr>';
          }
         ?>
      </table>
    </div>
    <div><label id="row">row</label><br><label id="col">col</label></div>
  </div>
</div>
