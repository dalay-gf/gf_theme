<?php


//Подгрузка переменной из header/header-1.tpl.php

global $seller_limited_access; // а это здесь зачем????

//Путь ссылок на товары
//$anchor_path = 'model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content;
$anchor_path = 'model/' . $row->field_field_main_sku[0]['raw']['value'] . '/' . $fields['nid']->content;
//dpm($row);
//dpm($anchor_path);

/* Скидки */
if (count($row->_field_data["nid"]["entity"]->field_discount) > 0) {
  $raw_discount_value = $fields["field_discount"]->content;
  $discount_percent = substr($raw_discount_value, 0, strpos($raw_discount_value, '%'));
  $discount = TRUE;
}

if ($discount and $extra_10) {
  $discount_percent += 10;
} elseif ($extra_10) {
  $discount_percent = 10;
}

if ($discount_percent) {
  $discount_coefficient = 1.0 - $discount_percent / 100;
} else {
  $discount_coefficient = 1;
}
// Выделяем "новый" товар(если он опубликован не позже, чем 2 месяца назад).
   $is_new = ((REQUEST_TIME - (int) $fields['created']->content) < (60*60*60*60));
   
?>


<div class="project-item-inner" id="<?php print "nid-" . $fields['nid']->content; ?>">
  <div class="show-on-hover">
    <?php if($is_new):?> <span class="new"></span> <?php endif; ?>

    <?php if ($discount_percent): ?>
    <a href="<?php print $product_url; ?>">
          <span class="onsale">
            <?php print '-' . $discount_percent . '%'; ?>
          </span>
    </a>
    <?php endif; ?>

    <?php if (user_is_logged_in()):?>
        <a href="<?php print $product_url; ?>">
          <span class="cn-in-stock">
            <span><?php print t("CN");?></span><br>
            <?php print $cn_stock; ?>
          </span>
        </a>
        <a href="<?php print $product_url; ?>">
          <span class="ru-in-stock">
            <span><?php print t("RU");?></span><br>
            <?php print $ru_stock; ?>
          </span>
        </a>
   <?php endif; ?>

    <figure class="alignnone project-img">
      <?php 
      $anchor_text = $fields['uc_product_image']->content;
      print l($anchor_text, $anchor_path, array('html' => TRUE));
      ?>
   </figure>
 </div>
 
  <div class="project-desc">
    <h4 class="title"><?php print l(strval($fields['model']->raw), $anchor_path, array('html' => TRUE));?></h4>
    <div class="price">
       
          <?php if ($retail_price) : ?>
            <div class="amount retail-amount">
              <span><?php print t('Retail price ') ?></span><span class="price-value"><?php print $symbol .' '. $retail_price; ?></span>
            </div>
          <?php endif; ?>
      
        
        <?php if(user_is_logged_in() && !$seller_limited_access): ?>
          <?php if($curr_reg_price): ?>
            <div class="amount wholesale-amount">
              <span><?php print t('Wholesale price ') ?></span><span class="price-value"><?php print $symbol .' '. round($curr_reg_price * $discount_coefficient); ?></span>
            </div>        
            
            <div class="addtocartlink">
              <?php ($row->_field_data["nid"]["entity"]->gf_region_stock[$current_code]) ? print $addtocartlink : print '<span class="no-code"></span>'; ?>
            </div>
            <?php else: ?><p><?php print $not_avaible_text; ?></p>
          <?php endif; ?>
        <?php endif; ?>
    </div>
  </div>
</div>

