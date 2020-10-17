<?php
if (isset($_POST['delete']) && ($_POST['delete'] = 'Delete') && isset($_POST['tid']) && ($usertype == ADMIN)) {
    $del = $qur->deleteTransaction($_POST['tid']);
    if ($del)
        echo "<h3 class='green'>Transaction Deleted Successfully</h3><br/>";
    else
        echo "<h3 class='red'>Could not Delete Transaction</h3><br/>";
}

if ($usertype != ADMIN && isset($_POST['delete'])) {
    echo "<h2 class='red'>You are not permitted to Delete.</h2><br/>";
}
?>