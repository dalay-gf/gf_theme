<?php


function gftheme_preprocess_views_view_fields(&$vars) {
  $view = &$vars['view'];
  if ($view->name == 'products') {
    $row = $vars['row'];

    $seller_limited_access = user_has_role(10);
    $is_gross = user_has_role(12);
    $is_publicator = user_has_role(13);
    $is_manager = user_has_role(5);
    $is_wholesaler = user_has_role(7);
    $is_creator = user_has_role(8);
    $is_admin = user_has_role(3);

    $is_man_sadovod = $is_opt_sadovod = $extra_10 = FALSE;
    if (user_has_role(18)) {
      $is_man_sadovod = $extra_10 = TRUE;
    } 

    if (user_has_role(19)) {
      $is_opt_sadovod = $extra_10 = TRUE;
    } 

    if ((!isset($_SESSION['gf_stock_region'])) || $is_opt_sadovod || $is_man_sadovod) {
      $_SESSION['gf_stock_region'] = GF_STOCK_REGION_RU;
    }
    $current_region = $_SESSION['gf_stock_region'];
    
    // поле количества на складе по регионам есть в ноде, а поля цены по складу нету(хотя она совпадает ???? с ценой забитой в ноде), можно было бы выводить без доп полей для вьюса
    //dpm($row);
    $ru_price = isset($row->gf_stock_prices_region_russia) ? round($row->gf_stock_prices_region_russia) : 0;
    $cn_price = isset($row->gf_stock_prices_region_china) ? round($row->gf_stock_prices_region_china): 0;

    $retail_price = round($ru_price * GF_RETAIL_PRICE_COEFFICIENT);
    $yuan_to_rub_rate = variable_get('gf_stock_yuan_exchange_rate', 1);
    
    $key = key($row->_field_data);
    
    // вывод остатков на складах по ролям
    if (isset($row->_field_data[$key]["entity"]->gf_region_stock[GF_STOCK_REGION_CN])){
      $cn_stock = $row->_field_data[$key]["entity"]->gf_region_stock[GF_STOCK_REGION_CN];
      
      if (!$is_creator && !$is_manager && !$is_publicator && !$is_admin) {
        if($cn_stock >= 10) $cn_stock = '&gt;10';
        if($cn_stock === 0 || $cn_stock == NULL) $cn_stock = '&#10007;';           
      }
    }
    else $cn_stock = '';

    if (isset($row->_field_data[$key]["entity"]->gf_region_stock[GF_STOCK_REGION_RU])){
      $ru_stock = $row->_field_data[$key]["entity"]->gf_region_stock[GF_STOCK_REGION_RU];
      
      if (!$is_creator && !$is_manager && !$is_publicator && !$is_admin) {
        if($ru_stock >= 10) $ru_stock = '&gt;10';
        if($ru_stock === 0 || $ru_stock == NULL) $ru_stock = '&#10007;';      
      }    
    }
    else $ru_stock = '';

    // Сылка на добавление в корзину(для замены ею формы с кнопкой, которая
    // при включенном кэше вью работает некорректно).
    $node = node_load($row->nid);
    $addtocartlink = gf_custom_addtocart_link($node); 
    
    $vars['addtocartlink'] = $addtocartlink;

    $vars['seller_limited_access'] = $seller_limited_access;
    $vars['is_gross'] = $is_gross;
    $vars['is_wholesaler'] = $is_wholesaler;
    $vars['is_publicator'] = $is_publicator;
    $vars['is_manager'] = $is_manager;
    $vars['is_creator'] = $is_creator;
    $vars['is_man_sadovod'] = $is_man_sadovod;
    $vars['is_opt_sadovod'] = $is_opt_sadovod;
    $vars['RU_CODE'] = GF_STOCK_REGION_RU;
    $vars['CN_CODE'] = GF_STOCK_REGION_CN;
    $vars['yuan_to_rub_rate '] = $yuan_to_rub_rate;
    $vars['current_code'] = $current_region;
    $vars['symbol'] = ($current_region == GF_STOCK_REGION_CN) ? 
      '<i class="fa fa-cny" aria-hidden="true"></i>' : '<i class="fa fa-rub" aria-hidden="true"></i>';

    $vars['curr_reg_price'] = ($current_region == GF_STOCK_REGION_CN) ? $cn_price : $ru_price;
    $vars['retail_price'] = ($current_region == GF_STOCK_REGION_CN) ? round($retail_price / $yuan_to_rub_rate) : $retail_price;
    $vars['cn_stock'] = $cn_stock;
    $vars['ru_stock'] = $ru_stock;

    $vars['not_avaible_text'] = t('Not available for purchase at current stock.');

    // Скидки.
    $vars['discount_coefficient'] = 1;
    $vars['discount_percent'] = $extra_10 ? 10 : 0;
  }
}
