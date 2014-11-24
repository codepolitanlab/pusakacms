<div class="row heading">
	<div class="col-md-6">
		<h1>PAGES</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/sync"><span class="fa fa-refresh"></span> Sync pages</a>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/create"><span class="fa fa-plus-circle"></span> Create new page</a>
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

            $.post(BASE_URL+'panel/pages/sort/', {source : source, dest : dest})
            .done(function(data){
                console.log(data);
                var res = JSON.parse(data);
                change_attributes(elm, res);

                $('.alert-'+res.status).fadeIn().children('span').html(res.message);
            });
        });

        // change important attribute of moved element
        var change_attributes = function(e, d){
            e.data('url', d.dest+'/'+d.page);
            if(d.dest)
                e.children('.dd3-content').children('small').children('.page-url')
                .attr('href', BASE_URL+d.dest+'/'+d.page).html(d.dest+'/'+d.page);
            else
                e.children('.dd3-content').children('small').children('.page-url')
                .attr('href', BASE_URL+d.page).html(d.page);

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