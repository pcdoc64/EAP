
<div id="forms" class="tabcontent">
  <div style="border: 1px solid #07839f; padding:5px; margin:auto; margin-left:30%; width:40%; vertical-align:top; display:inline-block">
    <div style="padding:5px; margin:auto; float:left">
      <table>
        <tr><td><label for="PDFall">Full Package</label></td><td><input type="checkbox" id="PDFall"></input></td></tr>
        <tr><td><label for="C5">C5</label></td><td><input type="checkbox" id="C5"></input></td></tr>
        <tr><td><label for="C43">C4/C3</label></td><td><input type="checkbox" id="C43"></input></td></tr>
        <tr><td><label for="F31">F31</label></td><td><input type="checkbox" id="F31"></input></td></tr>
        <tr><td><label for="PDFprog">Program</label></td><td><input type="checkbox" id="PDFprog"></input></td></tr>
<!--        <tr><td><label for="PDFmenu">Menu & shop</label></td><td><input type="checkbox" id="PDFmenu"></input></td></tr>
        <tr><td><label for="PDFnote">Instructions</label></td><td><input type="checkbox" id="PDFnote"></input></td></tr> -->
      </table>
    </div>
    <div style="padding:5px; margin:auto; margin-top:60px; float:right">
      <button type="button" id="PDFcreate" style="float:right; width:90px; margin:2px;">Create PDF</button>
      <button type="button" id="EmailCreate" style="float:right; width:90px; margin:2px;">Email Forms</button><br><br>
      <label id="addLabel" class="labelas" style="visibility:hidden">Address </label><input type="email" name="emailAddr" id="emailAddr" placeholder="email address" value="<?php echo $_SESSION['email1']; ?> " style="visibility:hidden"></input><br>
      <button type="button" id="EmailSub" style="visibility:hidden; float:right; width:90px; margin:2px;">Submit</button>
    </div>
  </div>
</div>
