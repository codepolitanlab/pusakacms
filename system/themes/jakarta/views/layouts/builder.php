<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!--pageMeta-->

    <!-- Loading Bootstrap -->
    <link href="<?php echo get_theme_url('assets/vendor/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Loading Flat UI -->
    <?php echo get_theme_css('flat-ui.css'); ?>
    <?php echo get_theme_css('style.css'); ?>
    <?php echo get_theme_css('style-contact.css'); ?>
    <?php echo get_theme_css('style-content.css'); ?>
    <?php echo get_theme_css('style-footers.css'); ?>
    <?php echo get_theme_css('style-headers.css'); ?>
    <?php echo get_theme_css('style-portfolios.css'); ?>
    <?php echo get_theme_css('style-pricing.css'); ?>
    <?php echo get_theme_css('style-team.css'); ?>
    <?php echo get_theme_css('style-dividers.css'); ?>

    <!-- Font Awesome -->
    <?php echo get_theme_css('font-awesome.css'); ?>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <?php echo get_theme_js('html5shiv.js'); ?>
      <?php echo get_theme_js('respond.min.js'); ?>
    <![endif]-->
    
    <!--headerIncludes-->
    
</head>
<body>
    
    <div id="page" class="page">
        
    </div><!-- /#page -->


    <!-- Load JS here for greater good =============================-->
    <?php echo get_theme_js('jquery-1.8.3.min.js'); ?>
    <?php echo get_theme_js('jquery-ui-1.10.3.custom.min.js'); ?>
    <?php echo get_theme_js('jquery.ui.touch-punch.min.js'); ?>
    <?php echo get_theme_js('bootstrap.min.js'); ?>
    <?php echo get_theme_js('bootstrap-select.js'); ?>
    <?php echo get_theme_js('bootstrap-switch.js'); ?>
    <?php echo get_theme_js('flatui-checkbox.js'); ?>
    <?php echo get_theme_js('flatui-radio.js'); ?>
    <?php echo get_theme_js('jquery.tagsinput.js'); ?>
    <?php echo get_theme_js('jquery.placeholder.js'); ?>
    <?php echo get_theme_js('application.js'); ?>
	<?php echo get_theme_js('over.js'); ?>
</body>
</html>