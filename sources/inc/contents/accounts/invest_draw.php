<h1>Investment / Drawing Panel</h1><br/>
<?php
include("sources/inc/usercheck.php");
$inp = new html();
if (isset($_POST['ab'])) {

    if (isset($_POST['tt']) && isset($_POST['tf']) && isset($_POST['a']) && $_POST['a'] > 0) {

        $query = new indquery();
        $date = $inp->get_post_date('date');

        $flag = $query->addNewTran($date, $_POST['a'], $_POST['tt'], $_POST['tf'], $_POST['c']);

        if ($flag) {
            echo "<h3 class='green'>Transaction successfull</h3>";
        } else {
            echo "<h3 class='red'>Transaction failed</h3>";
        }
    } else {
        echo "<h3 class='blue'>Ammount, Trasaction type and medium</h3>";
    }
}
echo "<br/><form method = 'POST' class='embossed'>";
echo "Date : ";
$inp->input_date('date', date('Y-m-d'));
echo "<br/><br/>";
$inp->input_number('Amount', 'a', null);
echo "<br/>Transaction type :  ";

$inp->input_radio('Investment', 'tt', 1, 0);
$inp->input_radio('Drawings', 'tt', -1, 0);

echo "<br/><br/>Transaction medium :  ";
$inp->input_radio('Cash', 'tf', 0, 0);
$inp->input_radio('Bank', 'tf', 1, 0);

echo "<br/><br/>";
$inp->input_text('Comments (optional)', 'c', null);
$inp->input_submit('ab', 'Apply');

echo "</form><br/>";
?>