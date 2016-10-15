	<div class="p_row">
		<h2 class="p_title"><?php echo text('nt.concerts.plugin.registered.concerts'); ?></h4>
	</div>
	
	<!-- Search and create group -->
	<div class="p_row">
		<form action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
			<input id="search-box" class="w4" type="text" name="save" placeholder="<?php echo text('nt.concerts.plugin.search'); ?>">
			<input type="hidden" name="action" value="pgp_nt_concerts_go_to_create_concert"/>
			<input id="create-btn" class="p_button w2" type="submit" name="save" value="<?php echo text('nt.concerts.plugin.new.concert'); ?>">
		</form>
	</div>
	
	<script type="text/javascript">
		$("#search-box").keyup(function() {
			var text = $(this).val();
			if(text.length>0) {
				$('.concert').each(function(i, obj) {
					var placeEl = $(obj).find('.key-place').html();
					var cityEl = $(obj).find('.key-city').html();
					if(placeEl==null || cityEl==null || 
							(placeEl.toLowerCase().indexOf(text.toLowerCase()) < 0 && cityEl.toLowerCase().indexOf(text.toLowerCase())< 0)) {
						$(obj).addClass('p-hide');
					} else {
						$(obj).removeClass('p-hide');
					}
				});
			} else {
				$('.concert').each(function(i, obj) {
					$(obj).removeClass('p-hide');
				});
			}
		});
	</script>
	
	<div class="p_table">
		<table>
			<thead>
			  <tr>
			    <th><?php echo text('nt.concerts.plugin.date'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.hour'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.place'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.address'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.city'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.region'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.price'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.map'); ?></th>
			    <th><?php echo text('nt.concerts.plugin.website'); ?></th>
			    <th></th>
			    <th></th>
			  </tr>
			</thead>
			<tbody>
			<?php 
				$concerts = get_all_concerts();
				if(isset($concerts)) {
					foreach ($concerts as $c) {
			?>
			
				<tr class="concert">
					<td><?php echo $c->day;?></td>
					<td><?php echo $c->hour;?></td>
					<td class="key-place"><?php echo $c->place;?></td>
					<td><?php echo $c->address;?></td>
					<td class="key-city"><?php echo $c->city;?></td>
					<td><?php echo $c->region;?></td>
					<td><?php echo $c->price;?></td>
					<td>
						<a class="p_link" href="<?php echo $c->maps;?>">
							<img class="p_icon hover_icon" src="<?php echo get_resource_request_url('maps-icon.png');?>"/>
						</a>
					</td>
					<td>
						<a class="p_link" href="<?php echo $c->website;?>">
							<img class="p_icon hover_icon" src="<?php echo get_resource_request_url('www-icon.png');?>"/>
						</a>
					</td>
					<td>
						<form action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
							<input type="hidden" name="action" value="pgp_nt_concerts_go_to_modify_concert"/>
							<input type="hidden" name="concert-id" value="<?php echo $c->id; ?>"/>
							<img class="p_icon p_cursor hover_icon click_action" src="<?php echo get_resource_request_url('edit-icon.png');?>"/>
						</form>
					</td>
					<td>
						<form class="deleteform" action="<?php echo PUBLIC_ACTION_URL; ?>" method="post" target="_self">
							<input type="hidden" name="action" value="pgp_nt_concerts_delete_concert"/>
							<input type="hidden" name="concert-id" value="<?php echo $c->id; ?>"/>
							<img class="p_icon p_cursor hover_icon click_action" src="<?php echo get_resource_request_url('delete-icon.png');?>"/>
						</form>
					</td>
				</tr>
				
			<?php 
					}
				}
				
			?>
			</tbody>
		</table>
	</div>
	
	<script>
		icon_hover('hover_icon');

		$(".click_action").click(function() {
			$(this).closest("form").submit();
		});

	</script>
	
	
