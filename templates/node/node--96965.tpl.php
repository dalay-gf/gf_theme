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
        $women_bags_nids = implode('+', [99375, 99380, 99382, 99385]);
        print views_embed_view('products', 'block_landing_by_nodes', $women_bags_nids);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $man_bags_nids = implode('+', [99303, 99305, 99301, 99347]);
        print views_embed_view('products', 'block_landing_by_nodes', $man_bags_nids);
      ?>  
    </div>    
    <div class="tabs__content product-from-category">
      <?php
        $briefcases_nids = implode('+', [89322, 96443, 96442, 89108]);
        print views_embed_view('products', 'block_landing_by_nodes', $briefcases_nids);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $wallets_nids = implode('+', [87210, 87213, 87273,87269]);
        print views_embed_view('products', 'block_landing_by_nodes', $wallets_nids);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $gloves_nids= implode('+', [88006, 88023, 88835, 88854]);
        print views_embed_view('products', 'block_landing_by_nodes', $gloves_nids);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        $belts_nids = implode('+', [88343, 88360, 88439, 88592]);
        print views_embed_view('products', 'block_landing_by_nodes', $belts_nids);
      ?>  
    </div>
    <div class="tabs__content product-from-category">
      <?php
        // $accessories_cat = implode('+', array(3365));
        $scarfs_nids = implode('+', [99164, 99192, 99233, 99247]);
        print views_embed_view('products', 'block_landing_by_nodes', $scarfs_nids);
      ?>  
    </div>  
  </div>
</div>
 </article> <!-- /.node -->

