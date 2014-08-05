var validateModule = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/modules');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			name: {
				message: 'Please enter a valid Module Name',
				validators: {
					notEmpty: {
						message: 'The Module Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Module Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
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
					name: 		form.find(":input[name='name']").val()
				},
				success: function(data) { 
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/modules');
			    }
		    });
		}
	}); 
};