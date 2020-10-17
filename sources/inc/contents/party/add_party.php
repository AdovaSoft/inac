<h2>Add new party</h2>
<br/>
<?php

include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    $flag = ($inp->check('name', 'n') && ($inp->check(null, 'p1') || $inp->check('phone number', 'p2')) && $inp->check('Address', 'a'));
    if ($flag) {
        $flag = $qur->addParty($_POST['n'], $_POST['p1'], $_POST['p2'], $_POST['a'], $_POST['em'], $_POST['t']);
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
echo "<table>";
echo "<tr><th>Name : </th>";
echo "<td>";
echo $inp->input_text('', 'n', $inp->value_pgd('n'), 'full-width');
echo "</td></tr>";
echo "<tr><th>Type : </th>";
echo "<td>";
echo "<select name='t' class='full-width'>";
echo "<option value='0'>Only Supplier</option>";
echo "<option value='1'>Only Client</option>";
echo "<option value='2'>Supplier and Client Both</option>";
echo "<option value='3'>Business Partner</option>";
echo "</select>";
echo "</td></tr>";
echo "<tr><th>Phone 1 : </th>";
echo "<td>";
echo $inp->input_text('', 'p1', $inp->value_pgd('p1'), 'full-width');
echo "</td></tr>";
echo "<tr><th>Phone 2 : </th>";
echo "<td>";
echo $inp->input_text('', 'p2', $inp->value_pgd('p2'), 'full-width');
echo "</td></tr>";
echo "<tr><th>Address : </th>";
echo "<td>";
echo $inp->input_text('', 'a', $inp->value_pgd('a'), 'full-width');
echo "</td></tr>";
echo "<tr><th>Email : </th>";
echo "<td>";
echo $inp->input_text('', 'em', $inp->value_pgd('em'), 'full-width');
echo "</td></tr>";
echo "<td colspan='2'>";
echo $inp->input_submit('ab', 'Add');
echo "</td></tr>";
echo "</table>";
?>