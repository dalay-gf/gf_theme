<?php

/*
Автодобавление в корзину при переходе по ссылке из мобильного приложения-сканера
*/
$add_scanned = FALSE;
if (!empty(drupal_get_query_parameters()['add-to-cart']) && !empty(drupal_get_query_parameters()['add_to_cart'])){ 
  $add_scanned = (drupal_get_query_parameters()['add-to-cart'] == 'yes' && 
    drupal_get_query_parameters()['add_to_cart'] == 'yes');
} 


if ($add_scanned) {
  uc_cart_add_item($node->nid, $qty = 1);
};

$rrp_title = t('RRP');

if ($field_discount[0]) {
  $raw_discount_value = $field_discount[0]["taxonomy_term"]->name;
  $discount_percent = substr($raw_discount_value, 0, strpos($raw_discount_value, '%'));
  $discount = TRUE;
}

if ($discount && $extra_10) {
  $discount_percent += 10;
}
if (!$discount && $extra_10) {
  $discount_percent = 10;
}

if ($discount_percent) {
  $discount_coefficient = 1.0 - $discount_percent / 100;
} else {
  $discount_coefficient = 1;
}

?>


<?php hide($content['field_antiprice']);?>

<div id="node-<?php print $node->nid; ?>" class="row <?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="columns">
    <div class="column col-6 col-sm-12">
      <!-- Project Slider -->
      <?php if ((isset($content["field_discount"][0]) and $content["field_discount"][0]["#markup"] != "0%") or $extra_10) : ?>
        <span class="onsale"><?php print '-' . $discount_percent . '%';?></span>
      <?php endif;?>
      <div class="owl-carousel owl-theme owl-slider thumbnail">
        <?php foreach(element_children($content['uc_product_image']) as $key): ?>
          <div class="item" data-thumb='<?php print render($content['uc_product_image'][$key]); ?>'>
            <?php print render($content['uc_product_image'][$key]); ?>
          </div>
        <?php endforeach; ?>
      </div>
      <!-- Project Slider / End -->
    <?php print render($content['field_main_description']); ?>
    
    </div>
    <div class="column col-6 col-sm-12">
      <div class="select-warehouse">
        <div class="ru-stock"></div>
        <div class="cn-stock"></div>
      </div>
      <div class="sku"><?php print t('SKU:').' '.$node->model; //????????????????????????????????????????????????? or  $content['field_main_sku']['#items'][0]['value'] ?></div> 
      
      <div class="available-colors">
        <div class="sub-title"><?php print t('Color').': '; ?></div>
        <?php print views_embed_view('groupped_catalog', 'page', $content['field_main_sku']['#items'][0]['value']); ?>
      </div>
      
      <div class="ru-warehouse-product-values">
        <?php print $add_to_cart_by_region; ?>
      </div>
      
      <div class="cn-warehouse-product-values">
                <div class="region-selector"> <?php
                  $region_selector_block = block_load('gf_stock', 'gf_stock_region_switch');
                  $renderable_region_selector_block = _block_get_renderable_array(_block_render_blocks(array($region_selector_block)));
                  $rs_output = drupal_render($renderable_region_selector_block);
                  print $rs_output;
                  ?>
                </div>
      </div>   
      
      <div class="tabs product-description">
        <ul class="tabs__caption">
          <li class="active"><?php print t('Specifications'); ?></li>
          <li><?php print t('Delivery'); ?></li>
          <li><?php print t('Payment'); ?></li>
          <li><?php print t('Warranty'); ?></li>
        </ul>
        <div class="tabs__content product-specifications active">
          <div class="table-responsive">
            <?php
              unset($content['field_main_description'], $content['field_rating'], $content['field_tags'], $content['field_catalog'], $content['field_antiprice'], $content['field_sku_autocomplete'], $content['field_votes']);
              $rows = array();
              foreach($content as $key => $field){
                if(strpos($key, 'field') !== FALSE && !empty($field)){
                  $content[$key]['#label_display'] = 'hidden';
                  $values = array();
                  foreach(element_children($content[$key]) as $i) {
                    $values[] = render($content[$key][$i]);
                  }
                  $rows[] = array($content[$key]['#title'], implode('<br/>', $values));
                }
              }
              $weight = render($content['weight']);
              if($weight) {
                $rows[] = array(t('Weight'), $weight);
              }
              $dimensions = render($content['dimensions']);
              if($dimensions) {
                $rows[] = array(t('Dimensions'), $dimensions);
              }
              print theme('table', array('rows' => $rows, 'attributes' => array('class' => array('table table-striped'))));
            ?>
          </div> 
        </div>
        <div class="tabs__content product-delivery">
            Содержимое 2 блока
        </div>
        <div class="tabs__content product-payment">
            Содержимое 3 блока
        </div>
        <div class="tabs__content product-warranty">
            Содержимое 4 блока
        </div>        
      </div>
    </div>
  </div>
</div>  
  
  
  
