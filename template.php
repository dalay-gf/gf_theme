<?php
function gf_preprocess_page(&$vars) {
  $search_form = drupal_get_form('search_block_form');
  $vars['search'] = drupal_render($search_form);
}


function gf_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'search_block_form') {
    unset($form['actions']['submit']);
    $prompt = t('search this');
    $form['keys']['#default_value'] = $prompt;
    $form['actions']['submit']['#type'] = 'hidden';
    $form['keys']['#attributes'] = array('onblur' => "if (this.value == '') {this.value = '{$prompt}';}", 'onfocus' => "if (this.value == '{$prompt}') {this.value = '';}" );
  }
}