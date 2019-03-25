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
$nodeurl = url('node/' . $fields['nid']->content, array('query' => drupal_get_destination(current_path())));

$base_price = round(intval($fields['price']->content), 0);
?>


<div class="project-item-inner" id="<?php print "nid-" . $fields['nid']->content; ?>">
    <figure class="alignnone project-img">
      <span><?php print $fields['uc_product_image']->content; ?></span>
    </figure>

    <div class="project-desc">
	  <h4 class="title"><a href="#"><?php print $fields['title']->content; ?></a></h4>
    <div class="price">
        <div class="amount retail-amount">
          <span><?php print t('Retail price ') ?></span>
          <span class="price-value">
            <?php print '₽ ' . $base_price * 2; ?>
          </span>
        </div>
        <div class="amount wholesale-amount">
            <span><?php print t('You price ') ?></span>
            <span class="price-value">
              <?php print '₽ ' . $base_price; ?>
            </span>
        </div>        
    </div>
    </div>
</div>
