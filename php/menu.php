<div id="menu">
  <div id='menu1'>
    <ul>
      <li id="m1"><a href="index.php?pg=aap">Event Pack</a></li>
      <li id="m2"><a href="index.php?pg=actv">Program</a></li>
      <li id="m3"><a href="index.php?pg=site">Sites</a></li>
      <li id="m4"><a href="index.php?pg=risk">Risk Items</a></li>
<!--      <li id="m5"><a href="index.php?pg=cmenu">Camp Menus</a></li> -->
      <?php if ($_SESSION['admin']=='TRUE') {echo '<li id="m6"><a href="index.php?pg=admin">Administration</a></li>';} ?>
      <li id="m7"><a href="index.php?pg=profile">Profile</a></li>
      <li id="m8"><a href="index.php?pg=log">Log out</a></li>
    </ul>
  </div>
</div>
