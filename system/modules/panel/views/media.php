<div class="row heading">
	<div class="col-md-6">
		<h1>MEDIA</h1>
	</div>
</div>
<br>

<script type="text/javascript" charset="utf-8">
	jQuery(document).ready(function(){
		jQuery('#elfinder').elfinder({
			url: '<?php echo site_url('panel/media/elfinder_init'); ?>',
		}).elfinder('instance');
	});
</script>

<!-- Element where elFinder will be created (REQUIRED) -->
<div id="elfinder"></div>