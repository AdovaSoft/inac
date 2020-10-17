<h2>Date wise Factory Stock Report</h2>
<?php
include("sources/inc/print/double_date.php");

$query = sprintf("SELECT date,name,stock, unite,price,type FROM (SELECT * FROM product_input WHERE date BETWEEN '%s' AND '%s' AND (type='1' OR type='3')  ) as pro LEFT JOIN product USING(idproduct)LEFT JOIN product_details USING(idproduct) LEFT JOIN mesurment_unite USING(idunite) LEFT JOIN price USING(idproduct) ORDER BY date DESC;", $date1, $date2);
$info = $qur->get_custom_select_query($query, 6);
$n = count($info);
$tti = $tto = $tti_p = $tto_o = 0;
if ($n > 0) {
    echo "<small>Report according to date " . date("d M Y (D)") . "</small><br/>";
    echo "<br/><table align='center' class='rb'>";
    echo "<tr>";

    echo "<th>SI</th>";

    echo "<th>";
    echo "Date";
    echo "</th>";

    echo "<th>";
    echo "Product";
    echo "</th>";

    echo "<th>";
    echo "Price ";
    echo "</th>";


    echo "<th>";
    echo "Incoming";
    echo "</th>";

    echo "<th>";
    echo "Outgoing";
    echo "</th>";

    echo "<th>";
    echo "Unit";
    echo "</th>";

    echo "<th>";
    echo "Total Price ";
    echo "</th>";

    echo "<th>";
    echo "Remark";
    echo "</th>";

    echo "</tr>";

    $j = 1;
    foreach ($info as $i) {
        echo "<tr>";

        echo "<td>" . $j++ . "</td>";

        echo "<td>";
        echo $inp->date_convert($i[0]);
        echo "</td>";

        echo "<td>";
        echo $i[1];
        echo "</td>";

        echo "<td class='text-right' >";
        echo money($i[4]);
        echo "</td>";

        if ($i[2] > 0) {
            echo "<td>";
            echo $i[2];
            if ($i[5] == 0 || $i[5] == 1)
                $tti_p = $tti_p + $i[2];

            echo "</td>";
            echo "<td>";
            if ($i[5] == 0 || $i[5] == 1) {
                echo "-";
            } else {
                echo $i[2];
            }
            echo "</td>";
        } else {
            echo "<td>";
            if ($i[5] == 0 || $i[5] == 1) {
                echo "-";
            } else {
                echo $i[2];
            }
            echo "</td>";
            echo "<td>";
            echo(-$i[2]);
            if ($i[5] == 0 || $i[5] == 1)
                $tto_p = $tto_o + (-$i[2]);
            echo "</td>";
        }

        echo "<td>";
        echo $i[3];
        echo "</td>";

        $ss = $i[2] * $i[4];
        if ($ss > 0) {
            $tti += $ss;
            echo "<td class='text-right'>" . money($ss) . "</td>";
        } else {
            $tto += $ss;
            $ss *= (-1);
            echo "<td class='text-right'>" . money($ss) . "</td>";
        }
        echo "<td>";

        if ($i[5] == 0) {
            echo "Godown";
        }
        if ($i[5] == 1) {
            echo "Factory";
        }
        if ($i[5] == 2) {
            echo "Factory to godown";
        }
        if ($i[5] == 3) {
            echo "Godown to factory";
        }
        echo "</td>";

        echo "</tr>";
    }
    $tto *= (-1);
    $total = $tti + $tto;
    echo "<tr><th colspan='4'>Total Incoming : " . money($tti) . " TK</th><th colspan='3'>Total Outgoing : " . money($tto) . " TK</th><th colspan='2'>Total (Incoming  -  Outgoing) : <br/>" . money($total) . " TK</th></tr>";
    echo "</table>";
} else {
    echo "<br/><h2 class='blue'>No input or output between $date1 and $date2</h2>";
}
?>