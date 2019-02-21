<?php
/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<?php

global $is_voted;

//Определение ролей "Крупный опт" и "Публикатор"
if (user_has_role(12)) {$is_gross = true;} else {$is_gross = false;};
if (user_has_role(13)) {$is_publicator = true;} else {$is_publicator = false;};

?>
<div class="spacer"></div>
<div id="node-<?php print $node->nid; ?>" class="row <?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="col-md-6">
    <!-- Project Slider -->
    <div class="owl-carousel owl-theme owl-slider thumbnail">
    <?php foreach(element_children($content['field_photo']) as $key): ?>
      <div class="item">
        <?php print render($content['field_photo'][$key]); ?>
      </div>
    <?php endforeach; ?>
    </div>
    <!-- Project Slider / End -->
  </div>
  <div class="col-md-6">
    <h2 class="product_title"><?php print $title; ?></h2>
    <div class="spacer"></div>
    <div class="pub-body"><?php print render($content['body']); ?></div>
    <?php if ($is_gross == false && $is_publicator == false) : ?>
    <?php print render($content['field_votes']); ?>
    <hr>
    <?php endif; ?>
    <div class="pub-info"><?php print t('Posted at: ') . date("Y-m-d H:i", $created); ?> <br>
    <?php if($is_voted) {$usr=user_load($uid); $username=$usr->name; print t('Posted by') . ': ' . $username; };?></div>
    <hr>
    <div class="voting"><?php print render($content['field_rating']); ?></div>
    <?php if(user_has_role(11) or user_has_role(3)) : ?>
    <div class="delete-button"><?php print l(t('Delete'), 'node/' . $node->nid . '/delete', array('html' => true, 'attributes' => array('class' => array('btn', 'btn-warning')), 'query' => drupal_get_destination()));?></div>
    <?php endif; ?>
    <div class="spacer"></div>
    <div class="col-md-12">
      <div class="spacer"></div>
      <div><?php print render($content['comments']); ?></div>
    </div>
    <div class="spacer"></div>
  </div>
  <div class="col-md-12">
	<h3><?php print t('Order Sample');?></h3>
	<?php
	$order_block = block_load('webform', 'client-block-53470');
	$renderable_order_block= _block_get_renderable_array(_block_render_blocks(array($order_block)));
	$output = drupal_render($renderable_order_block);
	print $output;
	/*print render(node_view(node_load(53470), 'full', NULL));*/
	?>
  </div>
<div class="spacer xl"></div>
<hr class="lg">