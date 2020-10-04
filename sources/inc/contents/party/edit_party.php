<h2>Edit Party</h2>
<br/>
<?php

include("sources/inc/usercheck.php");
if (isset($_POST['ab1'])) {

    $flag = true;;

    if (isset($_POST['pt']) && isset($_POST['n']) && isset($_POST['t']) && (isset($_POST['p1']) || isset($_POST['p2'])) && isset($_POST['a'])) {
        $id = $_POST['pt'];
        $name = $_POST['n'];
        $p1 = $_POST['p1'];
        $p2 = $_POST['p2'];
        $adrs = $_POST['a'];
        $type = $_POST['t'];
        if ($name == null || ($p1 == null && $p2 = null) || $adrs == null) {
            $flag = false;
            echo "<br/><h4 class='green'>You must give a name a phone number and address.</h4>";
        }
    } else {
        $flag = false;
        echo "<br/><h4 class='green'>You must give a name a phone number and address.</h4>";
    }

    if ($flag) {
        $flag = $qur->update_party($id, $name, $p1, $p2, $adrs, $type);
    }
    if ($flag) {
        echo "<br/><h4 class='green'>Successfully Changed</h4>";
    } else {
        echo "<br/><h4 class='red'>Failed to Changed</h4>";
    }
}

$query = sprintf("SELECT * FROM party ORDER BY name");
$party = $qur->get_custom_select_query($query, 2);
echo "<br/><form method = 'POST' class='embossed'>";
echo "<h4 class='blue'>Select Party</h4><br/>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
if (isset($_POST['pt']))
    $qur->get_dropdown_array($party, 0, 1, 'pt', $_POST['pt']);
else
    $qur->get_dropdown_array($party, 0, 1, 'pt', null);
echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Edit' />";
echo "</form>";

if (isset($_POST['ab']) || isset($_POST['ab1'])) {
    if (isset($_POST['pt']) && $_POST['pt'] != null) {
        $query = sprintf("SELECT idparty,name,phone,adress,type FROM (SELECT * FROM party WHERE idparty = %d) as p LEFT JOIN party_adress USING(idparty) LEFT JOIN party_phone USING(idparty) LEFT JOIN party_type USING(idparty);", $_POST['pt']);
        $party = $qur->get_custom_select_query($query, 5);
        echo "<br/><form method = 'POST'  class='embossed'>";
        echo "<input type = 'hidden' name = 'pt' value = '" . $_POST['pt'] . "' />";
        if (isset($_POST['n']))
            $inp->input_text('Name : ', 'n', $_POST['n']);
        else
            $inp->input_text('Name : ', 'n', $party[0][1]);
        echo "<br/>";
        echo "Type : ";
        echo "<select name='t'>";
        if ($party[0][4] == 1)
            echo "<option value='1' selected>Only Client (Current)</option>";
        elseif ($party[0][4] == 2)
            echo "<option value='2' selected>Supplier and Client Both  (Current)</option>";
        elseif ($party[0][4] == 3)
            echo "<option value='3' selected>Business Partner  (Current)</option>";
        else
            echo "<option value='0' selected>Only Supplier (Current)</option>";
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
            $inp->input_text('Phone 1 : ', 'p1', $party[0][2]);
        echo "<br/>";
        if (isset($_POST['p2']))
            $inp->input_text('Phone 2 : ', 'p2', $_POST['p2']);
        else
            $inp->input_text('Phone 2 : ', 'p2', $party[1][2]);
        echo "<br/>";
        if (isset($_POST['a']))
            $inp->input_text('Address : ', 'a', $_POST['a']);
        else
            $inp->input_text('Address : ', 'a', $party[0][3]);
        $inp->input_submit('ab1', 'Change');
        echo "</form>";
    }
}
?>
