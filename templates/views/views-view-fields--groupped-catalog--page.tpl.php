<?php
/**
*
*/
?>

<?php if (uc_stock_level($fields['model']->content) > 0) : ?>
  <a class="model-variant" href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
    <?php print $fields['uc_product_image']->content; ?>
    <span class="stock-level"><?php print uc_stock_level($fields['model']->content);?></span>
  </a>
<?php endif ;?>