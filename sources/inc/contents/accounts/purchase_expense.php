<h2>Purchase Expense</h2>
<br/>
<?php
include "./sources/inc/usercheck.php";
$flag = true;

if (isset($_POST['party']) && isset($_POST['p_t'])
    && isset($_POST['p_m']) && $_POST['amnt'] > 0) {

    //for check transaction
    if (isset($_POST['p_m']) && $_POST['p_m'] == 1) {
        if ($_POST['c_bn'] != "" && $_POST['c_br'] != "" && $_POST['c_ac'] != "") {
            $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
            $bank[0] = null;
            $bank[1] = $_POST['c_bn'];
            $bank[2] = $_POST['c_br'];
            $bank[3] = $_POST['c_d_y'] . '-' . $_POST['c_d_m'] . '-' . $_POST['c_d_d'];
            $bank[4] = $_POST['c_ac'];
            $response = $qur->addTran($_POST['party'], $date, $_POST['amnt'], $_POST['p_t'], $_POST['p_m'], $_POST['cmnt'], 1, $bank);

            if ($response['status'] == true) {
                extract($response);
                //'trans_id' => $new_transaction_id, 'party_id' => $party_id,
                echo "<h2 class='green'>Transaction successful</h2>
							  <a href='index.php?e=$encptid&page=accounts&sub=purchase_expense' class='bigbutton'>OK</a>
							  </br>
							  <a href='print.php?e=$encptid&page=accounts&sub=money_receipt&transaction=$trans_id&party=$party_id' class='bigbutton'>Create Money Receipt</a>";



            } else {
                echo "<h3 class='red'>Transaction failed</h3>";
            }
            $qur->purchaseExpense($_GET['pt'], $_GET['pay_type'], $_GET['cost']);

        } else {
            echo "<h3 class='red'>Ensure data about cheque</h3>";
            $qur->purchaseExpense($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
        }
    }
    //for cash transaction
    else {
        $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];

        $response = $qur->addTran($_POST['party'], $date, $_POST['amnt'], $_POST['p_t'], $_POST['p_m'], $_POST['cmnt'], 1, null);

        if ($response['status'] == true) {
            extract($response);
            //'trans_id' => $new_transaction_id, 'party_id' => $party_id,
            echo "<h2 class='green'>Transaction successful</h2>
							  <a href='index.php?e=$encptid&page=accounts&sub=purchase_expense' class='bigbutton'>OK</a>
							  </br>
							  <a href='print.php?e=$encptid&page=accounts&sub=money_receipt&transaction=$trans_id&party=$party_id' class='bigbutton'>Create Money Receipt</a>";

        } else if (isset($_GET['pt']) && isset($_GET['pay_type']) && isset($_GET['cost'])) {
            echo "<h3 class='red'>Transaction failed</h3>";
            $qur->purchaseExpense($_GET['pt'], $_GET['pay_type'], $_GET['cost']);
        } else {
            echo "<h3 class='red'>Ensure data validity</h3>";
            $payment_id = (isset($_GET['pt'])) ? $_GET['pt'] : NULL;
            $payment_type = (isset($_GET['pay_type'])) ? $_GET['pay_type'] : NULL;
            $payment_amount = (isset($_GET['cost'])) ? $_GET['cost'] : 0;

            $qur->purchaseExpense($payment_id, $payment_type, $payment_amount);
        }
    }
}

else {
    $payment_id = (isset($_GET['pt'])) ? $_GET['pt'] : NULL;
    $payment_type = (isset($_GET['pay_type'])) ? $_GET['pay_type'] : NULL;
    $payment_amount = (isset($_GET['cost'])) ? $_GET['cost'] : 0;

    $qur->purchaseExpense($payment_id, $payment_type, $payment_amount);
}

