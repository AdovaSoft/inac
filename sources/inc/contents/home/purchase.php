<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=purchase" method="POST" class="embossed">
  <h2>Purchase Search</h2>
  <br/>Enter voucher number<br/>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>"/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php

if (isset($_POST['delete_purchase'])) {
    include("sources/inc/contents/purchase/delete.php");
}

if (isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Purchase Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = (isset($_POST['searchword']) != null ? $_POST['searchword'] : $_GET['searchword']);
    if ($s == null) {
        echo "<h3 class='red'>Please enter a key word then click search</h3><br/>";
    } else {
        $purchase_results = $qur->search_pur($s);

        $n = count($purchase_results);

        if ($n > 0) {
            echo "<h3>Purchase Results</h3><br/>";
            echo "<table  align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Voucher No";
            echo "</th>";
            echo "<th>";
            echo "Party";
            echo "</th>";
            echo "<th>";
            echo "Date";
            echo "</th>";
            echo "<th>";
            echo "Action";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo esc($purchase_results[$i][1]);
                echo "</td>";

                echo "<td>";
                echo esc($purchase_results[$i][2]);
                echo "</td>";

                echo "<td>";
                echo $inp->date_convert($purchase_results[$i][3]);
                echo "</td>";

                echo "<td colspan='4'>";
                echo "<br/><form method='POST'><input type='hidden' name='searchword' value='" . $_POST['searchword'] . "'/><input type='hidden' name='pur_id' value='" . $purchase_results[$i][0] . "'/><input type='submit' name='delete_purchase' value='Delete'/></form> ";
                echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=purchase&&sub=return'><input type='hidden' name='v' value='" . $purchase_results[$i][0] . "'/><input type='submit' name='ab' value='Edit'/></form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table><br/>";
        } else {
            echo "<h3 class='blue'>No purchase records found.</h3><br/>";
        }
    }
}
?>