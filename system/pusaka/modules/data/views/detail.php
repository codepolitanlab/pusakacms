
<br>
<table class="table table-striped">
<?php foreach ($structure as $field): ?>
	<tr>
		<th style="width:150px"><?php echo $field['name']; ?></th>
		<td>: <?php echo isset($field['relation']['table'])? $current_data[$field['relation']['table']] : $current_data[$field['field']]; ?></td>
	</tr>
<?php endforeach; ?>
</table>