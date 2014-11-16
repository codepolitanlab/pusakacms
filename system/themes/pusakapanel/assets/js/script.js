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

	// navigation sortable
	var oldContainer
	$("ul.draggable").sortable({
		group: 'nested',
		afterMove: function (placeholder, container) {
			if(oldContainer != container){
				if(oldContainer)
					oldContainer.el.removeClass("active")
				container.el.addClass("active")

				oldContainer = container
			}
		},
		onDrop: function (item, container, _super) {
			container.el.removeClass("active")
			_super(item)
		}
	})

});

setInterval(function(){
	$('.alert').slideUp();
}, 5000);