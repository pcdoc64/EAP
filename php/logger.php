<?php
  $conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
  $query="SELECT * FROM logged ORDER BY LogID";
  $result=mysqli_query($conaap,$query);
  echo "<br>";
?>
<div id='PgTitle'>Action Logging</div>
<div class="aap_table">
  <input type="text" id="search" placeholder="Type to search">
  <table id="tabler" class="sortable scroll_table" style="width:900px" border='1'>
    <tr style="color:blue;width:100%">
      <th class="tabloc">Date</th>
      <th class="tabmap">User</th>
      <th class="tabcost">Section</th>
      <th class="tabcost">Rec Action</th>
      <th class="tabmap">Org Field</th>
      <th class="tabsect">Org Value</th>
      <th class="tabsect">Chng Value</th>
    </tr>

<?php
    if($result) {
      while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        echo ' <tr>
                  <td class="tabloc">'.date("d/m/Y H:i",strtotime($row["sdate"])).'</td>
                  <td class="tabmap">'.$row["uid"].'</td>
                  <td class="tabcost">'.$row["sectn"].'</td>
                  <td class="tabcost">'.$row["actn"].'</td>
                  <td class="tabmap">'.$row["orgfield"].'</td>
                  <td class="tabsect">'.$row["orgVal"].'</td>
                  <td class="tabsect">'.$row["chngval"].'</td>
                </tr>';
      }
    }
?>
  </table>
</div>

<script>
$( document ).ready(function() {
//  document.querySelector("#m1").style="Background-Color:black";
  var $rows=$('#tabler tr');

$('#search').keyup(function() {

  var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
      reg = RegExp(val, 'i'),
      text;

  $rows.show().filter(function() {
      text = $(this).text().replace(/\s+/g, ' ');
      return !reg.test(text);
  }).hide();
});
$(".clickrow").click(function() {
    window.location = $(this).data("url");
});
});
</script>
