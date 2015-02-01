$(function(){

	$('button#buttonCreateAccount').click(function(){
	
		//all items present?
		
		var allGood = 1;
		
		if( $('#newUserModal form input#firstname').val() == '' ) {
		
			$('#newUserModal form input#firstname').parent().addClass('has-error');
			
			var allGood = 0;
		
		} else {
		
			$('#newUserModal form input#firstname').parent().removeClass('has-error');			
		
		}
		
		if( $('#newUserModal form input#lastname').val() == '' ) {
		
			$('#newUserModal form input#lastname').parent().addClass('has-error');
			
			var allGood = 0;
		
		} else {
		
			$('#newUserModal form input#lastname').parent().removeClass('has-error');
					
		}
		
		if( $('#newUserModal form input#email').val() == '' ) {
		
			$('#newUserModal form input#email').parent().addClass('has-error');
			
			var allGood = 0;
		
		} else {
		
			$('#newUserModal form input#email').parent().removeClass('has-error');
					
		}
		
		if( $('#newUserModal form input#password').val() == '' ) {
		
			$('#newUserModal form input#password').parent().addClass('has-error');
			
			var allGood = 0;
		
		} else {
		
			$('#newUserModal form input#password').parent().removeClass('has-error');
		
		}
		
		
		
		if( allGood == 1 ) {
		
			//remove old alerts
			$('#newUserModal .modal-alerts > *').hide();
		
			//disable button
			$(this).addClass('disabled');
			
			//show loader
			$('#newUserModal .loader').fadeIn();
		
			$.ajax({
				url: $('#newUserModal form').attr('action'),
				type: 'post',
				dataType: 'json',
				data:  $('#newUserModal form').serialize()
			}).done(function(ret){
			
				//enable button
				$('button#buttonCreateAccount').removeClass('disabled');
				
				//hide loader
				$('#newUserModal .loader').hide();
			
				
				if( ret.responseCode == 0 ) {//error
				
					$('#newUserModal .modal-alerts').append( $(ret.responseHTML) )
				
				} else {//all good
				
					$('#newUserModal .modal-alerts').append( $(ret.responseHTML) )
					
					$('#users > *').remove();
					
					$('#users').append( $(ret.users) );
					
					$('#users form input[type="checkbox"]').checkbox();
					
					$('.userSites .site iframe').each(function(){
					    	
						theHeight = $(this).attr('data-height')*0.25;
						
						$(this).width(  )
					    	
						$(this).zoomer({
							zoom: 0.25,
							height: theHeight,
							width: $(this).closest('.tab-pane').width(),
							message: "",
							messageURL: "<?php echo site_url('sites')?>/"+$(this).attr('data-siteid')
						});
						
						$(this).closest('.site').find('.zoomer-cover > a').attr('target', '');
					
					})
				
				}
				
			})
		
		}
	
	})
	
	
	
	//update user data
	
	$('#users').on('click', '.updateUserButton', function(){
	
		//remove old alerts
		//$(this).closest('.bottom').find('.alerts').remove();
	
		//disable button
		var theButton = $(this);
		$(this).addClass('disabled');
	
		//show loader
		$(this).closest('.bottom').find('.loader').fadeIn(500);
		
		$.ajax({
			url: $(this).closest('form').attr('action'),
			type: 'post',
			dataType: 'json',
			data: $(this).closest('form').serialize()
		}).done(function(ret){
		
			//enable button
			theButton.removeClass('disabled');
			
			//hide loader
			theButton.closest('.bottom').find('.loader').hide();
			
			if( ret.responseCode == 0 ) {//error
			
				theButton.closest('.bottom').find('.alerts').append( $(ret.responseHTML) );
			
			} else if(ret.responseCode == 1) {//all good
			
				theButton.closest('.bottom').find('.alerts').append( $(ret.responseHTML) );				
				
				//append user detail form
				thePane = theButton.closest('.tab-pane');
				
				
				setTimeout(function(){thePane.closest('.bottom').find('.alert-success').fadeOut(500, function(){$(this.remove())})}, 3000);
				
				theButton.closest('form').remove();
				
				thePane.prepend( $(ret.userDetailForm) )
				
				thePane.find('form input[type="checkbox"]').checkbox();
							
			}
			
		})
	
	})
	
	
	
	//pasword reset
	$('#users').on('click', '.passwordReset', function(e){
	
		e.preventDefault();
		
		theButton = $(this);
		
		//disable buttons
		$(this).addClass('disabled');
		$(this).closest('.bottom').find('.updateUserButton').addClass('disabled');
		
		//show loader
		$(this).closest('.bottom').find('.loader').fadeIn();
		
		
		$.ajax({
			url: "<?php echo site_url('users/rpw')?>/"+$(this).attr('data-userid'),
			type: 'post',
			dataType: 'json'
		}).done(function(ret){
				
			//enable buttons
			theButton.removeClass('disabled');
			theButton.closest('.bottom').find('.updateUserButton').removeClass('disabled');
			
			//hide loader
			theButton.closest('.bottom').find('.loader').hide();
			
			$(theButton).closest('.bottom').find('.alerts').append( $(ret.responseHTML) );
		
			if( ret.responseCode == 0 ) {//error
			
				
			
			} else if( ret.responseCode == 1 ) {//all good
			
				setTimeout(function(){ theButton.closest('.bottom').find('.alerts > *').fadeOut(500, function(){$(this).remove()}) }, 3000)
			
			}
		
		})
	
	})
	
	
	
	//delete user account
	$('#users').on('click', '.deleteUserButton', function(e){
	
		e.preventDefault();
		
		//setup delete link
		$('#deleteUserModal a#deleteUserButton').attr('href', $(this).attr('href'));
		
		//modal
		$('#deleteUserModal').modal('show')
	
	})

})