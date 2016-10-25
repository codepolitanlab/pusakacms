<?php
	$extra = '';
	foreach ($field['options'][$data[$field['name']]]['extra'] as $attr => $attrvalue) {
		$extra .= $attr.'="'.$attrvalue.'" ';
	}
?>
<td>
	<a href="<?php echo site_url($field['options'][$data[$field['name']]]['url'].$data['id']); ?>" title="<?php echo $field['options'][$data[$field['name']]]['title']; ?>" <?php echo $extra; ?>>
		<?php echo $field['options'][$data[$field['name']]]['caption']; ?>
	</a>
</td>