<!-- use custom labeled relation field -->
<?php if (isset($field['relation']['custom_label'])): 
	$labels = $field['relation']['custom_label'];
	$separators = $field['relation']['separator_label'];
?>
	<td>
	<?php
		for($i = 0; $i < count($labels); $i++){
			echo $separators[$i];
			echo $data[$labels[$i]];
		}
		echo $separators[count($separators)-1];
	?>
	</td>

<!-- use simple relation field -->
<?php elseif (isset($field['relation']['relation_label'])): ?>
	<td><?php echo $data[$field['relation']['relation_label']]; ?></td>

<!-- use self configured select options -->
<?php elseif(isset($field['select_options'])): ?>
	<td><?php echo $field['select_options'][$data[$field['name']]]['options_label']; ?></td>
	
<!-- otherwise use field name -->
<?php else: ?>
	<td><?php echo $data[$field['name']]; ?></td>
<?php endif; ?>