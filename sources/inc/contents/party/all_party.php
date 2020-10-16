<h1>All Party</h1>
<?php
echo "<br/><a id='printBox' href='print.php?e=" . $encptid . "&page=party&&sub=all_party' class='button' target='_blank'><b> Print </b></a><br/>";
$query = sprintf("SELECT idparty,name,adress,phone,email
FROM party 
    LEFT JOIN party_phone USING(idparty) 
    LEFT JOIN party_email USING(idparty) 
    LEFT JOIN party_adress USING (idparty) ORDER BY name;");

$party = $qur->get_custom_select_query($query, 5);
// d($party);
$all_info = null;
$due_total = 0;
$advance_total = 0;
$n = count($party);
for ($i = 0; $i < $n; $i++) {
    if ($i != $n - 1 && $party[$i][0] == $party[$i + 1][0]) {
        $all_info[$i][0] = $party[$i][0];
        $all_info[$i][1] = $party[$i][1];
        $all_info[$i][2] = $party[$i][2];
        $all_info[$i][3] = $party[$i][3];
        $all_info[$i][4] = $party[$i + 1][3];
        $all_info[$i][5] = $qur->party_adv_due($party[$i][0]);
        $all_info[$i][6] = $party[$i][4];

        $i++;
    } else {
        $all_info[$i][0] = $party[$i][0];
        $all_info[$i][1] = $party[$i][1];
        $all_info[$i][2] = $party[$i][2];
        $all_info[$i][3] = $party[$i][3];
        $all_info[$i][4] = null;
        $all_info[$i][5] = $qur->party_adv_due($party[$i][0]);
        $all_info[$i][6] = $party[$i][4];

    }
}
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
echo "Email";
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
foreach ($all_info as $a) {
    // d($a);
    echo "<tr>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    echo esc($a[1]);
    echo "</a>";
    echo "</td>";

    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    echo esc($a[2]);
    echo "</a>";
    echo "</td>";

    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    echo esc($a[3], true);
    if (isset($a[4])) {
        echo ", ";
        echo esc($a[4], true);
    }
    echo "</a>";
    echo "</td>";

    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    echo esc($a[6]);
    echo "</a>";
    echo "</td>";
    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    if ($a[5] < 0) {
        echo money($a[5]);
        $due_total += (-$a[5]);
    }
    else {
        echo "-";
    }
    echo "</a>";
    echo "</td>";

    echo "<td>";
    echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
    if ($a[5] > 0) {
        echo money($a[5]);
        $advance_total = $advance_total + $a[5];
    }
    else {
        echo "-";
    }
    echo "</a>";
    echo "</td>";
    echo "</tr>";
}
echo "</tbody>";
echo "<tfoot>";
//echo "<tr><th colspan='4'><span style='display: block; width: 100%' class='text-center'>Total</span></th><th>" . money($due_total) . "</th><th>" . money($advance_total) . "</th></tr></tfoot>";
echo "</table>";

?>
