<?php
$id = $inp->value_pgd('id');
if (isset($id)) {
    $name = $qur->get_cond_row('party', array('name'), 'idparty', '=', $id);
    echo "<h1>Individual Party Overview of " . $name[0][0] . "<br/>";
    $total = $qur->party_adv_due($id);
    if ($total < 0) {
        echo "<small class='faintred'>Due of " . $name[0][0] . " : " . (-$total) . " taka</small></h1><br/>";
    } elseif ($total > 0) {
        echo "<small class='faintred'>Outstanding of " . $name[0][0] . " : " . ($total) . " taka</small></h1><br/>";
    } else {
        echo "<small class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</small></h1><br/>";
    }
    echo "<a class='button' onclick='showit(3)'>Select another party</a>";
    echo "<div id='sud3'><form method = 'POST'  class='embossed'>";
    echo "<h4 class='blue'>Select Party</h4><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $qur->get_drop_down('party', 'name', 'idparty', 'id', $inp->value_pgd('id'));
    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form></div>";
    if (isset($_POST['all_show'])) {
        echo "<form method = 'POST' class='embossed'><b>Showing All time report</b>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<input type = 'submit' name = 'datewise' value = 'Back to Monthly Report'/>";
        echo "</form>";
        $qur->printPartyFinOverview($id, $encptid, $name[0][0]);
    } else {
        include("sources/inc/double_date_id.php");
        echo "<form method = 'POST' class='embossed'>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";
        echo "<input type = 'submit' name = 'all_show' value = 'Show all time report'/>";
        echo "</form>";
        $qur->printPartyFinOverview($id, $encptid, $name[0][0], $date1, $date2);
    }
    if ($total < 0) {
        echo "<h2 class='faintred'>Due of " . $name[0][0] . " : " . (-$total) . " taka</h2><br/>";
    } elseif ($total > 0) {
        echo "<h2 class='faintred'>Outstanding of " . $name[0][0] . " : " . ($total) . " taka</h2><br/>";
    } else {
        echo "<h2 class='green'>You neither have Outstanding nor due with " . $name[0][0] . "</h2><br/>";
    }
} else {
    echo "<h1>Individual Party Overview</h1><br/>";
    echo "<form method = 'POST'  class='embossed'>";
    echo "<h4 class='blue'>Select Party</h4><br/>";
    echo "<img src='images/blank1by1.gif' width='300px' height='1px'/><br/>";
    $qur->get_drop_down('party', 'name', 'idparty', 'id', $inp->value_pgd('id'));
    echo "<br/><br/><input type = 'submit' name = 'ab' value = 'Show' />";
    echo "</form>";
}
?>