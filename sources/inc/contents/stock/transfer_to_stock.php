<h1>Product Transfer to Godown</h1>
<br/>
<?php
if (isset($_POST['ab']) && isset($_POST['p']) && isset($_POST['n'])) {
    $info = null;
    if ($_REQUEST['p'] > 0 && $_REQUEST['n'] > 0) {
        $query = sprintf("SELECT factory_stock FROM stock WHERE idproduct = " . $_REQUEST['p']);
        $info = $qur->get_custom_select_query($query, 1);
        if ($info[0][0] < $_REQUEST['n']) {
            echo "<h2 class='red'>Low on factory stock, current factory stock : " . $info[0][0] . "</h2><br/>";
        } else {
            $flag = $qur->transfarProduct($_POST['p'], $_POST['n'], 2, $inp->get_post_date('d'));
        }
    } elseif ($_REQUEST['n'] <= 0) {
        echo "<h2 class='red'>Please Insert Valid Data</h2><br/>";
    }
}

echo "<form method = 'POST' class='embossed'>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";

echo "<br/>Date : ";
$inp->input_date('d', date('Y-m-d'));

echo "<br/><br/>Product : ";
echo "<select name = 'p'>";
echo "<option value=''>Select an option</option>";
$info = $qur->get_custom_select_query('SELECT product.*, unite, factory_stock FROM product 
LEFT JOIN stock USING(idproduct) 
LEFT JOIN product_details USING(idproduct)
LEFT JOIN mesurment_unite USING(idunite);', 4);
foreach ($info as $i) {
    echo "<option value ='$i[0]'>$i[1] (" .esc($i[3]) . " $i[2])</option>";
}
echo "</select>";
echo "<br/><br/>Product Quantity : <input type = 'number' step='0.001' name = 'n' value = ''/> ";

echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Transfer' />";
echo "</form>";
?>