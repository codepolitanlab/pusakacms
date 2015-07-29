<div class="row heading">
	<div class="col-md-6">
		<h1>GENERAL SETTINGS</h1>
	</div>
</div>

<!-- form tabs -->
<ul class="nav nav-tabs">
	<?php foreach ($settings_form as $key => $val): ?>
		<li <?php echo ($tab == $val['id'])?' class="active"' : ''; ?>>
			<a href="<?php echo site_url('panel/settings/index/'.$val['id']); ?>">
				<?php echo $val['title']; ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

<!-- form contents -->
<div id="myTabContent" class="tab-content">
	<?php echo $settings_form[$tab]['form']; ?>
</div>
