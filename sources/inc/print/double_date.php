<?php
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
if (isset($date1) && isset($date2))
    echo "<h3>Report from " . $inp->date_convert($date1) . " to " . $inp->date_convert($date2) . "</h3>";