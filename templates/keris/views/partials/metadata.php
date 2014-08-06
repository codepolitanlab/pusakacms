<base href="<?php echo base_url() ?>" />
<meta charset="utf-8">
<title><?php echo $this->config->item('site_title'); ?></title>

<!-- Bootstrap core CSS -->
<link href="<?php echo get_theme_url() ?>/assets/css/bootstrap.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="<?php echo get_theme_url() ?>/assets/css/style.css" rel="stylesheet">

<script>
	var links = document.links;
	for (var i = 0, linksLength = links.length; i < linksLength; i++) {
		if (links[i].hostname != window.location.hostname) {
			links[i].target = '_blank';
		} 
	}
</script>