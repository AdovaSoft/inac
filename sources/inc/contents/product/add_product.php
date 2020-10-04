<h2>Add Product</h2>
<br/>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {

    $flag = ($_POST['n'] && $_POST['mt'] && $_POST['pt'] != null && $_POST['prc']);
    if ($flag) {
        $query = new indquery();
        $price = isset($_POST['prc']) ? $_POST['prc'] : 0;

        $flag = $query->addProduct($_POST['n'], $_POST['mt'], $_POST['pt'], $price);

        if ($flag) {
            echo "<h3 class='green'>New Product Added Successfully</h3>";
        } else {
            echo "<h3 class='red'>Failed to Add New Product</h3>";
            unset($_POST['ab']);
        }


    } else {
        echo "<h3 class='blue'>Please give product name, measurement type and product type.</h3>";
    }
}

echo "<br/><form method = 'POST' class='embossed'>";
if (isset($_POST['n']))
    $inp->input_text('Name : ', 'n', $_POST['n']);
else
    $inp->input_text('Name : ', 'n', null);

echo "<br/>";
if (isset($_POST['prc']))
    $inp->input_text('Price per unite : ', 'prc', $_POST['prc']);
else
    $inp->input_text('Price per unite : ', 'prc', null);

echo "<br/>Unit: ";
$qur->get_drop_down('mesurment_unite', 'unite', 'idunite', 'mt', null);


echo "<br/><br/>Product Type :  ";
$inp->input_radio('Raw Material', 'pt', 0, 0);
$inp->input_radio('Finished Product', 'pt', 1, 0);

echo "<br/>";
$inp->input_submit('ab', 'Add');

echo "</form>";
?>
