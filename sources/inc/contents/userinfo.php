<?php $usertype = isset($usertype) ? $usertype : 0; ?>
<h1>User</h1>
<div id="bigmenu">
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=add_user'>Add User</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&&page=delete_user'>Delete User</a>" ?>
  <a href="index.php?e=<?php echo $encptid ?>&&page=settings">Settings <img src="images/gear.gif" align="middle"
                                                                            alt="*"/></a>
  <a href="logout.php?e=<?php echo $encptid ?>">Logout <img src="images/cross.gif" align="middle" alt="X"/></a>
</div>