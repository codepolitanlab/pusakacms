<div class="row heading">
	<div class="col-md-6">
		<h1>PAGES</h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/sync"><span class="fa fa-refresh"></span> Sync pages</a>
			<a class="btn btn-md btn-transparent" href="{{ func.site_url }}panel/pages/new"><span class="fa fa-plus-circle"></span> Create new page</a>
		</div>
	</div>
</div>

<ul class="content-list nav">
	<?php echo $pages; ?>
</ul>