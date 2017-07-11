<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class City extends Eloquent {

	//protected $table = 'cities';
	public $timestamps = false;

	static function getPopularDestinations() {
		$cities = City::where('destination', 1)
			->orderBy('name')
			->get();
		
		$temp = array();
		foreach($cities as $city) {
			$prefix = strtoupper(substr($city->name, 0,1));
			if(!isset($temp[$prefix])) {
				$temp[$prefix] = array();
			}

			$temp[$prefix][] = $city;
		}

		$result = array();
		$popular_destinations = Config::get('flygresor.popular_destinations');
		foreach($popular_destinations as $rowKey => $row) {
			$result[$rowKey] = array();
			foreach($row as $prefix) {
				$result[$rowKey][$prefix] = $temp[$prefix];
			}
		}
		
		return $result;
	}
}
