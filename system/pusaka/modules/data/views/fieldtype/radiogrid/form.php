<div class="form-group">
	<label for="<?php echo $name; ?>"><?php echo $label;?></label> 
	<?php if(isset($desc) && !empty($desc)): ?>
		<small><?php echo $desc; ?></small>
	<?php endif; ?>

	<?php

	$r = array();
	$c = array();
	foreach ($datalist as $value) {
		$r[$value[$row_field]] = $value[$row_field];
		$c[$value[$column_field]] = $value[$column_field];
	}

	$grid = array();
	foreach ($r as $rk => $rv) {
		foreach ($c as $ck => $cv) {		
			$grid[$rk][$ck] = 0;
		}
	}

	foreach ($datalist as $value) {
		$grid[$value[$row_field]][$value[$column_field]] = array('pid' => $value['id'], 'price' => (int) $value[$caption_field]);
	}
	?>

	<table class="table">
		<tr>
		<th></th>
		<?php foreach ($c as $key => $value): ?>
			<th><?php echo $key; ?></th>
		<?php endforeach; ?>
		</tr>

		<?php foreach ($r as $rv): ?>
		<tr>
			<td><?php echo ($rv == 0) ? 'selamanya' : $rv.' bulan'; ?></td>
			<?php foreach ($grid[$rv] as $g): ?>
				<td>
					<?php if(is_array($g)): ?>
						<button type="button" class="btn btn-block package_price <?php echo ($field_value == $g['pid'])? 'btn-success' : ''; ?>" value="<?php echo $g['pid']; ?>">
						<?php echo number_format($g['price'], 0, ',', '.'); ?>
						</button>
					<?php endif; ?>
				</td>
			<?php endforeach; ?>			
		</tr>
		<?php endforeach; ?>
	</table>

	<input type="hidden" id="package_id" name="package_id" value="<?php echo $field_value; ?>">
</div>

<style type="text/css">
	th, td {text-align: center}
</style>
<script type="text/javascript">
$(function(){
	
	$('.package_price').click(function(){
		$('#package_id').val($(this).val());
		$('.package_price').removeClass('btn-success');
		$(this).addClass('btn-success');
	})
})
</script>