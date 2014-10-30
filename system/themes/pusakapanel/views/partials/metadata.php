<base href="<?php echo base_url() ?>" />
<meta charset="utf-8">
<title><?php echo $this->config->item('site_name'); ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo get_theme_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_theme_url() ?>assets/js/pagedown-bootstrap/css/jquery.pagedown-bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo get_theme_url() ?>assets/css/style.css" rel="stylesheet">

<script src="<?php echo get_theme_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/pagedown-bootstrap/js/jquery.pagedown-bootstrap.combined.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/jquery.slugify.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/script.js"></script>
<script>
	var base_url = "<?php echo site_url(); ?>";
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