<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php
$total_sum_of_orders = 0;

foreach ($rows as $id => $row)
{
  $total_sum_of_orders += $row;
}

print trim($total_sum_of_orders);
?>