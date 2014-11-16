<script src="<?php echo get_theme_url() ?>assets/js/jquery.min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/pagedown-bootstrap/js/jquery.pagedown-bootstrap.combined.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/jquery.slugify.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/jquery-sortable-min.js"></script>
<script src="<?php echo get_theme_url() ?>assets/js/script.js"></script>
<script>
	var base_url = "<?php echo site_url(); ?>";
	var links = document.links;
	for (var i = 0, linksLength = links.length; i < linksLength; i++) {
		if (links[i].hostname != window.location.hostname) {
			links[i].target = '_blank';
		} 
	}

	var set_parent_dropdown = function(area)
	{
		$.get("<?php echo site_url('panel/get_nav_parent_option'); ?>/" + area, function(data){
			$('#link_parent').html(data);
		});
	}

	$(function(){
		// nav area modals
		$('#areaModal').on('show.bs.modal', function (e) {
			var title = $(e.relatedTarget).data('title');
			var slug = $(e.relatedTarget).data('slug');
			var mode = $(e.relatedTarget).data('mode');
			$('#area-title').val(title);
			$('#area-slug').val(slug);
			if(mode == 'edit'){
				$('#area-form').attr('action', base_url + 'panel/navigation/edit_area/'+slug);
				$('#btn-submit-area-form').html('Edit');
				$('#areaModalLabel').html('Edit Navigation Area');
			} else {
				$('#area-form').attr('action', base_url + 'panel/navigation/create_area');
				$('#btn-submit-area-form').html('Create');
				$('#areaModalLabel').html('New Navigation Area');				
			}
		});

		// nav link modals
		$('#linkModal').on('show.bs.modal', function (e) {
			var mode = $(e.relatedTarget).data('mode');
			var link_area = $(e.relatedTarget).data('area');
			var link_title = $(e.relatedTarget).data('title');
			var link_source = $(e.relatedTarget).data('source');
			var link_url = $(e.relatedTarget).data('url');
			var link_target = $(e.relatedTarget).data('linktarget');

			set_parent_dropdown(link_area);

			$('#link_area').val(link_area);
			$('#link_title').val(link_title);
			$('#link_source').val(link_source);
			$('#link_url').val(link_url);
			$('#link_target').val(link_target);
			if(mode == 'edit'){
				$('#link-form').attr('action', base_url + 'panel/navigation/edit_link/' + link_area + '/' + link_title);
				$('#btn-submit-link-form').html('Edit');
				$('#linkModalLabel').html('Edit Link');
			} else {
				$('#area-form').attr('action', base_url + 'panel/navigation/create_link');
				$('#btn-submit-area-form').html('Create');
				$('#linkModalLabel').html('Add New Link');				
			}
		})
	})
</script>