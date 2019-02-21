<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>  <!--<![endif]-->
<?php 
  // In case then we show maintenance page in demo view
  if(!isset($site_name)) {
    template_preprocess_page($variables);
    extract($variables);
  }
?>
<head>

  <?php print $head; ?>

  <title><?php print $head_title; ?></title>
  <meta name="description" content="Giorgio Ferretti - Кожаные мужские и женские сумки оптом от производителя">
  <meta name="author" content="http://themeforest.net/user/NikaDevs">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

  <?php print $styles; ?>

  <!-- Head Libs -->
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/modernizr.js"></script>

  <!--[if lt IE 9]>
    <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/vendor/rs-plugin/css/settings-ie8.css" media="screen">
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="<?php print base_path() . path_to_theme(); ?>/vendor/respond.min.js"></script>
  <![endif]-->

  <!--[if IE]>
    <link rel="stylesheet" href="<?php print base_path() . path_to_theme(); ?>/css/ie.css">
  <![endif]-->

  <!-- Favicons
  ================================================== -->
  <link rel="apple-touch-icon" href="<?php print path_to_theme(); ?>/images/apple-touch-icon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php print path_to_theme(); ?>/images/apple-touch-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php print path_to_theme(); ?>/images/apple-touch-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php print path_to_theme(); ?>/images/apple-touch-icon-144x144.png">

</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>

  <div class="site-wrapper">
    
    <!-- Header -->
    <header class="header header-coming-soon">

      <div class="header-main">
        <div class="container">
          <!-- Logo -->
          <div class="logo">
            <!-- <a href="index.html"><img src="images/logo.png" alt="Stability"></a> -->
            <h1><a href="<?php print $front_page; ?>"><?php print $site_name; ?></a></h1>
            <p class="tagline"><?php print $site_slogan; ?></p>
          </div>
          <!-- Logo / End --> 
        </div>
      </div>
      
    </header>
    <!-- Header / End -->

    <!-- Main -->
    <div class="main main__padd-top" role="main">

      <!-- Page Content -->
      <section class="nd-region">
        <div class="container">

          <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
              <h1><?php print t('Происходит обновление каталога...'); ?></h1>

              <?php if ($messages): ?>
                <div id="messages"><div class="section clearfix">
                  <?php print $messages; ?>
                </div></div> <!-- /.section, /#messages -->
              <?php endif; ?>

              <?php print isset($content) ? $conten : t('...'); ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8 col-md-offset-2">
              <hr class="lg">
            </div>
          </div>

        </div>
      </section>
      <!-- Page Content / End -->

      <!-- Footer -->
      <footer class="footer footer__light" id="footer">
        <div class="footer-copyright">
          <div class="container">
            <div class="row">
              <div class="col-sm-6 col-md-4">
                <?php print t('Copyright') . ' &copy; '. date('Y'); ?>  <a href="<?php print $front_page;?>">STABILITY</a> &nbsp;| &nbsp; <?php print t('All Rights Reserved'); ?>
              </div>
              <div class="col-sm-6 col-md-8">
               </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- Footer / End -->
      
    </div>
    <!-- Main / End -->
  </div>
<!-- Javascript Files
  ================================================== -->
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/jquery-1.11.0.min.js"></script>
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/jquery-migrate-1.2.1.min.js"></script>
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/countdown/jquery.knob.js"></script>
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/countdown/countdown.js"></script>
  <script src="<?php print base_path() . path_to_theme(); ?>/vendor/countdown/ext.js"></script>

</body>
</html>
