<base href="<?php echo base_url() ?>" />
<meta charset="utf-8">
<title><?php echo $this->config->item('site_name'); ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo get_theme_url() ?>/assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo get_theme_url() ?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>/assets/css/style.css" rel="stylesheet">

<link rel="shortcut icon" href="<?php echo get_theme_url() ?>/assets/img/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo get_theme_url() ?>/assets/img/favicon.ico" type="image/x-icon">

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