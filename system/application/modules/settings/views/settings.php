<div class="row heading">
	<div class="col-md-6">
		<h1>GENERAL SETTINGS</h1>
	</div>
</div>

<!-- form tabs -->
<ul class="nav nav-tabs">
	<?php foreach ($settings_form as $key => $val): ?>
		<li <?php echo ($tab == $val['title'])?' class="active"' : ''; ?>>
			<a href="<?php echo "#".$val['id']; ?>" role="tab" data-toggle="tab"><?php echo $val['title']; ?></a>
		</li>
	<?php endforeach; ?>
</ul>

<!-- form contents -->
<div id="myTabContent" class="tab-content">
	<?php foreach ($settings_form as $key => $val): ?>
		<div class="tab-pane fade in <?php echo ($tab == $val['title'])?'active' : ''; ?>" id="<?php echo $val['id']; ?>">
			<?php echo $val['form']; ?>
		</div>
	<?php endforeach; ?>
</div>
