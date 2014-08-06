{{#if patient.id}}
<input class="hidden" name="id" value="{{patient.id}}" />
{{/if}}
<fieldset class="patient-song-form">
	{{#if song}}
	<legend>{{patient.name}} has a Song</legend>
	<?php $this->load->view('admin/templates/fields/disabled',array(
		'label'	=>	"Song",
		'name'	=>	"name",
		'value'	=>	"{{song.name}}",
		'icon'	=>	"fa-music",
	));?>
	<?php $this->load->view('admin/templates/fields/disabled',array(
		'label'	=>	"Artist",
		'name'	=>	"artist",
		'value'	=>	"{{song.artist}}",
		'icon'	=>	"fa-music",
	));?>
	<?php $this->load->view('admin/templates/fields/image',array(
		'label'	=>	"Album Cover",
		'name'	=>	"artworkUrl",
		'value'	=>	"{{song.artworkUrl}}",
	));?>
	<?php $this->load->view('admin/templates/fields/player',array(
		'label'	=>	"Preview",
		'name'	=>	"previewUrl",
		'value'	=>	"{{song.previewUrl}}",
	));?>
	<legend>Assign a Different Song to {{patient.name}}</legend>
	<?php $this->load->view('admin/templates/fields/itunes',array(
		'label'	=>	"Search for a Song",
		'name'	=>	"song_search",
		'icon'	=>	"fa-apple",
		'phold'	=>	"any song on iTunes",
	));?>
	{{else}}
	<legend>Assign a Song to {{patient.name}}</legend>
	<?php $this->load->view('admin/templates/fields/itunes',array(
		'label'	=>	"Search for a Song",
		'name'	=>	"song_search",
		'icon'	=>	"fa-apple",
		'phold'	=>	"any song on iTunes",
	));?>
	{{/if}}
</fieldset>
<?php //$this->load->view('admin/templates/blocks/cancel-search');?>