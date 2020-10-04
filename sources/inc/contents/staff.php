<h1>Staff</h1>
<div id="bigmenu">
  <a href="index.php?e=<?php echo $encptid ?>&&page=staff&&sub=view_all">View All</a>
  <a href="index.php?e=<?php echo $encptid ?>&&page=home&&sub=staff">Staff Search</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=salary_update'>Salary Update</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=attendance_update'>Attendance Update</a>" ?>
  <a href="index.php?e=<?php echo $encptid ?>&&page=staff&&sub=report">Staff Report</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=edit_staff'>Edit Staff Info</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=add_staff'>Add Staff</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=staff&&sub=change_status'>Change Status</a>" ?>
</div>