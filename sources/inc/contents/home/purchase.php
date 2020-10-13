<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=purchase" method="POST" class="embossed">
  <h2>Purchase Search</h2>
  <br/>Enter Suppler voucher number<br/>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>" required/>
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
    $s = $_REQUEST['searchword'];
    if (strlen($s) < 1) {
        echo "<h3 class='red'>Please enter a key word then click search</h3><br/>";
    } else {
        $purchase_results = $qur->search_pur($s);

        $n = count($purchase_results);

        if ($n > 0) {
            echo "<table  align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>";
            echo "Voucher No";
            echo "</th>";
            echo "<th>";
            echo "Suppler Voucher No";
            echo "</th>";
            echo "<th>";
            echo "Party";
            echo "</th>";
            echo "<th>";
            echo "Date";
            echo "</th>";
            echo "<th width='360'>";
            echo "Action";
            echo "</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=purchase&sub=overview&id=" . $purchase_results[$i][0] . "'>";
                echo esc($purchase_results[$i][0]);
                echo "</a>";
                echo "</td>";
                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=purchase&sub=overview&id=" . $purchase_results[$i][0] . "'>";
                echo esc($purchase_results[$i][1]);
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=purchase&sub=overview&id=" . $purchase_results[$i][0] . "'>";
                echo esc($purchase_results[$i][2]);
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<a href='index.php?e=" . $encptid . "&page=purchase&sub=overview&id=" . $purchase_results[$i][0] . "'>";
                echo $inp->date_convert($purchase_results[$i][3]);
                echo "</a>";
                echo "</td>";

                echo "<td>";
                echo "<br/><form method='POST'><input type='hidden' name='searchword' value='" . $_POST['searchword'] . "' required/>
                <input type='hidden' name='pur_id' value='" . $purchase_results[$i][1] . "'/>
                <input type='submit' name='delete_purchase' value='Delete'/></form> ";
                echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=purchase&&sub=return'>
                <input type='hidden' name='v' value='" . $purchase_results[$i][1] . "'/>
                <input type='submit' name='ab' value='Edit'/></form>";
                echo "<form method='POST' action='print.php?e=" . $encptid . "&&page=purchase&&sub=purchase' target='_blank'>
                <input type='hidden' name='id' value='" . $purchase_results[$i][0] . "'/>
                <input type='submit' name='ab' value='Print'/></form>";

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