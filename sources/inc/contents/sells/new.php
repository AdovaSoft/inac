<h1>New Sell</h1>
<br/>

<?php
if (isset($_GET['say']) && $_GET['say'] == 1) {

    $custom_message = "<h2 class='green'>Sells recorded successfully.</h2>
	                              <br/><a id='printBox' href='index.php?e=" . $encptid . "&page=accounts&sub=receive_payment&pt=" . $_GET['pt'] . "&pay_type=1&cost=" . ($_GET['cost'] - $_GET['d']) . "' class='button'>
	                              Receive Payment</a>
								  <br/>
								  <form method='POST' id='printBox' action='print.php?e=" . $encptid . "&page=sells&sub=sell' target='_blank'>
								  <input type='hidden' name='vou' value='" . $_GET['idselles'] . "'/>
								  <input type='submit' name='print' value='Print Bill'/></form>
								  <form method='POST' action='recept_print.php?e=" . $encptid . "' target='_blank'>
								  <input type='hidden' name='vou' value='" . $_GET['idselles'] . "'/>
								  <input type='submit' name='print' value='Print on Pad'/></form>
								  <form method='POST' id='printBox' action='print.php?e=" . $encptid . "&page=sells&sub=chalan' target='_blank'>
								  <input type='hidden' name='vou' value='" . $_GET['idselles'] . "'/>
								  <input type='submit' name='print' value='Print Chalan'/></form>
								  ";
} elseif (isset($_GET['say']) && $_GET['say'] == 2) {
    $custom_message = "<h3 class='red'>Could not record sells.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 3) {
    $custom_message = "<h3 class='faintred'>Please provide all information correctly.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 4) {
    $custom_message = "<h3 class='faintred'>No sellable product is selected.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 5) {
    $custom_message = "<h3 class='faintred'>Discount is too high.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 6) {
    $custom_message = "<h3 class='blue'>Not enough stock for all selected item.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 7) {
    $custom_message = "<h3 class='red'>Failed to update stock.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 8) {
    $custom_message = "<h3 class='red'>Transport cost cannot be negative.</h3>";
} elseif (isset($_GET['say']) && $_GET['say'] == 'input_added') {
    $custom_message = "<h3 class='blue'>New Input Panel Added.</h3>";
} else {
    $custom_message = "<h4 class='blue'>Please provide sells information and click sell.</h4>";
}
echo $custom_message;
$qur->print_new_sales($encptid);
?>

