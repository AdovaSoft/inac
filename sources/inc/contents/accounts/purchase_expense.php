<h2>Purchase Expense</h2>
<br/>
<?php
include "./sources/inc/usercheck.php";

/* d("GETS", $_GET, "POSTS", $_POST); */
$flag = true;

$party_id = $inp->value_pgd('party');
$payment_type = $inp->value_pgd('pay_type');
$payment_amount = $inp->value_pgd('cost');
$payment_medium = $inp->value_pgd('p_m');
$payment_comment = $inp->value_pgd('cmnt');

if (isset($_POST['party']) && isset($_POST['pay_type'])
    && isset($_POST['p_m']) && $payment_amount > 0) {

    //for check transaction
    if ($payment_medium == 1) {
        if ($_POST['c_bn'] != "" && $_POST['c_br'] != "" && $_POST['c_ac'] != "") {
            $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];
            $bank[0] = null;
            $bank[1] = $_POST['c_bn'];
            $bank[2] = $_POST['c_br'];
            $bank[3] = $_POST['c_d_y'] . '-' . $_POST['c_d_m'] . '-' . $_POST['c_d_d'];
            $bank[4] = $_POST['c_ac'];
            $bank[5] = $_POST['c_no'];
            $response = $qur->add_party_transaction($party_id, $date, $payment_amount, $payment_type, $payment_medium, $payment_comment, 1, $bank);

            if ($response['status'] == true) {
                extract($response);
                $qur->update_party_balance($party_id, EXPENSE, $payment_medium, $payment_amount);

                //'trans_id' => $new_transaction_id, 'party_id' => $party_id,
                echo "<h2 class='green'>Transaction Successful</h2>
							  <a href='index.php?e=$encptid&page=accounts&sub=purchase_expense' class='bigbutton'>OK</a>
							  </br>
							  <a href='print.php?e=$encptid&page=accounts&sub=money_receipt&transaction=$trans_id&party=$party_id' class='bigbutton'>Create Money Receipt</a>";
            } else {
                echo "<h3 class='red'>Transaction Failed</h3>";
            }

        } else {
            echo "<h3 class='red'>Ensure data about cheque</h3>";
            $qur->purchase_expense($party_id, $payment_type, $payment_amount);
        }
    } //for cash transaction
    else {
        $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];

        $response = $qur->add_party_transaction($party_id, $date, $payment_amount, $payment_type, $payment_medium, $payment_comment, 1, null);

        if ($response['status'] == true) {
            extract($response);
            //'trans_id' => $new_transaction_id, 'party_id' => $party_id,
            $qur->update_party_balance($party_id, EXPENSE, $payment_medium, $payment_amount);

            echo "<h2 class='green'>Transaction successful</h2>
							  <a href='index.php?e=$encptid&page=accounts&sub=purchase_expense' class='bigbutton'>OK</a>
							  </br>
							  <a href='print.php?e=$encptid&page=accounts&sub=money_receipt&transaction=$trans_id&party=$party_id' class='bigbutton'>Create Money Receipt</a>";

        } else if (isset($_GET['party']) && isset($_GET['pay_type']) && isset($_GET['cost'])) {
            echo "<h3 class='red'>Transaction failed</h3>";
            $qur->purchase_expense($party_id, $payment_type, $payment_amount);
        } else {
            echo "<h3 class='red'>Ensure data validity</h3>";
            $qur->purchase_expense($party_id, $payment_type, $payment_amount);
        }
    }
} else {
    $qur->purchase_expense($party_id, $payment_type, $payment_amount);
}

