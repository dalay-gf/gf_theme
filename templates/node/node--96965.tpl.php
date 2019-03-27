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
 * - $display_submitted: whether submissionformation should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result "node-blog". Note that the machine
 *     name will often be a short form of the human readable label.
 *   - node-teaser: Nodes teaser form.
 *   - node-preview: Nodes preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules,tended to be displayed front of the main title tag that
 *   appears the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules,tended to be displayed after the main title tag that appears
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *  to a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping
 *   teaser listings.
 * - $id: Position of the node.crements each time it's output.
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
 * - $is_front: Flags true when presented the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each fieldstance attached to the node a corresponding
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
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
<?php
  hide($content['comments']);
  hide($content['links']);
  hide($content['body']);
  hide($content['field_1_1']);
  hide($content['field_1_2']);
  hide($content['field_1_3']);
?>
<div class="invite-banner-text">
  <div class="logo-linger"><img src="<?php print base_path().path_to_theme().'/images/linger.svg';?>"></div>
  <div class="logo-feretti"><img src="<?php print base_path().path_to_theme().'/images/firetti.svg';?>"></div>
  <?php print render($content['field_1_1']); ?>
  <?php print render($content['field_1_2']);?>
  <?php
    $form_call_request = module_invoke('webform', 'block_view','client-block-96967');
    print render($form_call_request['content']);
  ?>  
</div>
<div class="container">
  <?php print render($content['body']); ?>
</div>
<div class="container">
  <div class="tabs product-categories">
    <ul class="tabs__caption">
      <li class="active"><?php print 'Женские Сумки'; ?></li>
      <li><?php print 'Мужские Сумки'; ?></li>
      <li><?php print 'Портфели'; ?></li>
      <li><?php print 'Кошельки'; ?></li>
      <li><?php print 'Перчатки'; ?></li>
      <li><?php print 'Ремни'; ?></li>
      <li><?php print 'Платки'; ?></li>    
    </ul>
    <div class="tabs__content product-from-category active">
      <?php
        $bags_cat = implode('+', array(2764, 2756, 3579, 2749));
        print views_embed_view('products', 'block_landing', $bags_cat);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $bags_cat = implode('+', array(2764, 2756, 3579, 2749));
        print views_embed_view('products', 'block_landing', $bags_cat);
      ?>  
    </div>    
    <div class="tabs__content product-from-category">
      <?php
        $briefcases_cat = implode('+', array(2748));
        print views_embed_view('products', 'block_landing', $briefcases_cat);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $wallets_cat = implode('+', array(2769, 2771, 2770, 2752, 2988));
        print views_embed_view('products', 'block_landing', $wallets_cat);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $gloves_cat = implode('+', array(2755, 2943, 2767));
        print views_embed_view('products', 'block_landing', $gloves_cat);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $belts_cat = implode('+', array(2795, 2803));
        print views_embed_view('products', 'block_landing', $belts_cat);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $accessories_cat = implode('+', array(3365));
        print views_embed_view('products', 'block_landing', $accessories_cat);
      ?>  
    </div>  
  </div>
</div>
 </article> <!-- /.node -->

