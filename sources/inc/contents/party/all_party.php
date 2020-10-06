<h1>All Party</h1>
<?php
echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=party&&sub=all_party' class='button' target='_blank'><b> Print </b></a><br/>";
$query = sprintf("SELECT idparty,name,adress,phone FROM party LEFT JOIN party_phone USING(idparty) LEFT JOIN party_adress USING (idparty) ORDER BY name;");

$party = $qur->get_custom_select_query($query, 4);
$all_info = null;
$due_total = 0;
$advance_total = 0;
//d($party);
$n = count($party);
if($n > 0) {

    echo "<table align='center' class='rb table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>";
    echo "Name";
    echo "</th>";

    echo "<th>";
    echo "Address";
    echo "</th>";

    echo "<th>";
    echo "Phone";
    echo "</th>";

    echo "<th>";
    echo "Have Due";
    echo "</th>";

    echo "<th>";
    echo "Paid Advance";
    echo "</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    for ($i = 0; $i < $n; $i++) {
        echo "<tr>";
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            echo esc($party[$i][1]);
            echo "</a>";
            echo "</td>";

            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            echo esc($party[$i][2]);
            echo "</a>";
            echo "</td>";

            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            echo esc($party[$i][3]);
            echo "</a>";
            echo "</td>";
        if ($i != $n - 1 && $party[$i][0] == $party[$i + 1][0]) {
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            echo money($party[$i+1][3]);
            echo "</a>";
            echo "</td>";
            $i++;
            } else {
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            echo '-';
            echo "</a>";
            echo "</td>";
        }
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $party[$i][0] . "'>";
            $all_info = $qur->party_adv_due($party[$i][0]);
            echo money($all_info) . "</a></td>";
        echo "</tr>";
    }
    echo "</tbody>";

    /*foreach ($all_info as $a) {

        echo "<td>";

        echo esc($a[1]);
        echo "</td>";

        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
        echo esc($a[2]);
        echo "</a>";
        echo "</td>";

        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
        echo esc($a[3]);
        if (isset($a[4])) {
            echo ", <br/>";
            echo esc($a[4]);
        }
        echo "</a>";
        echo "</td>";

        echo "<td align = 'center' >";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
        if ($a[5] < 0) {
            echo money($a[5]);
            $due_total += (-$a[5]);
        } else {
            echo "-";
        }
        echo "</a>";
        echo "</td>";

        echo "<td align = 'center' >";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
        if ($a[5] > 0) {
            echo money($a[5]);
            $advance_total = $advance_total + $a[5];
        } else {
            echo "-";
        }
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    } */
    /*echo "<tfoot>";
    echo "<tr><th colspan='3'>Total</th><th>" . money($due_total) . "</th><th>" . money($advance_total) . "</th></tr></tfoot>";
    */
    echo "</table>";
} else {
    echo "<h3> Nothing Found </h3>";
}