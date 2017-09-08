<?php
echo "<div id='PgTitle'>Camp Menus</div>";
?>
<div id='buttdiv'>
  <input type="button" class="buttons" value="New Menu" onclick="location.href='index.php?pg=menu_add';"></input>
<!--  <input type="button" class="buttons" value="Edit Menu" onclick="location.href='index.php?pg=menu_edit';"></input> -->
</div>

<script>
$( document ).ready(function() {
  document.querySelector("#m5").style="Background-Color:black";
});
</script>
