<?php

use Illuminate\Console\Command;
use Illuminate\Filesystem\FileNotFoundException;
use Symfony\Component\Finder\Finder;

class CrawlerHotel extends Command {

	protected $name = 'crawler:hotels';

	protected $description = 'Crawlers the Hotel';

	protected $feedUrl = 'http://transport.productsup.io/9c5cb7c99cdc2d42a459/channel/29604/pdsfeed.csv';
	protected $fileName = 'pdsfeed.csv';

	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		$this->comment('.................');
		$this->comment('Start Hotel Crawling...!');

		// download csv file from remote
		if($this->downloadFeedFile()) {
			$this->comment('Downloading completed!');
			Log::info('Hotel feed downloading completed!');

			//open the local csv file
			$file = storage_path('feeds/' . $this->fileName);
			$handle = fopen($file, "r");

			//loop through the records
			while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE) {
				for ($c=0; $c < 1; $c++) {
					if($data[0] == 'PathId') continue;
					if(count($data) < 2) continue;

					// insert or update hotel row
					$hotelRow = Hotel::where('path_id', $data[0])->first();
					if(isset($hotelRow->id)) {
						$hotelRow->min_price = $data[2];
					} else {
						$hotelRow = new Hotel;
						$hotelRow->path_id 		= $data[0];
						$hotelRow->path_name 	= $data[1];
						$hotelRow->min_price 	= $data[2];
					}
					$hotelRow->save();
				}
			}

			Log::info('Importing completed!');
		} else {
			$this->comment('Downloading Failed!');
			Log::info('Hotel feed downloading failed!');
		}

		$this->comment('End Hotel Crawling...!');
		$this->comment('.................');
	}

	private function downloadFeedFile()
	{
		// make path to save csv file
		$savePath = storage_path('feeds');
		mkpath($savePath, false);
		Config::set('laravel-storage::local.path', $savePath);

		//collect the remote csv file
		$csv = file_get_contents($this->feedUrl);

		//save the data to a local csv file
		Storage::delete($this->fileName);

		return Storage::put($this->fileName, $csv);
	}
}
