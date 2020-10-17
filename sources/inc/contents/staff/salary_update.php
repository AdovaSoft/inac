<h1>Update Salary</h1>
<br/>
<script type="text/javascript">
    function writeit(txt) {
        var t = document.getElementById('tran_type')[document.getElementById('tran_type').selectedIndex].innerHTML;
        var s = document.getElementById('staff')[document.getElementById('staff').selectedIndex].innerHTML;
        var tbox = document.getElementById('cmnt');
        tbox.value = "Paying" + t + " to " + s;
    }
</script>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    $date = $_POST['d_y'] . '-' . $_POST['d_m'] . '-' . $_POST['d_d'];

    if (isset($_POST['s']) && $_POST['s'] != null && isset($_POST['amnt']) && $_POST['amnt'] > 0 && isset($_POST['tt']) && $_POST['tt'] > 0) {
        $flag = true;
        if ($_POST['tt'] == 2) {
            $flag = $qur->add_bonus_payment($date, $_POST['s'], $_POST['m'], $_POST['y'], $_POST['amnt'], $_POST['cmnt']);
        } elseif ($_POST['tt'] == 1) {

            $flag = $qur->add_salary_pay($date, $_POST['s'], $_POST['m'], $_POST['y'], $_POST['amnt'], $_POST['cmnt']);
        }

        if ($flag) {
            echo "<h3 class='green'>Salary Update Successfully</h3>";
        } else {
            echo "<h3 class='red'>Salary Update failed</h3>";
        }
    } else {
        echo "<h3 class='red'>Please provide all info</h3>";
    }
}
echo "<br/><form method = 'POST'   class='embossed'>";
$query = "SELECT idstaff,name,post FROM staff WHERE status = 1 ORDER by name;";
$staff = $qur->get_custom_select_query($query, 3);
echo "Date : ";
$inp->input_date('d', Date('Y-m-d'));
echo "<br/><br/>";
echo "Staff : ";
echo "<select name = 's' id = 'staff' onchange='writeit()' >";
echo "<option></option>";
foreach ($staff as $s) {
    echo "<option value = '" . $s[0] . "' >" . $s[1] . " - " . $s[2] . "</option>";
}
echo "</select>";

echo "<br/><br/>";

echo "Month : ";

$inp->select_month('m', isset($_POST['m']) ? $_POST['m'] : Date('m'));

$inp->select_digit('y', 2001, 2031, isset($_POST['y']) ? $_POST['y'] : Date('Y'), 1);

echo "<br/><br/>Amount :<br/>";
$inp->input_number(null, 'amnt' . $i = null, isset($_POST['amnt']) ? $_POST['amnt'] : null);

echo "<br/>Payment Type : ";
echo "<select name='tt' id='tran_type' onchange='writeit()' >";
echo "<option >  </option> ";
echo "<option value = '1'> Salary </option> ";
echo "<option value = '2'> Bonus </option> ";
echo "</select>";
echo "<br/><br/>Comment : ";
echo "<input type = 'text' name = 'cmnt' id = 'cmnt' value = '' />";
echo "<br/>";
$inp->input_submit('ab', 'Save');
echo "</form>";