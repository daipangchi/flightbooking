<?php

class BaseController extends Controller {

    public function __construct()
    {
        //parent::__construct();

		// get suggestion departure city list
		/*$suggestionDepartureCities = Cache::rememberForever('suggestion_departure_cities', function() {
			$cityCodeList = ['ARN', 'GOT', 'MMX', 'CPH', 'OSL', 'KSD', 'JKG'];
			return Airport::select(array(
					'city_id',
					'city_name',
					'city_name_en',
					'country',
					'display_name',
					'IATA',
					'name',
					'ui_display_name',
					'ui_display_name_in_text_field'
				))
				->whereIn('IATA', $cityCodeList)
				->orderBy('prio2')
				->get()
				->toArray();
		});*/
        $cityCodeList = ['ARN', 'GOT', 'MMX', 'CPH', 'OSL', 'KSD', 'JKG'];
        $suggestionDepartureCities = Airport::select(array(
                'city_id',
                'city_name',
                'city_name_en',
                'country',
                'display_name',
                'IATA',
                'name',
                'ui_display_name',
                'ui_display_name_in_text_field'
            ))
            ->whereIn('IATA', $cityCodeList)
            ->orderBy('prio2')
            ->get()
            ->toArray();
        

		// get suggestion destination list
		/*$suggestionDestinationCities = Cache::rememberForever('suggestion_destination_cities', function() {
			$cityCodeList = ['CPH', 'LON', 'OSL', 'HEL', 'AMS', 'PAR', 'BER'];
			return Airport::select(array(
					'city_id',
					'city_name',
					'city_name_en',
					'country',
					'display_name',
					'IATA',
					'name',
					'ui_display_name',
					'ui_display_name_in_text_field'
				))
				->whereIn('IATA', $cityCodeList)
				->orderBy('prio3')
				->get()
				->toArray();
		});*/
        $cityCodeList = ['CPH', 'LON', 'OSL', 'HEL', 'AMS', 'PAR', 'BER'];
        $suggestionDestinationCities = Airport::select(array(
                'city_id',
                'city_name',
                'city_name_en',
                'country',
                'display_name',
                'IATA',
                'name',
                'ui_display_name',
                'ui_display_name_in_text_field'
            ))
            ->whereIn('IATA', $cityCodeList)
            ->orderBy('prio3')
            ->get()
            ->toArray();

		// get popular destinations by given array
		/*$popularDestinations = Cache::rememberForever('popular_destinations', function() {
			return City::getPopularDestinations();
		});*/
		$popularDestinations = City::getPopularDestinations();

		View::share('suggestionDepartureCities', $suggestionDepartureCities);
		View::share('suggestionDestinationCities', $suggestionDestinationCities);
		View::share('popularDestinations', $popularDestinations);
    }
    
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
