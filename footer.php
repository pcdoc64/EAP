<?php
$lawcode=array("A Scout is trustworthy","A Scout is loyal","A Scout is helpful","A Scout is friendly","A Scout is cheerful","A Scout is considerate","A Scout is thrifty","A Scout is courageous","A Scout is respectful","A Scout cares for the environment");
$rndlaw=$lawcode[rand(0,9)];
echo "<div class='footer'>
<div class='footer_contents'>".$rndlaw."</div>
</div>";
 ?>
</body>
</html>
