<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CrawlerAirport extends Command {

	protected $name = 'crawler:airports';

	protected $description = 'Crawlers the Airport';

	private $insertRows = 0;
	private $searchResult = 0;

	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		$this->comment('.................');
		$this->comment('Start Airport Crawling...!');

		$service = new TripService();
		$service->setLanguage(LANGUAGE_CODE);
		$term = $this->option('term');
		
		if($term) {
			$this->processResponse($service->getAirportByPrefix($term));
			$this->showComment($term);
		} else {
			$characterSets = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
				'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
				'u', 'v', 'w', 'x', 'y', 'z', 'å', 'ä', 'ö'
			];

			foreach($characterSets as $char1) {
				foreach($characterSets as $char2) {
					$term = $char1 . $char2;
					$this->processResponse($service->setLanguage(LANGUAGE_CODE)->getAirportByPrefix($term));
					$this->showComment($term);

					foreach($characterSets as $char3) {
						$term = $char1 . $char2 . $char3;
						$this->processResponse($service->getAirportByPrefix($term));
						$this->showComment($term);
					}
				}
			}
		}

		$this->comment('End Hotel Crawling...!');
		$this->comment('.................');
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('term', null, InputOption::VALUE_REQUIRED, 'Prefix of airport')
		);
	}
	
	private function showComment($term) {
		$this->comment(sprintf('Term:%s... %s rows inserted of %s results', $term, $this->insertRows, $this->searchResult));
	}

	/**
	 * check response from Atlas API and insert them
	 *
	 * @param $response
	 */
	private function processResponse($response) {
		$this->searchResult = 0;
		$this->insertRows = 0;

		if($response == null || $response == false) return;
		if(!isset($response->GetAirportByPrefixResult)) return;
		if(!isset($response->GetAirportByPrefixResult->Airport)) return;

		$airports = $response->GetAirportByPrefixResult->Airport;
		if(!is_array($airports)) {
			$airports = array($airports);
		}

		$this->searchResult = count($airports);
		foreach($airports as $item) {
			$cnt = Airport::where('IATA', $item->IATA)->count();
			if ($cnt == 0) {
				$this->insertRows++;
				$this->insertAirport($item);
			}
		}
	}

	/**
	 * insert city data to airports table
	 *
	 * @param $item
	 * @return bool
	 */
	private function insertAirport($item) {
		$airport = new Airport;
		$airport->city_id = empty($item->CityId) ? '' : $item->CityId;
		$airport->city_name = empty($item->CityName) ? '' : $item->CityName;
		$airport->city_name_en = empty($item->CityNameEN) ? '' : $item->CityNameEN;
		$airport->country = empty($item->Country) ? '' : $item->Country;
		$airport->display_name = $item->DisplayName;
		$airport->has_city = $item->HasCity;
		$airport->IATA = $item->IATA;
		$airport->name = $item->Name;
		$airport->prio = $item->Prio;
		$airport->ui_display_name = $item->UiDisplayName;
		$airport->ui_display_name_in_text_field = $item->UiDisplayNameInTextField;
		$airport->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', iconv('utf-8', 'us-ascii//TRANSLIT', $item->Name)));
		return $airport->save();
	}

}
