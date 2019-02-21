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

(node_last_viewed($row->nid) > 0) ? $node_is_viewed = TRUE : $node_is_viewed = FALSE;

//Определение ролей "Крупный опт" и "Публикатор"
if (user_has_role(12)) {$is_gross = true;} else {$is_gross = false;};
if (user_has_role(13)) {$is_publicator = true;} else {$is_publicator = false;};

?>

<div class="project-item-inner">

	<figure class="alignnone project-img">
	<?php $anchor_content = $fields['field_photo']->content; $anchor_path = 'node/' . $fields['nid']->raw; print l($anchor_content, $anchor_path, array('attributes' => array('class' => 'colorbox-node', 'data-inner-height' => '90%', 'data-inner-width' => '85%'), 'query' => drupal_get_destination(), 'html' => true));?>
	</figure>

	<div class="project-desc">
	<h4 class="title<?php if($node_is_viewed == FALSE) {print ' font-bold';};?>"><?php $anchor_content = $fields['title']->content; $anchor_path = 'node/' . $fields['nid']->raw; print l($anchor_content, $anchor_path, array('attributes' => array('class' => 'colorbox-node', 'data-inner-height' => '90%', 'data-inner-width' => '85%'), 'query' => drupal_get_destination(), 'html' => true));?></h4>
		<span class="price">
		<span class="ammount"><?php print t('Comments: ') . $fields['comment_count']->content; ?></span>
		</span>
		<?php if ($is_gross == false && $is_publicator == false) : ?>
		<span class="rating"><?php print $fields['field_votes']->content; ?></span>
		<?php endif; ?>
	</div>

</div>
