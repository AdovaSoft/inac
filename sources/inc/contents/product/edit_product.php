<h2>Edit Product</h2>
<br/>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab2'])) {
    $flag = ($_POST['n'] && $_POST['mt'] && $_POST['pt'] != null && $_POST['prc']);
    if ($flag) {
        $price = isset($_POST['prc']) ? $_POST['prc'] : 0;

        $flag = $qur->editProduct($_POST['id'], $_POST['n'], $_POST['mt'], $_POST['pt'], $price);

        if ($flag) {
            echo "<h3 class='green'>Edit Product successfully</h3><br/>";
        } else {
            echo "<h3 class='red'>Edit Product failed</h3><br/>";
        }
    } else {
        echo "<h3 class='red'>Please enter name, mesurment type and product type</h3><br/>";
    }
}

$pro = $qur->get_custom_select_query("SELECT * FROM product ORDER BY name", 2);
echo "<form method = 'POST'  class='embossed'>";
echo "<h4 class='blue'>Select Product</h4><br/>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
if (isset($_POST['p']))
    $qur->get_dropdown_array($pro, 0, 1, 'p', $_POST['p']);
else
    $qur->get_dropdown_array($pro, 0, 1, 'p', null);
echo "<br/>";
$inp->input_submit('ab', 'Edit');
echo "</form>";


if (isset($_POST['p'])) {
    if ($_POST['p'] != null) {

        echo "<br/><form method = 'POST'  class='embossed'>";

        echo "<input type = 'hidden' name = 'id' value = '" . $_POST['p'] . "' />";

        $query = sprintf("SELECT name,idunite,sell,purchase,price FROM (SELECT * FROM product WHERE idproduct = %d) as p LEFT JOIN product_details USING (idproduct)  LEFT JOIN price USING(idproduct) ORDER BY name;", $_POST['p']);

        $info = $qur->get_custom_select_query($query, 5);

        if (isset($_POST['n']))
            $inp->input_text('Name : ', 'n', $_POST['n']);
        else
            $inp->input_text('Name : ', 'n', $info[0][0]);

        echo "<br/>";

        if (isset($_POST['prc']))
            $inp->input_text('Price per unite : ', 'prc', $_POST['prc']);
        else
            $inp->input_text('Price per unite : ', 'prc', $info[0][4]);

        echo "<br/>Unit: ";
        $qur->get_drop_down('mesurment_unite', 'unite', 'idunite', 'mt', $info[0][1]);


        echo "<br/><br/>Product Type :  ";
        if ($info[0][2] == 1) {
            $inp->input_radio('Sell', 'pt', 0, 1);
            $inp->input_radio('Purchase', 'pt', 1, 0);
        } else {
            $inp->input_radio('Sell', 'pt', 0, 0);
            $inp->input_radio('Purchase', 'pt', 1, 1);
        }


        echo "<br/>";

        $inp->input_submit('ab2', 'Save');

        echo "</form>";
    }
}
?>
