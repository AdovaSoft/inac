<?php
    $date = date("Y-m-d");
    
    if ($inp->get_post_date('date'))
        $date = $inp->get_post_date('date');
    
    elseif ($inp->value_pgd('date') != NULL)
        $date = $inp->value_pgd('date');
    
    echo "<form method='post' class='embossed'>";
    echo "Select date &nbsp;&nbsp;&nbsp;";
    $inp->input_date('date', $date);
    echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='view' value='View'>";
    echo "</form>";
//echo "<br/><h2>Report of <b class='blue'>" . $inp->date_convert($date) . "</b></h2><br/>";
?>