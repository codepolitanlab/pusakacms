<div class="row heading">
	<div class="col-md-6">
		<h1>PAGES</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/sync"><span class="fa fa-refresh fa-fw"></span> Sync pages</a>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/create"><span class="fa fa-plus-circle fa-fw"></span> Create new page</a>
			<?php if (module_exist('builder')): ?>
				<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/builder/build"><span class="fa fa-plus-circle fa-gears"></span> Create page with Builder</a>
			<?php endif ?>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="dd" id="root">
			<ol class="dd-list">
				<?php echo $pages; ?>
			</ol>
		</div>
	</div>
</div>

<script>
	$(function(){

		$('.dd').nestable({
			getRootCallback:false
		}).on('change', '.dd-item', function(e) {
			e.stopPropagation();
			var elm = $(this),
			source = elm.data('url'),
			dest = $(this).parents('.dd-item').data('url');
			console.log(elm);

			$.post(base_url+'panel/pages/move_page/', {source : source, dest : dest})
			.done(function(data){
				console.log(data);
				var res = JSON.parse(data);
				change_attributes(elm, res);

				$('.alert-'+res.status).fadeIn().children('span').html(res.message);

				// we don't need to send new sorted structure anymore as it already done by syncing
				var newmap = JSON.stringify($('.dd').nestable('serialize'));
				$.post(base_url+'panel/pages/sort/', {newmap : newmap})
				.done(function(sorted){
					// console.log(sorted);
					// var ed = JSON.parse(sorted);

					// $('.alert-'+ed.status).fadeIn().children('span').html(ed.message);
				});
			});
		});

		// change important attribute of moved element
		var change_attributes = function(e, d){
			if(d.dest){
				e.data('url', d.dest+'/'+d.page);
				
				e.children('.dd3-content').children('small').children('.page-url')
				.attr('href', base_url+d.dest+'/'+d.page).html(d.dest+'/'+d.page);

				var opts = e.children('.dd3-content').children('div').children('.option');
				opts.children('.build').attr('href', base_url+'panel/builder/build/'+d.dest+'/'+d.page);
				opts.children('.edit').attr('href', base_url+'panel/pages/edit/'+d.dest+'/'+d.page);
				opts.children('.add').attr('href', base_url+'panel/pages/create/'+d.dest+'/'+d.page);
				opts.children('.remove').attr('href', base_url+'panel/pages/delete/'+d.dest+'/'+d.page);
			} else {
				e.data('url', d.page);
				e.children('.dd3-content').children('small').children('.page-url')   
				.attr('href', base_url+d.page).html(d.page);

				var opts = e.children('.dd3-content').children('div').children('.option');
				opts.children('.build').attr('href', base_url+'panel/builder/build/'+d.page);
				opts.children('.edit').attr('href', base_url+'panel/pages/edit/'+d.page);
				opts.children('.add').attr('href', base_url+'panel/pages/create/'+d.page);
				opts.children('.remove').attr('href', base_url+'panel/pages/delete/'+d.page);
			}

			// if element has children, do the same thing
			if(e.children('.dd-list').length > 0){
				$.each(e.children('.dd-list').children('.dd-item'), function(key, value){
					var p = $(value).data('url').split("/");

					var dd = {page:p[p.length-1], dest:e.data('url')};
					change_attributes($(value), dd);
				});
			}
		}
	});
</script>