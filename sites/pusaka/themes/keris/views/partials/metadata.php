<meta charset="utf-8">
<title><?php echo site_config('page_title'); echo uri_string() ? '' : ' - '.site_config('site_slogan'); ?></title>

<meta name="description" content="<?php echo site_config('meta_description'); ?>" />
<meta name="keywords" content="<?php echo site_config('meta_keywords'); ?>" />
<meta name="robots" content="index,follow" />

<meta property="og:title" content="<?php echo site_config('page_title'); ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:image" content="<?php echo base_url('sites/default/content/files/cover.png'); ?>" />
<meta property="og:description" content="<?php echo site_config('meta_description'); ?>" />
<meta property="og:site_name" content="<?php echo site_config('page_title'); ?>" />

<!-- Bootstrap core CSS -->
<link href="<?php echo theme_url() ?>assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo theme_url() ?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo theme_url() ?>assets/css/style.css" rel="stylesheet">

<link rel="shortcut icon" href="<?php echo theme_url() ?>assets/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo theme_url() ?>assets/img/favicon.ico" type="image/x-icon">

<script src="<?php echo theme_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo theme_url() ?>assets/js/bootstrap.min.js"></script>
<script>
	var links = document.links;
	for (var i = 0, linksLength = links.length; i < linksLength; i++) {
		if (links[i].hostname != window.location.hostname) {
			links[i].target = '_blank';
		} 
	}
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51093490-2', 'auto');
  ga('send', 'pageview');

</script>