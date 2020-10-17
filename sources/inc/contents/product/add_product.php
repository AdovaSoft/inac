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
echo "<table>";
echo "<tr><th class='text-left'>";
echo "Name : </th><td>";
$inp->input_text('', 'n', $inp->value_pgd('n'), 'full-width');
echo "</td></tr>";
echo "<tr><th class='text-left'>";
echo "Price per unite : </th><td>";
$inp->input_text('', 'prc', $inp->value_pgd('prc'), 'full-width');
echo "</td></tr>";
echo "<tr><th class='text-left'>";
echo "Unit : </th><td>";
$qur->get_drop_down('mesurment_unite', 'unite', 'idunite', 'mt', null, 'full-width');
echo "</td></tr>";
echo "<tr><th class='text-left'>";
echo "Product Type : </th><td>";
$inp->input_radio('Raw Material', 'pt', 0, 0);
$inp->input_radio('Finished Product', 'pt', 1, 0);
echo "</td></tr>";
echo "</table>";
$inp->input_submit('ab', 'Add');

echo "</form>";
?>
