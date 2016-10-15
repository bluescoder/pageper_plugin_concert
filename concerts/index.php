<?php 

require_once 'script/concerts.php';

?>

<div class="p_header">
	<h1 class="p_title"><?php echo text('nt.concerts.plugin.name') . " - " . text('nt.concerts.plugin.description'); ?></h1>
</div>

<div class="p_content">
	<?php 
		if(isset($_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION])) {
			include 'view/dialog.php';
		} else {
			include 'view/home.php';
		}
	?>

</div>

