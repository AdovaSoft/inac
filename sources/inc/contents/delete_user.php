<h1>Delete Current User</h1>
<br/>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    if (isset($_POST['s']) && $_POST['s'] != null) {
        $qur = new indquery();
        $query = sprintf("DELETE FROM user WHERE idstaff = %d", $_POST['s']);
        $qur->execute_query('START TRANSACTION');
        $flag = $qur->execute_query($query);

        if ($flag) {
            $custom_message = "<h3 class='green'>User Successfully Deleted</h3><br/>";
            $qur->execute_query('COMMIT');
        } else {
            $custom_message = "<h3 class='red'>Failed to Delete</h3><br/>";
            $qur->execute_query('ROLLBACK');
        }
    }
} else {
    $custom_message = "<h3 class='blue'>Please Select a staff to delete from user</h3><br/>";
}
echo "<form method = 'POST' class='embossed'>";
echo $custom_message;
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
$get_user = $qur->get_custom_select_query("SELECT idstaff,name FROM user LEFT JOIN staff USING(idstaff) WHERE type = 0;", 2);
$qur->get_dropdown_array($get_user, 0, 1, 's', null);
echo "<br/>";
$inp->input_submit('ab', 'DELETE');
echo "</form>";
?>
