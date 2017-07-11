<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Airport extends Eloquent {

	//protected $table = 'airports';

    /**
    * list airpost by code
    * 
    */
    static public function findAllByCode() {
        $list = Airport::orderBy('IATA')->get();
        $result = array();
        foreach($list as $row) {
            $result[$row->IATA] = $row;
        }
        
        return $result;
    }

    static public function findByCitySlug($citySlug) {
        $searchKey = str_replace(array('till-', '-'), '', $citySlug) . '%';
        $destinationCity = Airport::whereRaw('IF(url_slug != "", url_slug = "' . $citySlug . '", REPLACE(city_name, " ", "") LIKE "' . $searchKey. '")')
            ->orderBy('prio')
            ->limit(1)
            ->first();
        if(is_null($destinationCity)) {
            $destinationCity = Airport::whereRaw('REPLACE(name, " ", "") LIKE "' . $searchKey . '"')
                ->orderBy('prio')
                ->limit(1)
                ->first();
        }
        
        return $destinationCity;
    }
}
