<?php
/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
<?php
//Переключатель валют
$default_currency_code = variable_get('uc_currency_code', UC_CURRENCY_DEFAULT_CURRENCY);
$code = isset($_SESSION['currency_switcher']) ? $_SESSION['currency_switcher'] : $default_currency_code;
$symbol = currency_api_get_symbol($code);
$price_value = intval(str_replace($symbol, '', strip_tags($fields['display_price']->content)));
$ruble_sign = '<i class="fa fa-rub" aria-hidden="true"></i>';

if ($price_value > 0) {
  $display_price_base = str_replace('руб.', $ruble_sign, strip_tags($fields['display_price']->content));
  $symbol = str_replace('руб.', $ruble_sign, $symbol);
  $retail_price = $symbol . $price_value * 3;
  $order_price = $symbol . $price_value * 0.9;
} else {
  $retail_price = '';
  $order_price = '';
  $display_price_base = '';
}

//Подгрузка переменных из header/header-1.tpl.php
global $seller_limited_access;

//Определение роли "Крупный опт"
if (user_has_role(12)) {$is_gross = true;} else {$is_gross = false;};

//Путь ссылок на товары
$anchor_path = 'model/' . $fields['field_main_sku']->content . '/' . $fields['nid']->content;

(node_last_viewed($row->nid) > 0) ? $node_is_viewed = TRUE : $node_is_viewed = FALSE;

//Голосование
$vote_enabled = FALSE;
?>


<div class="project-item-inner" id="<?php print "nid-" . $fields['nid']->content; ?>">
  <?php /*($fields['view_1']->content <> '  ') ? $subtotal = $fields['view_1']->content : $subtotal = '0';*/
  if ($fields['model_qty_stats']->content > 0) {$subtotal = $fields['model_qty_stats']->content;} else {$subtotal = '0';};
  ?>
  <?php $in_orders = '<span class="in-orders">' . '<span>'. t('In Orders') . '</span><br>' . $subtotal . '</span>'; print l($in_orders, $anchor_path, array('query' => array('tab' => 'order'), 'html' => true)); ?>
  <figure class="alignnone project-img">
    <?php
    $anchor_text = $fields['uc_product_image']->content;
    print l($anchor_text, $anchor_path, array('html' => TRUE, 'query' => array('tab' => 'order')));
    ?>
  </figure>

  <div class="project-desc">
    <h4 class="title<?php if($node_is_viewed == FALSE) {print ' font-bold';};?>"><?php print l(strval($fields['model']->raw), $anchor_path, array('query' => array('tab' => 'order')));?></h4>
    <?php if($logged_in <> true or $seller_limited_access == true): ?>
    <div class="price row">
      <span class="amount col-md-12 col-sm-12 col-xs-12"><?php print l(t('Show price'), 'user/register', array('attributes' => array('class' => array('btn', 'btn-sm', 'btn-primary'), 'data-inner-height'=>array('90%'), 'data-inner-width'=>array("40%")), 'query' => array('src-page' => 'show-price')));?></span>
      <?php elseif ($logged_in == true and $seller_limited_access <> true): ?>
      <div class="price">
        <div class="row prices">
          <?php if ($is_gross == false) : ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <span class="retail-amount"><?php print $retail_price; ?></span>
            </div>
          <?php endif; ?>
          <div class="col-md-12 col-sm-12 col-xs-12">
            <span class="amount"><?php print $order_price; ?></span>
          </div>
          <?php if ($vote_enabled and $is_gross == false) : ?>
            <div class="spacer xl"></div>
            <div class="col-md-12 col-sm-12 col-xs-6">
              <span class="rating"><?php print $fields['field_votes']->content; ?></span>
            </div>
          <?php endif; ?>
        </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
