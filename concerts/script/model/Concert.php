<?php 

/**
 * Class which encapsulates a concert a info. Provides methods for validate inputa data
 * and more
 * @author david
 */
class Concert {
	
	public $id;
	public $day;
	public $hour;
	public $place;
	public $address;
	public $region;
	public $city;
	public $website;
	public $maps;
	public $price;
	
	/**
	 * Constructor
	 * @param $id
	 * @param $day
	 * @param $hour
	 * @param $place
	 * @param $address
	 * @param $region
	 * @param $city
	 * @param $website
	 * @param $maps
	 * @param $price
	 */
	public function __construct($id, $day, $hour, $place, $address, $region, $city, $website, $maps, $price) {
		$this->id = $id;
		$this->day = $day;
		$this->hour = $hour;
		$this->place = $place;
		$this->address = $address;
		$this->region = $region;
		$this->city = $city;
		$this->website = $website;
		$this->maps = $maps;
		$this->price = $price;
	}
	
	/**
	 * Validate that provided parameters in this object ara valid to register a new concert. It returns an error 
	 * key to show a text or null if check is ok
	 */
	public function validate_parameters_for_creation(&$errorsArray) {
		if(!$this->validate_date($this->day)) {
			$errorsArray['date'] = true;
		} 
		if(!$this->validate_time($this->hour)) {
			$errorsArray['hour'] = true;
		} 
		if(!$this->validate_price($this->price)) {
			$errorsArray['price'] = true;
		}
	}
	
	/**
	 * Checks that received date is valid in format yyyy/mm/dd
	 * @param $date
	 * @return boolean
	 */
	function validate_date($date) {
		$date_array  = explode('-', $date);
		return checkdate($date_array[1], $date_array[2], $date_array[0]);
	}
	
	/**
	 * Checks if a string with time in format HH:mm is valid (0-23 hours)
	 * @param $time
	 */
	function validate_time($time) {
		return preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/', $time);
	}

	/**
	 * Checks that price is valid
	 * @param $price
	 * @return boolean
	 */
	function validate_price($price) {
		$floatVal = floatval($price);
		return is_float($floatVal) && $floatVal>=0;
	}
	
	/**
	 * Returns price as float
	 * @return number
	 */
	public function get_price_as_float() {
		return floatval($this->price);
	}
	
}

?>