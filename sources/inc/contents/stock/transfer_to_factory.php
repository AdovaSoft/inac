<h1>Product Transfar to Factory</h1>
<br/>
<?php

if (isset($_POST['ab']) && isset($_POST['p']) && isset($_POST['n'])) {
    $info = null;
    if ($_REQUEST['p'] > 0 && $_REQUEST['n'] > 0) {
        $query = sprintf("SELECT stock FROM stock WHERE idproduct = " . $_REQUEST['p']);
        $info = $qur->get_custom_select_query($query, 1);
        if ($info[0][0] < $_REQUEST['n']) {
            echo "<h2 class='red'>Low on stock, current stock : " . $info[0][0] . "</h2><br/>";
        } else {
            $flag = $qur->transfarProduct($_POST['p'], $_POST['n'], 3, $inp->get_post_date('d'));
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
echo "<option></option>";
$query = sprintf("SELECT * FROM product ;");
$info = $qur->get_custom_select_query($query, 2);
foreach ($info as $i) {
    echo "<option value ='" . $i[0] . "'>" . $i[1] . "</option>";
}
echo "</select>";
echo "<br/><br/>Transfer : <input type = 'text' name = 'n' value = ''/> ";

echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Transfer' />";
echo "</form>";
?>