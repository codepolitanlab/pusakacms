<?php if($widgets): ?>
	<?php foreach ($widgets as $widget_slug => $widget): ?>
		<div class="panel panel-default" style="margin-bottom:10px;">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<a role="button" data-toggle="collapse" data-parent="#<?php echo $area; ?>" href="#collapse_<?php echo $widget_slug; ?>" class="panel-title">
							<?php echo $widget['widget_data']['title']; ?> &nbsp;&middot;
							<em><small><?php echo $widget['widget_slug']; ?></small></em>
						</a>
					</div>
					<div class="col-md-6 align-right">
						<a href="<?php echo site_url('panel/widgets/delete/'.$widget_slug.'/'.$area); ?>" class="remove" title="Delete Area"><span class="fa fa-times"></span></a>
					</div>
				</div>
			</div>
			<div  id="collapse_<?php echo $widget_slug; ?>" class="panel-collapse collapse">
				<div class="panel-body">
					<?php echo $widget['form']; ?>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p>There is no any widget in this area.</p>
<?php endif; ?>