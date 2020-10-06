<h1>Accounts</h1>
<div id="bigmenu">
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=accounts&&sub=payment'>Payments</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=accounts&&sub=invest_draw'>Invest/Draw</a>" ?>
  <a href="index.php?e=<?= $encptid ?>&&page=accounts&&sub=report">Accounts Report</a>
  <a href="index.php?e=<?= $encptid ?>&&page=accounts&&sub=daily_report">Daily Accounts</a>
</div>