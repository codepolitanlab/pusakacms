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
	var group = $("ul.draggable").sortable({
		handle: '.dragpanel',
		afterMove: function (placeholder, container) {
			if(oldContainer != container){
				if(oldContainer)
					oldContainer.el.removeClass("active")
				container.el.addClass("active")

				oldContainer = container
			}
		},
		onDrop: function (item, container, _super) {
			var data = group.sortable("serialize").get();
			var jsonString = JSON.stringify(data);
			var area = group.attr('id');
			
			$.post(BASE_URL+'panel/navigation/sort/'+area, {newmap : jsonString})
			.done(function(data){
				console.log(data)
				container.el.removeClass("active")

				var clonedItem = $('<li/>').css({height: 0})
				item.before(clonedItem)
				clonedItem.animate({'height': item.height()})

				item.animate(clonedItem.position(), function  () {
					clonedItem.detach()
					_super(item)
				})
			});
		}
	})

});

setInterval(function(){
	$('.alert').slideUp();
}, 5000);