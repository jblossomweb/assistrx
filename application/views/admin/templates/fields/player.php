<?php if (!isset($player_id)) $player_id = "audio_1"; ?>
<div class="form-group <?php echo $name; ?>">
	<label class="col-sm-3 control-label"><?php echo $label; ?></label>
	<div class="col-sm-5">

		<span class="stream-url"><?php echo $value; ?></span>

		<div id="jquery_jplayer_<?php echo $player_id; ?>" class="jp-jplayer"></div>

		<div id="jp_container_<?php echo $player_id; ?>" class="jp-flat-audio">
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

	</div>
</div>