<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
?>

<?php
$src_model = $row->gf_order_production_model_id;
$src_good_nid = db_select('uc_products',  'p')
  ->fields('p', ['nid'])
  ->condition('model', $src_model . "%", 'LIKE')
  ->execute()
  ->fetchAssoc();
$src_good = node_load($src_good_nid['nid']);

$image_fid = $src_good->uc_product_image['und'][0]['fid'];
$image_file = file_load($image_fid);
$image = image_load($image_file->uri);
$src_img = array(
  'file' => array(
    '#theme' => 'image_style',
    '#style_name' => 'thumbnail',
    '#path' => $image->source,
    '#width' => $image->info['width'],
    '#height' => $image->info['height'],
  ),
);

print l(drupal_render($src_img), '/model/' . $src_good->field_main_sku['und'][0]['value'] . '/' . $src_good_nid['nid'], array('attributes' => array('class' => array('src-img colorbox-node'), 'data-inner-height'=>array('80%'), 'data-inner-width'=>array("90%")), 'query' => array('tab' => 'order'), 'html' => true));

$order_price = round($row->_field_data['nid']['entity']->gf_order['product_price'], 2);
print  '<div class="src-img">' . drupal_render($src_img) .'</div>' . $output /*. '<br> ¥' . $order_price*/;
?>
