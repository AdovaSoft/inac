<form action="index.php?e=<?php echo $encptid ?>&&page=home&&sub=sp" method="POST" class="embossed">
  <h2>Sell and Purchase Search</h2>
  <br/>Enter voucher number<br/>
  <br/>
  <input type="text" name="searchword" class="searchword"
         value="<?php if (isset($_POST['searchword'])) echo $_POST['searchword']; ?>"/>
  <br/>
  <br/><input type="submit" name="submit" value="Search"/>
</form>
<?php


if (isset($_POST['delete_sell'])) {
    include("sources/inc/contents/sells/delete.php");
}

if (isset($_POST['delete_purchase'])) {
    include("sources/inc/contents/purchase/delete.php");
}

if (isset($_POST['searchword'])) {
    $searchword = $_POST['searchword'];
    echo "<br/><h3>Sell and Purchase Search Result for <b class='green'>" . $searchword . "</b></h3><br/>";
    $s = null;
    $s = ($_POST['searchword'] != null ? $_POST['searchword'] : $_GET['searchword']);
    if ($s == null) {
        echo "<h3 class='red'>Please enter a key word then click search</h3><br/>";
    } else {

        $res1 = $qur->search_sell($s);

        $n = count($res1);
        if ($n > 0) {
            echo "<h3>Sells Results</h3><br/>";
            echo "<table align='center' class='rb table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<td>";
            echo "Vouchar No";
            echo "</td>";
            echo "<td>";
            echo "Party";
            echo "</td>";
            echo "<td>";
            echo "Date";
            echo "</td>";
            echo "<td>";
            echo "Actions";
            echo "</td>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo $res1[$i][0];
                echo "</td>";

                echo "<td>";
                echo $res1[$i][1];
                echo "</td>";

                echo "<td>";
                echo $inp->date_convert($res1[$i][2]);
                echo "</td>";
                echo "<td>";
                echo "<form method='POST'><input type='hidden' name='searchword' value='" . $_POST['searchword'] . "'/><input type='hidden' name='sell_id' value='" . $res1[$i][0] . "'/><input type='submit' name='delete_sell' value='Delete'/></form> ";
                echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=sells&&sub=return'><input type='hidden' name='v' value='" . $res1[$i][0] . "'/><input type='submit' name='ab' value='Edit'/></form> ";
                echo "<form method='POST' action='print.php?e=" . $encptid . "&&page=sells&&sub=sell' target='_blank'><input type='hidden' name='vou' value='" . $res1[$i][0] . "'/><input type='submit' name='print' value='Print'/></form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table><br/>";
            /*create a link using res1[i][1] to Sales Return 'selles_ret' page*/

        } else {
            echo "<h3 class='blue'>No sells records found</h3><br/>";
        }


        $res2 = $qur->search_pur($s);

        $n = count($res2);

        if ($n > 0) {
            echo "<h3>Purchase Results</h3><br/>";
            echo "<table  align='center' class='rb'>";
            echo "<tr>";
            echo "<td>";
            echo "Vouchar No";
            echo "</td>";
            echo "<td>";
            echo "Party";
            echo "</td>";
            echo "<td>";
            echo "Date";
            echo "</td>";
            echo "<td>";
            echo "Action";
            echo "</td>";
            echo "</tr>";

            for ($i = 0; $i < $n; $i++) {
                echo "<tr>";
                echo "<td>";
                echo $res2[$i][1];
                echo "</td>";

                echo "<td>";
                echo $res2[$i][2];
                echo "</td>";

                echo "<td>";
                echo $inp->date_convert($res2[$i][3]);
                echo "</td>";

                echo "<td colspan='4'>";
                echo "<br/><form method='POST'><input type='hidden' name='searchword' value='" . $_POST['searchword'] . "'/><input type='hidden' name='pur_id' value='" . $res2[$i][0] . "'/><input type='submit' name='delete_purchase' value='Delete'/></form> ";
                echo "<form method='POST' action='index.php?e=" . $encptid . "&&page=purchase&&sub=return'><input type='hidden' name='v' value='" . $res2[$i][0] . "'/><input type='submit' name='ab' value='Edit'/></form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table><br/>";
        } else {
            echo "<h3 class='blue'>No purchase records found.</h3><br/>";
        }
    }
}
?>