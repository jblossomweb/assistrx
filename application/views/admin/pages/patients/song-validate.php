<script type="text/javascript">
var validatePatientSong = function(){
	var form = $(form_selector);
	var inputs = $(form_selector+" :input");
	var btn = $(form_selector+' button.submit');
	var cancel = $(form_selector+' button.cancel');
	var spinner = $(form_selector+' .fa-spin');

	cancel.click(function(e){
		e.preventDefault();
		LoadAjaxContent('/admin/ajax/patients');
	});

	form.bootstrapValidator({
		message: 'This value is not valid',
		fields: {
			name: {
				message: 'Please enter a valid Patient Name',
				validators: {
					notEmpty: {
						message: 'The Patient Name is required and cannot be empty'
					},
					stringLength: {
						min: 1,
						max: 50,
						message: 'The Patient Name must be between 1-50 characters long'
					},
					regexp: {
						regexp: /^[a-zA-Z0-9_\.\- ]+$/,
						message: 'No special characters, please. Letters, Numbers, Space, Dot, Dash or Underscore'
					}
				}
			},
			phone: {
				message: 'Please enter a valid Patient Phone',
				validators: {
					notEmpty: {
						message: 'The Patient Phone is required and cannot be empty'
					},
					phone: {
						message: 'Please enter a valid phone number (XXX-XXX-XXXX)'
					},
					regexp: {
						regexp: /^[0-9\-]+$/,
						message: 'Numbers and dashes only'
					}
				}
			},
			age: {
				message: 'Please enter a valid Age',
				validators: {
					notEmpty: {
						message: 'The Age is required and cannot be empty'
					},
					integer: {
						message: 'Numbers only' 
					},
					regexp: {
						regexp: /^[0-9]+$/,
						message: 'Numbers only'
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
					age: 		form.find(":input[name='age']").val(),
					phone: 		form.find(":input[name='phone']").val(),  
				},
				success: function(data) { 
					//console.log(data);
					data = $.parseJSON(data);
			        //console.log(data);
			        spinner.hide();
			        //form.fadeOut("fast");
			        LoadAjaxContent('/admin/ajax/patients/edit?id='+data.id);
			        //LoadAjaxContent('/admin/ajax/patients');
			    }
		    });
		}
	}); 
};
</script>