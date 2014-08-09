<!--Start Breadcrumb -->
<div id="breadcrumbs-container"></div>
<!--End Breadcrumb-->
<?php $this->load->view('admin/templates/blocks/guts-loader');?>

<div class="row" id="guts" style="display:none;">
	<div class="col-xs-12">
		<div class="box">
			<div class="box-header">
				<div class="box-name">
					<!--<i class="fa fa-music"></i>-->
					<img style="width:20px" width="20" src="http://www.cornify.com/getacorn.php?r=<?php echo time()+1;?>" />
					<span>Chosen Songs</span>
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

			<div class="box-content no-padding table-responsive">
				<table class="table songs-report table-bordered table-striped table-hover table-heading table-datatable" id="datatable-2">
					<thead>
						<tr>
							<th class="width150 patient"><label><input type="text" name="search_patient_name" value="patient name" class="search_init" /></label></th>
							<th class="width300 song"><label><input type="text" name="search_song_name" value="song" class="search_init" /></label></th>
							<th class="width150 artist"><label><input type="text" name="search_song_artist" value="artist" class="search_init" /></label></th>
							<th class="width150 album"><label><input type="text" name="search_album" value="album" class="search_init" /></label></th>
							<th class="cover">cover</th>
							<th class="preview">preview</th>
							<th class="buy width65"><label><input type="text" name="search_price" value="price" class="search_init" /></label></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($songs as $song): ?>
						<tr id="patient_song_<?php echo $song['pid']; ?>" class="patient_song">
							<td>
								<span class="cell">
									<i class="fa fa-user"></i>&nbsp;
									<?php echo $song['patient_name']; ?>
								</span>
							</td>
							<td>
								<span class="cell">
									<i class="fa fa-music"></i>&nbsp;
									<?php echo $song['song_name']; ?>
								</span>
							</td>
							<td>
								<span class="cell">
									<i class="fa fa-microphone"></i>&nbsp;
									<?php echo $song['song_artist']; ?>
								</span>
							</td>
							<td>
								<span class="cell">
									<i class="fa fa-book"></i>&nbsp;
									<?php echo $song['song_data']['collectionName']; ?>
								</span>
							</td>
							<td class="cover">
								<img src="<?php echo $song['song_data']['artworkUrl30']?>" alt="<?php echo $song['song_data']['collectionName']; ?>" />
							</td>
							<td>
								<span class="stream-url"><?php echo $song['song_data']['previewUrl']; ?></span>

								<div class="jquery_jplayer" id="jquery_jplayer_<?php echo "audio_".$song['pid']; ?>" class="jp-jplayer"></div>

								<div class="jp_container jp-flat-audio" id="jp_container_<?php echo "audio_".$song['pid']; ?>">
									<div class="jp-play-control jp-control">
										<a class="jp-play jp-button"></a>
										<a class="jp-pause jp-button"></a>
									</div>
									<div class="jp-bar">
										<div class="jp-seek-bar">
											<div class="jp-play-bar"></div>
											<div class="jp-details"><span class="jp-title"></span></div>
											<div class="jp-timing"><span class="jp-duration"></span></div>
										</div>
									</div>
									<div class="jp-no-solution">
										Media Player Error<br />
										Update your browser or Flash plugin
									</div>
								</div>
							</td>
							<td>
								<a alt="buy" title="buy" target="_blank" href="<?php echo $song['song_data']['trackViewUrl']; ?>">
									<i class="fa fa-dollar"><?php echo $song['song_data']['trackPrice']?></i>
								</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<a class="btn btn-primary btn-large" style="cursor:pointer;" onclick="cornify_add();return false;"><i class="fa fa-star-half-o"></i> More Rainbows and Unicorns!</a>
								&nbsp;&nbsp;
								<img style="width:33px" width="33" src="http://www.cornify.com/getacorn.php?r=<?php echo time();?>" />
							</td>
						</tr>
					</tfoot>
				</table>
			</div>

		</div>
	</div>
</div>
<div style="height: 40px;"></div>

<script type="text/javascript" src="http://www.cornify.com/js/cornify.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$.getScript('/assets/js/admin/guts-global.js', function(){
		// load breadcrumbs
		loadCrumbs([
		    {page: "reports", title: "Reports"},
		    {page: "reports/songs", title: "Chosen Songs"}
		 ]);
		$.getScript('/assets/js/admin/guts-list.js', function(){
			// Load Datatables and run plugin on tables 
			LoadDataTablesScripts(AllTables);
			// Add Drag-n-Drop feature
			WinMove();
		});
		$('#datatable-2').on('draw', function(){
			$.getScript('/assets/js/jquery.jplayer.js', function(){
				var debug = true;
				$(".jquery_jplayer").each(function(i,el){
					if(i>0){
						debug=false;
					}
			    	var player = $(this);
					var cont = player.next(".jp_container");

					player.jPlayer({
						ready: function(event) {
							player.jPlayer("setMedia", {
								title: "Preview",
								m4a: player.prev("span.stream-url").html()
							});
						},
						play: function() { // Avoid multiple jPlayers playing together.
							player.jPlayer("pauseOthers");
						},
						cssSelectorAncestor: "#"+cont.attr('id'),
						timeFormat: {
							padMin: false
						},
						swfPath: "js",
						supplied: "m4a",
						smoothPlayBar: true,
						remainingDuration: true,
						keyEnabled: true,
						keyBindings: {
							// Disable some of the default key controls
							muted: null,
							volumeUp: null,
							volumeDown: null
						},
						wmode: "window"/*,
						consoleAlerts: true,
						errorAlerts: true,
						warningAlerts: debug*/
					});
				});
			});
		    
		});
		
	});		
});
</script>