var validateResource = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/resources');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			controller: {
				message: 'Please enter a valid Resource Controller',
				validators: {
					notEmpty: {
						message: 'The Resource Controller is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Resource Controller must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_]+$/,
						message: 'The Resource Controller must be alpha-numeric with optional underscore'
					}
				}
			},
			action: {
				message: 'Please enter a valid Resource Action',
				validators: {
					notEmpty: {
						message: 'The Resource Action is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Resource Action must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_]+$/,
						message: 'The Resource Action must be alpha-numeric with optional underscore'
					}
				}
			}
			
		},
		submitHandler: function(){
			inputs.prop("disabled", true);
			spinner.show();
			form.ajaxSubmit({
				data: {
					id: 		form.find(":input[name='id']").val(), 
					controller: form.find(":input[name='controller']").val(),
					action: 	form.find(":input[name='action']").val(),
				},
				success: function(data) { 
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/resources');
			    }
		    });
		}
	}); 
};