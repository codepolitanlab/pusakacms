<!-- Load JS here for greater good =============================-->

<?php echo get_theme_js('jquery.ui.touch-punch.min.js');?>
<?php echo get_theme_js('bootstrap-select.js');?>
<?php echo get_theme_js('bootstrap-switch.js');?>
<?php echo get_theme_js('flatui-checkbox.js');?>
<?php echo get_theme_js('flatui-radio.js');?>
<?php echo get_theme_js('jquery.tagsinput.js');?>
<?php echo get_theme_js('flatui-fileinput.js');?>
<?php echo get_theme_js('jquery.placeholder.js');?>
<?php echo get_theme_js('jquery.zoomer.js');?>
<?php echo get_theme_js('application.js');?>

<?php echo get_theme_js('spectrum.js');?>
<?php echo get_theme_js('chosen.jquery.min.js');?>
<?php echo get_theme_js('redactor/redactor.min.js');?>
<?php echo get_theme_js('redactor/table.js');?>
<?php echo get_theme_js('redactor/bufferButtons.js');?>
<?php echo get_theme_js('src-min-noconflict/ace.js');?>

<script src="<?php echo site_url('builder/getelements');?>"></script>
<?php echo get_theme_js('builder.js');?>

<script>
    
    var baseUrl = "<?php echo base_url();?>";
    var siteUrl = "<?php echo site_url('/');?>";
    var elementUrl = "<?php echo base_url().'system/themes/'.$this->config->item('theme');?>/assets/";
    
    <?php if( isset($siteData) ):?>
    var siteID = <?php echo $siteData['site']->sites_id;?>;
    <?php else:?>
    var siteID = 0;
    <?php endif;?>
    
    <?php if( isset($pagesData) ):?>
    var pagesData = <?php echo json_encode($pagesData);?>
    <?php endif;?>
        
    $(function(){
    
    	var ua = window.navigator.userAgent;
    		var msie = ua.indexOf("MSIE ");
    	
    	/*if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    			
    		$('.modes #modeContent').parent().hide();
    			
    	} else {
    			
    		$('.modes #modeContent').parent().show();
    		
    	}*/
    	
    	<?php if( isset($siteData) ):?>
    	
    	//make sortable
    	
    	$('#pageList > ul').each(function(){
    	
    		makeSortable( $(this) );
    	
    	})
    	
    	$('#pageList li iframe').each(function(){
    	
    		theHeight = $(this).attr('data-height')*0.8;
    		
    		//add height to frames array
    		frames[$(this).attr('id')] = $(this).attr('data-height');
    		    		    		
    		$(this).zoomer({
    			zoom: 0.8,
    			height: theHeight,
    			width: $('#screen').width()
    		});
    		
    		$(this).closest('li').find('.zoomer-cover a').remove();
    		$(this).closest('li').find('.zoomer-cover').text('');
    		
    		
    		//add a delete button
    		delButton = $('<button type="button" class="btn btn-danger deleteBlock"><span class="fui-trash"></span> remove</button>');
    		resetButton = $('<button type="button" class="btn btn-warning resetBlock"><i class="fa fa-refresh"></i> reset</button>');
    		htmlButton = $('<button type="button" class="btn btn-inverse htmlBlock"><i class="fa fa-code"></i> source</button>');
    		
    		$(this).closest('li').find('.zoomer-cover').append( delButton )
    		$(this).closest('li').find('.zoomer-cover').append( resetButton );
			$(this).closest('li').find('.zoomer-cover').append( htmlButton ); 	
    		
    	})
    	
    	
    	allEmpty();
    	
    	<?php endif;?>
    	
    })    
    
    </script>

