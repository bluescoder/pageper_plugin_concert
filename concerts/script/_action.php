<?php 

/**
 * Script to process plugin actions from view
 */

include_once  'concerts.php';

register_action('pgp_nt_concerts_back');
register_action('pgp_nt_concerts_persist_concert');
register_action('pgp_nt_concerts_go_to_create_concert');
register_action('pgp_nt_concerts_go_to_modify_concert');
register_action('pgp_nt_concerts_delete_concert');

define("CONCERT_ATTRIBUTES", array('id', 'date', 'hour', 'place', 'website', 'address', 'region', 'city', 'price', 'maps'));
define("CONCERT_MANDATORY_ATTRIBUTES", array('date', 'hour', 'place', 'website', 'address', 'region', 'city', 'price', 'maps'));

/**
 * Goes to view for creating a new concert
 */
function pgp_nt_concerts_go_to_create_concert() {
	$_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION] = NT_CONCERT_PLUGIN_CREATE;
}

/**
 * Goes to view for modify a concrete concert information
 */
function pgp_nt_concerts_go_to_modify_concert() {
	if(isset($_POST['concert-id'])) {
		$concert = get_concert_by_id($_POST['concert-id']);
		if(isset($concert)) {
			$_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION] = NT_CONCERT_PLUGIN_MODIFY;
			$_SESSION[NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO] = serialize($concert);
		}
	}
}

/**
 * Action to delete a concert
 */
function pgp_nt_concerts_delete_concert() {
	if(isset($_POST['concert-id'])) {
		$db = get_db_handler();
		$pps = $db->prepare("DELETE FROM " . PLGCONCERTS_CONCERTS_TABLE .
				" WHERE id = :id");
		$pps->bindParam(":id", $_POST['concert-id']);
		$pps->execute();
	}
}

/**
 * Creates a new concert
 */
function pgp_nt_concerts_persist_concert() {
	$_SESSION[NT_CONCERT_PLUGIN_ERRORS] = array();
	
	$concert = new Concert ( isset($_POST ['id']) ? $_POST['id'] : null, trim($_POST ['date']), trim($_POST ['hour']), 
			trim($_POST ['place']), trim($_POST ['address']), trim($_POST ['region']), trim($_POST ['city']), 
			trim($_POST['website']), trim($_POST['maps']), trim($_POST['price']) );
	$_SESSION[NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO] = serialize($concert);
	
	
	check_concert_parameters_provided();
	$concert->validate_parameters_for_creation($_SESSION[NT_CONCERT_PLUGIN_ERRORS]);
	if(count($_SESSION[NT_CONCERT_PLUGIN_ERRORS]) == 0) {
		if(isset($concert->id) && strlen($concert->id)>0) {
			update_concert($concert);
		} else {
			register_concert($concert);
		}
		pgp_nt_concerts_back();
	}
}

/**
 * Comprueba que se han proporcionado todos los parámetros obligatorios
 */
function check_concert_parameters_provided() {
	$checked = true;
	foreach (CONCERT_MANDATORY_ATTRIBUTES as $att) {
		if(!isset($_POST[$att]) || strlen(trim($_POST[$att]))==0) {
			$checked = false;
			$_SESSION[NT_CONCERT_PLUGIN_ERRORS][$att] = true;
		}
	}
	return $checked;
}

/**
 * Cancel creation or modification and returns to main menu
 */
function pgp_nt_concerts_back() {
	unset($_SESSION[NT_CONCERT_PLUGIN_DIALOG_ACTION]);
	unset($_SESSION[NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO]);
	unset($_SESSION[NT_CONCERT_PLUGIN_ERRORS]);
}

/**
 * Updates a concert information on db
 * @param $concert
 */
function update_concert($concert) {
		$db = get_db_handler();
		$pps = $db->prepare(
				"UPDATE " . PLGCONCERTS_CONCERTS_TABLE . 
			  " SET day = :day,
					 hour = :hour,
					 place = :place,
					 address = :address,
					 city = :city,
				   region = :region,
					 website = :website,
					 maps = :maps,
					 price = :price
		  WHERE id = :id");
		$pps->bindParam(":id", $concert->id);
		$pps->bindParam(":day", $concert->day);
		$pps->bindParam(":hour", $concert->hour);
		$pps->bindParam(":place", $concert->place);
		$pps->bindParam(":address", $concert->address);
		$pps->bindParam(":city", $concert->city);
		$pps->bindParam(":region", $concert->region);
		$pps->bindParam(":website", $concert->website);
		$pps->bindParam(":maps", $concert->maps);
		$priceFloat = $concert->get_price_as_float();
		$pps->bindParam(":price", $priceFloat);
		$pps->execute();
}

/**
 * Register a new concert on db
 * @param $concert
 */
function register_concert($concert) {
	$db = get_db_handler();
	$pps = $db->prepare(
			"INSERT INTO " . PLGCONCERTS_CONCERTS_TABLE . " (day, hour, place, address, city, region, website, maps, price)
			VALUES (:day, :hour, :place, :address, :city, :region, :website, :maps, :price)");
	$pps->bindParam(":day", $concert->day);
	$pps->bindParam(":hour", $concert->hour);
	$pps->bindParam(":place", $concert->place);
	$pps->bindParam(":address", $concert->address);
	$pps->bindParam(":city", $concert->city);
	$pps->bindParam(":region", $concert->region);
	$pps->bindParam(":website", $concert->website);
	$pps->bindParam(":maps", $concert->maps);
	$priceFloat = $concert->get_price_as_float();
	$pps->bindParam(":price", $priceFloat);
	$pps->execute();
}


?>