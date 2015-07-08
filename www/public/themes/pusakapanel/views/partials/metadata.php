<base href="<?php echo base_url() ?>" />
<meta charset="utf-8">
<title><?php echo $this->config->item('site_name'); ?></title>


<link rel="shortcut icon" href="<?php echo theme_url("assets/img/favicon.ico") ?>" type="image/x-icon">
<link rel="icon" href="<?php echo theme_url("assets/img/favicon.ico") ?>" type="image/x-icon">

<!-- Bootstrap core CSS -->
<link href="<?php echo vendor_url("bootstrap", "3.2.0/css/bootstrap.min.css") ?>" rel="stylesheet">

<!-- Loading Flat UI -->
<link rel="stylesheet" href="<?php echo theme_url('assets/less/flat-ui.css'); ?>">

<link href="<?php echo vendor_url("font-awesome", "css/font-awesome.min.css") ?>" rel="stylesheet">

<?php if( isset($builder) ):?>
	<link rel="stylesheet" href="<?php echo vendor_url('builder', 'css/builder.css'); ?>">
	<link rel="stylesheet" href="<?php echo vendor_url('builder', 'css/spectrum.css'); ?>">
	<link rel="stylesheet" href="<?php echo vendor_url('builder', 'css/chosen.css'); ?>">
	<link rel="stylesheet" href="<?php echo vendor_url('builder', 'js/redactor/redactor.css'); ?>">
<?php endif;?>

<!-- Custom styles for this template -->
<link href="<?php echo theme_url("assets/css/style.css") ?>" rel="stylesheet">
<link href="<?php echo vendor_url('codemirror', 'lib/codemirror.css'); ?>" rel="stylesheet">
<link href="<?php echo vendor_url('codemirror', 'theme/mbo.css'); ?>" rel="stylesheet">
<link href="<?php echo vendor_url("jquery-ui", "smoothness/jquery-ui-1.10.1.custom.min.css") ?>" rel="stylesheet">

<!-- JavaScript -->
<!-- codemirror assets -->
<script src="<?php echo vendor_url('codemirror', 'lib/codemirror.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'addon/edit/closetag.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'addon/fold/xml-fold.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'addon/selection/active-line.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'mode/javascript/javascript.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'mode/xml/xml.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'mode/css/css.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'mode/htmlmixed/htmlmixed.js'); ?>"></script>
<script src="<?php echo vendor_url('codemirror', 'mode/markdown/markdown.js'); ?>"></script>

<script src="<?php echo vendor_url("jquery", "jquery-1.7.2.min.js") ?>"></script>
<script src="<?php echo vendor_url("jquery-ui", "jquery-ui-1.10.1.custom.min.js") ?>"></script>
<script src="<?php echo theme_url("assets/js/jquery.history.js") ?>"></script>

<script>
	var base_url = "<?php echo site_url(); ?>";
	var siteSlug = "<?php echo SITE_SLUG; ?>";

	// IMPORTANT
	// for handle closing rfm modal bootstrap
	window.closeBootstrapModal = function(){
    	$('.modal').modal('hide');
	};
</script>