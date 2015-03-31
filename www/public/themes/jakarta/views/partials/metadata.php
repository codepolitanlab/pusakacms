<meta charset="utf-8">
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

<link rel="shortcut icon" href="<?php echo theme_url() ?>assets/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo theme_url() ?>assets/img/favicon.ico" type="image/x-icon">

<!-- Bootstrap core CSS -->
<link href="<?php echo vendor_url('bootstrap', '3.2.0/css/bootstrap.min.css') ?>" rel="stylesheet">
<link href="<?php echo vendor_url('font-awesome', 'css/font-awesome.min.css') ?>" rel="stylesheet">
<link href="<?php echo vendor_url('selaksa', 'selaksa.css') ?>" rel="stylesheet">

<!-- Custom styles for this template -->
<?php echo get_theme_css('main_style.css'); ?>

<?php
switch ($this->config->item("theme_option")) {
	case "blue":
	$theme_option = 'color-blue.css';
	break;

	case "green":
	$theme_option = 'color-green.css';
	break;

	case "orange":
	$theme_option = 'color-orange.css';
	break;

	case "red":
	$theme_option = 'color-red.css';
	break;

	default:
	$theme_option = 'color-blue.css';
} 

// echo custom color css
echo get_theme_css($theme_option);
?>