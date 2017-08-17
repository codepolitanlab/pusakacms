<!-- if it is relation field -->
<?php if (isset($field['relation']['relation_label'])): ?>
	<td><?php echo $data[$field['relation']['relation_label']]; ?></td>

<!-- otherwise use field name -->
<?php else: ?>
	<td><?php echo $data[$field['name']]; ?></td>
<?php endif; ?>