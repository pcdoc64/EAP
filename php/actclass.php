<?php
$conaap=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$query="SELECT * FROM act_class ORDER By act_name";
$result=mysqli_query($conaap,$query);
//if ($result) {echo ' result found';} else {echo 'result not found';};
//echo 'rows '.mysqli_num_rows($result).'';
$cnti=mysqli_num_rows($result);
if((!$result)||($cnti==0)) {header('location:index.php?pg=admin&sel=actclass_add');}
?>
<div id="aboutacttype" class="centered_form" style="display:none";>
  <a href="index.php?pg=admin&sel=actclass" id='close' title="Close" class="close">X</a>
  <div id="aboutactclass" class="div_form">
    <p>What are Activity Classes for?</p>
  </div>
</div>

<div id='PgTitle2'>Activity Class</div>
<div id='buttdiv'>
<button class='buttona' id="show">About Activity Class</button>
<input type="button" class="buttons" value="New Class" onclick="location.href='index.php?pg=admin&sel=actclass_add';"></input>
<!-- <input type="button" class="buttons" value="Edit Site" onclick="location.href='index.php?pg=site_edit';"></input> -->
</div>
<div class=centered_table>
  <input type="text" id="search" placeholder="Type to search">
<table id="tabler" class="scroll_table" style="width:100%" border='1'>
  <tr style="color:blue">
    <th class="tabEitem">Class</th>
    <th class="tabqual">Quals</th>
    <th class="tabqual">P&R</th>
    <th class="tabqual">QBSI</th>
    <th class="tabqual">QB SOA</th>
  </tr>
  <?php
  while($row= mysqli_fetch_array($result,MYSQLI_ASSOC)) {
    echo ' <tr class="clickrow" data-url="index.php?pg=admin&sel=actclass_edit&id='.$row["idact_type"].'">
              <td>'.$row["act_name"].'</td>
              <td style="width:150px">';
              if ($row["req_woodbead"]=='W') {echo 'WoodBeads ';};
              if ($row["req_special"]=='S') {echo 'Special';};
        echo '</td>
              <td>'.$row["PR"].'</td>
              <td>'.$row["QBSI"].'</td>
              <td>'.$row["QBSOA"].'</td>
           </tr>';
  }
  ?>

</table>
</div>

<!--  Mod popup starts here for equipment -->
<script type="text/javascript">
$( document ).ready(function() {
	$('#aboutacttype').hide('fast');
    var $rows=$('#tabler tr');


  document.querySelector('#show').onclick = function() {
    if (document.querySelector('#footer')) document.querySelector('#footer').style="display:none";
    $('#aboutacttype').show('fast','linear');
  };

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
