<?php

// Коэффициент для расчета цен, рекомендуемых для розницы.
define('GF_RETAIL_PRICE_COEFFICIENT', 2.5);
function gftheme_preprocess_html(&$vars) {

  $path = drupal_get_path_alias();
  $aliases = explode('/', $path);

  foreach($aliases as $alias) {
    $vars['classes_array'][] = drupal_clean_css_identifier($alias);
  } 
}

function gftheme_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];

  if (!empty($breadcrumb)) {
    $output = '<div class="breadcrumb"><span class="text">'.t('You are here:').'</span>' . implode('<span class="delim"> › </span>', $breadcrumb) . '</div>';
    return $output;
  }
}

function gftheme_menu_tree__menu_catalog_menu(&$vars) {
  return '<ul id="catalog-menu" class="nav-menu">' . $vars['tree'] . '</ul>';
}

function gftheme_menu_tree__main_menu(&$vars) {
  return '<ul id="main-menu" class="nav-menu">' . $vars['tree'] . '</ul>';
}

function gftheme_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    unset($element['#below']['#theme_wrappers']);
    $sub_menu = '<ul>' . drupal_render($element['#below']) . '</ul>';
    $element['#localized_options']['html'] = TRUE;
    $output = l($element['#title'].' <span class="arrow-down"></span>', $element['#href'], $element['#localized_options']);    
  }
  else 
    $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function gftheme_process_page(&$vars) {
  //прячем заголовок если стоит галочка в ноде
  if(isset($vars['node']) && isset($vars['node']->field_hide_title['und'][0]['value'])){
    if($vars['node']->field_hide_title['und'][0]['value'] == 1) $vars['title'] = '';
  } 
}

function gftheme_preprocess_page(&$vars) {
  /*
  if(module_exists('uc_cart')) { 
    $item_count = count(uc_cart_get_contents());
    if( $item_count > 0 ) $item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));
      else $item_count = '<div class="icon_cart_alt"></div>';
    // вариант вывода корзины ссылкой с нулем товаров в корзине
    //$item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));   
    $vars['cart_items_count'] = $item_count;
  }
  */
  
  //language dropdown
  $block = module_invoke('locale', 'block_view', 'language');
  $vars['language_dropdown_block'] =  render($block['content']);
  
  //catalog menu tree
  $menu_catalog_menu = module_exists('i18n_menu') ? i18n_menu_translated_tree('menu-catalog-menu') : menu_tree('menu-catalog-menu');
  
  //main menu tree
  $main_menu_tree = module_exists('i18n_menu') ? i18n_menu_translated_tree(variable_get('menu_main_links_source', 'main-menu')) : menu_tree(variable_get('menu_main_links_source', 'main-menu'));
  
  // show menu based on current path
  $current_path = drupal_get_path_alias();
  if(drupal_match_path($current_path,'shop') || drupal_match_path($current_path,'shop/*') || drupal_match_path($current_path,'model/*')) $vars['main_menu_nav'] = drupal_render($menu_catalog_menu);
    else $vars['main_menu_nav'] = drupal_render($main_menu_tree);
  
}

function gftheme_form_alter(&$form, &$form_state, $form_id) {

}

// другие препроцесс функции
include 'node-preprocess.inc';
include 'preprocess_views_view_fields.inc';
