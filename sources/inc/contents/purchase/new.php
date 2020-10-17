<h1>New Purchase</h1>
<br/>
<?php
if (isset($_GET['say'])) {
    if ($_GET['say'] == 1) {
        $custom_message = "<h2 class='green'>Purchase recorded successfully.</h2>
<br/><a  id='showAll' href='index.php?e=" . $encptid . "&page=accounts&sub=purchase_expense&pt=" . $_GET['pt'] . "&pay_type=-1&cost=" . ($_GET['cost'] - $_GET['d']) . "' class='button'>Add Purchase Expense</a>";
    } elseif ($_GET['say'] == 2) {
        $custom_message = "<h3 class='red'>Could not record purchase.</h3>";
    } elseif ($_GET['say'] == 3) {
        $custom_message = "<h3 class='faintred'>Please provide all informations correctly.</h3>";
    } elseif ($_GET['say'] == 4) {
        $custom_message = "<h3 class='faintred'>No purchaseable product is selected.</h3>";
    } elseif ($_GET['say'] == 5) {
        $custom_message = "<h3 class='faintred'>Discount is too high.</h3>";
    } elseif ($_GET['say'] == 6) {
        $custom_message = "<h3 class='red'>Failed to update stock.</h3>";
    } elseif ($_GET['say'] == 8) {
        $custom_message = "<h3 class='red'>Transport cost cannot be negative.</h3>";
    } elseif ($_GET['say'] == 'input_added') {
        $custom_message = "<h3 class='blue'>New Input Panel Added.</h3>";
    }
} else {
    $custom_message = "<h4 class='blue'>Please provide Purchase information and click sell.</h4>";
}

echo $custom_message;
$qur->print_new_purchase($encptid);