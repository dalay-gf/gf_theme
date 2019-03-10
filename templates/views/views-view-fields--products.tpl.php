<?php

//Путь ссылок на товары
// $anchor_path = 'model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content;
// $product_url = url('model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content);
$product_url = url('node/' . $fields['nid']->content);


/* Скидки */
if (isset($fields['field_discount'])) {
  $discount_percent += (int) $fields['field_discount']->content;
}

if ($discount_percent) {
  $discount_coefficient = 1.0 - $discount_percent / 100;
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
      <a href="<?php print $product_url; ?>"><?php print $fields['uc_product_image']->content; ?></a>
    </figure>
  </div>

  <div class="project-desc">
    <h4 class="title"><a href="<?php print $product_url; ?>"><?php print $fields['model']->raw; ?></a></h4>
    <div class="price">
      <?php if ($retail_price) : ?>
        <div class="amount retail-amount">
          <span><?php print t('Retail price ') ?></span><span class="price-value"><?php print $symbol .' '. $retail_price; ?></span>
        </div>
      <?php endif; ?>

      <?php if($curr_reg_price): ?>
        <div class="amount wholesale-amount">
        <span><?php print t('Wholesale price ') ?></span>
        <span class="price-value">
          <?php print $symbol .' '. round($curr_reg_price * $discount_coefficient); ?>
        </span>
        </div>
      <?php endif; ?>

      <?php if($addtocartlink && user_is_logged_in()): ?>
        <div class="addtocartlink">
          <?php print $addtocartlink; ?>
        </div>
      <?php endif; ?>

    </div>
  </div>

</div>
