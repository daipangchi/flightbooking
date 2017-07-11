<?php

class PageController extends BaseController {
    
    public function __construct()
    {
        parent::__construct();
    }
    
	public function flygradsla()
	{
        return View::make('page.flygradsla');
	}

    public function gravid()
    {
        return View::make('page.gravid');
    }

    public function omoss()
    {
        return View::make('page.omoss');
    }

    public function notFound()
    {
        return View::make('page.404');
    }

    public function city($slug) {
        $city = City::where('slug', $slug)->first();
        if($city) {
            $destinationCity = Airport::findByCitySlug($slug);
            /*$destinationFeed = Cache::remember('feed_destination_cities_' . strtolower($slug), 1440, function() use ($slug) {
                return get_destination_city_feeds_by_slug($slug);
            });*/
            $destinationFeed = Cache::remember('feed_departure_cities_arn', 1440, function() {
                return get_departure_city_feeds('ARN');
            });

            $param['city'] = $city;
            $param['destinationCity'] = $destinationCity;
            $param['destinationFeed'] = $destinationFeed;
            return View::make('page.city')->with($param);
        }

        return Redirect::to(route('page.404'));
    }

    public function destinationer() {
        return View::make('page.destinationer');
    }

    public function saveCity() {
        if(Input::has('name')) {

            $cnt = City::where('name', Input::get('name'))->count();

            if ($cnt == 0) {
                $row = new City();
                $row->name = Input::get('name');
                $row->short_description = Input::get('short_description');
                $row->description = Input::get('description');
                $row->slug = strtolower($row->name);
                $row->save();
            }
        }

        return Redirect::to('http://localhost/test/html.php');
    }
}