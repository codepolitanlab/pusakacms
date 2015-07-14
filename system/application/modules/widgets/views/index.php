<div class="row heading">
	<div class="col-md-6">
		<h1>WIDGETS</h1>
	</div>
</div>
<br>

<div class="row">
	<div class="col-md-6">
		<h3>Available Widgets</h3>

		<!-- Nav tabs -->
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#core" aria-controls="core" role="tab" data-toggle="tab">Core Widgets</a></li>
			<li role="presentation"><a href="#addon" aria-controls="addon" role="tab" data-toggle="tab">Addon Widgets</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<?php foreach ($widgets as $widget_type => $widget_val): ?>
				<div role="tabpanel" class="tab-pane <?php echo ($widget_type=='core')? 'active' : ''; ?>" id="<?php echo $widget_type; ?>">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

						<?php if (! empty($widget_val)):?>

							<?php foreach ($widget_val as $wid_name => $wid_value): ?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="heading_<?php echo $wid_name; ?>">
										<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $wid_name; ?>" aria-expanded="false" aria-controls="collapse_<?php echo $wid_name; ?>" class="collapsed panel-title">
											<?php echo $wid_value['widget_name']; ?>
											<span class="pull-right"><small>+ Add</small></span>
										</a>
									</div>
									<div id="collapse_<?php echo $wid_name; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?php echo $wid_name; ?>" aria-expanded="false" style="height: 0px;">
										<div class="panel-body">
											<p class="text-muted"><?php echo $wid_value['widget_description']; ?></p>
										
											<?php echo $wid_value['form']; ?>
										</div>
									</div>
								</div>
							<?php endforeach; ?>

						<?php else: ?>
							<p>There is no core widgets.</p>
						<?php endif; ?>

					</div>
				</div>
			<?php endforeach; ?>

		</div>

	</div>

	<div class="col-md-6">
		<h3>Widget Areas</h3>

		<?php if($areas): ?>
			<?php foreach ($areas as $area_slug): ?>
				<div class="panel panel-success">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-6">
								<a role="button" data-toggle="collapse" href="#collapse_<?php echo $area_slug; ?>" class="panel-title">
									<?php echo $area_slug; ?>
								</a>
							</div>
						</div>
					</div>
					<div  id="collapse_<?php echo $area_slug; ?>" class="panel-collapse collapse in">
						<div class="panel-body" id="<?php echo $area_slug; ?>">
							<?php echo Modules::run('widgets/panel/widget_list', $area_slug); ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<p>There is no any widget area yet.</p>
		<?php endif; ?>

	</div>
</div>

<script>
	$(function(){
		<?php if($areas): $group = 0; foreach ($areas as $area_slug => $area_content): ?>
		$('#<?php echo $area_slug; ?>').nestable({group: <?php echo $group; ?>}).on('change', updateSort);
		<?php $group++; endforeach; endif; ?>
	})

	// callback to update arrange navigation
	var updateSort = function(e)
	{
		var list   = e.length ? e : $(e.target);
		var area = list.attr('id');

		//clear timeout
		$('.alert').fadeOut(100);
		clearTimeout(timeout);

		if (window.JSON) {
			var newmap = window.JSON.stringify(list.nestable('serialize'));
			$.post(base_url+'panel/navigation/sort/'+area, {newmap : newmap})
			.done(function(data){
				var res = JSON.parse(data);
				$('#alert-'+res.status).children('span').html(res.message);
				$('#alert-'+res.status).fadeIn(300);
				timeout = setTimeout(function(){
					$('.alert').fadeOut(300);
				}, 5000)
			});
		} else {
			output.val('JSON browser support required for this demo.');
		}
	};
</script>
<style>
	h3 {margin-top:0;}
</style>
