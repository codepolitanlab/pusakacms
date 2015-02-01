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