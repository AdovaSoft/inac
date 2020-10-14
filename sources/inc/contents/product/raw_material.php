<h1>Raw Material Purchase Overview</h1>
<br/>
<?php
include("sources/inc/double_date_id.php");
$info = $qur->get_raw_product_overview($date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=raw_material&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a><br/>";
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
    echo "<th>";
    echo "Total";
    echo "</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($info as $item) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($item[0]);
        echo "</td>";
        echo "<th>";
        echo esc($item[1]);
        echo "</th>";
        echo "<td>";
        echo esc($item[2]);
        echo "</td>";
        echo "<td>";
        echo esc($item[3]);
        echo "</td>";
        echo "<td>";
        echo esc($item[4]);
        echo "</td>";
        echo "<td class=' text-right pr-50'>";
        echo money($item[5]);
        echo "</td>";
        echo "<td class=' text-right pr-50'>";
        if (isset($item[5]) && isset($item[3])) {
            $temp = $item[5] * $item[3];
            $cos += $temp;
            echo money($temp);
        } else
            echo '-';

        echo "</td>";
        echo "</tr>";

    }
    echo "</tbody>";
    /*
    echo "<tr>";
    echo "<td colspan ='3'>";
    echo "Total ";
    echo "</td>";
    echo "<td><b>";
    echo $qun;
    echo "</b></td>";
    echo "<td></td>";
    echo "<td></td>";
    echo "<td><b>" . money($cos) . "</b></td>";
    echo "</tr>";*/
    echo "</table>";
} else {
    echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
}
?>