<!-- site settings -->
<script>
	$(function(){

		//listed to FTP form fields and check if we need to enable the test

		$('.siteSettingsModalButton').click( function(e){

			e.preventDefault();

			$('#siteSettings').modal('show');

    		//destroy all alerts
    		$('#siteSettings .alert').fadeOut(500, function(){

    			$(this).remove();

    		})
    		
    		
    		//set the siteID
    		$('input#siteID').val( $(this).attr('data-siteid') );
    		
    		
    		//destroy current forms
    		$('#siteSettings .modal-body-content > *').each(function(){
    			$(this).remove();
    		})
    		
    		
    		//show loader, hide rest
    		$('#siteSettingsWrapper .loader').show();
    		$('#siteSettingsWrapper > *:not(.loader)').hide();
    		
    		
    		//load site data using ajax
    		
    		$.ajax({
    			url: '<?php echo site_url('panel/builder/siteAjax')?>/'+$(this).attr('data-siteid'),
    			type: 'post',
    			dataType: 'json'
    		}).done(function(ret){    			
    			
    			if( ret.responseCode == 0 ) {//error

    				//hide loader, show error message
    				$('#siteSettings .loader').fadeOut(500, function(){
    					
    					$('#siteSettings .modal-alerts').append( $(ret.responseHTML) )

    				})
    				
    				//disable submit button
    				$('#saveSiteSettingsButton').addClass('disabled');


    			} else if( ret.responseCode == 1 ) {//all well :)
    			
    				//hide loader, show data
    				
    				$('#siteSettings .loader').fadeOut(500, function(){

    					$('#siteSettings .modal-body-content').append( $(ret.responseHTML) )

    				})
    				
    				//enable submit button
    				$('#saveSiteSettingsButton').removeClass('disabled');

    			}

    		})

    	} )


    	//site name input field
    	$('button#saveSiteSettingsButton').click(function(){
    		
    		//destroy all alerts
    		$('#siteSettings .alert').fadeOut(500, function(){

    			$(this).remove();

    		})
    		
    		//disable button
    		$('#saveSiteSettingsButton').addClass('disabled');
    		
    		//hide form data
    		$('#siteSettings .modal-body-content > *').hide();
    		
    		//show loader
    		$('#siteSettings .loader').show();
    		
    		
    		
    		$.ajax({
    			url: '<?php echo site_url('panel/builder/siteAjaxUpdate')?>',
    			type: 'post',
    			dataType: 'json',
    			data: $('form#siteSettingsForm').serializeArray()
    		}).done(function(ret){

    			if( ret.responseCode == 0 ) {//error

    				$('#siteSettings .loader').fadeOut(500, function(){

    					$('#siteSettings .modal-alerts').append( ret.responseHTML );
    					
    					//show form data
    					$('#siteSettings .modal-body-content > *').show();
    					
    					//enable button
    					$('#saveSiteSettingsButton').removeClass('disabled');

    				})


    			} else if( ret.responseCode == 1 ) {//all is well

    				$('#siteSettings .loader').fadeOut(500, function(){
    					
    					
    					//update site name in top menu
    					$('#siteTitle').text( ret.siteName );
    					

    					$('#siteSettings .modal-alerts').append( ret.responseHTML );
    					
    					//hide form data
    					$('#siteSettings .modal-body-content > *').remove();
    					$('#siteSettings .modal-body-content').append( ret.responseHTML2 );
    					
    					//enable button
    					$('#saveSiteSettingsButton').removeClass('disabled');
    					
    					
    					//is the FTP stuff all good?
    					
    					if( ret.ftpOk == 1 ) {//yes, all good

    						$('#publishPage').removeAttr('data-toggle');
    						$('#publishPage span.text-danger').hide();
    						
    						$('#publishPage').tooltip('destroy')

    					} else {//nope, can't use FTP

    					$('#publishPage').attr('data-toggle', 'tooltip');
    					$('#publishPage span.text-danger').show();

    					$('#publishPage').tooltip('show')
    					
    				}


    					//update the site name in the small window
    					$('#site_'+ret.siteID+' .window .top b').text( ret.siteName )

    				})


}

})


    		//hide modal
    		//$('#siteSettings').modal('hide')

    	})


    	//browse FTP
    	
    	$('#siteSettings').on('click', '#siteSettingsBrowseFTPButton, .link', function(e){
    		
    		e.preventDefault();
    		
    		//got all we need?
    		
    		if( $('#siteSettings_ftpServer').val() == '' || $('#siteSettings_ftpUser').val() == '' || $('#siteSettings_ftpPassword').val() == '' ) {

    			alert('Please make sure all FTP connection details are present');
    			
    			return false;

    		}
    		
    		
    		//check if this is a deeper level link
    		if( $(this).hasClass('link') ) {
    			
    			if( $(this).hasClass('back') ) {

    				$('#siteSettings_ftpPath').val( $(this).attr('href') );

    			} else {

    				//if so, we'll change the path before connecting

    				if( $('#siteSettings_ftpPath').val().substr( $('#siteSettings_ftpPath').val.length - 1 ) == '/' ) {//prepend "/"

    					$('#siteSettings_ftpPath').val( $('#siteSettings_ftpPath').val()+$(this).attr('href') );

    			} else {
    				
    				$('#siteSettings_ftpPath').val( $('#siteSettings_ftpPath').val()+"/"+$(this).attr('href') );
    				
    			}
    			
    		}


    	}


    		//destroy all alerts
    		
    		$('#ftpAlerts .alert').fadeOut(500, function(){

    			$(this).remove();

    		})
    		
    		//disable button
    		$(this).addClass('disabled');
    		
    		//remove existing links
    		$('#ftpListItems > *').remove();
    		
    		//show ftp section
    		$('#ftpBrowse .loaderFtp').show();
    		$('#ftpBrowse').slideDown(500);

    		
    		theButton = $(this)
    		
    		$.ajax({
    			url: '<?php echo site_url('ftpconnection/connect')?>',
    			type: 'post',
    			dataType: 'json',
    			data: $('form#siteSettingsForm').serializeArray()
    		}).done(function(ret){

    			//enable button
    			theButton.removeClass('disabled');
    			
    			//hide loading
    			$('#ftpBrowse .loaderFtp').hide();

    			if( ret.responseCode == 0 ) {//error

    				$('#ftpAlerts').append( $(ret.responseHTML) )

    			} else if( ret.responseCode == 1 ) {//all good

    				$('#ftpListItems').append( $(ret.responseHTML) )

    			}

    		})

    	});


    	//hide FTP browser
    	$('#siteSettings').on('click', '#ftpListItems .close', function(e){

    		e.preventDefault();
    		
    		$(this).closest('#ftpBrowse').slideUp(500);

    	});
    	
    	
    	//test FTP connection
    	$('#siteSettings').on('click', '#siteSettingsTestFTP', function(){

    		//got all we need?
    		
    		if( $('#siteSettings_ftpServer').val() == '' || $('#siteSettings_ftpUser').val() == '' || $('#siteSettings_ftpPassword').val() == '' ) {

    			alert('Please make sure all FTP connection details are present');
    			
    			return false;

    		}
    		
    		
    		//destroy all alerts
    		
    		$('#ftpTestAlerts .alert').fadeOut(500, function(){

    			$(this).remove();

    		})
    		
    		//disable button
    		$(this).addClass('disabled');
    		
    		
    		//show loading indicator
    		
    		$(this).next().fadeIn(500);
    		
    		
    		theButton = $(this)
    		
    		$.ajax({
    			url: '<?php echo site_url('ftpconnection/test')?>',
    			type: 'post',
    			dataType: 'json',
    			data: $('form#siteSettingsForm').serializeArray()
    		}).done(function(ret){

    			//enable button
    			theButton.removeClass('disabled');
    			
    			theButton.next().fadeOut(500);

    			if( ret.responseCode == 0 ) {//error

    				$('#ftpTestAlerts').append( $(ret.responseHTML) )

    			} else if( ret.responseCode == 1 ) {//all good

    				$('#ftpTestAlerts').append( $(ret.responseHTML) )

    			}

    		})

    	})    


var toDel;
var delButton;

	//delete site button/modal
	$('.deleteSiteButton').click(function(e){

		e.preventDefault();
		
		$('#deleteSiteModal .modal-content p').show();
		
		//remove old alerts
		$('#deleteSiteModal .modal-alerts > *').remove();
		
		$('#deleteSiteModal .loader').hide();
		

		toDel = $(this).closest('.site');
		delButton = $(this);
		
		
		$('#deleteSiteModal button#deleteSiteButton').show();

		$('#deleteSiteModal').modal('show');
		
		$('#deleteSiteModal button#deleteSiteButton').unbind('click').click(function(){

			$(this).addClass('disabled');

			$('#deleteSiteModal .loader').fadeIn(500);

			$.ajax({
				url: '<?php echo site_url('panel/builder/trash')?>/'+delButton.attr('data-siteid'),
				type: 'post',
				dataType: 'json'
			}).done(function(ret){

				$('#deleteSiteModal .loader').hide();
				
				$('#deleteSiteModal button#deleteSiteButton').removeClass('disabled');

				if( ret.responseCode == 0 ) {//error

					$('#deleteSiteModal .modal-content p').hide();
					
					$('#deleteSiteModal .modal-alerts').append( $(ret.responseHTML) )
					

				} else if( ret.responseCode == 1 ) {//all good

					$('#deleteSiteModal .modal-content p').hide();
					
					$('#deleteSiteModal .modal-alerts').append( $(ret.responseHTML) )
					
					$('#deleteSiteModal button#deleteSiteButton').hide();

					toDel.fadeOut(800, function(){

						$(this).remove();		
						
					})


				}

			})	


		})

	})

})
</script>

