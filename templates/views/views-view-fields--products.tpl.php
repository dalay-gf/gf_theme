<?php



//Путь ссылок на товары
$anchor_path = 'model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content;

(node_last_viewed($row->nid) > 0) ? $node_is_viewed = TRUE : $node_is_viewed = FALSE;



/* Скидки */
if(isset($row->_field_data["nid"]["entity"]->field_discount)){
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
}
// Выделяем "новый" товар(если он опубликован не позже, чем 2 месяца назад).
   $is_new = ((REQUEST_TIME - (int) $fields['created']->content) < (60*60*60*60));
      
?>

<div class="project-item-inner" id="<?php print "nid-" . $fields['nid']->content; ?>">
  <div class="show-on-hover">
    <?php if($is_new):?> <span class="new"></span> <?php endif; ?>
    
    <?php if ($discount_coefficient < 1.0): ?>
    <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="onsale">
            <?php print '-' . $discount_percent . '%'; ?>
          </span>
    </a>
    <?php endif; ?>
    
    <?php if (user_is_logged_in()):?>
        <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="cn-in-stock">
            <span><?php print t("CN");?></span><br>
            <?php print $cn_stock; ?>
          </span>
        </a>
        <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="ru-in-stock">
            <span><?php print t("RU");?></span><br>
            <?php print $ru_stock; ?>
          </span>
        </a>
   <?php endif; ?>


    <figure class="alignnone project-img">
      <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>"><?php print $fields['uc_product_image']->content; ?></a>
    </figure>
  </div>
  
  <div class="project-desc">
    <h4 class="title"><a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>"><?php print $fields['model']->raw; ?></a></h4>
    <div class="price">
        <?php //показываем ретейл цену всем ?>
        
        <?php if(!user_is_logged_in() or $is_creator or $is_manager or $is_publicator or $is_admin or $seller_limited_access): ?>
          <?php if ($retail_price) : ?>
            <div class="amount retail-amount">
              <span><?php print t('Retail price ') ?></span><span class="price-value"><?php print $symbol .' '. $retail_price; ?></span>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        
        <?php //показываем оптовую цену всем залогиненным кроме $seller_limited_access ?>
        
        <?php if(user_is_logged_in() && !$seller_limited_access): ?>
          <?php if($curr_reg_price): ?>
            <div class="amount wholesale-amount">
              <span><?php print t('Wholesale price ') ?></span><span class="price-value"><?php print $symbol .' '. round($curr_reg_price * $discount_coefficient); ?></span>
            </div>        
            
            <div class="addtocartlink">
              <?php ($row->_field_data["nid"]["entity"]->gf_region_stock[$current_code]) ? print $addtocartlink : print '<span class="no-code"></span>'; ?>
            </div>
            <?php else: ?><?php print $not_avaible_text; ?>
          <?php endif; ?>
        <?php endif; ?>
    </div>
  </div>

</div>
