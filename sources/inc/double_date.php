<?php
$date2 = date("Y-m-d");
$date1 = date('Y-m-d', strtotime('-30 day', strtotime($date2)));

if ($inp->get_post_date('date1') && $inp->get_post_date('date2')) {
    $date1 = $inp->get_post_date('date1');
    $date2 = $inp->get_post_date('date2');
} elseif ($inp->value_pgd('date1') && $inp->value_pgd('date2')) {
    $date1 = $inp->value_pgd('date1');
    $date2 = $inp->value_pgd('date2');
}

echo "<form method='post' class='embossed'>";
echo "Report from &nbsp;&nbsp;&nbsp;";
$inp->input_date('date1', $date1);
echo "&nbsp;&nbsp;&nbsp; to &nbsp;&nbsp;&nbsp;";
$inp->input_date('date2', $date2);
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='view' value='View'>";
echo "</form>";


echo "<br/><h2>Report from <b class='blue'>" . $inp->date_convert($date1) . "</b> to <b class='blue'>" . $inp->date_convert($date2) . "</b></h2><br/>";
