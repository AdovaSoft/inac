<h1>Purchase</h1>
<div id="bigmenu">
  <a href="index.php?e=<?= $encptid ?>&page=purchase&sub=new">New Purchase</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&page=purchase&sub=return'>Purchase Return</a>" ?>
  <a href="index.php?e=<?= $encptid ?>&page=purchase&sub=report">Purchase Report</a>
  <a href="index.php?e=<?= $encptid ?>&page=purchase&sub=daily_report">Daily Purchase</a>
</div>