<h2>Factory Finished Product Stock Report</h2>
<?php
    $query = sprintf("SELECT name, factory_stock, unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details WHERE sell = 1 ) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");
    
    $info = $qur->get_custom_select_query($query, 5);
    $cost = 0;
    if (count($info) > 0) {
        echo "<table class='rb'>";
        echo "<tr>";
        
        echo "<th>SI</th>";
        
        echo "<th>";
        echo "Name";
        echo "</th>";
        
        echo "<th>";
        echo "Stock";
        echo "</th>";
        
        echo "<th>";
        echo "Unit";
        echo "</th>";
        
        echo "<th>";
        echo "Price";
        echo "</th>";
        
        
        echo "<th>";
        echo "Total";
        echo "</th>";
        
        echo "</tr>";
        
        $i = 0;
        foreach ($info as $ar) {
            echo "<tr>";
            
            echo "<td>" . $i++ . "</td>";
            
            echo "<td>";
            echo $ar[0];
            echo "</td>";
            
            echo "<td>";
            echo $ar[1];
            echo "</td>";
            
            echo "<td>";
            echo $ar[2];
            echo "</td>";
            
            echo "<td class='text-right'>";
            echo money($ar[3]);
            echo "</td>";
            
            
            $total = $ar[3] * $ar[1];
            echo "<td class='text-right'>";
            echo money($total);
            echo "</td>";
            $cost += $ar[3] * $ar[1];
            
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<th colspan = '4' class='text-right'>";
        echo "Grand Total : ";
        echo "</th>";
        
        echo "<th colspan = '2' >";
        echo money($cost);
        echo "</th>";
        echo "</tr>";
        
        echo "</table>";
    } else {
        echo "No raw materials is in stock";
    }

?>
