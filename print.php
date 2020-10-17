<?php
include("./sources/inc/system.php");
include("sources/inc/security_o.php");

?>
<!DOCTYPE html>
<html lang="en-US">
<head lang="en-US">
  <title>Print Preview</title>
  <link rel="stylesheet" href="css/printstyle.css" type="text/css"/>
  <script type='text/javascript' src='js/print.js'></script>
</head>
<body onLoad="printpage()" style="margin: 0 auto;  font-size: 16pt;">
<center>
  <h1 id='banner'><?= COMPANY ?></h1>
    <?php
    $page = $inp->value_pgd('page');
    $sub = $inp->value_pgd('sub');
    $section = "print";
    include("sources/inc/content.php");
    ?>
</center>
<?php echo "<b style='display:block; bottom: 0; margin-top: 2rem;'>Printed on : " . date("d M Y (D) h:i:s A") . "</b>"; ?>
</body>
</html>
