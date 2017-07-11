<?php

function save_flight($departureFlights, $returnFlights, $price, $adultNum=1, $childNum=0) {
    if($returnFlights) {
        $hashKey = md5($departureFlights[0]->DepartureCityCode . $departureFlights[0]->DepartureDate . $departureFlights[0]->DepartureTime .
            $returnFlights[0]->DepartureCityCode . $returnFlights[0]->DepartureDate . $returnFlights[0]->DepartureTime .
            $adultNum . $childNum);
    } else {
        $hashKey = md5($departureFlights[0]->DepartureCityCode . $departureFlights[0]->DepartureDate . $departureFlights[0]->DepartureTime .
            $adultNum . $childNum);
    }

    $row = Flight::where('hash', $hashKey)->first();
    if(!isset($row->id)) {
        $row = new Flight();
        $row->departure_airport_name = $departureFlights[0]->DepartureAirportName;
        $row->departure_city_name    = $departureFlights[0]->DepartureCityName;
        $row->departure_city_code    = $departureFlights[0]->DepartureCityCode;
        $row->travellers_adult       = $adultNum;
        $row->travellers_child       = $childNum;
        $row->price                  = $price;
        $row->departure_time         = $departureFlights[0]->DepartureDate . ' ' . $departureFlights[0]->DepartureTime;
        $row->departure_stops        = count($departureFlights);
        $row->departure_timezone     = $departureFlights[0]->DepartureTimezone;
        $row->hash                   = $hashKey;
        if($returnFlights) {
            $row->return_airport_name = $returnFlights[0]->DepartureAirportName;
            $row->return_city_name = $returnFlights[0]->DepartureCityName;
            $row->return_city_code = $returnFlights[0]->DepartureCityCode;
            $row->return_time = $returnFlights[0]->DepartureDate . ' ' . $returnFlights[0]->DepartureTime;;
            $row->return_stops = count($returnFlights);
            $row->return_timezone = $returnFlights[0]->DepartureTimezone;
        }
        $row->save();
    } else {
        $row->price = $price;
        $row->save();
    }
}

function save_direct_flight($departureFlights, $returnFlights) {
    $bulkRows = array();
    foreach($departureFlights as $flight) {
        $hashKey = md5($flight->DepartureCityCode . $flight->DepartureDate . $flight->DepartureTime . $flight->ArrivalCityCode . $flight->ArrivalDate . $flight->ArrivalTime . $flight->AirlineCode . $flight->FlightNumber);
        $cnt = DirectFlight::where('hash', $hashKey)->count();

        if($cnt > 0) continue;

        $bulkRows[] = extract_flight_info($flight, $hashKey);
    }

    foreach($returnFlights as $flight) {
        $hashKey = md5($flight->DepartureCityCode . $flight->DepartureDate . $flight->DepartureTime . $flight->ArrivalCityCode . $flight->ArrivalDate . $flight->ArrivalTime . $flight->AirlineCode . $flight->FlightNumber);
        $cnt = DirectFlight::where('hash', $hashKey)->count();

        if($cnt > 0) continue;

        $bulkRows[] = extract_flight_info($flight, $hashKey);
    }

    if(count($bulkRows) > 0) {
        DirectFlight::insert($bulkRows);
    }
}

function extract_flight_info($flight, $hashKey) {
    return array(
        'departure_airport_name'=> $flight->DepartureAirportName,
        'departure_city_name'   => $flight->DepartureCityName,
        'departure_city_code'   => $flight->DepartureCityCode,
        'departure_date'        => $flight->DepartureDate,
        'departure_time'        => $flight->DepartureTime,
        'departure_timezone'    => $flight->DepartureTimezone,
        'departure_day'         => date('w', strtotime($flight->DepartureDate)),
        'arrival_airport_name'  => $flight->ArrivalAirportName,
        'arrival_city_name'     => $flight->ArrivalCityName,
        'arrival_city_code'     => $flight->ArrivalCityCode,
        'arrival_date'          => $flight->ArrivalDate,
        'arrival_time'          => $flight->ArrivalTime,
        'arrival_timezone'      => $flight->ArrivalTimezone,
        'arrival_day'           => date('w', strtotime($flight->ArrivalDate)),
        'airline_name'          => $flight->AirlineName,
        'airline_code'          => $flight->AirlineCode,
        'flight_number'         => $flight->FlightNumber,
        'hash'                  => $hashKey,
        'created_at'            => DB::raw('NOW()')
    );
}