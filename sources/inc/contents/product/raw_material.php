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
    echo "<td>";
    echo "Total";
    echo "</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($info as $item) {
        echo "<tr>";
        echo "<td>";
        echo $inp->date_convert($item[0]);
        echo "</td>";
        echo "<td>";
        echo isset($item[1]) ? $item[1] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[2]) ? $item[2] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[3]) ? $item[3] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[4]) ? $item[4] : '-';
        echo "</td>";
        echo "<td>";
        echo isset($item[5]) ? money($item[5]) : '-';
        echo "</td>";
        echo "<td>";
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
    echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=product&&sub=raw_material&&date1=" . $date1 . "&&date2=" . $date2 . "' class='button' target='_blank'><b> Print </b></a>";
} else {
    echo "<br/><h3 class='blue'>There is nothing to show about this item between these dates</h3>";
}
?>