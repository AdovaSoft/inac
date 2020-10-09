<?php
$date1 = (isset($_GET['date1'])) ? $_GET['date1'] : null;
$date2 = (isset($_GET['date2'])) ? $_GET['date2'] : null;
if (!is_null($date1) && !is_null($date2))
    echo "<h3>Report from " . $inp->date_convert($date1) . " to " . $inp->date_convert($date2) . "</h3>";

