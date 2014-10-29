<?php if($this->session->flashdata('success')): ?>
	<div class="alert alert-success" role="alert">
		<?php echo $this->session->flashdata('success'); ?>
	</div>
<?php endif; ?>

<?php if(validation_errors()): ?>
	<div class="alert alert-danger" role="alert">
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
	<div class="alert alert-danger" role="alert">
		<?php echo $this->session->flashdata('error'); ?>
	</div>
<?php endif; ?>
