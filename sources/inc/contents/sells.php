<h1>Sells</h1>
<div id="bigmenu">
  <a href="index.php?e=<?= $encptid ?>&page=sells&sub=new">New Sell</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&page=sells&sub=return'>Sell Adjustment</a>" ?>
  <a href="index.php?e=<?= $encptid ?>&page=sells&sub=report">Sell Report</a>
  <a href="index.php?e=<?= $encptid ?>&page=sells&sub=daily_report">Daily Sell</a>
</div>