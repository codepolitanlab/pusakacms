$(function(){
	// expand page list
	$('.content-list .expand').click(function(){
		$parent = $(this).parent().parent().parent().parent('.list-desc');
		$child = $parent.siblings('.children');
		$child.slideToggle();

		return false;
	});

	// jquery slugify
	$('.slug').slugify('.title');

	// confirm delete
	$('.remove').click(function(){
		return confirm('Are you sure want to delete this item?');
	})

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
		var link_slug = $(e.relatedTarget).data('slug');
		var link_source = $(e.relatedTarget).data('source');
		var link_url = $(e.relatedTarget).data('url');
		var link_target = $(e.relatedTarget).data('linktarget');

		console.log(link_title + ' ' + link_slug);

		set_parent_dropdown(link_area);

		$('#link_area').val(link_area);
		$('#link_title').val(link_title);
		$('#link_slug').val(link_slug);
		$('#link_source').val(link_source);
		$('#link_url').val(link_url);
		$('#link_target').val(link_target);
		if(mode == 'edit'){
			$('#link-form').attr('action', base_url + 'panel/navigation/edit_link/' + link_area + '/' + link_slug);
			$('#btn-submit-link-form').html('Edit');
			$('#linkModalLabel').html('Edit Link');
		} else {
			$('#area-form').attr('action', base_url + 'panel/navigation/create_link');
			$('#btn-submit-area-form').html('Create');
			$('#linkModalLabel').html('Add New Link');				
		}
	})
});

setInterval(function(){
	$('.alert').slideUp();
}, 5000);

var set_parent_dropdown = function(area)
{
	$.get(BASE_URL + 'panel/navigation/get_nav_parent_option/' + area, function(data){
		$('#link_parent').html(data);
	});
}
