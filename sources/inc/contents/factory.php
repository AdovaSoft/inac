<h1>Factory</h1>
<div id="bigmenu">
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=factory_all">Factory All Products</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=factory_raw">Factory Raw Matarials</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=factory_finished">Factory Finished</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=daily_report_factory">Daily Factory Stock</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=date_report_factory">Datewise Factory Report</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=transfer_to_factory'>Tansfer to Factory</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=update_fac'>Update Factroy Stock</a>" ?>
</div>