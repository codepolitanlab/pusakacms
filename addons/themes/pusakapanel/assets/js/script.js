$(function(){
	// confirm delete
	$('.remove').click(function(){
		return confirm('Are you sure want to remove this item? \nThis will be remove the folder and all of its child contents.');
	})
	
	// expand page list
	$('.content-list .expand').click(function(){
		$parent = $(this).parent().parent().parent().parent('.list-desc');
		$child = $parent.siblings('.children');
		$child.slideToggle();

		return false;
	});

	// jquery slugify
	$('.slug').slugify('.title');

	// nav area modals
	$('#areaModal').on('show.bs.modal', function (e) {
		var title = $(e.relatedTarget).data('title');
		var slug = $(e.relatedTarget).data('slug');
		var mode = $(e.relatedTarget).data('mode');
		$('#area-title').val(title);
		$('#area-slug').val(slug);
		if(mode == 'edit'){
			$('#area-form').attr('action', base_url + 'panel/navigation/edit_area/'+slug);
			$('#btn-submit-area-form').html('Edit');
			$('#areaModalLabel').html('Edit Area');
		} else {
			$('#area-form').attr('action', base_url + 'panel/navigation/create_area');
			$('#btn-submit-area-form').html('Create');
			$('#areaModalLabel').html('New Area');				
		}
	});

	// nav link modals
	$('#linkModal').on('show.bs.modal', function (e) {
		var mode = $(e.relatedTarget).data('mode');
		var link_area = $(e.relatedTarget).data('area');
		var link_title = $(e.relatedTarget).data('title');
		var link_slug = $(e.relatedTarget).data('slug');
		var link_source = $(e.relatedTarget).data('source');
		var link_url = $(e.relatedTarget).data('url');
		var link_target = $(e.relatedTarget).data('linktarget');

		console.log(link_title + ' ' + link_slug);

		set_parent_dropdown(link_area);

		$('#link_area').val(link_area);
		$('#link_title').val(link_title);
		$('#link_slug').val(link_slug);
		$('#link_source').val(link_source);
		$('#link_url').val(link_url);
		$('#link_target').val(link_target);
		if(mode == 'edit'){
			$('#link-form').attr('action', base_url + 'panel/navigation/edit_link/' + link_area + '/' + link_slug);
			$('#btn-submit-link-form').html('Edit');
			$('#linkModalLabel').html('Edit Link');
		} else {
			$('#link-form').attr('action', base_url + 'panel/navigation/create_link');
			$('#btn-submit-link-form').html('Create');
			$('#linkModalLabel').html('Add New Link');
		}
	})

	// groups modals
	$('#groupModal').on('show.bs.modal', function (e) {
		var mode = $(e.relatedTarget).data('mode');
		var group_id = $(e.relatedTarget).data('group-id');
		var group_name = $(e.relatedTarget).data('name');
		var group_desc = $(e.relatedTarget).data('desc');

		console.log(group_id + ' ' + group_name);

		$('#group_name').val(group_name);
		$('#group_description').val(group_desc);
		if(mode == 'edit'){
			$('#group-form').attr('action', base_url + 'panel/users/edit_group/' + group_id);
			$('#btn-submit-group-form').html('Edit');
			$('#groupModalLabel').html('Edit Group');
		} else {
			$('#group-form').attr('action', base_url + 'panel/users/create_group');
			$('#btn-submit-group-form').html('Create');
			$('#groupModalLabel').html('Add Group');
		}
	})

	// editor switch
	$('.btn-editor').click(function(){
		var c = "";
		var editor = $(this).data('editor');
		$('.btn-editor').removeClass('btn-success');
		$(this).addClass('btn-success');

		// turn on ckeditor
		if(editor == 'ckeditor'){
			// get data from ckeditor and place to textarea
			c = cmeditor.getValue();
			$('#contentfield').val(c);
			//hide codemirror
			$(cmeditor.getWrapperElement()).hide();
			// create ckeditor instance
			var ckeditor1 = CKEDITOR.replace('contentfield');

		// turn on codemirror
		} else {
			var c = CKEDITOR.instances.contentfield.getData();
			// get data from ckeditor and place to textarea
			$('#contentfield').val(c);
			// destroy ckeditor
			CKEDITOR.instances.contentfield.destroy();
			// set codemirror content
			cmeditor.setValue(c);
			setTimeout(function() {
				cmeditor.refresh();
			},1);
			// show codemirror editor
			$(cmeditor.getWrapperElement()).show();
			// hide textarea
			$('#contentfield').hide();
		}
	});
});

// define timeout
var timeout = setTimeout(function(){
	$('.alert').slideUp();
}, 8000);

var set_parent_dropdown = function(area)
{
	$.get(base_url + 'panel/navigation/get_nav_parent_option/' + area, function(data){
		$('#link_parent').html(data);
	});
}

// alert before close browser or change page
var alertClose = 0;
var alertCloseMessage = "You didn't save changes.";
window.onbeforeunload = function (e) {
	e = e || window.event;

	for (var i in CKEDITOR.instances) {
        if(CKEDITOR.instances[i].checkDirty())
        {
            alertClose = 1;
        }
    }

	if(alertClose > 0){
		if (e) {
			e.returnValue = alertCloseMessage;
		}
		return alertCloseMessage;
	}
};

// load codemirror
var cmeditor = CodeMirror.fromTextArea(document.getElementById("contentfield"), {
	mode: "markdown",
	autoCloseTags: true,
	lineNumbers: true,
	lineWrapping: true,
	styleActiveLine: true,
	theme: "monokai"
});
$(cmeditor.getWrapperElement()).hide();

// check if editor content has changed
cmeditor.on('change', function(){
	alertClose = 1;
});

// check if form changed
$("form :input").change(function() {
	alertClose = 1;
});
$("form").submit(function() {
	window.onbeforeunload = null;
});