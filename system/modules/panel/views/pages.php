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
		<div class="dd">
            <ol class="dd-list">
				<?php echo $pages; ?>
			</ol>
		</div>
	</div>
</div>

<script>
    $(function(){
	    $('.dd').nestable({group: 1}).on('change', updateSort);
    })

    // callback to update arrange navigation
    var updateSort = function(e)
    {
        var list   = e.length ? e : $(e.target);
        var area = list.attr('id');
        if (window.JSON) {
            var newmap = window.JSON.stringify(list.nestable('serialize'));
            $.post(BASE_URL+'panel/pages/sort/'+area, {newmap : newmap})
            .done(function(data){
                console.log(data);
            });
        } else {
            output.val('JSON browser support required for this demo.');
        }
    };
</script>