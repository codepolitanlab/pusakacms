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

	// nav modals
	$('#areaModal').on('show.bs.modal', function (e) {
  		var title = $(e.relatedTarget).data('title');
  		var slug = $(e.relatedTarget).data('slug');
  		var mode = $(e.relatedTarget).data('mode');
  		$('#area-title').val(title);
  		$('#area-slug').val(slug);
  		if(mode == 'edit')
  			$('#area-form').attr('action', base_url + 'panel/navigation/edit_area/'+slug);
	}) 
});