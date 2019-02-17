<?php
function gftheme_preprocess_html(&$vars) {
  $path = drupal_get_path_alias();
  $aliases = explode('/', $path);

  foreach($aliases as $alias) {
    $vars['classes_array'][] = drupal_clean_css_identifier($alias);
  } 
}

function gftheme_preprocess_page(&$vars) {
  if(module_exists('uc_cart')) { 
    $item_count = count(uc_cart_get_contents());
    //if( $item_count > 0 ) $item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));
    //  else $item_count = '<div class="icon_cart_alt"></div>';
    $item_count = l('<span class="icon_cart_alt"></span><span class="item-count">'.$item_count.'</span>', 'cart', array('html' => TRUE));   
    $vars['cart_items_count'] = $item_count;
  }
}


function gftheme_form_alter(&$form, &$form_state, $form_id) {

}