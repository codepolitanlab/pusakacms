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
		<ul class="navlist draggable">
			<?php echo $pages; ?>
		</ul>
	</div>
</div>