<!-- js account -->
<script>
	$(function(){


	//user details
	$('#accountDetailsSubmit').click(function(){

		//all fields filled in?
		
		allGood = 1
		
		if( $('#account_details input#firstname').val() == '' ) {

			$('#account_details input#firstname').closest('.form-group').addClass('has-error');
			
			allGood = 0;

		} else {

			$('#account_details input#firstname').closest('.form-group').removeClass('has-error');
			
			allGood = 1;

		}
		
		if( $('#account_details input#lastname').val() == '' ) {

			$('#account_details input#lastname').closest('.form-group').addClass('has-error');

			allGood = 0;

		} else {

			$('#account_details input#lastname').closest('.form-group').removeClass('has-error');
			
			allGood = 1;

		}
		
		
		if( allGood == 1 ) {

			theButton = $(this);

			//disable button
			$(this).addClass('disabled');
			
			//show loader
			$('#account_details .loader').fadeIn(500);
			
			//remove alerts
			$('#account_details .alerts > *').remove();

			$.ajax({
				url: "<?php echo site_url('users/uaccount')?>",
				type: 'post',
				dataType: 'json',
				data: $('#account_details').serialize()
			}).done(function(ret){

				//enable button
				theButton.removeClass('disabled');
				
				//hide loader
				$('#account_details .loader').hide()
				
				$('#account_details .alerts').append( $(ret.responseHTML) );
				
				if( ret.responseCode == 1 ) {//success

					setTimeout(function(){ $('#account_details .alerts > *').fadeOut(500, function(){ $(this).remove(); }) }, 3000)

				}

			})

		}

	})


	//user login
	$('#accountLoginSubmit').click(function(){

		allGood = 1
		
		if( $('#account_login input#email').val() == '' ) {

			$('#account_login input#email').closest('.form-group').addClass('has-error');
			
			allGood = 0;

		} else {

			$('#account_login input#email').closest('.form-group').removeClass('has-error');
			
			allGood = 1;

		}
		
		if( $('#account_login input#password').val() == '' ) {

			$('#account_login input#password').closest('.form-group').addClass('has-error');

			allGood = 0;

		} else {

			$('#account_login input#password').closest('.form-group').removeClass('has-error');
			
			allGood = 1;

		}
		
		
		if( allGood == 1 ) {

			theButton = $(this);
			
			//disable button
			$(this).addClass('disabled');

			//show loader
			$('#account_login .loader').fadeIn(500);

			//remove alerts
			$('#account_login .alerts > *').remove();
			
			$.ajax({
				url: "<?php echo site_url('users/ulogin')?>",
				type: 'post',
				dataType: 'json',
				data: $('#account_login').serialize()
			}).done(function(ret){
				
				//enable button
				theButton.removeClass('disabled');

				//hide loader
				$('#account_login .loader').hide()

				$('#account_login .alerts').append( $(ret.responseHTML) );

				if( ret.responseCode == 1 ) {//success
					
					setTimeout(function(){ $('#account_login .alerts > *').fadeOut(500, function(){ $(this).remove(); }) }, 3000)
					
				}
				
			})

		}

	})

})
</script>