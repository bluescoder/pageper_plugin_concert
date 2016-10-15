
	<div class="p_row">
		<h2 class="p_title">
			<?php 
				if($_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION] == NT_CONCERT_PLUGIN_CREATE) {
					echo text('nt.concerts.plugin.create.concert');
				} else if($_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION] == NT_CONCERT_PLUGIN_MODIFY) {
					echo text('nt.concerts.plugin.edit.concert');
				} 
				
				if(isset($_SESSION[NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO])) {
					$concertInfo = unserialize($_SESSION[NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO]);
				}
			?>
		</h4>
	</div>
	
	<div class="p_row">
		<form id="form" action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
			<input id="form-action" type="hidden" name="action" value="pgp_nt_concerts_persist_concert"/>
			<input type="hidden" name="id"  value="<?php if(isset($concertInfo) && isset($concertInfo->id)) { echo $concertInfo->id; }?>"/>
			
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['date'])) { echo "p_error";}?>" 
				type="date" name="date" placeholder="<?php echo text('nt.concerts.plugin.date'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->day; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['hour'])) { echo "p_error";}?>" 
				type="time" name="hour" placeholder="<?php echo text('nt.concerts.plugin.hour'); ?>" 
				value="<?php if(isset($concertInfo)) { echo $concertInfo->hour; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['place'])) { echo "p_error";}?>" 
				type="text" name="place" placeholder="<?php echo text('nt.concerts.plugin.place'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->place; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['address'])) { echo "p_error";}?>" 
				type="text" name="address" placeholder="<?php echo text('nt.concerts.plugin.address'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->address; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['city'])) { echo "p_error";}?>" 
				type="text" name="city" placeholder="<?php echo text('nt.concerts.plugin.city'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->city; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['region'])) { echo "p_error";}?>" 
				type="text" name="region" placeholder="<?php echo text('nt.concerts.plugin.region'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->region; }?>"/>
			<input class="w3 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['price'])) { echo "p_error";}?>" 
				type="number" name="price" placeholder="<?php echo text('nt.concerts.plugin.price'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->price; }?>"/>
			<br/>
			<input class="w9 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['website'])) { echo "p_error";}?>" 
				type="text" name="website" placeholder="<?php echo text('nt.concerts.plugin.website'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->website; }?>"/>
			<input class="w9 <?php if(isset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]['maps'])) { echo "p_error";}?>" 
				type="text" name="maps" placeholder="<?php echo text('nt.concerts.plugin.map'); ?>"
				value="<?php if(isset($concertInfo)) { echo $concertInfo->maps; }?>"/>
			
			<br/>
			<input id="back-button" class="w2" type="button" value="<?php echo text("nt.concerts.plugin.cancel"); ?>"/>
			<input class="w2" type="submit" value="<?php echo text("nt.concerts.plugin.save.concert"); ?>"/>
		</form>
		
	</div>
	
	<script>
		$("#back-button").click(function() {
			$("#form-action").val("pgp_nt_concerts_back");
			$("#form").submit();
		});
	</script>
	