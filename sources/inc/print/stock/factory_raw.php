<h2>Factory Raw Materials Stock Report</h2>
<?php
    $query = sprintf("SELECT name, factory_stock, unite, price, idproduct FROM (SELECT idproduct,idunite FROM product_details WHERE purchase = 1 ) as product LEFT JOIN product USING (idproduct) LEFT JOIN stock USING(idproduct) LEFT JOIN mesurment_unite USING(idunite)  LEFT JOIN price USING(idproduct);");
    $qur = new indquery();
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
            echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
            echo esc($ar[0]);
            echo "</a>";
            echo "</td>";
            
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
            echo esc($ar[1]);
            echo "</a>";
            echo "</td>";
            
            echo "<td>";
            echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
            echo esc($ar[2]);
            echo "</a>";
            echo "</td>";
            
            echo "<td class='text-right'>";
            echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
            echo money($ar[3]);
            echo "</a>";
            echo "</td>";
            
            
            echo "<td class='text-right'>";
            echo "<a href='index.php?e=" . $encptid . "&page=stock&sub=particular_product&p=" . $ar[4] . "'>";
            $total = $ar[3] * $ar[1];
            echo money($total);
            $cost += $ar[3] * $ar[1];
            echo "</a>";
            echo "</td>";
            echo "</tr>";
        }
        
        echo "<tr>";
        echo "<th colspan = '4' class='text-right'>";
        echo "Grand Total : ";
        echo "</th>";
        
        echo "<th colspan='2' >";
        echo money($cost);
        echo "</th>";
        echo "</tr>";
        
        echo "</table>";
    } else {
        echo "No raw materials is in stock";
    }

?>
