<?php
$id = $inp->value_pgd('id');
if (isset($id)) {
    $name = $qur->get_cond_row('party', array('name'), 'idparty', '=', $id);
    echo "<h1>Individual Party Overview of " . $name[0][0] . "<br/>";

    $total = $qur->party_adv_due($id);

    if ($total < 0) {
        $neg = -$total;
        echo "<small class='faintred'>Due of " . $name[0][0] . " : " . money($neg) . " taka</small></h1><br/>";
    } elseif ($total > 0) {
        echo "<small class='faintred'>Outstanding of " . $name[0][0] . " : " . money($total) . " taka</small></h1><br/>";
    } else {
        echo "<small class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</small></h1><br/>";
    }

    echo "<a class='button' id='printBox' onclick='showit(3)' style='padding-top: 20px; padding-bottom: 20px;'>Select another party</a>";
    echo "<div id='sud3'><form method = 'POST'  class='embossed'>";
    echo "<h4 class='blue'>Select Party</h4><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $qur->get_drop_down('party', 'name', 'idparty', 'id', $inp->value_pgd('id'), 'full-width');
    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form></div>";
    if (isset($_POST['all_show'])) {
        echo "<form method = 'POST' class='embossed'><b>Showing All time report</b>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<input type = 'submit' name = 'datewise' value = 'Back to Monthly Report'/>";
        echo "</form>";
        $qur->print_party_overview($id, $encptid, $name[0][0]);
    } else {
        include("sources/inc/double_date_id.php");
        echo "<form method = 'POST' class='embossed'>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<input type = 'submit' name = 'all_show' value = 'Show all time report'/>";
        echo "</form>";
        $qur->print_party_overview($id, $encptid, $name[0][0], $date1, $date2);
    }
    /*
    if ($total < 0) {
        echo "<h2 class='faintred'>Due of " . $name[0][0] . " : " . (-$total) . " taka</h2><br/>";
    } elseif ($total > 0) {
        echo "<h2 class='faintred'>Outstanding of " . $name[0][0] . " : " . ($total) . " taka</h2><br/>";
    } else {
        echo "<h2 class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</h2><br/>";
    } */
} else {
    echo "<h1>Individual Party Overview</h1><br/>";
    echo "<form method = 'POST'  class='embossed'>";
    echo "<h4 class='blue'>Select Party</h4><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $query = sprintf("SELECT party.*, ac_types.title FROM party INNER JOIN party_type USING(idparty) INNER JOIN ac_types USING(type) ORDER BY name");
    $party = $qur->get_custom_select_query($query, 3);
    $qur->get_dropdown_array($party, 0, 1, 'id', $inp->value_pgd('id'), 'full-width', false, 2, true);

    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form>";
}
?>