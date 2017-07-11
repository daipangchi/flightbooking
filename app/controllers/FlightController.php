<?php

class FlightController extends BaseController {

    public function __construct()
    {
        parent::__construct();
    }

    /**
    * show search index page
    * 
    */
    public function index()
    {
        // get suggestion departure city list
        $departureCityFeed = Cache::remember('feed_departure_cities_arn', 1440, function() {
            return get_departure_city_feeds('ARN');
        });

        return View::make('flight.index', compact('departureCityFeed'));
    }
    
    /**
    * show empty search page and start search
    * 
    */
    public function search() 
    {
        return View::make('flight.search');
    }
    
    /**
    * get Airports by prefix
    * 
    */
    public function getAirportByPrefix() 
    {
        // check term string
        $term = Input::get('term');
        if(strlen($term) < 2) return;
        
        $service = new TripService();
        $result = $service->getAirportByPrefix($term);
        
        // check response
        $airports = array();
        if($result != false && isset($result->GetAirportByPrefixResult->Airport)) {
            $airports = $result->GetAirportByPrefixResult->Airport;
            if(!is_array($airports)) {
                $airports = array($airports);
            }
        }
        
        // return json
        echo json_encode($airports);
        exit;
    }
    
    /**
    * get Trip data
    * 
    */
    public function getTripSearch() 
    {
        $params = [
            'IATAFrom'  => Input::get('IATAFrom'),
            'IATATo'    => Input::get('IATATo'),
            'start'     => Input::get('start'),
            'end'       => Input::get('end'),
            'oneWay'    => Input::has('oneWay') ? (bool)Input::get('oneWay') : false,
            'numAdults' => Input::has('numAdults') ? Input::get('numAdults') : 1,
            'children'  => Input::has('children') ? Input::get('children') : array(),
            'multiCity' => false,
        ];

        // get flights
        $service = new TripService();
        $response = $service->addFilters($params)
            ->setPageLimit(FLIGHT_LIMIT)
            ->setCurrency(CURRENCY_CODE)
            ->setLanguage(LANGUAGE_CODE)
            ->getTripSearch();
        //print_r(json_encode($response)); exit;

        // get airport
        $airport = Airport::where('IATA', $params['IATATo'])->first();
        $destination = null;
        if(isset($airport->id)) {
            $destination = Hotel::where('path_name', '=', $airport->city_name)
                ->orderBy('prior', 'desc')
                ->first();
        }

        // get destination feed
        /*$destinationFeed = Cache::remember('feed_destination_cities_' . strtolower($params['IATATo']), 1440, function() use ($params) {
            return get_destination_city_feeds_by_code(strtolower($params['IATATo']));
        });*/
        $destinationFeed = Cache::remember('feed_departure_cities_' . strtolower($params['IATAFrom']), 1440, function() use($params) {
            return get_departure_city_feeds($params['IATAFrom']);
        });
        
        $param['tripResult'] = isset($response->GetTripSearchResult) ? $response->GetTripSearchResult : null;
        $param['params']        = $params;
        $param['destination']   = $destination;
        $param['destinationFeed'] = $destinationFeed;
        return View::make('flight.search.trip')->with($param);
    }
    
    /**
    * filter Trip data
    * 
    */
    public function getTripSearchWithFilter() {
        $params = [
            'IATAFrom'  => Input::get('IATAFrom'),
            'IATATo'    => Input::get('IATATo'),
            'start'     => Input::get('start'),
            'end'       => Input::get('end'),
            'oneWay'    => Input::has('oneWay') ? (bool)Input::get('oneWay') : false,
            'numAdults' => Input::has('numAdults') ? Input::get('numAdults') : 1,
            'children'  => Input::has('children') ? Input::get('children') : array(),
            'multiCity' => false,
            'offset'    => Input::has('offset') ? Input::get('offset') : 0,
            'sessionId' => Input::has('sessionId') ? Input::get('sessionId') : '',
            'sortOption'=> Input::get('sortOption'),
            'selectedMaxPrice'      => Input::has('selectedMaxPrice') ? Input::get('selectedMaxPrice') : 0, 
            'selectedFlightStops'   => Input::has('selectedFlightStops') ? Input::get('selectedFlightStops') : 'any',
            'selectedDepartureTimeRange'    => Input::has('selectedDepartureTimeRange') ? Input::get('selectedDepartureTimeRange') : array(), 
            'selectedReturnTimeRange'       => Input::has('selectedReturnTimeRange') ? Input::get('selectedReturnTimeRange') : array(), 
            'selectedAirlines'              => Input::has('selectedAirlines') ? Input::get('selectedAirlines') : array(), 
			'selectedAgencys'				=> Input::has('selectedAgencys') ? Input::get('selectedAgencys') : array(),
        ];  
        
        $service = new TripService();
        $response = $service->addFilters($params)
            ->setPageLimit(FLIGHT_LIMIT)
            ->setCurrency(CURRENCY_CODE)
            ->setLanguage(LANGUAGE_CODE)
            ->getTripsWithSessionAndFilter();
        //print_r(json_encode($response)); exit;

        // determine view
        $view = 'flight.search.list';
        if(Input::get('offset') != 0) {
            $view = 'flight.search.list_more';
        } else {
            // get airport
            $airport = Airport::where('IATA', $params['IATATo'])->first();
            $destination = null;
            if(isset($airport->id)) {
                $destination = Hotel::where('path_name', 'like', $airport->city_name . '%')->first();
            }

            $param['destination'] = $destination;
        }

        $param['tripResult'] = isset($response->GetTripsWithSessionAndFilterResult) ? $response->GetTripsWithSessionAndFilterResult : null;
        $param['params'] = $params;
        return View::make($view)->with($param);
    }
}