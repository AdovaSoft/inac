<h2>Raw Material Purchase Overview</h2>
<?php
include("sources/inc/print/double_date.php");
$info = $qur->get_raw_product_overview($date1, $date2);
$n = count($info);
if ($n > 0) {
    $qun = 0;
    $cos = 0;
    echo "<table align='center' class='rb'>";
    echo "<tr>";

    echo "<th>SI</th>";
   
    echo "<th>";
    echo "Date";
    echo "</th>";
    
    echo "<th>";
    echo "Party";
    echo "</th>";
    
    echo "<th>";
    echo "Product";
    echo "</th>";
    
    echo "<th>";
    echo "Number";
    echo "</th>";
    
    echo "<th>";
    echo "Unit";
    echo "</th>";
    
    echo "<th>";
    echo "Rate";
    echo "</th>";
    
    echo "<th>";
    echo "Total";
    echo "</th>";
    
    echo "</tr>";

    $j = 1;
    foreach ($info as $item) {
        echo "<tr>";

        echo "<td>" . $j++ . "</td>";
        
        echo "<td>";
        echo $inp->date_convert($item[0]);
        echo "</td>";
        
        echo "<td>";
        echo esc($item[1]);
        echo "</td>";
        
        echo "<td>";
        echo esc($item[2]);
        echo "</td>";
        
        echo "<td>";
        echo esc($item[3]);
        echo "</td>";
        
        echo "<td>";
        echo esc($item[4]);
        echo "</td>";
        
        echo "<td class='text-right'>";
        echo money($item[5]);
        echo "</td>";

        if (isset($item[5]) && isset($item[3])) {
           
            $temp = $item[5] * $item[3];
            echo "<td class='text-right'>";
            echo money($temp);
            echo "</td>";
            $cos += $temp;

        } else {
            echo "<td>";
            echo '-';
            echo "</td>";
        }

        echo "</tr>";

    }
    echo "<tr>";
    echo "<th colspan ='7'>";
    echo "Total ";
    echo "</th>";
    echo "<th>" . money($cos) . "</th>";
    echo "</tr>";
    echo "</table>";
}
?>