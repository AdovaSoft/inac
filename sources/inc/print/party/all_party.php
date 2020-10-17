<h2>All Party</h2>
<?php
    $query = sprintf("SELECT idparty,name,adress,phone,email FROM party
    LEFT JOIN party_phone USING(idparty)
    LEFT JOIN party_email USING(idparty) 
    LEFT JOIN party_adress USING (idparty) ORDER BY name;"
    );
    $party = $qur->get_custom_select_query($query, 5);
    $all_info = null;
    $due_total = 0;
    $advance_total = 0;
    
    $n = count($party);
    for ($i = 0; $i < $n; $i++) {
        if ($i != $n - 1 && $party[$i][0] == $party[$i + 1][0]) {
            $all_info[$i][0] = $party[$i][0];
            $all_info[$i][1] = $party[$i][1];
            $all_info[$i][2] = $party[$i][2];
            $all_info[$i][3] = $party[$i][3];
            $all_info[$i][4] = $party[$i + 1][3];
            $all_info[$i][5] = $qur->party_adv_due($party[$i][0]);
            $all_info[$i][6] = $party[$i][4];
            $i++;
        } else {
            $all_info[$i][0] = $party[$i][0];
            $all_info[$i][1] = $party[$i][1];
            $all_info[$i][2] = $party[$i][2];
            $all_info[$i][3] = $party[$i][3];
            $all_info[$i][4] = null;
            $all_info[$i][5] = $qur->party_adv_due($party[$i][0]);
            $all_info[$i][6] = $party[$i][4];
        }
    }
    echo "<table align='center' class='rb'>";
    echo "<tr>";
    
    echo '<th>SI</th>';
    
    echo "<th>";
    echo "Name";
    echo "</th>";
    
    echo "<th>";
    echo "Address";
    echo "</th>";
    
    echo "<th>";
    echo "Phone";
    echo "</th>";
    
    echo "<th>";
    echo "Email";
    echo "</th>";
    
    echo "<th>";
    echo "Have Due";
    echo "</th>";
    
    echo "<th>";
    echo "Paid Advance";
    echo "</th>";
    echo "</tr>";
    $i = 1;
    foreach ($all_info as $a) {
        echo "<tr>";
        
        echo "<td>" . $i++ . "</td>";
        
        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&p=" . $a[0] . "'>";
        echo esc($a[1]);
        echo "</a>";
        echo "</td>";
        
        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&p=" . $a[0] . "'>";
        echo esc($a[2]);
        echo "</a>";
        echo "</td>";
        
        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&p=" . $a[0] . "'>";
        echo esc($a[3]);
        if ($a[4]) {
            echo ", <br/>";
            echo esc($a[4]);
        }
        echo "</a>";
        echo "</td>";
        
        echo "<td>";
        echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&id=" . $a[0] . "'>";
        echo esc($a[6]);
        echo "</a>";
        echo "</td>";
        
        
        if ($a[5] < 0) {
            $due = (-$a[5]);
            
            echo "<td class='text-right' >";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&p=" . $a[0] . "'>";
            echo money($due);
            echo "</a>";
            echo "</td>";
            $due_total = $due_total + $due;
        } else {
            echo "<td align = 'center' >";
            echo "<a href='index.php?e=" . $encptid . "&&page=party&&sub=view_particular&&p=" . $a[0] . "'>";
            echo "-";
            echo "</a>";
            echo "</td>";
        }
        
        if ($a[5] > 0) {
            echo "<td class='text-right' >" . money($a[5]) . "</td>";
            $advance_total = $advance_total + $a[5];
        } else {
            echo "<td align = 'center' > - </td>";
        }
        
        echo "</tr>";
    }
    echo "<tr>";
    echo "<th colspan='5' class='text-center' >Total</th>";
    echo "<th class='text-right' >" . money($due_total) . "</th>";
    echo "<th  class='text-right' >" . money($advance_total) . "</th>";
    echo "</tr>";
    echo "</table>";

?>