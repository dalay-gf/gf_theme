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

function gftheme_process_page(&$vars) {
  //прячем заголовок если стоит галочка в ноде
  if(isset($vars['node']) && isset($vars['node']->field_hide_title['und'][0]['value'])){
    if($vars['node']->field_hide_title['und'][0]['value'] == 1) $vars['title'] = '';
  } 
}

function gftheme_preprocess_page(&$vars) {
  if(module_exists('uc_cart')) { 
    $item_count = count(uc_cart_get_contents());
    if( $item_count > 0 ) $item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));
      else $item_count = '<div class="icon_cart_alt"></div>';
    // вариант вывода корзины ссылкой с нулем товаров в корзине
    //$item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));   
    $vars['cart_items_count'] = $item_count;
  }
  $block = module_invoke('locale', 'block_view', 'language');
  $vars['language_dropdown_block'] =  render($block['content']);
}

/*
function gftheme_menu_tree__menu_catalog_menu(&$vars) {
  return '<ul>' . $variables['tree'] . '</ul>';
}
*/

function gftheme_form_alter(&$form, &$form_state, $form_id) {

}

include 'node-preprocess.inc';
include 'preprocess_views_view_fields.inc';
