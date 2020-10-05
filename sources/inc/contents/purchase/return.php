<h2> Purchase Return </h2>
<br/>
<?php
include("sources/inc/usercheck.php");
echo "<form method = 'POST' class='embossed'>";
echo "Voucher no : <input type='text' name='v' value='" . $inp->value_pgd('v') . "'>";
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='ab' value='Edit'>";
echo "</form>";

if (isset($_POST['ab']) && $_POST['ab'] == 'Edit') {
    if ($_POST['v'] != '') {
        $qur->printReturnPur($_POST['v']);
    } else {
        echo "<br/><h3 class='red'>Please enter a voucher number then click edit.</h3>";
    }
}

if (isset($_POST['ab']) && $_POST['ab'] == 'Save') {

    $flag = true;
    $id = $_POST['v'];
    $cost = 0;
    $pro = array();
    for ($i = 0; $i < $_POST['num']; $i++) {

        if ($_POST['pr_pc_' . $i] < $_POST['pc_' . $i] || $_POST['co_' . $i] <= 0) {
            echo "<br/><h2 class='red'>You cant add more product now and cant set any price to zero or negetive</h2>";
            $flag = false;
            break;

        } else {
            $pro[$i][0] = $_POST['pr_' . $i];
            $pro[$i][1] = $_POST['pr_pc_' . $i];
            $pro[$i][2] = $_POST['pc_' . $i];
            $pro[$i][3] = $_POST['co_' . $i];
        }

        $cost += $_POST['pr_pc_' . $i] * $_POST['co_' . $i];
    }

    $d = $_POST['d'];
    if ($flag)
        $flag = $qur->purchaseReturn($id, $pro, $d, $cost);

    if ($flag) {
        echo "<br/><h2 class='green'> Purchase Return Successfull</h2>";
    } else {
        echo "<br/><h2 class='red'> Purchase Return Failed</h2>";
    }
    $qur->printReturnPur($_POST['v']);
}
?>

