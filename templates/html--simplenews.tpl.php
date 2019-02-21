<!DOCTYPE html>
<!--[if IE 7]>                  <html class="ie7 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>     <![endif]-->
<!--[if lte IE 8]>              <html class="ie8 no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>     <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>  <!--<![endif]-->
<head>
  <title><?php print $head_title; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

  <?php if ($adaptive_enabled != '0'):?>
  <!-- Mobile Specific Metas
  ================================================== -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php endif; ?>

  <?php print $styles; ?>
</head>
<body class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php
//  print $page_top;
  print $page;
//  print $scripts;
//  print $page_bottom;
  ?>
</body>
</html>
 
