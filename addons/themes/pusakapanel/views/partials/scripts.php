<script src="<?php echo vendor_url('bootstrap', '3.2.0/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo theme_url() ?>assets/js/jquery.slugify.js"></script>
<script src="<?php echo theme_url() ?>assets/js/jquery.nestable.js"></script>
<script src="<?php echo theme_url() ?>assets/js/flatui-checkbox.js"></script>
<script src="<?php echo theme_url() ?>assets/js/flatui-radio.js"></script>
<script src="<?php echo vendor_url('ckeditor', 'ckeditor.js') ?>"></script>
<script src="<?php echo theme_url() ?>assets/js/script.js"></script>

<!-- sometimes we need script that use content from php -->
<script>
	var links = document.links;
	for (var i = 0, linksLength = links.length; i < linksLength; i++) {
		if (links[i].hostname != window.location.hostname) {
			links[i].target = '_blank';
		} 
	}
</script>

<!-- scripts for builder -->
<?php 
if(isset($builder)){
	get_partial("scripts_builder");
}; 
?>