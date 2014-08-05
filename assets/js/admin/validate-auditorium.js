var validateAuditorium = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/auditoriums');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			aud_id: {
				message: 'Please enter a valid Auditorium ID',
				validators: {
					notEmpty: {
						message: 'Auditorium ID is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'Auditorium ID must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_]+$/,
						message: 'Auditorium ID must be alpha-numeric with underscore'
					}
				}
			},
			aud_number: {
				message: 'Please enter valid Auditorium Number',
				validators: {
					notEmpty: {
						message: 'Auditorium Number is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 10,
						message: 'Auditorium Number must an integer between 1-10 digits'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Auditorium Number must be numeric'
					}
				}
			},
			complex_id: {
				message: 'Please select a valid Complex',
				validators: {
					notEmpty: {
						message: 'Complex is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 10,
						message: 'Please select a valid Complex'
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Please select a valid Complex'
					}
				}
			}
			
		},
		submitHandler: function(){
			inputs.prop("disabled", true);
			spinner.show();
			form.ajaxSubmit({
				data: {
					id: 			form.find(":input[name='id']").val(), 
					aud_id: 		form.find(":input[name='aud_id']").val(),
					aud_number: 	form.find(":input[name='aud_number']").val(),
					complex_id: 	form.find(":input[name='complex_id']").val()
				},
				success: function(data) { 
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/auditoriums');
			    }
		    });
		}
	}); 
};