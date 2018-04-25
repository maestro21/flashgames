/* forms */
var validator;
$( document ).ready(function() {
		
	
	$.validator.addMethod('phone', function (value, element) { console.log('called');
		return this.optional(element) || /^[+]?[(]?[0-9]{3}[)]?[-s.]?[0-9]{3}[-s.]?[0-9]{4,6}$/im.test(value);
	}, "<?php echo T('error_phone'); ?>");	
	$.validator.addClassRules('phone', { phone: true });
	
	$.validator.addMethod('slug', function (value, element) { console.log('called');
		return this.optional(element) || /^[-a-z0-9]*$/im.test(value);
	}, "<?php echo T('error_slug'); ?>");	
	$.validator.addClassRules('slug', { slug: true });
	
	validator = $("form").validate({
		
		rules: {			
            phone: {
				phone: true,
				required: true
			},
        },
		
		submitHandler: function(form) {
			saveFn();
		},
		
		invalidHandler: function(event, validator) {
			addmsg('<?php echo T('error_form'); ?>', 'error');
		}
		
	});

	
	$("#form").submit(function(e){ saveFn(); return false; });
	$('.submit').click(function() { saveForm(); });	
	function saveFn(){ saveForm(); }
	
	
	
});

(function($) {
	$.fn.serializefiles = function() {
		var obj = $(this);
		/* ADD FILE TO PARAM AJAX */
		var formData = new FormData();
		$.each($(obj).find("input[type='file']"), function(i, tag) {
			$.each($(tag)[0].files, function(i, file) {
				formData.append(tag.name, file);
			});
		});
		var params = $(obj).serializeArray();
		$.each(params, function (i, val) {
			formData.append(val.name, val.value);
		});
		return formData;
	};
})(jQuery);

function saveForm(id,path) {
	syncEditorContents();
	if(id == null) id = 'form';
	if(!$('#' + id).valid()) return false;
	if(path == null) path = $('#' + id).attr("action");

	var data = $('#' + id).find('input, select, textarea').not('[name*="{key}"]').serializefiles();
    // add files
    $.each( $('#' + id).find('input[type="file"]'), function( key, value ) {
       data.append(value.id, value.files[0]);
    });
    
	$.ajax({
		url: path,
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		type: 'POST',
		success: function(data){
			processResponse(data);
		}
	});
}


function processResponse(data) {
	data = jQuery.parseJSON(data); console.log(data);
	$('.messages').html('');
	$('.messages').hide();
	addmsg(data.message, data.status);	
	$('.messages').show(300);
	if(data.status == 'ok') {
		var timeout = 2000;
		if(data.timeout) timeout = data.timeout;
		setTimeout(function() {
			if(data.redirect) {
				if(data.redirect == 'self' || data.redirect == 'reload') 
					window.location.reload();
				else 
					window.location = data.redirect;
			}
			$('.messages').html('');
		},timeout);
	}	
}

function sendGetForm(id,path) {
	$.get(path, $('#' + id).serialize())
	.done(function( data ) {
		processResponse(data);		
	});
}


function conf(action, text) {
	if(confirm(text)){
		$.get(action + '?ajax=1')
		.done(function( data ) {
			processResponse(data);
		});
	}
}


function addmsg(txt, cl, selector) {
	if(selector == null) selector = '.messages';
	if(cl == null) cl = 'ok';
	var html = '<div class="' + cl + '">' + txt + '</div>';
	$(selector).html($(selector).html() + html);
}


/* Editor editor */
function syncEditorContents() {
	 $('textarea').each(function() {
        var id = $(this).attr("id");
		if($(this).hasClass('html')) {
			$(this).appendTo('form');
			$(this).val(tinyMCE.get(id).getContent());
		}
    });
}


