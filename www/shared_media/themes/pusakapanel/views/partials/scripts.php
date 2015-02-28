<script src="<?php echo get_theme_url() ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<?php echo get_theme_js('jquery.slugify.js');?>
<?php echo get_theme_js('jquery.nestable.js');?>
<?php echo get_theme_js('flatui-checkbox.js');?>
<?php echo get_theme_js('flatui-radio.js');?>
<?php echo get_theme_js('script.js');?>

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