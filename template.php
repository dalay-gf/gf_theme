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
 if ($form_id=='uc_cart_view_form'){
   $form['items']['#prefix'] = '<div class="table-outer"><div class="cart-page-header"><span>'.t('Customer cart').'</span></div>';
   $form['actions']['#prefix'] = '</div>';
   $form['actions']['checkout']['checkout']['#value'] = str_replace('→','',$form['actions']['checkout']['checkout']['#value']);
   $form['items']['#columns']['remove']['weight'] = -1; 
 }
}

function gftheme_tapir_table_alter(&$table, $table_id) { 
  if ($table_id == 'uc_cart_view_table') { 
  //dpm($table);
    foreach (element_children($table) as $key) {
      if (!empty($table[$key]['remove']['#value'])) $table[$key]['remove']['#value'] = '╳';
      //dpm($key);
    } 
  } 
} 

/* эта функция сдесь лишняя - от старой темы */

function _get_node_field($node, $field, $lang = 'en') {
  global $language;
  $var = FALSE;
  if(isset($node->{$field}[$lang]) && !empty($node->{$field}[$lang])) {
      $var = $node->{$field}[$lang];
  } elseif(isset($node->{$field}[$language->language]) && !empty($node->{$field}[$language->language])) {
      $var = $node->{$field}[$language->language];
  } elseif(isset($node->{$field}['und']) && !empty($node->{$field}['und'])) {
      $var = $node->{$field}['und'];
  } elseif(isset($node->{$field}) && !empty($node->{$field})) {
      $var = $node->{$field};
  }
  return $var;
}

/*

function gftheme_uc_cart_review_table($variables) {
  $items = $variables['items'];
  $show_subtotal = $variables['show_subtotal'];

  $subtotal = 0;

  // Set up table header.
  $header = array(
    array('data' => theme('uc_qty_label'), 'class' => array('qty')),
    array('data' => t('Products'), 'class' => array('products')),
    array('data' => t('Price'), 'class' => array('price')),
  );

  // Set up table rows.
  $display_items = uc_order_product_view_multiple($items);
  if (!empty($display_items['uc_order_product'])) {
    foreach (element_children($display_items['uc_order_product']) as $key) {
      $display_item = $display_items['uc_order_product'][$key];
      $subtotal += $display_item['total']['#price'];
      $rows[] = array(
        array('data' => $display_item['qty'], 'class' => array('qty')),
        array('data' => $display_item['product'], 'class' => array('products')),
        array('data' => $display_item['total'], 'class' => array('price')),
      );
    }
  }

  // Add the subtotal as the final row.
  if ($show_subtotal) {
    $rows[] = array(
      'data' => array(
        // One cell
        array(
          'data' => array(
            '#theme' => 'uc_price',
            '#prefix' => '<span id="subtotal-title">' . t('Subtotal:') . '</span> ',
            '#price' => $subtotal,
            '#suffix' => '<div id="total-qty"><span>'. t('Total qty:') . 
            '</span>' . uc_cart_get_total_qty() . '</div>', // добавляем инф-ю об общем кол-ве заказанного
          ),
          // Cell attributes
          'colspan' => 3,
          'class' => array('subtotal'),
        ),
      ),
      // Row attributes
      'class' => array('subtotal'),
    );
  }

  return theme('table', array('header' => $header, 'rows' => $rows, 'attributes' => array('class' => array('cart-review'))));
}

function gftheme_uc_cart_checkout_review($variables) {
  $panes = $variables['panes'];
  $form = $variables['form'];

  drupal_add_css(drupal_get_path('module', 'uc_cart') . '/uc_cart.css');

  $output = '<div id="review-instructions">' . filter_xss_admin(variable_get('uc_checkout_review_instructions', uc_get_message('review_instructions'))) . '</div>';

  $output .= '<table class="order-review-table">';

  foreach ($panes as $title => $data) {
    $output .= '<tr class="pane-title-row">';
    $output .= '<td colspan="2">' . $title . '</td>';
    $output .= '</tr>';
    if (is_array($data)) {
      if ($title == t('Payment method')) {
        // Если мы в разделе отображения методов оплаты(определяем по
        // заголовку раздела), то добавляем после поля с общей суммой заказа
        // данные об общем кол-ве заказанного. Поле с данными о методе оплаты двигаем ниже.
        $data[3] = $data[2];
        $data[2] = [
          'title' => t('Total qty'),
          'data' => '<span class="total-qty">' . uc_cart_get_total_qty() . '</span>',
        ];
      }
      foreach ($data as $row) {
        if (is_array($row)) {
          if (isset($row['border'])) {
            $border = ' class="row-border-' . $row['border'] . '"';
          }
          else {
            $border = '';
          }
          $output .= '<tr' . $border . '>';
          $output .= '<td class="title-col">' . $row['title'] . ':</td>';
          $output .= '<td class="data-col">' . $row['data'] . '</td>';
          $output .= '</tr>';
        }
        else {
          $output .= '<tr><td colspan="2">' . $row . '</td></tr>';
        }
      }
    }
    else {
      $output .= '<tr><td colspan="2">' . $data . '</td></tr>';
    }
  }

  $output .= '<tr class="review-button-row">';
  $output .= '<td colspan="2">' . drupal_render($form) . '</td>';
  $output .= '</tr>';

  $output .= '</table>';

  return $output;
}
*/

// другие препроцесс функции
include 'node-preprocess.inc';
include 'preprocess_views_view_fields.inc';
