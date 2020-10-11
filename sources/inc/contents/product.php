<h1>Product</h1>
<div id="bigmenu">
  <a href="index.php?e=<?php echo $encptid ?>&page=product&sub=particular_product">Product Report</a>
  <a href="index.php?e=<?php echo $encptid ?>&page=product&sub=raw_material">Raw Material</a>
  <a href="index.php?e=<?php echo $encptid ?>&page=product&sub=finished_product">Finished Product</a>
  <a href="index.php?e=<?php echo $encptid ?>&page=home&sub=product">Product Search</a>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&page=product&sub=edit_product'>Edit Product</a>" ?>
    <?php if ($usertype == ADMIN) echo "<a href='index.php?e=" . $encptid . "&page=product&sub=add_product'>Add Product</a>" ?>
</div>