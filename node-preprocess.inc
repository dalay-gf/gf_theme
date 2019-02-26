<?php

/**
 * Implements hook_preprocess_node()/
 */
function gftheme_preprocess_node(&$variables) {
  if (in_array($variables['node']->type, uc_product_types())) {
    global $user;
    $node = $variables['node'];

    $extra_10 = FALSE;
    (user_has_role(18)) ? $is_man_sadovod = $extra_10 = TRUE : $is_man_sadovod = FALSE;
    (user_has_role(19)) ? $is_opt_sadovod = $extra_10 = TRUE : $is_opt_sadovod = FALSE;


    $current_region = $_SESSION['gf_stock_region'] ?? FALSE;

    if ((!$current_region) || $current_region == GF_STOCK_REGION_ALL 
      || $is_opt_sadovod || $is_man_sadovod) {
      $current_region = GF_STOCK_REGION_RU;
    }

    $other_region = ($current_region == GF_STOCK_REGION_RU) ? GF_STOCK_REGION_CN : GF_STOCK_REGION_RU;

    $variables['seller_limited_access'] = user_has_role(10);
    $variables['is_gross'] = user_has_role(12);
    $variables['is_publicator'] = user_has_role(13);
    $variables['is_manager'] = user_has_role(5);
    $variables['is_creator'] = user_has_role(8);
    $variables['is_man_sadovod'] = $is_man_sadovod;
    $variables['is_opt_sadovod'] = $is_opt_sadovod;
    $variables['current_region'] = $current_region;
    $variables['extra_10'] = $extra_10;
    $variables['currency_symbol'] = [
      GF_STOCK_REGION_CN => '<i class="fa fa-cny" aria-hidden="true"></i>',
      GF_STOCK_REGION_RU => '<i class="fa fa-rub" aria-hidden="true"></i>',
    ];

    $price_ru = ($node->gf_region_stock[GF_STOCK_REGION_RU] > 0) ? 
      round($node->gf_region_prices[GF_STOCK_REGION_RU]) : 0;
    $price_cn = ($node->gf_region_stock[GF_STOCK_REGION_CN] > 0) ? 
      round($node->gf_region_prices[GF_STOCK_REGION_CN]) : 0;

    $yuan_to_rub_rate = variable_get('gf_stock_yuan_exchange_rate');

    // Расчет рекомендуемой розничной цены делаем на основе цены для российского склада.
    // И для китайской цены тоже.(согласно инструкций от Сергея)
    $retail_price = ($price_ru) ? ($price_ru * GF_RETAIL_PRICE_COEFFICIENT) : 0;
    // Если цены для рос. склада нет, то используем китайскую(указаний для
    // такой ситуации не было, но совсем без РРЦ будет смотреться негармонично).
    $retail_price_cn = $retail_price ? ($retail_price / $yuan_to_rub_rate) : ($price_cn * GF_RETAIL_PRICE_COEFFICIENT);

    if ($current_region == GF_STOCK_REGION_CN) {
      $order_price = $price_cn;
      $other_retail_price = $retail_price;
      $retail_price = $retail_price_cn;
      $other_order_price = $price_ru;
    } 
    else {
      $order_price = $price_ru;
      $other_order_price = $price_cn;
      $other_retail_price = $retail_price_cn;
    }

    // вывод остатков на складах по ролям
    if (isset($node->gf_region_stock[GF_STOCK_REGION_CN])){
      $cn_stock = $node->gf_region_stock[GF_STOCK_REGION_CN];
      
      if (!$is_creator && !$is_manager && !$is_publicator && !$is_admin) {
        if($cn_stock >= 10) $cn_stock = '&gt;10';
        if($cn_stock === 0 || $cn_stock == NULL) $cn_stock = '&#10007;';           
      }
    }
    else $cn_stock = '';

    if (isset($node->gf_region_stock[GF_STOCK_REGION_RU])){
      $ru_stock = $node->gf_region_stock[GF_STOCK_REGION_RU];
      
      if (!$is_creator && !$is_manager && !$is_publicator && !$is_admin) {
        if($ru_stock >= 10) $ru_stock = '&gt;10';
        if($ru_stock === 0 || $ru_stock == NULL) $ru_stock = '&#10007;';      
      }    
    }
    else $ru_stock = '';    
    
    // show cart form for node if stock > 0 and node have add_to_cart form
    //dpm($current_region);
    // dpm($node->gf_region_stock[$current_region]);

    
    if (isset($variables['content']['add_to_cart']) && 
        isset($node->gf_region_stock[$current_region]) && 
        $node->gf_region_stock[$current_region] > 0 &&
        $node->gf_region_stock[$current_region] != NULL &&
        $order_price){
      unset($variables['content']['add_to_cart']['#form']['qty']['#title']);
      $variables['content']['add_to_cart']['#form']['qty']['#attributes']['class'] = array('qty', 'text', 'input-text');
      $variables['content']['add_to_cart']['#form']['qty']['#prefix'] = '<div class="quantity"><input type="button" value="-" class="minus small-input-button">';
      $variables['content']['add_to_cart']['#form']['qty']['#suffix'] = '<input type="button" value="+" class="plus small-input-button"></div>';
      $add_to_cart_by_region = render($variables['content']['add_to_cart']);
    }
    else $add_to_cart_by_region = '';
    
    $variables['cn_stock'] = $cn_stock;
    $variables['ru_stock'] = $ru_stock;
    
    $variables['add_to_cart_by_region'] = $add_to_cart_by_region;    
    
    $variables['other_region'] = $other_region; 


    $field_adaptive = user_load($user->uid)->field_adaptive_design;


    $variables['adaptive_enabled'] = isset($field_adaptive[LANGUAGE_NONE]) ?
      $field_adaptive[LANGUAGE_NONE][0]['value'] : TRUE;



    $variables['order_price'] = $order_price;
    //$variables['retail_price'] = round($retail_price);

    $variables['other_order_price'] = $other_order_price;
    $variables['other_retail_price'] = round($other_retail_price);
  }

}
