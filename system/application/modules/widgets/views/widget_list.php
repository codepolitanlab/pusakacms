<?php if($widgets): ?>
	<?php foreach ($widgets as $widget_slug => $widget): ?>
		<li class="panel panel-info panel-sortable-item" style="margin-bottom:10px;" data-title="<?php echo $widget['widget_data']['title']; ?>">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-9">
						<div class="panel-handle dd-handle dd3-handle" title="klik and drag to rearrange"><span class="fa fa-align-justify" style="color:#aaa;line-height:27px;"></span></div>
						<a role="button" data-toggle="collapse" data-parent="#<?php echo $area; ?>" href="#collapse_<?php echo $widget_slug; ?>" class="panel-title">
							<?php echo $widget['widget_data']['title']; ?> &nbsp;&middot;
							<em><small><?php echo $widget['widget_slug']; ?></small></em>
						</a>
					</div>
					<div class="col-md-3 align-right">
						<a href="<?php echo site_url('panel/widgets/delete/'.$widget_slug.'/'.$area); ?>" class="btn btn-default btn-xs remove" title="Delete widget"><span class="fa fa-times"></span></a>
					</div>
				</div>
			</div>
			<div id="collapse_<?php echo $widget_slug; ?>" class="panel-collapse collapse">
				<div class="panel-body">
					{{ noparse}}<?php echo $widget['form']; ?>{{ /noparse }}
				</div>
			</div>
		</li>
	<?php endforeach; ?>
<?php else: ?>
	<p>There is no any widget in this area.</p>
<?php endif; ?>