$('document').ready(function() {
	putLength();
	
	$('#fetch').click(function(e) {
		handleNumberFetch(e);
	});
	
	scheduled_array = [];
	$('#add_scheduled_item').hide();
	$('#personalised_info').hide();
	$('#saved_messages_div').hide();
	
	Array.prototype.indexOf || (Array.prototype.indexOf = function(d, e) {
	    var a;
	    if (null == this) throw new TypeError('"this" is null or not defined');
	    var c = Object(this),
	        b = c.length >>> 0;
	    if (0 === b) return -1;
	    a = +e || 0;
	    Infinity === Math.abs(a) && (a = 0);
	    if (a >= b) return -1;
	    for (a = Math.max(0 <= a ? a : b - Math.abs(a), 0); a < b;) {
	        if (a in c && c[a] === d) return a;
	        a++
	    }
	    return -1
	});
});

function putLength() {
	//console.log(typeof($('#message_body')))
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
        url: $("#file_url").val(),	//'index.php?r=group/link',
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
		paramName: 'files[]',
        done: function (e, data) {        	
        	//$('#fetch').show();
            $.each(data.result.files, function (index, file) { console.log(file);
                if (typeof file.error !== 'undefined') { console.log(file.error);
                	alert('Only "CSV", "Excel", and "Text" files are alowed. Call: 08060553348 for more information.');
                	return false;
                }
				$('#up').show().val('Numbers Loaded!');
            	$('#file_url').val(file.url);
            });
            handleNumberFetch(e);
        },
        error: function (e, data) {
        	$('#up').show().val('Numbers Loaded!').removeClass('btn-info').addClass('btn-success');
            //$.each(data.result.files, function (index, file) { 
            	alert('Error uploading  your file. Just copy and past the comma separated nos here. or contact the admin.');
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

$(document).ready(function () {

    // ===========Featured Owl Carousel============
    if ($(".owl-carousel-featured").length > 0) {
        $(".owl-carousel-featured").owlCarousel({
            items: 4,
            lazyLoad: true,
            pagination: true,
            autoPlay: 5000,
            stopOnHover: true
        });
    }

    // ==================Counter====================
    $('.item-count').countTo({
        formatter: function (value, options) {
            return value.toFixed(options.decimals);
        },
        onUpdate: function (value) {
            console.debug(this);
        },
        onComplete: function (value) {
            console.debug(this);
        }
    });
});

$(document).ready(function () {
    $('#freesms').on('submit', function(e) {
        e.preventDefault();
        $("#freesms_output").html("We are sending your SMS. Please wait.");
        
        if($('#smsbody').val().length == 0) { $("#freesms_output").html("Please enter message to send").show(); return false; }
        if($('#smsno').val().length == 0) { $("#freesms_output").html("Please enter mobile number").show(); return false; }        
        if($('#smsid').val().length == 0) { $("#freesms_output").html("Please enter sender id").show(); return false; }
        
        $('#smslength').val($('#smsbody').val().length).show();
        var arr = $.ajax({
            url : $(this).attr('action'),	// || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
            	$("#freesms_output").hide();
            	alert(data);
                //$("#freesms_output").html(data).show();
                console.log(data);
                return true;
            },
            error: function (jXHR, textStatus, errorThrown) {
                //alert(errorThrown);
            	$("#freesms_output").hide();
            	$("#freesms_output").html("Error occured while sending your SMS").show();
                console.log(jXHR);
                return false;
            }
        });
        console.log(arr);
    });
    
    $('#cal_cal').on('click', function(e) {
        e.preventDefault();
        var ref = [
           {unit_price: 1.7, min: 1, max: 999, type: "standard"},
           {unit_price: 1.6, min: 1000, max: 9999, type: "standard"},
           {unit_price: 1.5, min: 10000, max: 99999, type: "standard"},
           {unit_price: 1.4, min: 100000, max: 999999, type: "standard"},
           {unit_price: 1.3, min: 1000000, max: 999999999, type: "standard"},
           {unit_price: 2.2, min: 1, max: 999, type: "express"},
           {unit_price: 2.1, min: 1000, max: 9999, type: "express"},
           {unit_price: 2.0, min: 10000, max: 99999, type: "express"},
           {unit_price: 1.9, min: 100000, max: 999999, type: "express"},
           {unit_price: 1.8, min: 1000000, max: 999999999, type: "express"}
        ];
        var unit_price = 1;
        var no_of_sms = parseInt($("#no_of_sms_cal").val());
        var sms_type = $("#sms_type_cal").val();
        sms_type = (sms_type == "")? "express": sms_type;
        
        if (sms_type === "") { 
        	$('#sms_type_cal>option:eq(0)').attr('selected', true);
        } else if (sms_type === "standard") { 
        	$('#sms_type_cal>option:eq(1)').attr('selected', true);
        } else if (sms_type === "express") { 
        	$('#sms_type_cal>option:eq(2)').attr('selected', true);
        }
        no_of_sms = (no_of_sms.length == "")? 2: no_of_sms;
        
        for(i in ref) {
        	var unit = ref[i];
        	var y = unit.min >= no_of_sms + ' | ' + unit.max <= no_of_sms;
        	//console.log(unit);
        	//console.log(no_of_sms >= unit.min);
        	//console.log(no_of_sms <= unit.max);
        	//console.log("-------------");
        	if((no_of_sms >= unit.min && no_of_sms <= unit.max) && unit.type == sms_type) {
        		unit_price = parseFloat(unit.unit_price);
        		console.log(unit);
        		break;
        	}
        	
        }
        console.log(no_of_sms);
        var amt = (reallyIsNaN(Math.floor(no_of_sms * unit_price)))? 0: Math.floor(no_of_sms * unit_price);
        $("#calculated_amt_cal").val("N " + amt);
    });
    
    $('#price_cal_btn').on('click', function(e) {
        e.preventDefault();
        var ref = [
           {unit_price: 1.7, min: 1, max: 2099, type: "standard"},
           {unit_price: 1.6, min: 2100, max: 19999, type: "standard"},
           {unit_price: 1.5, min: 20000, max: 189999, type: "standard"},
           {unit_price: 1.4, min: 190000, max: 1699999, type: "standard"},
           {unit_price: 1.3, min: 1700000, max: 999999999, type: "standard"},
           {unit_price: 2.2, min: 1, max: 2099, type: "express"},
           {unit_price: 2.1, min: 2100, max: 19999, type: "express"},
           {unit_price: 2.0, min: 20000, max: 189999, type: "express"},
           {unit_price: 1.9, min: 190000, max: 1699999, type: "express"},
           {unit_price: 1.8, min: 1700000, max: 999999999, type: "express"}
        ];
        var unit_price = 1;
        var price = parseFloat($("#price_cal").val());
        var sms_type = $("#sms_type_cal1").val();
        sms_type = (sms_type == "")? "express": sms_type;
        
        if (sms_type === "") { 
        	$('#sms_type_cal>option:eq(0)').attr('selected', true);
        } else if (sms_type === "standard") { 
        	$('#sms_type_cal>option:eq(1)').attr('selected', true);
        } else if (sms_type === "express") { 
        	$('#sms_type_cal>option:eq(2)').attr('selected', true);
        }
        price = (price == "")? 1: price;
        
        for(i in ref) {
        	var unit = ref[i];
        	var y = unit.min >= price + ' | ' + unit.max <= price;
        	//console.log(unit);
        	//console.log(no_of_sms >= unit.min);
        	//console.log(no_of_sms <= unit.max);
        	//console.log("-------------");
        	if((price >= unit.min && price <= unit.max) && unit.type == sms_type) {
        		unit_price = parseFloat(unit.unit_price);
        		console.log(unit);
        		break;
        	}
        	
        }
        console.log(price);
        var amt = (reallyIsNaN(Math.floor(price / unit_price)))? 0: Math.floor(price / unit_price);
		var s = (amt > 1)? '\'s': '';
        $("#calculated_no_cal").val(amt + " SMS" + s);
    });
    
    $('#contact_form_home').on('submit', function(e) {
        e.preventDefault();
        $("#contact_output").html("We are sending your request/comment. Please wait.");
        
        if($('#name_contact').val().length == 0) { $("#contact_output").html("Please enter your name.").show(); return false; }
        if($('#subject_contact').val().length == 0) { $("#contact_output").html("Please enter subject.").show(); return false; }       
        if($('#comment_contact').val().length == 0) { $("#contact_output").html("Please enter your request or comment.").show(); return false; }       
        
        $.ajax({
            url : $(this).attr('action'),	// || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function (data) {
            	$("#contact_output").hide();
                $("#contact_output").html(data).show();
                console.log(data);
            },
            error: function (jXHR, textStatus, errorThrown) {
                
            	$("#contact_output").hide();
            	$("#contact_output").html("error").show();
                console.log(jXHR);
            }
        });
    });
    
    var reallyIsNaN = function(x) {
    	   return x !== x;
    	};
    	
    	$('.scheduled_datepicker').datetimepicker({
    		dayOfWeekStart : 1,
    		lang:'en',
    		format:'d-M-Y',
    		formatDate:'Y-m-d',
    		timepicker:false
    		});
    	
    	$('.scheduled_timepicker').datetimepicker({
    		lang:'en',
    		format:'H:i:s',
    		step:5,
    		datepicker:false
    		});
    	
    	$('body').on('focus, click', ".scheduled_datepicker", function(ev) {
    		var e = $(ev.target);
    		e.datetimepicker({
        		dayOfWeekStart : 1,
				lang:'en',
				format:'d-m-Y',
				formatDate:'Y-m-d',
				timepicker:false
        		});
    	});
		
		$('body').on('focus, click', ".scheduled_timepicker", function(ev) {
    		var e = $(ev.target);
    		e.datetimepicker({
        		lang:'en',
        		format:'H:i:s',
        		step:5,
        		datepicker:false
        		});
    	});
    	
    	//var scheduled_array = [];
    	
    	$('body').on('change', "#scheduled_box", function(ev) {
    		
    		var e = $(ev.target);

    		if (e.is(':checked')) {
    			$('#add_scheduled_item').show();
    			if(scheduled_array.length == 0) {
    				var max = 0;
    			} else {
    				var max = getMaxOfArray(scheduled_array);
    			}    			
    			scheduled_array.push(max + 1);
    			updateScheduleArray(scheduled_array);
    		} else {
    			scheduled_array = [];
    			$('#schedule_form').html("");
    			$('#add_scheduled_item').hide();
    		}
    		
    	});
    	
    	$('body').on('click', "#add_scheduled_item", function(ev) {
    		
    		var e = $(ev.target);

    		if ($('#scheduled_box').is(':checked')) {
    			//$('#add_scheduled_item').show();
    			if(scheduled_array.length == 0) {
    				var max = 0;
    			} else {
    				var max = getMaxOfArray(scheduled_array);
    			} 
    			scheduled_array.push(max + 1);
    			//updateScheduleArray(scheduled_array);
    			addScheduleItem(max + 1);
    		} else {
    			scheduled_array = [];
    			$('#schedule_form').html("");
    			$('#add_scheduled_item').hide();
    			//$('#schedule_form').html('<button type="button" id="add_scheduled_item">Add schedule</button>');
    		}
    		
    	});
    	
    	$('body').on('click', ".delete_scheduled_item", function(ev) {
    		
    		var e = $(ev.target);
    		ev.preventDefault();
			
			console.log(e.closest("div.row1"))

    		//$('#add_scheduled_item').show();
			var data_id = e.data('schedule-id'); //console.log(data_id)
			var index = scheduled_array.indexOf(data_id);
			if (index > -1) {
				scheduled_array.splice(index, 1);
				//deleteScheduleItem(data_id);
				e.closest("div.row1").remove();
			}			 
			
    		if ($('#scheduled_box').is(':checked')) {
    			console.log(scheduled_array)
    			if(scheduled_array.length == 0) {
    				$('#scheduled_box').attr('checked', false);
    				$('#schedule_form').html("");
    				$('#add_scheduled_item').hide();
    			} else {
    				//updateScheduleArray(scheduled_array);
    			}    			
    		} else {
    			scheduled_array = [];
    			$('#schedule_form').html("");
    			$('#add_scheduled_item').hide();
    		}
    		
    	});
    	
    	function updateScheduleArray(arr) {
    		var schedules = '';
    		if(arr.length > 0) {
	    		for(var j in arr) {
	    			var i = arr[j];
	    			schedules = '<div class="form-group"><div class="row row1" id="shedule_item_' + i + '"><div class="col-md-5"><div class="row"><div class="col-md-3"><label>Date</label></div><div class="col-md-9"><input name="scheduled_date[' + i + ']" class="form-control scheduled_datepicker" type="text" placeholder="Select time" value="""/>';
	    			schedules += '</div></div></div><div class="col-md-5">';
	    			schedules += '<div class="row"><div class="col-md-3"><label>Time</label></div><div class="col-md-9"><input name="scheduled_time[' + i + ']" class="form-control scheduled_timepicker" type="text" placeholder="Select time" value=""/>';
	    			schedules += '</div></div></div><div class="col-md-2"><a href="#" data-schedule-id="' + i + '" class="delete_scheduled_item">Delete</a></div></div></div>';
	    		}
    		} else {
    			var i = 0;
    			schedules = '<div class="form-group"><div class="row row1" id="shedule_item_' + i + '"><div class="col-md-5"><div class="row"><div class="col-md-3"><label>Date</label></div><div class="col-md-9"><input name="scheduled_date[' + i + ']" class="form-control scheduled_datepicker" type="text" placeholder="Select time" value="" />';
    			schedules += '</div></div></div><div class="col-md-5">';
    			schedules += '<div class="row"><div class="col-md-3"><label>Time</label></div><div class="col-md-9"><input name="scheduled_time[' + i + ']" class="form-control scheduled_timepicker" type="text" placeholder="Select time" value="" />';
    			schedules += '</div></div></div><div class="col-md-2"><a href="#" data-schedule-id="' + i + '" class="delete_scheduled_item">Delete</a></div></div></div>';
    		}
    		//console.log(schedules)
    		$('#schedule_form').html(schedules);
    	}
    	
    	function addScheduleItem(i) {
    		//var item = $('#shedule_item_' + i); console.log(item)
    		//var schedules = '';
    		//if(typeof(item) === 'undefined') {
    			schedules = '<div class="form-group"><div class="row row1" id="shedule_item_' + i + '"><div class="col-md-5"><div class="row"><div class="col-md-3"><label>Date</label></div><div class="col-md-9"><input name="scheduled_date[' + i + ']" class="form-control scheduled_datepicker" type="text" placeholder="Select time" value=""/>';
    			schedules += '</div></div></div><div class="col-md-5">';
    			schedules += '<div class="row"><div class="col-md-3"><label>Time</label></div><div class="col-md-9"><input name="scheduled_time[' + i + ']" class="form-control scheduled_timepicker" type="text" placeholder="Select time" value="" />';
    			schedules += '</div></div></div><div class="col-md-2"><a href="#" data-schedule-id="' + i + '" class="delete_scheduled_item">Delete</a></div></div></div>';
    		//}
    		$('#schedule_form').append(schedules);
    	}
    	
    	function deleteScheduleItem(i) {
    		var item = $('#shedule_item_' + i);  console.log(item)
			var parent = '#shedule_item_' + i;
    		if(typeof(item) !== 'undefined') {
    			item.remove();
				$('body').on('click', 'a.delete_scheduled_item', function(events){
				   $(this).parents('div').eq(1).remove();
				});
    		}
    		
    	}
    	
    	function getMaxOfArray(numArray) {
    		  return Math.max.apply(null, numArray);
    		}
		
		$('body').on('change', "#personalised_box", function(ev) {
    		
    		var e = $(ev.target);

    		if (e.is(':checked')) {
				$('#personalised_info').show();
			} else {
				$('#personalised_info').hide();
			}
		});
		
		$('body').on('change', "#existing_message, #new_message", function(ev) {
    		
    		var e = $(ev.target);

    		if ($('#existing_message').is(':checked')) {
				$('#saved_messages_div').show();
			} else {
				$('#saved_messages_div').hide();
			}
			
			if ($('#new_message').is(':checked')) {
				$('#message_body').val("");
				$("#saved_messages_select").val($("#saved_messages_select option:first").val());
			} else {
				//$('#saved_messages_div').hide();
			}
		});
		
		$('body').on('change', "#saved_messages_select", function(ev) {
    		
    		var e = $(ev.target);

    		if (e.val() != '') {
				$('#message_body').val($('#saved_messages_select option:selected').text().trim());
			}
		});
});