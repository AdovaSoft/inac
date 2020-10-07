<?php
$date1 = (isset($_GET['date1'])) ? $_GET['date1'] : date('Y-m-d');
$date2 = (isset($_GET['date2'])) ? $_GET['date2'] : date('-30days', strtotime($date1));
if (isset($date1) && isset($date2))
    echo "<h3>Report from " . $inp->date_convert($date1) . " to " . $inp->date_convert($date2) . "</h3>";

