<h2>Add new party</h2>
<br/>
<?php

include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    $flag = ($inp->check('name', 'n') && ($inp->check(null, 'p1') || $inp->check('phone number', 'p2')) && $inp->check('Address', 'a'));
    if ($flag) {
        $flag = $qur->addParty($_POST['n'], $_POST['p1'], $_POST['p2'], $_POST['a'], $_POST['t']);
        if ($flag) {
            echo "<h3 class='green'>Party Added successfully</h3>";
        } else {
            echo "<h3 class='red'>failed</h3>";
            unset($_POST['ab']);
        }
    } else {
        echo "<h3 class='green'>Please give name, phone number and address</h3>";
    }
}
echo "<br/><form method = 'POST'  class='embossed'>";
if (isset($_POST['n']))
    $inp->input_text('Name : ', 'n', $_POST['n']);
else
    $inp->input_text('Name : ', 'n', null);
echo "<br/>";
echo "Type : ";
echo "<select name='t'>";
echo "<option value='0'>Only Supplier</option>";
echo "<option value='1'>Only Client</option>";
echo "<option value='2'>Supplier and Client Both</option>";
echo "<option value='3'>Business Partner</option>";
echo "</select>";
echo "<br/>";
echo "<br/>";
if (isset($_POST['p1']))
    $inp->input_text('Phone 1 : ', 'p1', $_POST['p1']);
else
    $inp->input_text('Phone 1 : ', 'p1', null);
echo "<br/>";
if (isset($_POST['p2']))
    $inp->input_text('Phone 2 : ', 'p2', $_POST['p2']);
else
    $inp->input_text('Phone 2 : ', 'p2', null);
echo "<br/>";
if (isset($_POST['a']))
    $inp->input_text('Address : ', 'a', $_POST['a']);
else
    $inp->input_text('Address : ', 'a', null);
$inp->input_submit('ab', 'Add');
?>