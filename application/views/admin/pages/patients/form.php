{{#if patient.id}}
<input class="hidden" name="id" value="{{patient.id}}" />
{{/if}}
<fieldset class="patient-form">
	<legend>Patient Info</legend>
	<?php $this->load->view('admin/templates/fields/text',array(
		'label'	=>	"Patient Name",
		'name'	=>	"name",
		'value'	=>	"{{patient.name}}",
		'icon'	=>	"fa-user",
	));?>
	<?php $this->load->view('admin/templates/fields/number',array(
		'label'	=>	"Age",
		'name'	=>	"age",
		'value'	=>	"{{patient.age}}",
		'icon'	=>	"fa-calendar",
	));?>
	<?php $this->load->view('admin/templates/fields/text',array(
		'label'	=>	"Phone",
		'name'	=>	"phone",
		'value'	=>	"{{patient.phone}}",
		'icon'	=>	"fa-phone",
	));?>
</fieldset>
<?php $this->load->view('admin/templates/blocks/select-song');?>