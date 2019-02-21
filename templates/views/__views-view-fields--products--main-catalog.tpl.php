<?php



//Путь ссылок на товары
$anchor_path = 'model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content;

(node_last_viewed($row->nid) > 0) ? $node_is_viewed = TRUE : $node_is_viewed = FALSE;



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

?>

<div class="project-item-inner" id="<?php print "nid-" . $fields['nid']->content; ?>">
  <div class="show-on-hover">
    <?php // Выделяем "новый" товар(если он опубликован не позже, чем 2 месяца назад).
      $is_new = ((REQUEST_TIME - (int) $fields['created']->content) < (60*60*60*60));
      if($is_new) print '<span class="new"></span>'; 
    ?>
    <?php if ($discount_coefficient < 1.0): ?>
    <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="onsale">
            <?php print '-' . $discount_percent . '%'; ?>
          </span>
    </a>
    <?php endif; ?>

        <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="cn-in-stock">
            <?php
            print '<span>'. t("CN") .'</span><br>';
            $cn_stock = $row->_field_data["nid"]["entity"]->gf_region_stock[$CN_CODE];
            if ($is_creator or $is_manager or $is_publicator or $is_admin) {
              print $cn_stock;
            } else {
              if($cn_stock > 0 && $cn_stock < 10) {
                  print $cn_stock;
              } elseif ($cn_stock >= 10) {
                print '&gt;10';
              } else {
                print '&#10007;';
              }
            }
            ?>
          </span>
        </a>
        <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>">
          <span class="ru-in-stock">
            <?php
            $ru_stock = $row->_field_data["nid"]["entity"]->gf_region_stock[$RU_CODE];
            print '<span>'. t("RU") .'</span><br>';
            if ($is_creator or $is_manager or $is_publicator or $is_admin) {
              print $ru_stock;
            } else {
              if ($ru_stock < 10 and $ru_stock > 0) {
              print $ru_stock;
              } elseif ($ru_stock >=10) {
              print '&gt;10';
              } else {
              print '&#10007;';
              }
            }
            ?>
          </span>
        </a>


    <figure class="alignnone project-img">
      <a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>"><?php print $fields['uc_product_image']->content; ?></a>
    </figure>
  </div>
  
  <div class="project-desc">
    <h4 class="title"><a href="<?php print url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content); ?>"><?php print $fields['model']->raw; ?></a></h4>
    <div class="price">
    
      <?php if ($curr_reg_price) : ?>
        
        <?php if(!$logged_in || $seller_limited_access): ?>
          <?php if ($retail_price) : ?><div class="retail-amount"><?php print $symbol . $retail_price; ?></div><?php endif; ?>
        <?php else: ?>
          <div class="amount">
            <?php print $symbol . round($curr_reg_price * $discount_coefficient); ?>
          </div>        
          
        <div class="addtocartlink">
          <?php ($row->_field_data["nid"]["entity"]->gf_region_stock[$current_code]) ? print $addtocartlink : print '<span class="no-code"></span>'; ?>
        </div>
        <?php endif; ?>
        
      <?php else: ?> <?php print $not_avaible_text; ?>
      <?php endif; ?>

    </div>
  </div>

</div>
