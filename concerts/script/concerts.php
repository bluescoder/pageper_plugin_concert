<?php 

include_once 'model/Concert.php';

define('PLGCONCERTS_CONCERTS_TABLE', 'concert');

define ('NT_CONCERT_PLUGIN_DIALOG_ACTION', 'nt_concert_plugin_dialog_action');
define ('NT_CONCERT_PLUGIN_CREATE', 'nt_concert_plugin_create');
define ('NT_CONCERT_PLUGIN_MODIFY', 'nt_concert_plugin_modify');
define ('NT_CONCERT_PLUGIN_MODIFY_CONCERT_INFO', 'nt_concert_plugin_modify_concert_info');
define ('NT_CONCERT_PLUGIN_ERRORS', 'nt_concert_plugin_errors');

/**
 * Gets all concerts following recived date. If date is not provided gets all concertes
 * from current date
 * @param $dateFilter
 */
function get_all_concerts($dateFilter = 0) {
	if($dateFilter == 0) {
		$dateFilter = date('Y-m-d');
	}
	
	$db = get_db_handler();
	$pps = $db->prepare(
			" SELECT id, day, hour, place, address, region, city, website, maps, price
			  FROM " . PLGCONCERTS_CONCERTS_TABLE . " 
			  WHERE day > :dateFilter  
		    ORDER BY day DESC, hour DESC"
			);
	$dateFilter = date('Y-m-d');
	$pps->bindParam(":dateFilter", $dateFilter);
	$pps->execute();
	$results= $pps->fetchAll();

	$concerts = [];
	foreach($results as $c) {
		array_push($concerts, create_concert_obj_from_db_result($c));
	}
	return $concerts;
}

/**
 * Checks if the concert with given id exists
 * @param $id
 */
function get_concert_by_id($id) {
	$concert = null;
	if (isset ( $id )) {
		$db = get_db_handler ();
		$pps = $db->prepare ( "SELECT id, day, hour, place, address, region, city, website, maps, price
			 FROM " . PLGCONCERTS_CONCERTS_TABLE . " WHERE id = :id" );
		$pps->bindParam ( ":id", $id );
		$pps->execute ();
		$results = $pps->fetchAll ();
		
		if(count($results) == 1) {
			$concert = create_concert_obj_from_db_result($results[0]);
		}
	}
	return $concert;
}

/**
 * Creates a Concert object with info received from a db row
 * @param $r
 * @return Concert
 */
function create_concert_obj_from_db_result($r) {
	return new Concert($r['id'], $r['day'], $r['hour'], $r['place'], $r['address'], $r['region'],
					$r['city'], $r['website'], $r['maps'], $r['price']);
}

?>