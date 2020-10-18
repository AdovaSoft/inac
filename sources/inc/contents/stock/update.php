<h2>Update Godown Stock </h2>
<?php
include("sources/inc/usercheck.php");
if ($inp->value_pgd('say') == 1) {
    $custom_message = "<br/><h3 class='green'>Stock Update Successfully</h3>";
} elseif ($inp->value_pgd('say') == 2) {
    $custom_message = "<br/><h3 class='red'>Stock Update failed</h3>";
} elseif ($inp->value_pgd('say') == 3) {
    $c_s = $qur->get_cond_row('stock', array('stock'), 'idproduct', '=', $inp->value_pgd('p'));
    $custom_message = "<br/><h3 class='red'>Current stock : " . $c_s[0][0] . "<br/>You cant remove " . $_POST['s'] . "</h3>" . "<br/><h3 class='red'>Exedding your stock</h3>";
} elseif ($inp->value_pgd('say') == 4) {
    $custom_message = "<br/><h3 class='red'>DATA ARE NOT VALID</h3>";
} elseif ($inp->value_pgd('say') == 5) {
    $custom_message = "<br/><h3 class='red'>Stock update cant be zero or negetive</h3>";
} else {
    $custom_message = "<br/><h3 class='blue'>Please provide update informaton</h3>";
}

echo $custom_message;
echo "<br/><form action='editor.php' method = 'POST' class='embossed'>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
echo "<br/>Date : ";
$inp->input_date('d', date('Y-m-d'));
echo "<br/><br/>Product : ";
$array = $qur->get_custom_select_query('SELECT product.*, unite, stock FROM product 
LEFT JOIN stock USING(idproduct) 
LEFT JOIN product_details USING(idproduct)
LEFT JOIN mesurment_unite USING(idunite);', 4);
$qur->get_dropdown_array($array, 0, 1, 'p', null, '', true);
echo "<br/><br/>";

$inp->input_text('Quantity : ', 's', $inp->value_pgd('s'));

echo "<br/>";
$inp->input_radio('Add', 'pr', 1, 0);
$inp->input_radio('Remove', 'pr', -1, 0);
echo "<br/>";
echo "<input type='hidden' name='editor' value='stock/update'/>";
echo "<input type='hidden' name='e' value='" . $encptid . "'/>";
echo "<input type='hidden' name='returnlink' value='index.php?page=stock&&sub=update&&e=" . $encptid . "'/>";
$inp->input_submit('ab', 'Update');
echo "</form>";
?>
