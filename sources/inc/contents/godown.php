<h1>Godown</h1>
<div id="bigmenu">
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=godown_finished">Godown Finished</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=daily_report_godown">Daily Godown Stock</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=date_report_godown">Date wise Godown</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=godown_all">Godown All Products</a>
  <a href="index.php?e=<?= $encptid ?>&&page=stock&&sub=godown_raw">Godown Raw Materials</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=transfer_to_stock'>Transfer to Godown</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=stock&&sub=update'>Update Godown Stock</a>" ?>
</div>