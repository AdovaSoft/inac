<h1>Delete Stock Entry</h1>
<br/>
<?php
include("sources/inc/usercheck.php");
if (isset($_POST['ab'])) {
    $p = $_POST['i'];
    $s = $_POST['s'];
    $flag = $qur->delete_product_input($p, $s);

    if ($flag) {
        echo "<h3 class='green'>Deleted Successfully</h3>";
    } else {
        echo "<h3 class='red'>Failed to Delete</h3>";
    }
}

if ($inp->get_post_date('d'))
    $date = $inp->get_post_date('d');
else
    $date = date("Y-m-d");

echo "<br/><form method = 'POST' class='embossed'>";
echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
echo "<h4 class='blue'>Please select a date<br/>to view and delete stock</h4><br/>";
if ($inp->get_post_date('d'))
    $date = $inp->get_post_date('d');
else
    $date = date('Y-m-d');
$inp->input_date('d', $date);
echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type = 'submit' name = 'view' value = 'View' /><br/>";
echo "<br/></form>";

$query = sprintf("SELECT idupdate,name,stock FROM (SELECT * FROM product_input WHERE date = '%s') as pro LEFT JOIN product USING(idproduct);", $date);

$info = $qur->get_custom_select_query($query, 3);

$n = count($info);

if ($n > 0) {
    echo "<br/><table align='center' class='rb'>";
    echo "<tr>";
    echo "<td>";
    echo "Product";
    echo "</td>";

    echo "<td>";
    echo "Incomming";
    echo "</td>";

    echo "<td>";
    echo "Outgoing";
    echo "</td>";

    echo "<td>";
    echo "Change";
    echo "</td>";
    echo "</tr>";

    foreach ($info as $i) {
        echo "<form method = 'POST' >";
        echo "<tr>";
        echo "<td>";
        echo "<input type = 'hidden' name = 'i' value = '" . $i[0] . "' />";
        echo "<input type = 'hidden' name = 'n' value = '" . $i[1] . "' />";
        echo "<input type = 'hidden' name = 's' value = '" . $i[2] . "' />";
        echo "<input type = 'hidden' name = 'd_y' value = '" . $_POST['d_y'] . "' />";
        echo "<input type = 'hidden' name = 'd_m' value = '" . $_POST['d_m'] . "' />";
        echo "<input type = 'hidden' name = 'd_d' value = '" . $_POST['d_d'] . "' />";
        echo $i[1];
        echo "</td>";
        if ($i[2] > 0) {
            echo "<td>";
            echo $i[2];
            echo "</td>";
            echo "<td>";
            echo '-';
            echo "</td>";
        } else {
            echo "<td>";
            echo '-';
            echo "</td>";
            echo "<td>";
            echo(-$i[2]);
            echo "</td>";
        }

        echo "<td>";
        echo "<input type = 'submit' name = 'ab' value = 'Delete' />";
        echo "</td>";
        echo "</tr>";
        echo "</form>";
    }

    echo "</table>";
} else {
    echo "<br/><h2 class='blue'>No input or output in $date date</h2>";
}
?>