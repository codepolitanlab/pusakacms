<div class="row heading">
	<div class="col-md-6">
		<h1><?php echo $mode.' Data '.$title_data; ?></h1>
	</div>
	<div class="col-md-6 align-right">
		<div>
			<a class="btn btn-md btn-transparent" href="<?php echo $path; ?>"><span class="fa fa-arrow-left"></span> Back</a>
			<a class="btn btn-md btn-transparent" href="<?php echo $add_url; ?>"><span class="fa fa-plus-circle"></span> Add New Data</a>
		</div>
	</div>
</div>

<?php echo $form; ?>