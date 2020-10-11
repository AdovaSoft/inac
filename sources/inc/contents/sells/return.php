<h1> Sales Adjustment </h1>
<br/>
<?php
include("sources/inc/usercheck.php");
echo "<form method = 'POST' class='embossed'>";
echo "Voucher no : <input type='text' name='v' value='" . $inp->value_pgd('v') . "'>";
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='ab' value='Edit'>";
echo "</form>";

if (isset($_POST['ab']) && $_POST['ab'] == 'Edit') {
    if ($_POST['v'] != '') {
        $qur->print_edit_sells($_POST['v']);
    } else {
        echo "<br/><h3 class='red'>Please enter a voucher number then click edit.</h3>";
    }
}

if (isset($_POST['ab']) && $_POST['ab'] == 'save') {
    $flag = true;
    $id = $_POST['v'];
    $cost = 0;
    $pro = array();
    $driver = (isset($_POST['driver'])) ? $_POST['driver'] : NULL;
    $vehicle = (isset($_POST['vehicle'])) ? $_POST['vehicle'] : NULL;
    $company = (isset($_POST['company'])) ? $_POST['company'] : NULL;
    for ($i = 0; $i < $_POST['num']; $i++) {
        if ($_POST['pr_pc_' . $i] < $_POST['pc_' . $i] || $_POST['co_' . $i] <= 0) {
            echo "<br/><h2 class='red'>You can't add more product now and can't set any price to zero or negative</h2>";
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
        $flag = $qur->sells_return($id, $pro, $d, $cost, $driver, $vehicle, $company);

    if ($flag) {
        echo "<br/><h2 class='green'>Sales Update Successfully</h2>";
    } else {
        echo "<br/><h2 class='red'>Sales Return Failed</h2>";
    }
    $qur->print_edit_sells($_POST['v']);
}
?>
