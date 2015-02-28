<base href="<?php echo base_url() ?>" />
<meta charset="utf-8">
<title><?php echo $this->config->item('site_name'); ?></title>


<link rel="shortcut icon" href="<?php echo get_theme_url("assets/img/favicon.ico") ?>" type="image/x-icon">
<link rel="icon" href="<?php echo get_theme_url("assets/img/favicon.ico") ?>" type="image/x-icon">

<!-- Bootstrap core CSS -->
<link href="<?php echo get_theme_url("assets/vendor/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">

<!-- Loading Flat UI -->
<link rel="stylesheet" href="<?php echo get_theme_url('assets/less/flat-ui.css'); ?>">

<link href="<?php echo get_theme_url("assets/vendor/font-awesome/css/font-awesome.min.css") ?>" rel="stylesheet">

<?php if( isset($builder) ):?>
	<link rel="stylesheet" href="<?php echo get_theme_url('assets/css/builder.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_url('assets/css/spectrum.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_url('assets/css/chosen.css'); ?>">
	<link rel="stylesheet" href="<?php echo get_theme_url('assets/js/redactor/redactor.css'); ?>">
<?php endif;?>

<!-- Custom styles for this template -->
<link href="<?php echo get_theme_url("assets/css/style.css") ?>" rel="stylesheet">
<link href="<?php echo get_theme_url('assets/vendor/codemirror/lib/codemirror.css'); ?>" rel="stylesheet">
<link href="<?php echo get_theme_url('assets/vendor/codemirror/theme/mbo.css'); ?>" rel="stylesheet">

<!-- JavaScript -->
<!-- codemirror assets -->
<script src="<?php echo get_theme_url('assets/vendor/codemirror/lib/codemirror.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/addon/edit/closetag.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/addon/fold/xml-fold.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/addon/selection/active-line.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/mode/javascript/javascript.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/mode/xml/xml.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/mode/css/css.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js'); ?>"></script>
<script src="<?php echo get_theme_url('assets/vendor/codemirror/mode/markdown/markdown.js'); ?>"></script>

<script src="<?php echo get_theme_url("assets/js/jquery-1.7.2.min.js") ?>"></script>

<script>
	// IMPORTANT
	// for handle closing rfm modal bootstrap
	window.closeBootstrapModal = function(){
    	$('.modal').modal('hide');
	};
</script>