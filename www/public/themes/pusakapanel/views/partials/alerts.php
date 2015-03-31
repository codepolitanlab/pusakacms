<div>
	<?php if($this->session->flashdata('success')): ?>
		<div class="alert alert-success alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('warning')): ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $this->session->flashdata('warning'); ?>
		</div>
	<?php endif; ?>

	<?php if(validation_errors()): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo validation_errors(); ?>
		</div>
	<?php endif; ?>

	<?php if($this->session->flashdata('error')): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $this->session->flashdata('error'); ?>
		</div>
	<?php endif; ?>

	<?php if(isset($error)): ?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $error; ?>
		</div>
	<?php endif; ?>

	<?php if(isset($warning)): ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $warning; ?>
		</div>
	<?php endif; ?>

	<?php if(isset($info)): ?>
		<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<?php echo $info; ?>
		</div>
	<?php endif; ?>

	<div class="alert alert-danger alert-dismissible" id="alert-error" role="alert" style="display:none">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<span>error message</span>
	</div>
	<div class="alert alert-success alert-dismissible" id="alert-success" role="alert" style="display:none">
		<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		<span>success message</span>
	</div>
</div>
