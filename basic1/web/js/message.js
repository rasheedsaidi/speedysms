$('document').ready(function() {
	putLength();
	
	$('#fetch').click(function(e) {
		handleNumberFetch(e);
	});
	
	
});

function putLength() {
	console.log(typeof($('#message_body')))
	if (typeof($('#message_body')) !== 'undefined' && typeof($('#message_body').val()) !== 'undefined') {
		message_length = $('#message_body').val().length;
		$('#message_length').val(message_length);
		$('#message_status').html(message_length+ ' Characters, ' + Math.ceil(message_length/160) + ' SMS message(s).');
		len = setTimeout('putLength()', 1000);
	}
}

function handleNumberFetch(e) {
	 
    e.preventDefault();
 
    var
        $link = $(e.target),
        callUrl = $link.attr('href'),
        formId = $link.data('manageContact'),
        ajaxRequest;
 
 //$('#file_url').val()
  /*  ajaxRequest = $.ajax({
        type: "get",
        dataType: 'json',
        url: callUrl + $('#file_url').val(),
        //data: (typeof formId === "string" ? $('#' + formId).serializeArray() : null)
    });
    ajaxRequest.always = function(r) {
    	console.log(ajaxRequest);
    	console.log(r);
    }
 */
    $.ajax({
        url: 'index.php?r=group/link',
        type: 'post',
        data: {url: $("#file_url").val()},
        success: function (data) {
           console.log(data.numbers);
           if (data.numbers != '0')
        	   $('#contact_body').val(data.numbers);
        },
        fail: function (data) {
        	console.log(data);
        }
   });
    
 
}
function fetchDone (response) {
    // This is called by the link attribute 'data-on-done' => 'simpleDone'
    console.dir(response);
    $('#fetch').val(response.body);
}

$(function () {
    'use strict';
    // Change this to the location of your server-side upload handler:
    var url = window.location.hostname === 'blueimp.github.io' ?
                '//jquery-file-upload.appspot.com/' : 'blueimp-file-upload/server/php/';
    $('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        done: function (e, data) {
        	$('#up').show().val('Numbers Loaded!');
            $.each(data.result.files, function (index, file) { console.log(file);
                if (typeof file.error !== 'undefined') {
                	alert('Only "CSV", "Excel", and "Text" files are alowed. Call: 08060553348 for more information.');
                	return;
                }
            	$('#file_url').val(file.url);
            });
        },
        error: function (e, data) {
        	$('#up').show().val('Numbers Loaded!').removeClass('btn-info').addClass('btn-success');
            //$.each(data.result.files, function (index, file) { 
            	alert('Error uploading  your file. Please retry or contact the admin.');
	        //});
	    },
        progressall: function (e, data) {
        	$('#up').show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});