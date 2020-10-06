<?php
include ("./sources/inc/system.php");
include ("./sources/inc/security_o.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <link rel="stylesheet" href="css/printstyle.css" type="text/css"/>
  <script type='text/javascript' src='js/print.js'></script>
</head>
<body onLoad="printpage()" style="width: 900px; margin: 0 auto;">
<center>
  <h1 id='banner'><?php echo $company; ?></h1>
    <?php
    echo "<b>Printed on : " . date("d M Y (D)") . "</b><br/>";
    $page = $inp->value_pgd('page');
    $sub = $inp->value_pgd('sub');
    $section = "print";
    include("sources/inc/content.php");
    ?>
</center>
</body>
</html>
