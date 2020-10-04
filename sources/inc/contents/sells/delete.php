<?php
if (isset($_POST['sell_id']) && ($usertype == ADMIN)) {
    $delete_sell = $qur->selles_delete($_POST['sell_id']);
    if ($delete_sell) {
        echo "<br/><h3 class='green'>Sell Deleted Successfully</h3><br/>";
    } else {
        echo "<br/><h3 class='red'>Failed to Delete Sell</h3><br/>";
    }
} else {
    echo "<h2 class='red'>You are not permited to Delete.</h2><br/>";
}
?>