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

function gftheme_css_alter(&$css) {
  unset($css[drupal_get_path('module', 'logintoboggan') . '/logintoboggan.css']);
  unset($css[drupal_get_path('module', 'uc_payment') . '/uc_payment.css']);
}

function gftheme_breadcrumb($vars) {
  $breadcrumb = $vars['breadcrumb'];

  if (!empty($breadcrumb)) {
    //$page_title = filter_xss(menu_get_active_title(), array());
    //$breadcrumb[] = t($page_title);
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
  
  drupal_add_library('system', 'ui.accordion');
  
  //language dropdown
  $block = module_invoke('locale', 'block_view', 'language');
  $vars['language_dropdown_block'] =  render($block['content']);
  
  //catalog menu tree
  $menu_catalog_menu = module_exists('i18n_menu') ? i18n_menu_translated_tree('menu-catalog-menu') : menu_tree('menu-catalog-menu');
  
  //main menu tree
  $main_menu_tree = module_exists('i18n_menu') ? i18n_menu_translated_tree(variable_get('menu_main_links_source', 'main-menu')) : menu_tree(variable_get('menu_main_links_source', 'main-menu'));
  
  // show menu based on current path
  $current_path = drupal_get_path_alias();
  if(drupal_match_path($current_path,'shop') || 
     drupal_match_path($current_path,'shop/*') || 
     drupal_match_path($current_path,'model/*')||
     drupal_match_path($current_path,'cart/*')||
     drupal_match_path($current_path,'novelty/*')
     ) $vars['main_menu_nav'] = drupal_render($menu_catalog_menu);
    else $vars['main_menu_nav'] = drupal_render($main_menu_tree);
  
}

function gftheme_form_alter(&$form, &$form_state, $form_id) {
 if ($form_id=='uc_cart_view_form'){
   //dpm($form);
   $form['items']['#prefix'] = '<div class="table-outer"><div class="cart-page-header"><span>'.t('Customer cart').'</span></div>';
   $form['actions']['#prefix'] = '</div>';
   $form['actions']['checkout']['checkout']['#value'] = str_replace('→','',$form['actions']['checkout']['checkout']['#value']);
   $form['items']['#columns']['remove']['weight'] = -1; 
 }
 if($form_id == 'contact_site_form'){
   //dpm($form);
   $blockObject = block_load('block', '45');
   $block = _block_get_renderable_array(_block_render_blocks(array($blockObject)));
   $output = drupal_render($block);
   $form['#prefix'] = '<div class="contacts-form-title">'.t('Send message').':</div><div class="contacts-form-outer">';
   $form['#suffix'] = $output.'</div>';
   $form['name']['#prefix'] = '';
   $form['mail']['#prefix'] = '';
   $form['subject']['#prefix'] = '';
   $form['message']['#prefix'] = '';
   
   $form_title = $form['name']['#title'];
   unset($form['name']['#title']);
   $form['name']['#default_value'] = $form_title;
   
   $form['name']['#attributes']['onblur'] = "if (this.value == '') {this.value = '{$form_title}';}";
   $form['name']['#attributes']['onfocus'] = "if (this.value == '{$form_title}') {this.value = '';}";
   
   $form_mail = $form['mail']['#title'];
   unset($form['mail']['#title']);
   $form['mail']['#default_value'] = $form_mail;
   
   $form['mail']['#attributes']['onblur'] = "if (this.value == '') {this.value = '{$form_mail}';}";
   $form['mail']['#attributes']['onfocus'] = "if (this.value == '{$form_mail}') {this.value = '';}";
   
   $form_subject = $form['subject']['#title'];
   unset($form['subject']['#title']);
   $form['subject']['#default_value'] = $form_subject;
   
   $form['subject']['#attributes']['onblur'] = "if (this.value == '') {this.value = '{$form_subject}';}";
   $form['subject']['#attributes']['onfocus'] = "if (this.value == '{$form_subject}') {this.value = '';}"; 
   
   $form_message = $form['message']['#title'];
   unset($form['message']['#title']);
   $form['message']['#default_value'] = $form_message;
   
   $form['message']['#attributes']['onblur'] = "if (this.value == '') {this.value = '{$form_message}';}";
   $form['message']['#attributes']['onfocus'] = "if (this.value == '{$form_message}') {this.value = '';}";    
 }
}

function gftheme_tapir_table_alter(&$table, $table_id) { 
  if ($table_id == 'uc_cart_view_table') { 
    foreach (element_children($table) as $key) {
      if (!empty($table[$key]['remove']['#value'])) $table[$key]['remove']['#value'] = '╳';
      if (!empty($table[$key]['qty']['#prefix'])) $table[$key]['qty']['#prefix'] = '<div class="quantity"><input type="button" value="&#9660;" class="minus small-input-button">';
      if (!empty($table[$key]['qty']['#suffix'])) $table[$key]['qty']['#suffix'] = '<input type="button" value="&#9650;" class="plus small-input-button"></div>';
    } 
  } 
} 

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

  $output .= '<div class="order-review-table">';

  foreach ($panes as $title => $data) {
    $output .= '<table><tr class="pane-title-row">';
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

  $output .= '</table>';
  $output .= '<div class="review-buttons">' . drupal_render($form) . '</div';
  $output .= '</div>';

  return $output;
}


// другие препроцесс функции
include 'node-preprocess.inc';
include 'preprocess_views_view_fields.inc';
