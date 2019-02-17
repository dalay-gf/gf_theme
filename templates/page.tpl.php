<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template in this directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see html.tpl.php
 *
 * @ingroup themeable
 */
?>

<div id="page">
  <header class="header">
    <div class="container">
      <?php print render($page['header']); ?>
    </div>
  </header> <!-- /.header -->
  
  <nav class="logo-navigation">
    <div class="container flex">
      <button class="mobile-menu">            
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar last"></span>
        <span class="close-btn"></span>
      </button>
      <div class="mobile-cart">
        <?php print $cart_items_count; ?>
      </div>      
      <?php if ($logo): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
          <?php if(drupal_get_path_alias() == 'shop'): ?><img class="opt" src="<?php print base_path().path_to_theme().'/images/logo-opt.svg'; ?>" alt="<?php print t('Home Wholesale'); ?>" />   <?php else: ?> <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
          <?php endif; ?>
        </a>
      <?php endif; ?>
      
      <div class="mobile-language">
        <div class="icon_globe-2 change-language"></div>
        <?php $block = module_invoke('locale', 'block_view', 'language'); print render($block['content']); ?>
      </div>
      
      <div class="mobile-search-icon"><div data-icon="&#x55;"></div></div>
      
      <?php if ($main_menu): ?>
        <div id="navigation">
          <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('links')))); ?>
          <?php
            global $user;
            global $variables;
            (user_is_anonymous()) ? $logged_in = FALSE : $logged_in = TRUE;
          ?>
          <ul id="sub-main-menu">
            <?php if ($logged_in):?>
              <li><?php print l(t('Settings'),'user');?></li>
              <li><?php print l(t('Log out'),'logout');?></li>
              <?php else :?>      
                 <li><?php print l(t('Log In'),'user');?></li>
                 <li><?php print l(t('Register'),'user/register');?></li>
            <?php endif;?>
          </ul>
        </div> <!-- /#navigation -->
      <?php endif; ?>  
      
    </div>
    <div class="container">
      <?php if ($page['navigation']): ?><?php print render($page['navigation']); ?><?php endif; ?> 
    </div>  
  </nav>
  
  <?php if ($page['highlighted']): ?>
    <section class="highlighted container-fluid">
      <?php print render($page['highlighted']); ?>
    </section>
  <?php endif; ?>
  
  <?php if ($page['directions']): ?>
    <section class="directions">
      <div class="container">
        <?php print render($page['directions']); ?>
      </div>
    </section>        
  <?php endif; ?>

  
  <section id="about-company" class="about-company content container">
    <?php print $messages; ?> 
    <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif; ?>
    <?php print render($page['help']); ?>
    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
    <a id="main-content"></a>
    <?php print render($title_prefix); ?>
    <?php print render($title_suffix); ?>
   
    <?php print render($page['content']); ?>  
  </section>
  
  <?php if ($page['brands']): ?>
    <section id="brands" class="brands">
      <div class="container">  
        <?php print render($page['brands']); ?>
      </div>
    </section>
  <?php endif; ?>

  <?php if ($page['assortment']): ?>
    <section id="assortment" class="assortment">
      <div class="container">  
        <?php print render($page['assortment']); ?>
      </div>
    </section>       
  <?php endif; ?>
  
  <?php if ($page['lookbook']): ?>
    <section id="lookbook" class="lookbook">
      <div class="container-fluid"> 
        <?php print render($page['lookbook']); ?>
      </div>
    </section>    
  <?php endif; ?>
  
  <?php if ($page['prefooter']): ?>
    <section id="prefooter" class="prefooter">
      <div class="container">
        <?php print render($page['prefooter']); ?>
      </div>
    </section> <!-- /#footer -->
  <?php endif; ?> 
  
  <?php if ($page['footer']): ?>
    <footer id="footer">
      <div class="container">
        <?php print render($page['footer']); ?>
      </div>
    </footer> <!-- /#footer -->
  <?php endif; ?>
  
</div> <!-- /#page -->
