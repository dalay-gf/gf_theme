<?php

/**
 * @file
 * Default simple view template to display a rows in a grid.
 *
 * - $rows contains a nested array of rows. Each row contains an array of
 *   columns.
 *
 * @ingroup views_templates
 */
// Match Column numbers to Bootsrap class
//$columns_classes = array(3 => 4, 4 => 3, 2 => 6, 6 => 2);
//$bootsrap_class = isset($columns_classes[$view->style_plugin->options['columns']]) ? $columns_classes[$view->style_plugin->options['columns']] : 3;
?>
<?php foreach ($rows as $row_number => $columns): ?>
  <div class = "columns products row">
    <?php foreach ($columns as $column_number => $item): ?>
      <div class = "column col-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 product project-item"> 
        <div class="outer"><?php print $item; ?></div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endforeach; ?> 
