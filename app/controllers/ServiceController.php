<?php

class ServiceController extends BaseController {
    
    public function __construct()
    {
        //parent::__construct();
    }

    public function getAirportByPrefix() {
        $term = Input::get('term');        
        $cities = Airport::select(array(
                'city_id as CityId',
                'city_name as CityName',
                'city_name_en as CityNameEN',
                'country as Country',
                'display_name as DisplayName',
                'IATA',
                'name as Name',
                'ui_display_name as UiDisplayName',
                'ui_display_name_in_text_field as UiDisplayNameInTextField'
                ))
            ->where('city_name', 'LIKE', $term . '%')
            ->orWhere('city_name', 'LIKE', $term . '%')
            ->orWhere('display_name', 'LIKE', $term . '%')
            ->orWhere('ui_display_name', 'LIKE', $term . '%')
            ->orWhere('IATA', 'LIKE', $term . '%')
            ->orWhere('name', 'LIKE', $term . '%')
            ->orWhere('country', 'LIKE', $term . '%')
            ->limit(10)
            ->orderBy('prio')
            ->get();
        echo json_encode($cities);        
        exit;
    }

    public function getResult() {
        $params = [
            'IATAFrom'  => Input::get('IATAFrom'),
            'IATATo'    => Input::get('IATATo'),
            'start'     => Input::get('start'),
            'end'       => Input::get('end'),
            'oneWay'    => Input::has('oneWay') ? (bool)Input::get('oneWay') : false,
            'numAdults' => Input::has('numAdults') ? Input::get('numAdults') : 1,
            'children'  => Input::has('children') ? Input::get('children') : array(),
            'multiCity' => false,
            'clientId'  => Input::has('clientId') ? Input::get('clientId') : ATLAS_CLIENT_ID,
        ];
        $pageLimit = Input::has('pageLimit') ? Input::get('pageLimit') : FLIGHT_LIMIT;

        // get flights
        $service = new TripService();
        $response = $service->addFilters($params)
            ->setPageLimit($pageLimit)
            ->setCurrency(CURRENCY_CODE)
            ->setLanguage(LANGUAGE_CODE)
            ->getTripSearch();

        $response = isset($response->GetTripSearchResult) ? $response->GetTripSearchResult : array();
        echo json_encode($response);
        exit;
    }

    public function getResultWithFilter() {
        $params = [
            'IATAFrom'  => Input::get('IATAFrom'),
            'IATATo'    => Input::get('IATATo'),
            'start'     => Input::get('start'),
            'end'       => Input::get('end'),
            'oneWay'    => Input::has('oneWay') ? (bool)Input::get('oneWay') : false,
            'numAdults' => Input::has('numAdults') ? Input::get('numAdults') : 1,
            'children'  => Input::has('children') ? Input::get('children') : array(),
            'multiCity' => false,
            'clientId'  => Input::has('clientId') ? Input::get('clientId') : ATLAS_CLIENT_ID,
            'offset'    => Input::has('offset') ? Input::get('offset') : 0,
            'sessionId' => Input::has('sessionId') ? Input::get('sessionId') : '',
            'sortOption'=> Input::has('sortOption') ? Input::get('sortOption') : 'price',
            'selectedMaxPrice'      => Input::has('selectedMaxPrice') ? Input::get('selectedMaxPrice') : 0,
            'selectedFlightStops'   => Input::has('selectedFlightStops') ? Input::get('selectedFlightStops') : 'any',
            'selectedDepartureTimeRange'    => Input::has('selectedDepartureTimeRange') ? Input::get('selectedDepartureTimeRange') : array(),
            'selectedReturnTimeRange'       => Input::has('selectedReturnTimeRange') ? Input::get('selectedReturnTimeRange') : array(),
            'selectedAirlines'              => Input::has('selectedAirlines') ? Input::get('selectedAirlines') : array(),
        ];
        $pageLimit = Input::has('pageLimit') ? Input::get('pageLimit') : FLIGHT_LIMIT;

        $service = new TripService();
        $response = $service->addFilters($params)
            ->setPageLimit($pageLimit)
            ->setCurrency(CURRENCY_CODE)
            ->setLanguage(LANGUAGE_CODE)
            ->getTripsWithSessionAndFilter();

        $response = isset($response->GetTripsWithSessionAndFilterResult) ? $response->GetTripsWithSessionAndFilterResult : array();
        echo json_encode($response);
        exit;
    }
}