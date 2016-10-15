<?php 

/**
 * Script with install and uninstall functions
 */

include_once 'concerts.php';

/**
 * Installs the plugin
 */
function install() {
	$db = get_db_handler ();
	$pps = $db->prepare ( "CREATE TABLE ". PLGCONCERTS_CONCERTS_TABLE . " (
				id INTEGER PRIMARY KEY,
				day DATETIME, 
				hour TIMESTAMP, 
				place VARCHAR(200), 
				address VARCHAR(200), 
				city VARCHAR(200), 
				region VARCHAR(200), 
				website VARCHAR(200), 
				maps VARCHAR(200), 
				price REAL)" );
		$pps->execute();
}

/**
 * Uninstalls the plugin
 */
function uninstall() {
	drop_table(PLGCONCERTS_CONCERTS_TABLE);
}

?>