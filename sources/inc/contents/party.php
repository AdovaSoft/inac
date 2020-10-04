<h1>Party</h1>
<div id="bigmenu">
  <a href="index.php?e=<?php echo $encptid ?>&&page=party&&sub=all_party">View All</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=party&&sub=clients">View Clients</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=party&&sub=suppliers">View Suppliers</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=party&&sub=partner">View Partners</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=party&&sub=view_particular">View Particular</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=home&&sub=party">Party Search</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=edit_party'>Edit Party Info</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=add_party'>Add New Party</a>" ?>
</div>