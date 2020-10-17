<?php
//initialize system file
include("./sources/inc/system.php");

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
  <title><?= COMPANY ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="./vendors/DataTables-1.10.22/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="./css/general.css">

    <?php if (!is_null($_SESSION['theme'])) : ?>
      <link rel="stylesheet" type="text/css" href="./css/<?= $_SESSION['theme'] ?>/style.css">
    <?php endif; ?>

  <!-- JavaScript -->
  <script src="./vendors/jQuery-1.12.4/jquery-1.12.4.js"></script>
  <script src='./js/hidecheck.js'></script>
  <script src='./js/timedateday.js'></script>
  <script src='./js/slideupdown.js'></script>
  <!-- dataTables -->
  <script src="./vendors/DataTables-1.10.22/js/jquery.dataTables.min.js"></script>
    <?php
    //lunch security or login form
    include("./sources/inc/security.php");
    ?>
</head>
<body onLoad="startTime();">
<div id="topmenu">
    <?php
    include("sources/inc/topmenu.php");
    ?>
</div>
<div id="ttd">
  <div id="date">
      <?php echo date("D, d M Y"); ?>
  </div>
  <div id="digclock"></div>
</div>
<center>
  <div id="content">
    <img src="images/blank1by1.gif" class="leftpillar" alt=""/>
    <img src="images/blank1by1.gif" class="rightpillar" alt=""/>
    <br/>
    <h1 id="banner"><?= COMPANY ?></h1><br/>
      <?php
      $page = isset($_GET['page']) ? $_GET['page'] : NULL;
      $sub = isset($_GET['sub']) ? $_GET['sub'] : NULL;
      $section = "contents";
      include("sources/inc/content.php");
      ?>
    <br/>
  </div>
</center>
<center>
  <div id="ending">
      <?php
      include("sources/inc/ending.php");
      ?>
  </div>
</center>
<script>
    $(document).ready(function () {
        $('body').find('.table').DataTable({
            "dom": 'lrft<"dt-center"ip>',
            "oLanguage": {
                "sSearch": "Filter:"
            },
            "ordering": false,
            "info": true
        });
    });
</script>
</body>
</html>