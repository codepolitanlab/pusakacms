<!-- if it is relation field -->
<?php if (isset($field['format'])): ?>
	<td><?php echo date($field['format'], strtotime($data[$field['name']])); ?></td>

<!-- otherwise use field name -->
<?php else: ?>
	<td><?php echo $data[$field['name']]; ?></td>
<?php endif; ?>