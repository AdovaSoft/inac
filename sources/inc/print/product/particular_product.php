<h2>Particular Product Overview</h2>
<?php
    $id = $inp->value_pgd('id');
    include("sources/inc/print/double_date.php");
    $info = $qur->get_particular_product_overview($id, $date1, $date2);
    $n = count($info);
    if ($n > 0) {
        $qun = 0;
        $cos = 0;
        echo "<h3>Current Stock : " . $qur->current_stock($id) . "</h3>";
        echo "<br/><table align='center' class='rb'>";
        echo "<tr>";
        
        echo "<th>SI</th>";
        
        echo "<th>";
        echo "Date";
        echo "</th>";
        
        echo "<th>";
        echo "Party";
        echo "</th>";
        
        echo "<th>";
        echo "Quantity";
        echo "</th>";
        
        echo "<th>";
        echo "Price";
        echo "</th>";
        
        echo "<th>";
        echo "Total";
        echo "</th>";
        
        echo "</tr>";
        
        $j = 1;
        foreach ($info as $i) {
            echo "<tr>";
            
            echo "<td>" . $j++ . "</td>";
            
            echo "<td>";
            echo $inp->date_convert($i[0]);
            echo "</td>";
            
            echo "<td class='text-left'>";
            echo esc($i[1]);
            echo "</td>";
            
            echo "<td>";
            echo esc($i[2]);
            echo "</td>";
            $qun += $i[2];
            
            echo "<td class='text-right' >";
            echo money($i[3]);
            echo "</td>";
            
            echo "<td class='text-right' >";
            $total = $i[2] * $i[3];
            echo money($total);
            $cos += $i[2] * $i[3];
            echo "</td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        
        echo "<th colspan ='4'>";
        echo "Total ";
        echo "</th>";
        echo "<td colspan='2'><b>" . money($cos) . "</b></td>";
        
        echo "</tr>";
        echo "</table>";
    }
?>