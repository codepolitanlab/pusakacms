<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 

<title><?php echo site_config('page_title'); echo uri_string() ? '' : ' - '.site_config('site_slogan'); ?></title>

<meta name="description" content="<?php echo site_config('meta_description'); ?>" />
<meta name="keywords" content="<?php echo site_config('meta_keywords'); ?>" />
<meta name="robots" content="index,follow" />

<meta property="og:title" content="<?php echo site_config('page_title'); ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:image" content="<?php echo base_url('themes/nyanpublish/assets/img/nyanlogo_publish.png'); ?>" />
<meta property="og:description" content="<?php echo site_config('meta_description'); ?>" />
<meta property="og:site_name" content="<?php echo site_config('page_title'); ?>" />

<link rel="shortcut icon" href="<?php echo get_theme_url() ?>assets/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_theme_url() ?>assets/img/favicon.ico" type="image/x-icon">

<!-- Bootstrap core CSS -->
<link href="<?php echo get_theme_url() ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>assets/vendor/awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>assets/vendor/selaksa/selaksa.css" rel="stylesheet">

<link href="<?php echo get_theme_url() ?>assets/css/default.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>assets/css/component.css" rel="stylesheet">

<script src="<?php echo get_theme_url() ?>assets/js/modernizr.custom.js"></script>
