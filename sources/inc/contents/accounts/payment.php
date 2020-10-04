<h2>Payment</h2>
<br/>
<?php
include("sources/inc/usercheck.php");
$flag = true;
if (isset($_POST['ab'])) {
    if (isset($_POST['party']) && isset($_POST['p_t']) && isset($_POST['p_m']) && $_POST['amnt'] > 0) {
        if ($_POST['p_m'] == 1) {
            if ($_POST['c_bn'] != "" && $_POST['c_br'] != "" && $_POST['c_ac'] != "") {
                $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
                $bank[0] = null;
                $bank[1] = $_POST['c_bn'];
                $bank[2] = $_POST['c_br'];
                $bank[3] = $_POST['c_d_y'] . '-' . $_POST['c_d_m'] . '-' . $_POST['c_d_d'];
                $bank[4] = $_POST['c_ac'];
                $flag = $qur->addTran($_POST['party'], $date, $_POST['amnt'], $_POST['p_t'], $_POST['p_m'], $_POST['cmnt'], 1, $bank);
            } else {
                echo "<h3 class='red'>Ensure data about cheque</h3>";
                $qur->printPayment($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
            }
        } else {
            $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
            $flag = $qur->addTran($_POST['party'], $date, $_POST['amnt'], $_POST['p_t'], $_POST['p_m'], $_POST['cmnt'], 1, null);
            if ($flag) {
                echo "<h2 class='green'>Transaction successfull</h2>
							  <br/><a href='index.php?e=" . $encptid . "&&page=accounts&&sub=payment' class='bigbutton'>OK</a>";
            } else {
                echo "<h3 class='red'>Transaction failed</h3>";
                $qur->printPayment($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
            }
        }
    } else {
        echo "<h3 class='red'>Ensure data validity</h3>";
        $qur->printPayment($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
    }
} else {
    $qur->printPayment($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
}
?>
