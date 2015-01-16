/*
	
	HTML Builder front-end version 1.5

*/


/* SETTINGS */

var pageContainer = "#page";

var editableItems = new Array();

editableItems['.frameCover'] = [];
editableItems['span.fa'] = ['color', 'font-size'];
editableItems['.bg.bg1'] = ['background-color'];
editableItems['nav a, a.edit'] = ['color', 'font-weight', 'text-transform'];
editableItems['h1'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['h2'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['h3'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['h4'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['h5'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['p'] = ['color', 'font-size', 'background-color', 'font-family'];
editableItems['a.btn, button.btn'] = ['border-radius', 'font-size', 'background-color'];
editableItems['img'] = ['border-top-left-radius', 'border-top-right-radius', 'border-bottom-left-radius', 'border-bottom-right-radius', 'border-color', 'border-style', 'border-width'];
editableItems['hr.dashed'] = ['border-color', 'border-width'];
editableItems['.divider > span'] = ['color', 'font-size'];
editableItems['hr.shadowDown'] = ['margin-top', 'margin-bottom'];
editableItems['.footer a'] = ['color'];
editableItems['.bg.bg1, .bg.bg2, .header10, .header11'] = ['background-image', 'background-color'];

var editableItemOptions = new Array();

editableItemOptions['nav a : font-weight'] = ['400', '700'];
editableItemOptions['a.btn : border-radius'] = ['0px', '4px', '10px'];
editableItemOptions['img : border-style'] = ['none', 'dotted', 'dashed', 'solid'];
editableItemOptions['img : border-width'] = ['1px', '2px', '3px', '4px'];
editableItemOptions['h1 : font-family'] = ['default', 'Lato', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h2 : font-family'] = ['default', 'Lato', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['h3 : font-family'] = ['default', 'Lato', 'Helvetica', 'Arial', 'Times New Roman'];
editableItemOptions['p : font-family'] = ['default', 'Lato', 'Helvetica', 'Arial', 'Times New Roman'];


var editableContent = ['.editContent, .navbar a, button, a.btn, .footer a:not(.fa), .tableWrapper'];


/* FLAT UI PRO INITS */

$(function(){

	// Tabs
	$(".nav-tabs a").on('click', function (e) {
	  e.preventDefault();
	  $(this).tab("show");
	})

})


/* END SETTINGS */
    
var mainMenuWidth = 230;
var secondMenuWidth = 300;

$( window ).load(function() {
	
	$('#loader').fadeOut();

	
	//header tooltips
	if( $('#publishPage').attr('data-toggle') == 'tooltip' ) {
		
		$('#publishPage').tooltip('show');
	
		setTimeout(function(){$('#publishPage').tooltip('hide')}, 5000)
	
	}
	
	$('#modeElementsLabel').tooltip('hide');
	$('#modeContentLabel').tooltip('hide');
	$('#modeStyleLabel').tooltip('hide');

	
	//publish hash?
	if( window.location.hash == "#publish" ) {
	
		$('#publishPage').click();
	
	}
	
});


var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
	rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 	return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  	return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
}


function pageEmpty() {

	if( $('#pageList ul:visible > li').size() == 0 ) {
	
		$('#start').show();
		
		$('#frameWrapper').addClass('empty');
	
	} else {
	
		$('#start').hide();
		
		$('#frameWrapper').removeClass('empty');
	
	}

}

function allEmpty() {

	var allEmpty = false;
	
	if( $('#pageList li').size() == 0 ) {
	
		allEmpty = true;
	
	} else {
	
		allEmpty = false;
	
	}
	
	if( allEmpty ) {
	
		$('a.actionButtons:not(#siteSettingsButton, #savePage)').each(function(){
		
			$(this).addClass('disabled');
		
		});
		
		$('header .modes input').each(function(){
		
			$(this).prop('disabled', true).parent().addClass('disabled');
		
		});
	
	} else {
	
		$('header .modes input').each(function(){
		
			$(this).prop('disabled', false).parent().removeClass('disabled');
		
		});
		
		$('a.actionButtons').each(function(){
		
			$(this).removeClass('disabled');
		
		});
	
	}
	
}


function prepPagesforSave() {

	var thePages = {};
			
	//work through pages/iframes
	$('#pageList > ul').each(function(){
	
		pageName = $('#pages li:eq('+($(this).index()+1)+') a:first').text();
				
		pageFrames = [];
		
		if( $(this).find('iframe').size() > 0 ) {//we've got frames
																
			$(this).find('iframe').each(function(){
		
				frame = {};
		
				frame['frameContent'] = "<html>"+$(this).contents().find('html').html()+"</html>";
			
				//get real frame height rather then from the array
			
				/*frame['frameHeight'] = frames[$(this).attr('id')];*/
			
				//show the parent LI to render the markup inside the iframe
			
				$('#pageList > ul').hide();
			
				$(this).closest('ul').show();
			
			
				frame['frameHeight'] = this.contentWindow.document.body.offsetHeight;
			
				//update the array as well
				frames[$(this).attr('id')] = this.contentWindow.document.body.offsetHeight;
			
			
			
				frame['originalUrl'] = $(this).attr('data-originalurl');
							
				//thePages[pageName][c] = frameContent;
			
				pageFrames.push(frame);
						
			})
			
			thePages[pageName] = pageFrames;
		
		} else {//no frames
		
			thePages[pageName] = '';
		
		}
					
		
							
	});
	
	//show the active page
	
	$('#pages li.active').removeClass('active').find('a:first').click();
	
	return thePages;

}


function makeDraggable(theID) {

	$('#elements li').each(function(){
	
		$(this).draggable({
			helper: function() {
				return $('<div style="height: 100px; width: 300px; background: #F9FAFA; box-shadow: 5px 5px 1px rgba(0,0,0,0.1); text-align: center; line-height: 100px; font-size: 28px; color: #16A085"><span class="fui-list"></span></div>');
			},
			revert: 'invalid',
			appendTo: 'body',
			connectToSortable: theID,
			stop: function(){
				
				pageEmpty();
				
				allEmpty();
				
			},
			start: function(){
			
				//switch to block mode
				$('input:radio[name=mode]').parent().addClass('disabled');
				$('input:radio[name=mode]#modeBlock').radio('check');
				
				//show all iframe covers and activate designMode
				
				$('#pageList ul .zoomer-wrapper .zoomer-cover').each(function(){
				
					$(this).show();
				
				})
				
				//deactivate designmode
				
				$('#pageList ul li iframe').each(function(){
				
					this.contentDocument.designMode = "off";
				
				})
			
			}
		});	
	
	})
	
	$('#elements li a').each(function(){
	
		$(this).unbind('click').bind('click', function(e){
		
			e.preventDefault();
		
		})
	
	})

}

function makeSortable(el) {

	el.sortable({
		revert: true,
		placeholder: "drop-hover",
		beforeStop: function(event, ui){
			
			//alert( ui.item.find('iframe').attr('src') )
						
			if( ui.item.find('.zoomer-cover > button').size() == 0 ) {
			
				if( ui.item.find('iframe').size() > 0 ) {//iframe thumbnails
			   				
					theHeight = ui.item.height()/0.25;
			
					theHeight = theHeight*0.8;
				
					var attr = ui.item.find('iframe').attr('sandbox');
				
					if (typeof attr !== typeof undefined && attr !== false) {
					
						ui.item.html('<iframe src="'+ui.item.find('iframe').attr('src')+'" scrolling="no" data-originalurl="'+ui.item.find('iframe').attr('src')+'" frameborder="0" sandbox="allow-same-origin"><iframe>');
					
					} else {
				
						ui.item.html('<iframe src="'+ui.item.find('iframe').attr('src')+'" scrolling="no" data-originalurl="'+ui.item.find('iframe').attr('src')+'" frameborder="0"><iframe>');
				
					}
					
					ui.item.find('iframe').uniqueId();
								
					ui.item.find('iframe').zoomer({
			    		zoom: 0.8,
			    		width: $('#screen').width(),
			    		height: theHeight
					});
				
				
					//remove the link if it excists
					ui.item.find('.zoomer-cover a').remove();
					ui.item.find('.zoomer-cover').text('');
				
				
				} else {//image thumbnails
				
					theHeight = ui.item.find('img').attr('data-height')*0.8;
										
					ui.item.html('<iframe src="'+ui.item.find('img').attr('data-src')+'" scrolling="no" data-originalurl="'+ui.item.find('img').attr('data-src')+'" frameborder="0"><iframe>');
					
					ui.item.find('iframe').uniqueId();
										
					ui.item.find('iframe').zoomer({
						zoom: 0.8,
						width: $('#screen').width(),
						height: theHeight,
						message: "Drag&Drop Me!"
					});
					
					ui.item.find('iframe').load(function(){
					
						heightAdjustment( ui.item.find('iframe').attr('id'), true );
					
					})
					
					
					//remove the link if it excists
					ui.item.find('.zoomer-cover a').remove();
				
				}
				
				//add a delete button
				delButton = $('<button type="button" class="btn btn-danger deleteBlock"><span class="fui-trash"></span> remove</button>');
				resetButton = $('<button type="button" class="btn btn-warning resetBlock"><i class="fa fa-refresh"></i> reset</button>');
				htmlButton = $('<button type="button" class="btn btn-inverse htmlBlock"><i class="fa fa-code"></i> source</button>');
				
				ui.item.find('.zoomer-cover').append( delButton )
				ui.item.find('.zoomer-cover').append( resetButton );
				ui.item.find('.zoomer-cover').append( htmlButton );
				
				
				//dropped element, so we've got pending changes
				setPendingChanges(true)
							
			}
			   			
		},
		stop: function(){
			
			$('#pageList ul:visible li').each(function(){
			
				$(this).find('.zoomer-cover > a').remove();
				
			});
						
		},
		over: function(){
			
			$('#start').hide();
			
		}
	});

}


function buildeStyleElements(el, theSelector) {

	for( x=0; x<editableItems[theSelector].length; x++ ) {
			
		//create style elements
				
		//alert( $(el).get(0).tagName )
				
		newStyleEl = $('#styleElTemplate').clone();
				
		newStyleEl.attr('id', '');
		newStyleEl.find('.control-label').text( editableItems[theSelector][x]+":" );
				
		if( theSelector+" : "+editableItems[theSelector][x] in editableItemOptions) {//we've got a dropdown instead of open text input
					
			//alert( theSelector+" "+editableItems[kkey][x] )
					
			newStyleEl.find('input').remove();
					
			newDropDown = $('<select></select>');
			newDropDown.attr('name', editableItems[theSelector][x]);
					
			for( z=0; z<editableItemOptions[ theSelector+" : "+editableItems[theSelector][x] ].length; z++ ) {
					
				newOption = $('<option value="'+editableItemOptions[theSelector+" : "+editableItems[theSelector][x]][z]+'">'+editableItemOptions[theSelector+" : "+editableItems[theSelector][x]][z]+'</option>');
						
						
				if( editableItemOptions[theSelector+" : "+editableItems[theSelector][x]][z] == $(el).css( editableItems[theSelector][x] ) ) {
						
					//current value, marked as selected
					newOption.attr('selected', 'true')
						
				}
						
					
				newDropDown.append( newOption )
						
			}
					
			newStyleEl.append( newDropDown );
					
			newDropDown.selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
					
				
		} else {
				
			newStyleEl.find('input').val( $(el).css( editableItems[theSelector][x] ) ).attr('name', editableItems[theSelector][x])
				
			if( editableItems[theSelector][x] == 'background-image' ) {
				
				newStyleEl.find('input').bind('focus', function(){
				
					theInput = $(this);
					
					$('#imageModal').modal('show');
					
					$('#imageModal .image button.useImage').unbind('click');
	
					$('#imageModal').on('click', '.image button.useImage', function(){
					
						$(el).css('background-image',  'url("'+$(this).attr('data-url')+'")');
		
						//update live image
						theInput.val( 'url("'+$(this).attr('data-url')+'")' )
						//$(el).attr('src', $(this).attr('data-url'))
			
						//update image URL field
						//$('input#imageURL').val( $(this).attr('data-url') );
				
						//hide modal
						$('#imageModal').modal('hide');
				
				
						//we've got pending changes
						setPendingChanges(true)
		
					})
					
				});
				
			} else if( editableItems[theSelector][x].indexOf("color") > -1 ) {
						
				//alert( editableItems[theSelector][x]+" : "+$(el).css( editableItems[theSelector][x] ) )
														
				if( $(el).css( editableItems[theSelector][x] ) != 'transparent' && $(el).css( editableItems[theSelector][x] ) != 'none' && $(el).css( editableItems[theSelector][x] ) != '' ) {
					
					newStyleEl.val( $(el).css( editableItems[theSelector][x] ) )
						
				}
					
				newStyleEl.find('input').spectrum({
					preferredFormat: "hex",
					showPalette: true,
					allowEmpty: true,
					showInput: true,
					palette: [
						["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
						["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
						["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
						["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
						["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
						["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
						["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
						["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
					]
				});
					
			}
					
		}
				
								
				
		newStyleEl.css('display', 'block');
				
				
		$('#styleElements').append( newStyleEl );
		
		
		$('#styleEditor form#stylingForm').height('auto')
			
	}

}

var frames = new Array();//array store all the frames' heights

function heightAdjustment(el, par) {

	par = typeof par !== 'undefined' ? par : false;

	if( par == false ) {//el is element inside iframe
			
		$('#pageList li:visible iframe').each(function(){
			
			theBody = $(this).contents().find('body');
	
			if( $.contains( document.getElementById( $(this).attr('id') ).contentWindow.document, el ) ) {
			
				frameID = $(this).attr('id');
				
				//alert( frameID )
				
				return false;
										
			}			
	
		})
	
		theFrame = document.getElementById(frameID);
	
	} else {//el is frame ID
			
		theFrame = document.getElementById(el)
	
	}
	
	//realHeight = theFrame.contentWindow.document.body.offsetHeight;
	
	realHeight = theFrame.contentWindow.document.body.offsetHeight;
	
	//alert( realHeight )
		
	frames[$(theFrame).attr('id')] = realHeight;
							
	$(theFrame).height( realHeight+"px" );
	
	$(theFrame).parent().height( (realHeight*0.8)+"px" );//.zoomer-small
	$(theFrame).parent().next().height( (realHeight*0.8)+"px" )//.zoomer-hoover
	$(theFrame).parent().parent().height( (realHeight*0.8)+"px" );//.zoomer-wrapper

}


var _oldIcon = new Array();


function styleClick(el) {

	theSelector = $(el).attr('data-selector');
	
	$('#editingElement').text( theSelector );
	
	
	//activate first tab
	$('#detailTabs a:first').click();
	
	
	//hide all by default
	$('a#link_Link').parent().hide();
	$('a#img_Link').parent().hide();
	$('a#icon_Link').parent().hide();
	$('a#video_Link').parent().hide();
	
	
	//is the element an ancor tag?
	if( $(el).prop('tagName') == 'A' || $(el).parent().prop('tagName') == 'A' ) {
	
		$('a#link_Link').parent().show();
				
		if( $(el).prop('tagName') == 'A' ) {
				
			theHref = $(el).attr('href');
		
		} else if( $(el).parent().prop('tagName') == 'A' ) {
			
			theHref = $(el).parent().attr('href');
			
		}
		
		zIndex = 0;
		
		pageLink = false;
		
		//the actual select
		
		$('select#internalLinksDropdown').prop('selectedIndex', 0);
		
		$('select#internalLinksDropdown option').each(function(){
				
			if( $(this).attr('value') == theHref ) {
			
				$(this).attr('selected', true);
				
				zIndex = $(this).index();
			
				pageLink = true;
			
			} 
		
		})
		
		
		//the pretty dropdown
		$('.link_Tab .btn-group.select .dropdown-menu li').removeClass('selected');
		
		$('.link_Tab .btn-group.select .dropdown-menu li:eq('+zIndex+')').addClass('selected');
				
		$('.link_Tab .btn-group.select:eq(0) .filter-option').text( $('select#internalLinksDropdown option:selected').text() )
		
		$('.link_Tab .btn-group.select:eq(1) .filter-option').text( $('select#pageLinksDropdown option:selected').text() )
		
		if( pageLink == true ) {
		
			$('input#internalLinksCustom').val('');
		
		} else {
		
			if( $(el).prop('tagName') == 'A' ) {
		
				if( $(el).attr('href')[0] != '#' ) {
					$('input#internalLinksCustom').val( $(el).attr('href') )
				} else {
					$('input#internalLinksCustom').val( '' )
				}
			
			} else if( $(el).parent().prop('tagName') == 'A' ) {
				
				if( $(el).parent().attr('href')[0] != '#' ) {
					$('input#internalLinksCustom').val( $(el).parent().attr('href') )
				} else {
					$('input#internalLinksCustom').val( '' )
				}
				
			}
			
		}
		
		//list available blocks on this page, remove old ones first
		
		$('select#pageLinksDropdown option:not(:first)').remove();
		
		
		$('#pageList ul:visible iframe').each(function(){
			
			if( $(this).contents().find( pageContainer + " > *:first" ).attr('id') != undefined ) {
				
				if( $(el).attr('href') == '#'+$(this).contents().find( pageContainer + " > *:first" ).attr('id') ) {
					
					newOption = '<option selected value=#'+$(this).contents().find( pageContainer + " > *:first" ).attr('id')+'>#'+$(this).contents().find( pageContainer + " > *:first" ).attr('id')+'</option>';
					
				} else {
					
					newOption = '<option value=#'+$(this).contents().find( pageContainer + " > *:first" ).attr('id')+'>#'+$(this).contents().find( pageContainer + " > *:first" ).attr('id')+'</option>';
					
				}
				
				
				
				$('select#pageLinksDropdown').append( newOption );
				
			}
			
		})
		
		//if there aren't any blocks to list, hide the dropdown
				
		if( $('select#pageLinksDropdown option').size() == 1 ) {
			
			$('select#pageLinksDropdown').next().hide();
			$('select#pageLinksDropdown').next().next().hide();
			
		} else {
			
			$('select#pageLinksDropdown').next().show();
			$('select#pageLinksDropdown').next().next().show();
			
		}
		
	
	} 
	
	if( $(el).prop('tagName') == 'IMG' ){
		
		$('a#img_Link').parent().show();
				
		//set the current SRC
		$('.imageFileTab').find('input#imageURL').val( $(el).attr('src') )
		
		
		//reset the file upload
		$('.imageFileTab').find('a.fileinput-exists').click();
		
			
	} 
	
	if( $(el).attr('data-type') == 'video' ) {
	
		$('a#video_Link').parent().show();
		
		$('a#video_Link').click();
				
		//inject current video ID,check if we're dealing with Youtube or Vimeo
		
		if( $(el).prev().attr('src').indexOf("vimeo.com") > -1 ) {//vimeo
			
			match = $(el).prev().attr('src').match(/player\.vimeo\.com\/video\/([0-9]*)/);
			
			//console.log(match);
			
			$('#video_Tab input#vimeoID').val( match[match.length-1] );
			$('#video_Tab input#youtubeID').val('');
			
		} else {//youtube
			
			//temp = $(el).prev().attr('src').split('/');
			
			var regExp = /.*(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;
			var match = $(el).prev().attr('src').match(regExp);
				
			$('#video_Tab input#youtubeID').val( match[1] );
			$('#video_Tab input#vimeoID').val('');
			
		}
		
		
		
		//alert( $(el).prev().attr('src') )
		
		
	} 
	
	if( $(el).hasClass('fa') ) {
	
		$('a#icon_Link').parent().show();
			
		//get icon class name, starting with fa-
		var get = $.grep(el.className.split(" "), function(v, i){
		
			return v.indexOf('fa-') === 0;
			
		}).join();
		
		$('select#icons option').each(function(){
		
			if( $(this).val() == get ) {
			
				$(this).attr('selected', true);
				
				$('#icons').trigger('chosen:updated');
			
			}
		
		})
	
	}
	
	
	//$(el).addClass('builder_active');	
	
	//remove borders from other elements
	$('#pageList ul:visible li iframe').each(function(){
		
		//remove borders		
		
		for( var key in editableItems ) {
		
			$(this).contents().find( pageContainer + ' '+ key ).css({'outline': '', 'cursor': '', 'outline-offset': ''});
			
			$(this).contents().find( pageContainer + ' '+ key ).hover( function(){
									
				if( $(this).closest('body').width() != $(this).width() ) {
											
					$(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});
						
				} else {
							
					$(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});
							
				}
			
			}, function(){
									
				if( $(this).closest('body').width() != ($(this).width()+6) ) {
						
					$(this).css({'outline': '', 'cursor': ''});
						
				} else {
						
					$(this).css({'border': '', 'cursor': '', 'outline-offset': ''});
						
				}
				
			} )
		
		}
		
	});
	
	//unbind event
	$(el).unbind('mouseenter mouseleave');
	
	if( $(el).closest('body').width() != $(el).width() ) {
											
		$(el).css({'outline': '3px dashed red', 'cursor': 'pointer'});
						
	} else {
							
		$(el).css({'outline': '3px dashed red', 'outline-offset':'-3px',  'cursor': 'pointer'});
							
	}
	
	
	
	//remove all style attributes
	
	$('#styleElements > *:not(#styleElTemplate)').each(function(){
	
		$(this).remove();
	
	})
	
	
	//load the attributes
	
	buildeStyleElements(el, theSelector)
	
	
	//show style editor if hidden
	
	if( $('#styleEditor').css('left') == '-300px' ) {
	
		$('#styleEditor').animate({'left': '0px'}, 250);
	
	}
	
	
	//image library
	$('#imageModal').on('show.bs.modal', function (e) {
			
		$('#imageModal').off('click', '.image button.useImage');
			
		$('#imageModal').on('click', '.image button.useImage', function(){
				
			//update live image
			$(el).attr('src', $(this).attr('data-url'))
			
			//update image URL field
			$('input#imageURL').val( $(this).attr('data-url') );
				
			//hide modal
			$('#imageModal').modal('hide');
				
				
			//height adjustment of the iframe heightAdjustment
											
			randomEl = $(el).closest('body').find('*:first');
								
			heightAdjustment(randomEl[0])
				
				
			//we've got pending changes
			setPendingChanges(true);
			
			$(this).unbind('click');
		
		})
		
	})
	
	
	//save button
	$('button#saveStyling').unbind('click').bind('click', function(){
	
		$('#styleEditor #tab1 .form-group:not(#styleElTemplate) input, #styleEditor #tab1 .form-group:not(#styleElTemplate) select').each(function(){
		
			//alert( $(this).attr('name')+":"+$(this).val() )
			
			$(el).css( $(this).attr('name'),  $(this).val())			
		
		})
		
		
		//links
		if( $(el).prop('tagName') == 'A' ) {
			
			//change the href prop?
				
			if( $('select#internalLinksDropdown').val() != '#' ) {
									
				$(el).attr('href', $('select#internalLinksDropdown').val());
				
			} else if( $('select#pageLinksDropdown').val() != '#' ) {
									
				$(el).attr('href', $('select#pageLinksDropdown').val() );
					
			} else if( $('input#internalLinksCustom').val() != '' ) {
								
				$(el).attr('href', $('input#internalLinksCustom').val());
				
			}
			
		}
		
		if( $(el).parent().prop('tagName') == 'A' ) {
			
			//change the href prop?
				
			if( $('select#internalLinksDropdown').val() != '#' ) {
									
				$(el).parent().attr('href', $('select#internalLinksDropdown').val());
				
			} else if( $('select#pageLinksDropdown').val() != '#' ) {
									
				$(el).parent().attr('href', $('select#pageLinksDropdown').val() );
					
			} else if( $('input#internalLinksCustom').val() != '' ) {
								
				$(el).parent().attr('href', $('input#internalLinksCustom').val());
				
			}
			
		}
		
		
		//icons
		
		if( $(el).hasClass('fa') ) {
		
			//out with the old, in with the new :)
			//get icon class name, starting with fa-
			var get = $.grep(el.className.split(" "), function(v, i){
			
				return v.indexOf('fa-') === 0;
				
			}).join();
			
			//if the icons is being changed, save the old one so we can reset it if needed
			
			if( get != $('select#icons').val() ) {
			
				$(el).uniqueId();
			
				_oldIcon[$(el).attr('id')] = get;
				
				//alert( _oldIcon[el] )
							
			}
			
			$(el).removeClass( get ).addClass( $('select#icons').val() )
		
		}
		
		//video URL
		
		if( $(el).attr('data-type') == 'video' ) {
		
			if( $('input#youtubeID').val() != '' ) {
			
				$(el).prev().attr('src', "//www.youtube.com/embed/"+$('#video_Tab input#youtubeID').val());
			
			} else if( $('input#vimeoID').val() != '' ) {
				
				$(el).prev().attr('src', "//player.vimeo.com/video/"+$('#video_Tab input#vimeoID').val()+"?title=0&amp;byline=0&amp;portrait=0");
				
			}
			
		}
				
		
		$('#detailsAppliedMessage').fadeIn(600, function(){
		
			setTimeout(function(){ $('#detailsAppliedMessage').fadeOut(1000) }, 3000)
		
		})
		
		
		//clean up inline stuff
		
		
		//we've got pending changes
		setPendingChanges(true);
	
	});
	
	
	//delete button
	$('button#removeElementButton').unbind('click').bind('click', function(){
	
		if( $(el).prop('tagName') == 'A' ) {//ancor
		
			if( $(el).parent().prop('tagName') == 'LI' ) {//clone the LI
								
				toDel = $(el).parent();
							
			} else {
			
				toDel = $(el);
			
			}
			
		} else if( $(el).prop('tagName') == 'IMG' ) {//image
		
			if( $(el).parent().prop('tagName') == 'A' ) {//clone the A
				
				toDel = $(el).parent();
			
			} else {
			
				toDel = $(el);
			
			}
		
		} else {//everything else
			
			toDel = $(el);
		
		}
		
		$('#styleEditor').on('click', 'button#removeElementButton', function(){
		
			$('#deleteElement').modal('show');
			
			$('#deleteElement button#deleteElementConfirm').unbind('click').bind('click', function(){
			
				toDel.fadeOut(500, function(){
				
					randomEl = $(this).closest('body').find('*:first');
				
					toDel.remove();
										
					heightAdjustment(randomEl[0]);
					
					//we've got pending changes
					setPendingChanges(true)
				
				})
				
				$('#deleteElement').modal('hide');
				
				closeStyleEditor();
			
			})
		
		})
	
	})
	
	
	//clone button
	$('button#cloneElementButton').unbind('click').bind('click', function(){
		
		if( $(el).parent().hasClass('propClone') ) {//clone the parent element
					
			theClone = $(el).parent().clone();
			theClone.find( $(el).prop('tagName') ).attr('style', '');
			
			theOne = theClone.find( $(el).prop('tagName') );
			cloned = $(el).parent();
		
			cloneParent = $(el).parent().parent();
		
		} else {//clone the element itself
		
			theClone = $(el).clone();
			theClone.attr('style', '');
			
			theOne = theClone;
			cloned = $(el);
			
			cloneParent = $(el).parent();
		
		}
				
		cloned.after( theClone );
		
		//theClone.insertAfter( cloned );
		
				
		for( var key in editableItems ) {
								
			$(el).closest('body').find( pageContainer + ' '+ key ).each( function(){
													
				if( $(this)[0] === $(theOne)[0] ) {
													
					theOne.hover( function(){
											
						if( $(this).closest('body').width() != $(this).width() ) {
											
							$(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});
						
						} else {
							
							$(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});
							
						}
					
					}, function(){
											
						if( $(this).closest('body').width() != ($(this).width()+6) ) {
						
							$(this).css({'outline': '', 'cursor': ''});
						
						} else {
						
							$(this).css({'outline': '', 'cursor': '', 'outline-offset': ''});
						
						}
						
					} ).click( function(e){
					
						e.preventDefault();
						
						e.stopPropagation();
					
						styleClick(this, key)
						
					
					} ).each( function(){
					
						$(this).attr('data-selector', key);
					
					} );
				
				}		
			});
		
		}
		
		//possible height adjustments
						
		heightAdjustment(el);
	
	})
	
	
	//reset button
	$('button#resetStyleButton').unbind('click').bind('click', function(){
	
		if( $(el).closest('body').width() != $(el).width() ) {
			
			$(el).attr('style', '').css({'outline': '3px dashed red', 'cursor': 'pointer'})
		
		} else {
			
			$(el).attr('style', '').css({'outline': '3px dashed red', 'outline-offset':'-3px', 'cursor': 'pointer'})
			
		}
		
		$('#styleEditor form#stylingForm').height( $('#styleEditor form#stylingForm').height()+"px" );
		
		$('#styleEditor form#stylingForm .form-group:not(#styleElTemplate)').fadeOut(500, function(){
		
			$(this).remove()
		
		})
		
		//reset icon
		
		if( _oldIcon[$(el).attr('id')] != null ) {
		
			var get = $.grep(el.className.split(" "), function(v, i){
			
				return v.indexOf('fa-') === 0;
				
			}).join();
			
			$(el).removeClass( get ).addClass( _oldIcon[$(el).attr('id')] );
			
			$('select#icons option').each(function(){
			
				if( $(this).val() == _oldIcon[$(el).attr('id')] ) {
				
					$(this).attr('selected', true);
					
					$('#icons').trigger('chosen:updated');
									
				}
			
			})
		
		}
		
		setTimeout( function(){buildeStyleElements(el, theSelector)}, 550)
		
	})
	
	
	

}


function closeStyleEditor() {
	
	//only if visible
		
	if( $('#styleEditor').css('left') == '0px' ) {

		$('#styleEditor').animate({'left': '-300px'}, 250);
	
		$('#pageList ul li iframe').each(function(){
		
			//remove hover events used by Styling modus			
		
			for( var key in editableItems ) {
		
				$(this).contents().find( pageContainer + ' '+ key ).unbind('mouseenter mouseleave click').css({'outline': '', 'cursor': '', 'outline-offset': ''});
		
			}
			
		
			if ( $('input:radio[name=mode]:checked').val() == 'styling' ) {
			
				$('#pageList ul li iframe').each(function(){
			
					for( var key in editableItems ) {
				
						$(this).contents().find( pageContainer + ' '+ key ).hover( function(){
											
							if( $(this).closest('body').width() != $(this).width() ) {
							
								$(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});
							
							} else {
							
								$(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});
							
							}
					
						}, function(){
											
							if( $(this).closest('body').width() != ($(this).width()+6) ) {
						
								$(this).css({'outline': '', 'cursor': ''});
						
							} else {
						
								$(this).css({'outline': '', 'cursor': '', 'outline-offset': ''});
						
							}
						
						} ).click( function(e){
					
							e.preventDefault();
							
							e.stopPropagation();
						
							styleClick(this, key)
						
						} );
				
					}				
			
				})
		
			}
				
		})
	
	}

}

var pendingChanges = false;

function setPendingChanges(v) {

	if( v == true ) {
				
		$('#savePage .bLabel').text("Save pending changes (!)");
		
		pendingChanges = true;
	
	} else {
	
		$('#savePage .bLabel').text("Save");
		
		pendingChanges = false;
	
	}

}

$(function(){
	
	
	//video ID toggle
	
	$('input#youtubeID').focus(function(){
			
		$('input#vimeoID').val('');
		
	})
	
	$('input#vimeoID').focus(function(){
		
		$('input#youtubeID').val('');
		
	})
	

	//chosen font-awesome dropdown
	
	$('select#icons').chosen({
		'search_contains': true
	});

	//detect mode
	if( window.location.protocol == 'file:' ) {
	
		_mode = "local";
	
	} else {
	
		_mode = "server";
	
	}
		
	//check if formData is supported
	if (!window.FormData){
		
		//not supported, hide file upload
		$('form#imageUploadForm').hide();
		
		$('#imageModal #uploadTabLI').hide();
	
	}
	

	//internal links dropdown
	
	$('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
	$('select#internalLinksDropdown').change(function(){
		
		$('select#pageLinksDropdown option').attr('selected', false);
		
		$('.link_Tab .btn-group.select:eq(1) .dropdown-menu li').removeClass('selected');
		
		$('.link_Tab .btn-group.select:eq(1) > button .filter-option').text( $('.link_Tab .btn-group.select:eq(1) .dropdown-menu li:first').text() )
		
	})
	
	$('select#pageLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
	
	$('select#pageLinksDropdown').change(function(){
		
		$('select#internalLinksDropdown option').attr('selected', false);
		
		$('.link_Tab .btn-group.select:eq(0) .dropdown-menu li').removeClass('selected');
		
		$('.link_Tab .btn-group.select:eq(0) > button .filter-option').text( $('.link_Tab .btn-group.select:eq(0) .dropdown-menu li:first').text() )
		
	})

	
	$('input#internalLinksCustom').focus(function(){
	
		$('select#internalLinksDropdown option').attr('selected', false);
		
		$('.link_Tab .dropdown-menu li').removeClass('selected');
		
		$('.link_Tab .btn-group.select > button .filter-option').text( $('.link_Tab .dropdown-menu li:first').text() )
		
		this.select();
	
	})
	
	
	$('#detailsAppliedMessageHide').click(function(){
	
		$(this).parent().fadeOut(500)
	
	})


	//hide style editor option?
	
	if( typeof editableItems === 'undefined' ) {
	
		$('#modeStyle').parent().remove();
	
	}
	
	$('#closeStyling').click(function(){
	
		closeStyleEditor();
	
	})


	$('#styleEditor form').on("focus", "input", function(){
	
		$(this).css('position', 'absolute');
		$(this).css('right', '0px')
		
		$(this).animate({'width': '100%'}, 500);
		
		$(this).focus(function(){
		    this.select();
		});
	
	}).on("blur", "input", function(){
		
		$(this).animate({'width': '42%'}, 500, function(){
		
			$(this).css('position', 'relative');
			$(this).css('right', 'auto');
		
		})
	
	})
            	
	/*$('#toggle').click(function(){
	
		//change icon
		$(this).find('span').removeClass('fui-gear').addClass('fui-cross');
	
		if( $('#main').width() == 0 ) {//slide out
		
			$('#main').animate({
				width: mainMenuWidth
			}, 500);
			
			$('body').animate({
				paddingLeft: mainMenuWidth
			}, 500, function(){
		    			
				zoomm();
				    			
			});
		
		} else {//slide in
		
			$(this).find('span').removeClass('fui-cross').addClass('fui-gear');
		
			$('#main').animate({
				width: 0
			}, 500);
			
			$('body').animate({
				paddingLeft: 0
			}, 500, function(){
			    				
				var screenWidth = $('#screen').width();
				
				$('#pageList li').each(function(){
					
					$(this).find('.zoomer-wrapper').width( screenWidth );
					$(this).find('.zoomer-wrapper > *').width( screenWidth );
					
					$(this).find('.zoomer-wrapper iframe').width( screenWidth );
					
					$(this).find('.zoomer-wrapper iframe').contents().find('html').css('transform', 'none');
				
				});
					    			
			});
		
		}
	
	});*/
	
	
	
	
		
		
	for( var key in _Elements.elements ) {
					
		niceKey = key.toLowerCase().replace(" ", "_");
		
		$('<li><a href="" id="'+niceKey+'">'+key+'</a></li>').appendTo('#menu #main ul#elements');
			
		for( x=0; x<_Elements.elements[key].length; x++ ) {
			
			//alert( data.elements[key][x].url )
			
			
			if( _Elements.elements[key][x].thumbnail == null ) {//we'll need an iframe
						
				//build us some iframes!
			
				if( _Elements.elements[key][x].sandbox != null ) {
			
					newItem = $('<li class="element '+niceKey+'"><iframe src="'+elementUrl+_Elements.elements[key][x].url+'" scrolling="no" sandbox="allow-same-origin"></iframe></li>');
			
				} else {
				
					newItem = $('<li class="element '+niceKey+'"><iframe src="about:blank" scrolling="no"></iframe></li>');
			
				}
				
				newItem.find('iframe').uniqueId();
				
				newItem.find('iframe').attr('src', elementUrl+_Elements.elements[key][x].url);
			
			} else {//we've got a thumbnail
			
				newItem = $('<li class="element '+niceKey+'"><img src="'+elementUrl+_Elements.elements[key][x].thumbnail+'" data-src="'+elementUrl+_Elements.elements[key][x].url+'" data-height="'+_Elements.elements[key][x].height+'"></li>')
			
			}
			
			
							
			newItem.appendTo('#menu #second ul');
			
			
			
			//dynamic magin
			
			/*var iFrame = document.getElementById( frameID );
			
			var doc = iFrame.contentWindow.document;
			
			doc.open().write('<body onload="setTimeout(location.href=\'http:\/\/chillyorange.com\', 3000)">');
			doc.close();*/
			
				
			//zoomer works
				
			if( _Elements.elements[key][x].height ) {
				
				theHeight = _Elements.elements[key][x].height*0.25;
				
			} else {
				
				theHeight = 'auto'
				
			}
				
			newItem.find('iframe').zoomer({
				zoom: 0.25,
				width: 270,
				height: theHeight,
				message: "Drag&Drop Me!"
			});
			
		}
			
		//draggables
		makeDraggable( '#page1' )
	
	}
		
		//import element data
		/*
		var theElements;
		$.getJSON('elements.json',function(data){
		
			theElements = data.elements;
			
			for( var key in data.elements ) {
						
				niceKey = key.toLowerCase().replace(" ", "_");
			
				$('<li><a href="" id="'+niceKey+'">'+key+'</a></li>').appendTo('#menu #main ul#elements');
				
				for( x=0; x<data.elements[key].length; x++ ) {
				
					//alert( data.elements[key][x].url )
					
					//build us some iframes!
					
					newItem = $('<li class="element '+niceKey+'"><iframe src="'+data.elements[key][x].url+'" scrolling="no"></iframe></li>');
					
					newItem.appendTo('#menu #second ul');
					
					//zoomer works
					
					if( data.elements[key][x].height ) {
					
						theHeight = data.elements[key][x].height*0.25;
					
					} else {
					
						theHeight = 'auto'
					
					}
					
					newItem.find('iframe').zoomer({
					    zoom: 0.25,
					    width: 270,
					    height: theHeight,
					    message: "Drag&Drop Me!"
					});
				
				}
				
				//draggables
				makeDraggable( '#page1' )
			
			}   
			
			
		}).error(function(){
			Alert('Please double check the formatting of your JSON file.')
			console.log('error');
		});*/
		
		//use function call to make the ULs sortable
		makeSortable( $('#pageList ul#page1') );
		
	//second menu animation		
	$('#menu #main #elements').on('click', 'a:not(.btn)', function(){
	
		$('#menu #main a').removeClass('active');
		$(this).addClass('active');
	
		//show only the right elements
		$('#menu #second ul li').hide();
		$('#menu #second ul li.'+$(this).attr('id')).show();
		
		if( $(this).attr('id') == 'all' ) {
		
			$('#menu #second ul li').show();
		
		}
	
		$('.menu .second').css('display', 'block').stop().animate({
			width: secondMenuWidth
		}, 500);	
		
	
	})
	
	
	
	$('#menu #main').on('click', 'a:not(.actionButtons)', function(e){
	
		e.preventDefault();
	
	})

	$('#menu').mouseleave(function(){
	
		$('#menu #main a').removeClass('active');

		$('.menu .second').stop().animate({
			width: 0
		}, 500, function(){
		
			$('#menu #second').hide();
		
		});

	});
	
	
	//disable on load
	$('input:radio[name=mode]').parent().addClass('disabled');
	$('input:radio[name=mode]#modeBlock').radio('check');
	
	
	var elToUpdate;
	
	
	//design mode toggle
	$('input:radio[name=mode]').on('toggle', function(){
	
		if( $(this).val() == 'content' ) {
		
			
			//close style editor
			closeStyleEditor();
		
			//hide all iframe covers and activate designMode
			
			$('#pageList ul .zoomer-wrapper .zoomer-cover').each(function(){
			
				$(this).hide();
			
			})
			
			
			$('#pageList ul li iframe').each(function(){
			
				
				//remove old click events
			
				for( var key in editableItems ) {
								
					$(this).contents().find( pageContainer + ' '+ key ).unbind('hover').unbind('click');
				
				}				
			
			})
			
			
			//active content edit mode
			$('#pageList ul li iframe').each(function(){
			
				
				for (i=0; i<editableContent.length; ++i) {
					
					//remove old events
					$(this).contents().find( pageContainer + ' '+editableContent[i] ).unbind('click').unbind('hover');
					
					
					$(this).contents().find( pageContainer + ' '+editableContent[i] ).hover( function(){
											
						$(this).css({'outline': '3px dashed red', 'cursor': 'pointer'})
					
					}, function(){
											
						$(this).css({'outline': '', 'cursor': ''})
						
					} ).click( function(e){
				
						elToUpdate = $(this);
					
						e.preventDefault();
						
						e.stopPropagation();
										
						$('#editContentModal #contentToEdit').val( $(this).html() )
					
						$('#editContentModal').modal('show');
						
						//for the elements below, we'll use a simplyfied editor, only direct text can be done through this one
						if( this.tagName == 'SMALL' || this.tagName == 'A' || this.tagName == 'LI' || this.tagName == 'SPAN' || this.tagName == 'B' || this.tagName == 'I' || this.tagName == 'TT' || this.tageName == 'CODE' || this.tagName == 'EM' || this.tagName == 'STRONG' || this.tagName == 'SUB' || this.tagName == 'BUTTON' || this.tagName == 'LABEL' || this.tagName == 'P' || this.tagName == 'H1' || this.tagName == 'H2' || this.tagName == 'H2' || this.tagName == 'H3' || this.tagName == 'H4' || this.tagName == 'H5' || this.tagName == 'H6' ) {
							
							$('#editContentModal #contentToEdit').redactor({
								buttons: ['html', 'bold', 'italic', 'deleted'],
								focus: true,
								plugins: ['bufferbuttons'],
								buttonSource: true,
								paragraphize: false,
								linebreaks: true
							});
							
						} else if( this.tagName == 'DIV' && $(this).hasClass('tableWrapper') ) {
							
							$('#editContentModal #contentToEdit').redactor({
								buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'table', 'image', 'link', 'alignment'],
								focus: true,
								plugins: ['table', 'bufferbuttons'],
								buttonSource: true,
								paragraphize: false,
								linebreaks: false
							});
							
						} else {
					
							$('#editContentModal #contentToEdit').redactor({
								buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'image', 'file', 'link', 'alignment', 'horizontalrule'],
								focus: true,
								buttonSource: true,
								paragraphize: false,
								linebreaks: false
							});
						}
						
						
						/*if( $('#editContentModal #contentToEdit').redactor('utils.isBlock', this) ) {
							
							alert('block')
							
						} else {
							
							alert('inline')
							
						}*/
						
					
					} ).each( function(){
					
						$(this).attr('data-selector', key)
					
					} );
					
				}
							
			})
			
			
		
		} else if( $(this).val() == 'block' ) {
		
			//close style editor
			closeStyleEditor();
		
			//show all iframe covers and activate designMode
			
			$('#pageList ul .zoomer-wrapper .zoomer-cover').each(function(){
			
				$(this).show();
			
			})
			
			//deactivate designmode
			
			$('#pageList ul li iframe').each(function(){
			
				
				for( var key in editableItems ) {
				
					$(this).contents().find( pageContainer + ' '+ key ).unbind('mouseenter mouseleave');
				
				}
			
				this.contentDocument.designMode = "off";
			
			})
		
		} else if( $(this).val() == 'styling' ) {
		
			//hide all iframe covers and activate designMode
			
			$('#pageList ul .zoomer-wrapper .zoomer-cover').each(function(){
			
				$(this).hide();
			
			});
			
			
			//remove contentEditable hovers and clicks
			$('#pageList ul li iframe').each(function(){
			
				for (i=0; i<editableContent.length; ++i) {
				
					$(this).contents().find( pageContainer + ' '+editableContent[i] ).unbind('click').unbind('hover');
				
				}
			
			});
			
			
			
			//active styling mode
			$('#pageList ul li iframe').each(function(){
			
				for( var key in editableItems ) {
								
					$(this).contents().find( pageContainer + ' '+ key ).hover( function(){
											
						if( $(this).closest('body').width() != $(this).width() ) {
											
							$(this).css({'outline': '3px dashed red', 'cursor': 'pointer'});
						
						} else {
							
							$(this).css({'outline': '3px dashed red', 'outline-offset': '-3px', 'cursor': 'pointer'});
							
						}
					
					}, function(){
											
						$(this).css({'outline': '', 'cursor': '', 'outline-offset': ''})
						
					} ).click( function(e){
					
						e.preventDefault();
						
						e.stopPropagation();
					
						styleClick(this, key)
						
					
					} ).each( function(){
					
						$(this).attr('data-selector', key)
					
					} );
				
				}				
			
			})
		
		}
	
	});
	
	
	$('button#updateContentInFrameSubmit').click(function(){
		
		//alert( elToUpdate.text() )
		
		elToUpdate.html( $('#editContentModal #contentToEdit').redactor('code.get') ).css({'outline': '', 'cursor':''})
				
		$('#editContentModal textarea').each(function(){
			
			$(this).redactor('core.destroy');
			$(this).val('');
			
		});
		
		$('#editContentModal').modal('hide');
		
		$(this).closest('body').removeClass('modal-open');
		
		//element was deleted, so we've got pending changes
		setPendingChanges(true)
				
	})
	
	
	//close styleEditor
	$('#styleEditor > a.close').click(function(e){
	
		e.preventDefault();
		
		closeStyleEditor();
	
	})
	
	
	//delete blocks from window
	
	var blockToDelete;
	
	$('#pageList').on("click", ".zoomer-cover > .deleteBlock", function(){
	
		$('#deleteBlock').modal('show');
		
		blockToDelete = $(this).closest('li');
	
		$('#deleteBlock').off('click', '#deleteBlockConfirm').on('click', '#deleteBlockConfirm', function(){
		
			$('#deleteBlock').modal('hide');
		
			blockToDelete.fadeOut(500, function(){
			
				$(this).remove();
				
				pageEmpty();
				
				allEmpty();
				
				//element was deleted, so we've got pending changes
				setPendingChanges(true)
			
			})
		
		})
	
	});
	
	
	//reset block
	$('#pageList').on("click", ".zoomer-cover > .resetBlock", function(){
		
		$('#resetBlock').modal('show');
		
		frameToReset = $(this).closest('li').find('iframe');
			
		$('#resetBlock').off('click', '#resetBlockConfirm').on('click', '#resetBlockConfirm', function(){
		
			$('#resetBlock').modal('hide');
		
			frameToReset.zoomer('refresh');
			
			//element was reset, so we've got pending changes
			setPendingChanges(true)
		
		})
				
	
	});
	
	
	var aceEditors = new Array();//store all ace editors
	
	
	//block source code
	$('#pageList').on("click", ".zoomer-cover > .htmlBlock", function(){
		
		//hide the iframe
		$(this).closest('.zoomer-wrapper').find('.zoomer-small iframe').hide();
		
		
		//disable draggable on the LI
		$(this).closest('li').parent().sortable('disable');
				
				
		//built editor element
		theEditor = $('<div class="aceEditor"></div>');
		theEditor.uniqueId();
		
		$(this).closest('li').append( theEditor );
		
		theId = theEditor.attr('id');
		
		var editor = ace.edit( theId );
		editor.setValue( $(this).closest('.zoomer-wrapper').find('.zoomer-small iframe').contents().find( pageContainer ).html() );
		editor.setTheme("ace/theme/twilight");
		editor.getSession().setMode("ace/mode/html");
		
		//buttons
		
		cancelButton = $('<button type="button" class="btn btn-danger editCancelButton btn-wide"><span class="fui-cross"></span> Cancel</button>');
		saveButton = $('<button type="button" class="btn btn-primary editSaveButton btn-wide"><span class="fui-check"></span> Save</button>');
	
		buttonWrapper = $('<div class="editorButtons"></div>');
		buttonWrapper.append( cancelButton );
		buttonWrapper.append( saveButton );
		
		$(this).closest('li').append( buttonWrapper );
		
		aceEditors[ theId ] = editor;
		
	});
	
	
	$('#pageList').on("click", "li .editorButtons .editCancelButton", function(){
		
		//theId = $(this).closest('.editorButtons').prev().attr('id');
		
		//enable draggable on the LI
		$(this).closest('li').parent().sortable('enable');
		
		$(this).parent().prev().remove();
		
		$(this).parent().prev().find('.zoomer-small iframe').fadeIn(500);
		
		$(this).parent().fadeOut(500, function(){
			
			$(this).remove();
			
		})
						
	});
	
	
	$('#pageList').on("click", "li .editorButtons .editSaveButton", function(){
		
		//enable draggable on the LI
		$(this).closest('li').parent().sortable('enable');
		
		
		theId = $(this).closest('.editorButtons').prev().attr('id');
		
		theContent = aceEditors[theId].getValue();
		
		theiFrame = $(this).parent().prev().find('.zoomer-small iframe');
						
		
		$(this).parent().prev().remove();
		
		$(this).parent().prev().find('.zoomer-small iframe').show().contents().find( pageContainer ).html( theContent );
		
		//theiFrame.contents().find( pageContainer ).html( theContent );
		
		$(this).parent().fadeOut(500, function(){
			
			$(this).remove();
			
		})
		
		//new page added, we've got pending changes
		setPendingChanges(true)
						
	});
	
	
	//export markup
	
	$('#exportModal').on('show.bs.modal', function (e) {
	
		$('#exportModal > form #exportSubmit').show('');
		
		$('#exportModal > form #exportCancel').text('Cancel & Close');
		
		closeStyleEditor();
	
	});
	
	$('#exportModal').on('shown.bs.modal', function (e) {
		
		//delete older hidden fields
		
		$('#exportModal form input[type="hidden"].pages').remove();
		
		//loop through all pages
		$('#pageList > ul').each(function(){
				
			//grab the skeleton markup
							
			newDocMainParent = $('iframe#skeleton').contents().find( pageContainer );
			
			//empty out the skeleton
			newDocMainParent.find('*').remove();
			
			//loop through page iframes and grab the body stuff
				
			$(this).find('iframe').each(function(){
				
				//remove .frameCovers
										
				theContents = $(this).contents().find( pageContainer );
					
				theContents.find('.frameCover').each(function(){
					$(this).remove();
				})
					
					
				toAdd = theContents.html();
				
				
				//grab scripts
				
				scripts = $(this).contents().find( pageContainer ).find('script');
				
				if( scripts.size() > 0 ) {
				
					theIframe = document.getElementById("skeleton");
				
					scripts.each(function(){
					
						if( $(this).text() != '' ) {//script tags with content
						
							var script = theIframe.contentWindow.document.createElement("script");
							script.type = 'text/javascript';
							script.innerHTML = $(this).text();
						
							theIframe.contentWindow.document.getElementById( pageContainer.substring(1) ).appendChild(script);
							
						} else if( $(this).attr('src') != null ) {
						
							var script = theIframe.contentWindow.document.createElement("script");
							script.type = 'text/javascript';
							script.src = $(this).attr('src');
							
							theIframe.contentWindow.document.getElementById( pageContainer.substring(1) ).appendChild(script)
						
						}
				
					})
				
				}
				
				newDocMainParent.append( $(toAdd) );
				
			});
			
			//theStyle = $('<style>body{width:100%}</style>');
			
			//$('iframe#skeleton').contents().find('head').append( $('<style>body{width:100%}</style>') )
			
			//create the hidden input
			
			//alert( $('#pages li:eq('+$(this).index()+1+') a:first').text() )
			
			newInput = $('<input type="hidden" name="pages['+$('#pages li:eq('+($(this).index()+1)+') a:first').text()+']" class="pages" value="">');
			
			$('#exportModal form').prepend( newInput );
			
			newInput.val( "<html>"+$('iframe#skeleton').contents().find('html').html()+"</html>" )
		
		})
				
	});
	
	
	
	$('#exportModal > form').submit(function(){
	
		$('#exportModal > form #exportSubmit').hide('');
		
		$('#exportModal > form #exportCancel').text('Close Window');
	
	})
	
	
	//page menu buttons
	
	//add page
	
	$('#pages').on('blur', 'li > input', function(){
	
		if( $(this).parent().find('a.plink').size() == 0 ) {
		
			if( $("#pages li > a:contains('"+$(this).val()+"')").size() == 0 || $(this).val() == '' ) {
								
				theLink = $('<a href="#'+$(this).val()+'" class="plink">'+$(this).val()+'</a>');
		
				$(this).hide();
		
				$(this).closest('li').prepend( theLink );
		
				$(this).closest('li').removeClass('edit');
				
				//alert( $(this).parent().index() )
			
			
				//update the page dropdown
			
				$('#internalLinksDropdown option:eq('+$(this).parent().index()+')').text( $(this).val() ).attr('value', $(this).val()+".html");
				
				$('#internalLinksDropdown').next().find('ul.dropdown-menu li:eq('+$(this).parent().index()+') a span.pull-left').text($(this).val());
			
				//$('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
			
				//alert( ($(this).parent().index())+" : "+$(this).val() )
			
		
				$(this).remove();
			
			} else {
				
				$(this).val( 'page'+($('#pages li').size()-1) ).focus();
				
				$('#pageTitle span span').text( 'page'+($('#pages li').size()-1) )
				
				alert('Please make sure your new page has a unique name.')
			
			}
		
		}
	
	})
	
	$('#addPage').click(function(e){
	
		e.preventDefault();
		
		//turn inputs into links
		$('#pages li.active').each(function(){
		
			if( $(this).find('input').size() > 0 ) {
							
				theLink = $('<a href="#">'+$(this).find('input').val()+'</a>');
				
				$(this).find('input').remove();
				
				$(this).prepend( theLink );
				
			}
			
		})
		
		$('#pages li').removeClass('active');
		
		newPageLI = $('#newPageLI').clone();
		newPageLI.css('display', 'block');
		newPageLI.find('input').val( 'page'+$('#pages li').size() );
		newPageLI.attr('id', '');
		
		$('ul#pages').append( newPageLI );
		
		
		theInput = newPageLI.find('input');
		
		theInput.focus();
		
		var tmpStr = theInput.val();
		theInput.val('');
		theInput.val(tmpStr);
		
		theInput.keyup( function(){
		
			$('#pageTitle span span').text( $(this).val() )
		
		} )
		
		newPageLI.addClass('active').addClass('edit');
					
		
		//create the page structure
		
		newPageList = $('<ul></ul>');
		newPageList.css('display','block');
		newPageList.attr('id', 'page'+($('#pages li').size()-1) );
		
		$('#pageList > ul').hide();
		$('#pageList').append( newPageList );
		
		
		makeSortable( newPageList );
		
		//draggables
		makeDraggable( '#'+'page'+($('#pages li').size()-1) )
		
		
		//alter page title
		$('#pageTitle span span').text( 'page'+($('#pages li').size()-1) );
		
		$('#frameWrapper').addClass('empty')
		$('#start').fadeIn();
		
		
		//add page to page dropdown
		
		newItem = $('<option value="'+'page'+($('#pages li').size()-1)+'.html">'+'page'+($('#pages li').size()-1)+'</option>')
		
		$('#internalLinksDropdown').append( newItem );
		
		$('select#internalLinksDropdown').selectpicker({style: 'btn-sm btn-default', menuStyle: 'dropdown-inverse'});
		
		
		//update heading in pageSettingsModal
		$('#pageSettingsModal h4.modal-title .pName').text( 'page'+($('#pages li').size()-1) )
		
		//update other pageSettingsModal stuff
							
		$('#pageSettingsModal input#pageID').val( '' )
		
		$('#pageSettingsModal input#pageName').val( 'page'+($('#pages li').size()-1) )
			
		$('#pageSettingsModal input#pageData_title').val( '' )
		
		$('#pageSettingsModal textarea#pageData_metaKeywords').val( '' )
					
		$('#pageSettingsModal textarea#pageData_metaDescription').val( '' )
					
		$('#pageSettingsModal textarea#pageData_headerIncludes').val( '' )
				
		
		//new page added, we've got pending changes
		setPendingChanges(true)
		
	})
	
	
	$('#pages').on('click', 'li:not(.active)', function(){
		
		$('#pageList > ul').hide();
		
		$('#pageList > ul:eq('+($(this).index()-1)+')').show();
		
		pageEmpty();
		
		//draggables
		makeDraggable( '#'+'page'+($(this).index()) )
	
		$('#pages li').removeClass('active').removeClass('edit');
		
		$(this).addClass('active');
		
		$('#pageTitle span span').text( $(this).find('a').text() );
		
		
		//page meta data
		
		$('#pageSettingsModal h4.modal-title .pName').text( $(this).find('a').text() )
		
		if (typeof pagesData === 'undefined') {
		    // variable is undefined
		} else {
		
			if( typeof pagesData[$(this).find('a').text()] !== 'undefined' ) {
			
				$('#pageSettingsModal input#pageID').val( pagesData[$(this).find('a').text()].pages_id )
			
			} else {
				
				$('#pageSettingsModal input#pageID').val( '' )
				
			}
			
			if( typeof pagesData[$(this).find('a').text()] !== 'undefined' ) {
			
				$('#pageSettingsModal input#pageData_title').val( pagesData[$(this).find('a').text()].pages_title )
			
			} else {
				
				$('#pageSettingsModal input#pageData_title').val( '' )
				
			}
			
			if( typeof pagesData[$(this).find('a').text()] !== 'undefined' ) {
						
				$('#pageSettingsModal textarea#pageData_metaKeywords').val( pagesData[$(this).find('a').text()].pages_meta_keywords )
			
			} else {
				
				$('#pageSettingsModal textarea#pageData_metaKeywords').val( '' )
				
			}
			
			if( typeof pagesData[$(this).find('a').text()] !== 'undefined' ) {
			
				$('#pageSettingsModal textarea#pageData_metaDescription').val( pagesData[$(this).find('a').text()].pages_meta_description )
			
			} else {
				
				$('#pageSettingsModal textarea#pageData_metaDescription').val( '' )
				
			}
			
			if( typeof pagesData[$(this).find('a').text()] !== 'undefined' ) {
			
				$('#pageSettingsModal textarea#pageData_headerIncludes').val( pagesData[$(this).find('a').text()].pages_header_includes )
			
			} else {
				
				$('#pageSettingsModal textarea#pageData_headerIncludes').val( '' )
				
			}
		
		}
	
	})
	
	
	$('#pages').on('click', 'li.active .fileSave', function(){
	
		//do something
				
		theLI = $(this).closest('li');
		
		//make sure the new page name is unique 
		
		if( $("#pages li > a:contains('"+theLI.find('input').val()+"')").size() == 0 ) {
								
		if( theLI.find('input').size() > 0 ) {
					
			theLink = $('<a href="#'+theLI.find('input').val()+'">'+theLI.find('input').val()+'</a>');
			
			theLI.find('input').remove();
			
			theLI.prepend( theLink );
			
		}
		
		$('#pages li').removeClass('edit');
		
		} else {
		
			alert('Please sure your new page has a unique name')
		
		}
	
	});
	
	
	//edit page button
	
	$('#pages').on('click', 'li.active .fileEdit', function(){
	
		
		theLI = $(this).closest('li');
	
		newInput = $('<input type="text" value="'+theLI.find('a:first').text()+'" name="page">');
		
		theLI.find('a:first').remove();
		
		theLI.prepend( newInput );
		
		newInput.focus();
		
		var tmpStr = newInput.val();
		newInput.val('');
		newInput.val(tmpStr);
		
		newInput.keyup( function(){
		
			$('#pageTitle span span').text( $(this).val() )
		
		} )
		
		theLI.addClass('edit');
		
		
		//changed page title, we've got pending changes
		setPendingChanges(true);
	
	})
	
	var theLIIndex;
	
	//delete page button
	$('#pages').on('click', 'li.active .fileDel', function(){
	
		theLIIndex = $(this).parent().parent().index();
	
		$('#deletePage').modal('show');
		
		$('#deletePageCancel').unbind('click').click(function(){
		
			$('#deletePage').modal('hide');
		
		})
		
		$('#deletePage').off('click').on('click', '#deletePageConfirm', function(){
		
			$('#deletePage').modal('hide');
		
			$('#pages li:eq('+theLIIndex+')').remove();
			
			$('#pageList ul:visible').remove();
			
			
			//update the page dropdown list
			
			$('select#internalLinksDropdown option:eq('+theLIIndex+')').remove();
			
			$('.link_Tab .dropdown-menu li:eq('+theLIIndex+')').remove();
			
			
			//activate the first page
			
			$('#pages li:eq(1)').addClass('active');
			
			$('#pageList ul:first').show();
			
			$('#pageTitle span span').text( $('#pages li:eq(1)').find('a:first').text() )
			
			
			//draggables
			makeDraggable( '#'+'page1' )
			
			
			//show the start block?
			
			pageEmpty();
			
			allEmpty();
			
			
			//page was deleted, so we've got pending changes
			setPendingChanges(true);
			
		
		})
	
	})
	
	
	
	//save new site
	$('a#savePage').click(function(){
	
		//close styleEditor
		closeStyleEditor();
	
		//disable button
		$("a#savePage").addClass('disabled');
		
		
		//remove old alerts
		$('#errorModal .modal-body > *, #successModal .modal-body > *').each(function(){
			$(this).remove();
		})
		
		thePages = prepPagesforSave();
		
		if( typeof pagesData !== 'undefined' ) {
				
			theData = {pageData: thePages, siteName: $('#siteTitle').text(), siteID: siteID, pagesData: pagesData};
		
		} else {
		
			theData = {pageData: thePages, siteName: $('#siteTitle').text(), siteID: siteID};
		
		}
	
		
		$.ajax({
			url: siteUrl+"sites/save",
			type: "POST",
			dataType: "json",
			data: theData,
		}).done(function(res){
		
			//enable button
			$("a#savePage").removeClass('disabled');
		
			if( res.responseCode == 0 ) {
			
				$('#errorModal .modal-body').append( $(res.responseHTML) );
				
				$('#errorModal').modal('show');
			
			} else if( res.responseCode == 1 ) {
			
				$('#successModal .modal-body').append( $(res.responseHTML) );
				
				$('#successModal').modal('show');
				
				siteID = res.siteID;
				
				//no more pending changes
				setPendingChanges(false)
			
			}
		
		})
	
	})
	
	
	//site name input field
	/*$('button#saveSiteSettingsButton').click(function(){
	
		$('#siteTitle').text( $('#siteNameInput').val() )
		
		setPendingChanges(true);
		
		
		//hide modal
		$('#siteSettings').modal('hide')
	
	})*/
	
	
	//back button
	$('a#backButton').click(function(e){
	
		if( pendingChanges == true ) {
		
			$('#backModal').modal('show');
			
			return false;
		
		}
			
	})
	
	$('#leavePageButton').click(function(){
		
		pendingChanges = false;//prevent the JS alert after confirming user wants to leave
	
	})
	
	$(window).bind('beforeunload', function(){
		
		if( pendingChanges == true ) {
		
			return 'Your site contains changed which haven\'t been saved yet. Are you sure you want to leave?';
			
		}
	
	});
	
	
	
	/*
		
		site publishing
	
	*/

	//publish modal
	$('#publishPage').click(function(e){
	
		e.preventDefault();
	
		
		if( publishActive == 0 ) {//check if we're currently publishing anything
		
		
			//hide alerts
			$('#publishModal .modal-alerts > *').each(function(){
				$(this).remove();
			})
		
		
			$('#publishModal .modal-body > .alert-success').hide();
		
		
			//hide loaders
			$('#publishModal_assets .publishing').each(function(){
		
				$(this).hide();
				$(this).find('.working').show();
				$(this).find('.done').hide();
		
			})
		
			//remove published class from asset checkboxes
			$('#publishModal_assets input').each(function(){
				$(this).removeClass('published');
			})
		
			//do we have pending changes?
		
			if( pendingChanges == true ) {//we've got changes, save first
			
				$('#publishModal #publishPendingChangesMessage').show();
				$('#publishModal .modal-body-content').hide();
		
			} else {//all set, get on it with publishing
		
				//get the correct pages in the Pages section of the publish modal
			
				$('#publishModal_pages tbody > *').remove();
			
				$('#pages li:visible').each(function(){
			
					thePage = $(this).find('a:first').text();
				
					theRow = $('<tr><td class="text-center" style="width: 0px;"><label class="checkbox"><input type="checkbox" value="'+thePage+'" id="" data-type="page" name="pages[]" data-toggle="checkbox"></label></td><td>'+thePage+'<span class="publishing"><span class="working">Publishing... <img src="'+baseUrl+'images/publishLoader.gif"></span><span class="done text-primary">Published &nbsp;<span class="fui-check"></span></span></span></td></tr>')
								
					//checkboxify
					theRow.find('input').checkbox();
				
					theRow.find('input').on('check uncheck toggle', function(){
				
						$(this).closest('tr')[$(this).prop('checked') ? 'addClass' : 'removeClass']('selected-row');
				
					})
				
					$('#publishModal_pages tbody').append( theRow )
				
				})
				
		
				$('#publishModal #publishPendingChangesMessage').hide();
				$('#publishModal .modal-body-content').show();
		
			}
				
		}
		
		
		//enable/disable publish button
		activateButton = false;
		
		$('#publishModal input[type=checkbox]').each(function(){
			
			if( $(this).prop('checked') ) {
								
				activateButton = true;
					
				return false;
				
			}
				
		})
			
		if( activateButton ) {
			
			$('#publishSubmit').removeClass('disabled');
			
		} else {
			
			$('#publishSubmit').addClass('disabled');
			
		}
		
		$('#publishModal').modal('show');		
	
	});
	
	
	
	//save site before publishing
	$('#publishModal #publishPendingChangesMessage .btn.save').click(function(){
	
		$('#publishModal #publishPendingChangesMessage').hide();
		
		$('#publishModal .loader').show();
		
		
		$(this).addClass('disabled');
	
		thePages = prepPagesforSave();
		
		
		$.ajax({
			url: siteUrl+"sites/save/1",
			type: "POST",
			dataType: "json",
			data: {pageData: thePages, siteName: $('#siteTitle').text(), siteID: siteID}
		}).done(function(res){			
						
			$('#publishModal .loader').fadeOut(500, function(){
			
				$('#publishModal .modal-alerts').append( $(res.responseHTML) )
				
				//self-destruct success messages
				setTimeout(function(){$('#publishModal .modal-alerts .alert-success').fadeOut(500, function(){$(this).remove()})}, 2500)
				
				//enable button
				$('#publishModal #publishPendingChangesMessage .btn.save').removeClass('disabled');
			
			})
					
			if( res.responseCode == 1 ) {//changes were saved without issues
		
				//no more pending changes
				setPendingChanges(false);
				
				
				//get the correct pages in the Pages section of the publish modal
				
				$('#publishModal_pages tbody > *').remove();
				
				$('#pages li:visible').each(function(){
				
					thePage = $(this).find('a:first').text();
					
					theRow = $('<tr><td class="text-center" style="width: 0px;"><label class="checkbox"><input type="checkbox" value="'+thePage+'" id="" data-type="page" name="pages[]" data-toggle="checkbox"></label></td><td>'+thePage+'<span class="publishing"><span class="working">Publishing... <img src="'+baseUrl+'images/publishLoader.gif"></span><span class="done text-primary">Published &nbsp;<span class="fui-check"></span></span></span></td></tr>')
									
					//checkboxify
					theRow.find('input').checkbox();
					
					theRow.find('input').on('check uncheck toggle', function(){
					
						$(this).closest('tr')[$(this).prop('checked') ? 'addClass' : 'removeClass']('selected-row');
					
					})
					
					$('#publishModal_pages tbody').append( theRow )
					
				})
				
				
				//show content
				$('#publishModal .modal-body-content').fadeIn(500);
					
			}
		
		})
	
	})
	
	
	//listen for checkboxes
	$('#publishModal').on('change', 'input[type=checkbox]', function(){
	
		activateButton = false;
	
		$('#publishModal input[type=checkbox]').each(function(){
		
			if( $(this).prop('checked') ) {
							
				activateButton = true;
				
				return false;
			
			}
			
		})
		
		if( activateButton ) {
		
			$('#publishSubmit').removeClass('disabled');
		
		} else {
		
			$('#publishSubmit').addClass('disabled');
		
		}
	
	})
	
		
	
	//submit publish
	$('#publishSubmit').click(function(){
	
		
		//track the publishing state
		publishActive = 1;
	
		//disable button
		$('#publishSubmit, #publishCancel').addClass('disabled');
		
		
		//remove existing alerts
		$('#publishModal .modal-alerts > *').remove();
		
		
		//prepare stuff
		
		$('#publishModal form input[type="hidden"].page').remove();
		
		//loop through all pages
		$('#pageList > ul').each(function(){
		
			//export this page?
			
			if( $('#publishModal #publishModal_pages input:eq('+($(this).index()+1)+')').prop('checked') ) {
			
				//grab the skeleton markup
								
				newDocMainParent = $('iframe#skeleton').contents().find( pageContainer );
				
				//empty out the skeleton
				newDocMainParent.find('*').remove();
				
				//loop through page iframes and grab the body stuff
					
				$(this).find('iframe').each(function(){
					
					//remove .frameCovers
										
					theContents = $(this).contents().find( pageContainer );
					
					theContents.find('.frameCover').each(function(){
						$(this).remove();
					})
					
					
					toAdd = theContents.html();
					
					
					
					//grab scripts
					
					scripts = $(this).contents().find( pageContainer ).find('script');
					
					if( scripts.size() > 0 ) {
					
						theIframe = document.getElementById("skeleton");
					
						scripts.each(function(){
						
							if( $(this).text() != '' ) {//script tags with content
							
								var script = theIframe.contentWindow.document.createElement("script");
								script.type = 'text/javascript';
								script.innerHTML = $(this).text();
							
								theIframe.contentWindow.document.getElementById( pageContainer.substring(1) ).appendChild(script);
								
							} else if( $(this).attr('src') != null ) {
							
								var script = theIframe.contentWindow.document.createElement("script");
								script.type = 'text/javascript';
								script.src = $(this).attr('src');
								
								theIframe.contentWindow.document.getElementById( pageContainer.substring(1) ).appendChild(script)
							
							}
					
						})
					
					}
					
					newDocMainParent.append( $(toAdd) );
					
				});
				
				//theStyle = $('<style>body{width:100%}</style>');
				
				//$('iframe#skeleton').contents().find('head').append( $('<style>body{width:100%}</style>') )
				
				//create the hidden input
				
				//alert( $('#pages li:eq('+$(this).index()+1+') a:first').text() )
				
				newInput = $('<input type="hidden" class="page" name="xpages['+$('#pages li:eq('+($(this).index()+1)+') a:first').text()+']" value="">');
				
				$('#publishModal form').prepend( newInput );
				
				newInput.val( "<html>"+$('iframe#skeleton').contents().find('html').html()+"</html>" )
				
			}
		
		})
		
		
		//we'll publish everything item by item, to prevent time outs and to give somewhat of an indication
		
		publishAsset();
	
	})
	
	
	
	//image uploading
	
	$('input#imageFile').change(function(){
	
		if( $(this).val() == '' ) {
			
			//no file, disable submit button
			$('button#uploadImageButton').addClass('disabled');
		
		} else {
		
			//got a gile, enable button
			$('button#uploadImageButton').removeClass('disabled');
		
		}
	
	})
	
	
	$('button#uploadImageButton').click(function(){
	
		if( $('input#imageFile').val() != '' ) {
		
			//remove old alerts
			$('#imageModal .modal-alerts > *').remove();
		
			//disable button
			$('button#uploadImageButton').addClass('disable');
		
			//show loader
			$('#imageModal .loader').fadeIn(500);
	
			var form = $('form#imageUploadForm');
		
			var formdata = false;
		
			if (window.FormData){
				formdata = new FormData(form[0]);
			}
		
			var formAction = form.attr('action');
		
			$.ajax({
				url : formAction,
				data : formdata ? formdata : form.serialize(),
				cache : false,
				contentType : false,
				processData : false,
				dataType: "json",
				type : 'POST',
			}).done(function(ret){
			
				//enable button
				$('button#uploadImageButton').addClass('disable');
			
				//hide loader
				$('#imageModal .loader').fadeOut(500)
						
				if( ret.responseCode == 0 ) {//error
					
					$('#imageModal .modal-alerts').append( $(ret.responseHTML) )
			
				} else if( ret.responseCode == 1 ) {//success
				
					//append my images
					$('#myImagesTab > *').remove()
					$('#myImagesTab').append( $(ret.myImages) )
			
					$('#imageModal .modal-alerts').append( $(ret.responseHTML) )
					
					setTimeout(function(){$('#imageModal .modal-alerts > *').fadeOut(500)}, 3000)
			
				}
		
			})
		
		} else {
		
			alert('No image selected');
		
		}
	
	})
	
	
	
	//update page settings
	$('button#pageSettingsSubmittButton').click(function(){
	
		//disable button
		$(this).addClass('disabled');
		
		
		//hide old alerts
		$('#pageSettingsModal .modal-alerts > *').remove();
		
		
		//show loader
		$('#pageSettingsModal .loader').fadeIn(500);
		
		
		$.ajax({
			url: $('form#pageSettingsForm').attr('action'),
			type: 'post',
			data: $('form#pageSettingsForm').serialize(),
			dataType: 'json'
		}).done(function(ret){
		
			//enable button
			$('button#pageSettingsSubmittButton').removeClass('disabled');
			
			//hide loader
			$('#pageSettingsModal .loader').hide();
			
			
			if( ret.responseCode == 0 ) {//error
			
				$('#pageSettingsModal .modal-alerts').append( $(ret.responseHTML) )
			
			} else {//success
			
				$('#pageSettingsModal .modal-alerts').append( $(ret.responseHTML) )
				
				//self destruct success alert
				setTimeout(function(){ $('#pageSettingsModal .modal-alerts > *').fadeOut(500, function(){$(this).remove()}) }, 3000)
				
				if( typeof ret.pagesData !== 'undefined' ) {
					
					//updates pagesData array
					pagesData = ret.pagesData;
				
				}
			
			}
		
		})
	
	});
	
	
	//content modal, destroy redactor when modal closes
	$('#editContentModal').on('hidden.bs.modal', function (e) {
		
		$('#editContentModal #contentToEdit').redactor('core.destroy');
		
	})
		    
})

var publishActive = 0;
var theItem;

function publishAsset() {

	toPublish = $('#publishModal_assets input[type=checkbox]:checked:not(.published, .toggleAll), #publishModal_pages input[type=checkbox]:checked:not(.published, .toggleAll)');
	
	if( toPublish.size() > 0 ) {
	
		theItem = toPublish.first();
		
		//display the asset loader
		theItem.closest('td').next().find('.publishing').fadeIn(500);
		
		
		if( theItem.attr('data-type') == 'page' ) {
		
			theData = {siteID: $('form#publishForm input[name=siteID]').val(), item: theItem.val(), pageContent: $('form#publishForm input[name="xpages['+theItem.val()+']"]').val()};
				
		} else if( theItem.attr('data-type') == 'asset' ) {
		
			theData = {siteID: $('form#publishForm input[name=siteID]').val(), item: theItem.val()};
		
		}
						
		$.ajax({
			url: $('form#publishForm').attr('action')+"/"+theItem.attr('data-type'),
			type: 'post',
			data: theData,
			dataType: 'json'
		}).done(function(ret){
		
			if( ret.responseCode == 0 ) {//fatal error, publishing will stop
			
				//hide indicators
				theItem.closest('td').next().find('.working').hide();
				
				//enable buttons
				$('#publishSubmit, #publishCancel').removeClass('disabled');
			
				$('#publishModal .modal-alerts').append( $(ret.responseHTML) );
			
			} else if( ret.responseCode == 1 ) {//no issues
				
				//show done
				theItem.closest('td').next().find('.working').hide();
				theItem.closest('td').next().find('.done').fadeIn();
					
				theItem.addClass('published');
					
				publishAsset();
			
			}
				
		})
	
	} else {
	
		//publishing is done
		
		publishActive = 0;
		
		//enable buttons
		$('#publishSubmit, #publishCancel').removeClass('disabled');
		
		
		//show message
		$('#publishModal .modal-body > .alert-success').fadeIn(500, function(){
		
			setTimeout(function(){$('#publishModal .modal-body > .alert-success').fadeOut(500)}, 2500)
		
		});
	
	}

}