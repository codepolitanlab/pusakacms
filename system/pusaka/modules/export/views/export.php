<div class="row heading">
	<div class="col-md-6">
		<h1>EXPORT TO HTML</h1>
	</div>
</div>
<br>

<div class="panel panel-default">
	<div class="panel-body align-center">
		<div class="row">
			<div class="col-md-9">
				<input type="text" class="form-control" name="location" id="location" placeholder="Fill export location, i.e. D:/xampp/htdocs/html or /var/www/html" value="<?php echo $location; ?>">
			</div>
			<div class="col-md-3">
				<?php if($this->config->item('url_suffix') == '.html'): ?>
					<button class="btn btn-success form-control" id="btn-export">Export to HTML</button>
				<?php endif; ?>
			</div>
		</div>

		<div class="progress-panel" style="display:none;margin-top:20px;">
			<div class="progress">
				<div id="progress-bar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
			</div>
			<div id="progress-msg" class="align-left">
				<p>Processing..</p>
			</div>
		</div>
	</div>
</div>

<script>
	var url = [
	{"url":"<?php echo site_url('panel/export/save_export_location');?>"},
	{"url":"<?php echo site_url('panel/export/check_writable');?>"},
	{"url":"<?php echo site_url('panel/export/copy_theme');?>"},
	{"url":"<?php echo site_url('panel/export/copy_files');?>"},
	{"url":"<?php echo site_url('panel/export/copy_vendor');?>"},
	{"url":"<?php echo site_url('panel/export/export_pages');?>"},
	{"url":"<?php echo site_url('panel/export/export_blog');?>"},
	{"url":"<?php echo site_url('panel/export/add_missing_index_folder');?>"}
	];
	var step = 0;
	var progress = 0;
	var satuan = Math.floor(100 / url.length);

	$('#btn-export').click(function(){
		var dest = $('#location').val();
		if(jQuery.trim(dest) == ''){
			$('.alert-danger').fadeOut('fast').fadeIn()
			.children('span').html('Specify the export destination first.');
			$(this).focus();
			return;
		}
		
		$('.progress-panel').fadeIn();
		get_ajax(dest, url, step);
	});


	function get_ajax(dest, url, step)
	{
		progress = satuan * step;
		$('#progress-bar').css('width', progress+'%');

		$.ajax({
			url: url[step].url,
			type: 'POST',
			data: {location:dest}
		})
		.done(function(data){
			var msg = jQuery.parseJSON(data);
			if(msg.status == 'error'){
				$('.alert-danger').fadeOut('fast').fadeIn()
				.children('span').html(msg.message);
				$('.progress-panel').fadeOut();
				return;
			}

			$('#progress-msg').append('<p><span class="fa fa-check"></span> '+msg.message+'</p>');

			step = step + 1;
			if(step < url.length)
				get_ajax(dest, url, step);
			else {
				$('#progress-bar').css('width', '100%');
				setTimeout(function(){
					window.location.href = "<?php echo site_url('panel/export/success'); ?>";
				}, 1000);
			}
		})
	}
</script>