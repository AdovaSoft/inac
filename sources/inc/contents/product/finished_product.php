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
    echo "<th>";
    echo "Date";
    echo "</th>";
    echo "<th>";
    echo "Party";
    echo "</th>";
    echo "<th>";
    echo "Product";
    echo "</th>";
    echo "<th>";
    echo "Number";
    echo "</th>";
    echo "<th>";
    echo "Unit";
    echo "</th>";
    echo "<th>";
    echo "Rate";
    echo "</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($products as $finished) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($finished[0]);
        echo "</td>";

        echo "<th>";
        echo esc($finished[1]);
        echo "</th>";

        echo "<td>";
        echo esc($finished[2]);
        echo "</td>";
        echo "<td>";
        echo esc($finished[3]);
        echo "</td>";
        echo "<td>";
        echo esc($finished[4]);
        echo "</td>";
        echo "<td class='text-right pr-50'>";
        echo money($finished[5]);
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
} else {
    echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
}
?>