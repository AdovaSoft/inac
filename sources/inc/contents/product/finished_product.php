<h1>Finished Product Sell Overview</h1>
<br/>
<?php
include("sources/inc/double_date_id.php");
$products = $qur->get_finished_product_overview($date1, $date2);
$n = count($products);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=finished_product&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a><br/>";
    echo "<table align='center' class='rb table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>";
    echo "Date";
    echo "</td>";
    echo "<td>";
    echo "Party";
    echo "</td>";
    echo "<td>";
    echo "Product";
    echo "</td>";
    echo "<td>";
    echo "Number";
    echo "</td>";
    echo "<td>";
    echo "Unit";
    echo "</td>";
    echo "<td>";
    echo "Rate";
    echo "</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($products as $finished) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($finished[0]);
        echo "</td>";

        echo "<td>";
        echo isset($finished[1]) ? $finished[1] : '-';
        echo "</td>";

        echo "<td>";
        echo isset($finished[2]) ? $finished[2] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($finished[3]) ? $finished[3] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($finished[4]) ? $finished[4] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($finished[5]) ? $finished[5] : '-';
        echo "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    /*
    echo "<tr>";
    echo "<td colspan = 2>";
    echo "Total ";
    echo "</td>";
    echo "<td ><b>";
    echo $qun;
    echo "</b></td>";
    echo "<td> </td>";
    echo "<td><b>" . $cos . "</b></td>";
    echo "<td> </td>";
    echo "</tr>";
    */
    echo "</table>";
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=finished_product&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";
} else {
    echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
}
?>