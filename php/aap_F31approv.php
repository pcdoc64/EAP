<div id="approv" class="tabcontent">
  <div style="border: 1px solid #07839f; padding:5px; vertical-align:top">
    <h3>F31 - Approval</h3>
    <div>
      <table>
        <tr style="background-color:lightgrey">
          <td colspan=4><b> Team Leaders approval </b><i>(Refer to qualifications chart):</i></td>
        </tr>
        <tr>
          <td colspan=4><input type="checkbox" name="approv" id="approv" <?php if ($result and ($row[36]=="1")) {echo 'checked';} ?>>Approved as submitted.</td>
        </tr>
        <tr>
          <td colspan=2 style="width:300px"><input type="checkbox" name="approv_cond" id="approv_cond"<?php if ($result and ($row[37]=="1")) {echo 'checked';} ?>>Approved with the following conditions :</td>
          <td colspan=2 style="width:570px"><input type="text" name="approv_condit" id="approv_condit" style="width:550px" value="<?php if($result) {echo $row[38];}?>"></td>
        </tr>
        <tr>
          <td colspan=2><input type="checkbox" name="napprov_res" id="napprov_res"<?php if ($result and ($row[39]=="1")) {echo 'checked';} ?>>Not approved for the following reasons :</td>
          <td colspan=2><input type="text" name="napprov_reason" id="napprov_reason" style="width:550px" value="<?php if($result) {echo $row[40];}?>"></td>
        </tr>
        <tr>
          <td colspan=4><input type="checkbox" name="require_sub" id="require_sub"<?php if ($result and ($row[41]=="1")) {echo 'checked';} ?>>Requires submission to Queensland Chief Commissioner and branch team because it contains high and extreme risks that require approval</td>
        </tr>
        <tr>
          <td colspan=2><label class="labela">Name:</label><input type="text" name="approv_name" id="approv_name" style="width:120px" value="<?php if($result) {echo $row[42];}?>"></td>
          <td colspan=2><label class="labela">Appointment:</label><input type="text" name="approv_apoint" id="approv_apoint" style="width:460px" value="<?php if($result) {echo $row[43];}?>"></td>
        </tr>
        <tr>
          <td colspan=2></td>
          <td colspan=1 width="300px"></td>
          <td colspan=1><label class="labela">Date:</label>
          <input type="date" name="approv_date" id="approv_date" style="width:170px"  value="<?php if($result) {echo $row[44];}?>">
        </td>
        </tr>
      </table>
      <table style="table-layout:fixed; width=870px;">
        <tr>
          <td width="310"></td>
          <td width="350"></td>
          <td width="100"></td>
          <td width="100"></td>
        </tr>
        <tr style="background-color:lightgrey">
          <td colspan=2 style="width:610px"><b>Monitor and review </b> <i>(To be completed during or after activity)</i></td>
          <td colspan=1 style="width:90px" align="center">YES</td>
          <td colspan=1 style="width:90px" align="center">NO</td>
        </tr>
        <tr>
          <td colspan=2><label>Are the control methods still effective?</label></td>
          <td><input type="radio" name="effectiv_method" id="effectiv_method" style="width:85px" <?php if ($result and ($row[45]=="1")) {echo "checked";}?> value="1"></td>
          <td><input type="radio" name="effectiv_method" id="effectiv_method" style="width:85px" <?php if ($result and ($row[45]=="0")) {echo 'checked';}?> value="0"></td>
        </tr>
        <tr>
          <td colspan=2><label>Has there been any changes?</label></td>
          <td><input type="radio" name="changes" id="changes" style="width:85px" <?php if ($result and ($row[46]=="1")) {echo 'checked';}?> value="1"></td>
          <td><input type="radio" name="changes" id="changes" style="width:85px" <?php if ($result and ($row[46]=="0")) {echo 'checked';}?> value="0"></td>
        </tr>
        <tr>
          <td colspan=2><label>Are any further actions required?</label></td>
          <td><input type="radio" name="further_action" id="further_action" style="width:85px" <?php if ($result and ($row[47]=="1")) {echo 'checked';}?> value="1"></td>
          <td><input type="radio" name="further_action" id="further_action" style="width:85px" <?php if ($result and ($row[47]=="0")) {echo 'checked';}?> value="0"></td>
        </tr>
        <tr>
          <td colspan=4><label class="labela">Details</label><textarea cols="4" rows="3" wrap="soft" id="action_detail" name="action_detail" style="width:600px"><?php if($result) {echo $row[48];}?></textarea></td>
        </tr>
        <tr>
          <td colspan=1><label class="labela">Name:</label><input type="text" id="monitor_name" name="monitor_name" style="width:170px" value="<?php if($result) {echo $row[49];}?>"></td>
          <td colspan=3><label class="labela">Appointment:</label><input type="text" id="monitor_appt" name="monitor_appt" style="width:160px" value="<?php if($result) {echo $row[50];}?>"></td>
        </tr>
        <tr>
          <td colspan=2>
          <td colspan=2><label class="labela" style="width:60px">Date:</label><input type="date" class="datepicker" id="monitor_date" name="monitor_date" style="width:130px"  value="<?php if($result) {echo $row[51];}?>"></td>
        </tr>
      </table>
    </div>
  </div>
</div>
