<?php 

/**
 * Facade which exposes functionality to website
 */

require_once 'concerts.php';

/**
 * Gets following concerts
 */
function get_following_concerts($limitCount = 100) {
	$concerts = get_all_concerts();
	$limitedConcerts = array();
	
	if(isset($concerts)) {
		if(count($concerts) > $limitCount) {
			$start = count($concerts) - $limitCount;
			for($i = 0; $i<$limitCount; $i++) {
				array_push($limitedConcerts, $concerts[$start + $i]);
			}
		} else {
			$limitedConcerts = $concerts;
		}
	}
	
	return $limitedConcerts;
}


?>