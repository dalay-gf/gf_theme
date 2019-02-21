<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<span class="color-subtotal">
<?php
$sum_of_orders = 0;
foreach ($rows as $id => $row){
  $sum_of_orders = $row;
};
print trim($sum_of_orders);
?>
</span>