<?php
if (isset($_POST['pur_id']) && ($usertype == ADMIN)) {
    $delete_purchase = $qur->purchase_delete($_POST['pur_id']);
    if ($delete_purchase) {
        echo "<br/><h3 class='green'>Purchase Deleted Successfully</h3><br/>";
    } else {
        echo "<br/><h3 class='red'>Failed to Delete Purchase</h3><br/>";
    }
} else {
    echo "<h2 class='red'>You are not permited to Delete.</h2><br/>";
}
?>