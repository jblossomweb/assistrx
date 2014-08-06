<?php if(!$form):?>
<?php echo $return; ?>
<?php else: ?>
<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<i class="fa fa-music"></i>
					<span>Song Selection</span>
				</div>
				<div class="box-icons">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="expand-link">
						<i class="fa fa-expand"></i>
					</a>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
				<div class="no-move"></div>
			</div>
			<div class="box-content">
				<form id="frmEditPatientSong" method="post" action="/admin/ajax/patients/song" class="form-horizontal"></form>
			</div>
		</div>
	</div>
</div>

<script id="patient-song-form-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/pages/patients/song-form');?>
</script>
<script id="itunes-result-template" type="text/x-handlebars-template">
<?php $this->load->view('admin/templates/fields/itunes-result');?>
</script>

<script type="text/javascript">
var form_selector = "#frmEditPatientSong";
var form_template = "#patient-song-form-template";
var itunes_result_template = "#itunes-result-template";
var form_data = {
	  <?php if(!empty($patient['name'])): ?>
	  patient: {
	  	id: "<?php echo $patient['id'];?>",
	  	name: "<?php echo $patient['name'];?>",
	  	age: "<?php echo $patient['age'];?>",
	  	phone: "<?php echo $patient['phone'];?>"
	  }<?php endif;?><?php if(!empty($song['name'])): ?>,
	  song: {
	  	id: "<?php echo $song['id'];?>",
	  	name: "<?php echo $song['name'];?>",
	  	artist: "<?php echo $song['artist'];?>",
	  	artworkUrl: "<?php echo $song['artworkUrl100'];?>",
	  	previewUrl: "<?php echo $song['previewUrl'];?>"
	  }<?php endif;?>
};
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "patients", title: "Patients"},
	    	{page: "patients/song?id=<?php echo $patient['id'];?>", title: "Song"}
		 ]);
		renderTemplate(form_template,form_selector,form_data);
		$.getScript('/assets/js/admin/guts-form.js', function(){
			loadForm(function(){
				<?php if(!empty($song['name'])): ?>
				$.getScript('/assets/js/jquery.jplayer.js', function(){
					$("#jquery_jplayer_audio_1").jPlayer({
						ready: function(event) {
							$(this).jPlayer("setMedia", {
								title: "Preview",
								m4a: $(".previewUrl").find("span.stream-url").html()
							});
						},
						play: function() { // Avoid multiple jPlayers playing together.
							$(this).jPlayer("pauseOthers");
						},
						timeFormat: {
							padMin: false
						},
						swfPath: "js",
						supplied: "m4a",
						cssSelectorAncestor: "#jp_container_audio_1",
						smoothPlayBar: true,
						remainingDuration: true,
						keyEnabled: true,
						keyBindings: {
							// Disable some of the default key controls
							muted: null,
							volumeUp: null,
							volumeDown: null
						},
						wmode: "window"
					});
				});
				<?php endif; ?>
			});

			$.getScript('/assets/js/admin/itunes-search.js', function(){
				//
			});

			//$.getScript('/assets/js/jquery.jplayer.js', function(){

			//});

		});
	});
});
</script>
<?php endif; ?>