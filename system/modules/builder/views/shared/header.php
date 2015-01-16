<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php if( isset($pageTitle) ){ echo $pageTitle; } else { echo $this->lang->line('alternative_page_title'); }?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Loading Bootstrap -->
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'bootstrap/css/bootstrap.css'); ?>">
	    
	<!--//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">-->
		
	<!-- Loading Flat UI -->
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'less/flat-ui.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/style.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/login.css'); ?>">
	
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/font-awesome.css'); ?>">
	
	<?php if( isset($builder) ):?>
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/builder.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/spectrum.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/chosen.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'js/redactor/redactor.css'); ?>">
	<?php endif;?>
	
	<link rel="shortcut icon" href="<?php echo get_module_image('builder', 'images/favicon.ico', false); ?>">
	
	<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
	<!--[if lt IE 9]>
	<?php echo get_module_js('builder', 'html5shiv.js'); ?>
	<?php echo get_module_js('builder', 'respond.min.js'); ?>
	<![endif]-->
	<!--[if lt IE 10]>
	<link rel="stylesheet" href="<?php echo get_module_asset('builder', 'css/ie-masonry.css'); ?>">
	<?php echo get_module_js('builder', 'masonry.pkgd.min.js'); ?>
	<![endif]-->
</head>