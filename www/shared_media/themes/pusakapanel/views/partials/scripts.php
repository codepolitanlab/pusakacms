<script src="<?php echo get_theme_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/pagedown-bootstrap/js/jquery.pagedown-bootstrap.combined.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/jquery.slugify.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/jquery.nestable.js"></script>
<?php echo get_theme_js('flatui-checkbox.js');?>
<?php echo get_theme_js('flatui-radio.js');?>
<script src="<?php echo get_theme_url() ?>assets/js/script.js"></script>

<script>
	var base_url = "<?php echo site_url(); ?>";
	var links = document.links;
	for (var i = 0, linksLength = links.length; i < linksLength; i++) {
		if (links[i].hostname != window.location.hostname) {
			links[i].target = '_blank';
		} 
	}

	var editor = CodeMirror.fromTextArea(document.getElementById("pagedownMe"), {
		mode: 'markdown',
		autoCloseTags: true,
		lineNumbers: true,
		lineWrapping: true,
		styleActiveLine: true,
		theme: "neo"
	});
</script>

<!-- scripts for builder -->
<?php 
if(isset($builder)){
	get_partial("scripts_builder");
}; 
?>