<h1>Stock</h1>
<div id="bigmenu">
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=all">All Products</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=raw">All Raw Matarials</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=finished">All Finished Product</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=godown_all">Godown All Products</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=godown_raw">Godown Raw Matarials</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=godown_finished">Godown Finished</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=factory_all">Factory All Products</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=factory_raw">Factory Raw Matarials</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=factory_finished">Factory Finished</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=daily_report">Daily Stock</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=date_report">Datewise Report</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=daily_report_godown">Daily Godown Stock</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=date_report_godown">Datewise Godown</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=daily_report_factory">Daily Factory Stock</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=stock&&sub=date_report_factory">Datewise Factory Report</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=transfer_to_factory'>Tansfer to Factory</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=transfer_to_stock'>Tansfer to Godown</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=update_fac'>Update Factroy Stock</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=update'>Update Godown Stock</a>" ?>
</div>

