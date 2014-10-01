<div class="widget">
	<h3>Labels</h3>
	<?php $labels = $this->pusaka->get_labels();
	asort($labels);
	foreach ($labels as $url => $label): ?>
	<label class="label label-info"><?php echo anchor($url, $label); ?></label>
	<?php endforeach; ?>
</div>