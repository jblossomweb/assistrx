var validateGroup = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/groups');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			name: {
				message: 'Please enter a valid Group Name',
				validators: {
					notEmpty: {
						message: 'The Group Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 45,
						message: 'The Group Name must be between 1-45 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			description: {
				message: 'Please enter a valid Description',
				validators: {
					stringLength: {
						max: 45,
						message: 'The Description can be up to 45 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			homepage: {
				message: 'Please enter a valid Homepage URL',
				validators: {
					stringLength: {
						max: 50,
						message: 'The Homepage URL can be up to 45 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\/\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash, Slash or Underscore'
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
					name: 		form.find(":input[name='name']").val(),
					description: form.find(":input[name='description']").val(),
					homepage: 	form.find(":input[name='homepage']").val(),
					resources: 	form.find(":input[name='resources']").val()
				},
				success: function(data) { 
					data = $.parseJSON(data);
			        console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/groups/edit?id='+data.id);
			    }
		    });
		}
	}); 
};