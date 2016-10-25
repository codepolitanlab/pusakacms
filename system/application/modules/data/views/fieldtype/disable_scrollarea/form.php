<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>
	
	<div class="scrollarea">
		<?php echo $current_data['tos']; ?>
	</div>
</div>

<style type="text/css">
	.scrollarea {
		overflow-x: scroll;
		width: 100%;
		height: 200px;
		background-color: #ddd;
		padding: 10px;
	}
	.scrollarea h1 {
		font-size: 16px;
	}
</style>