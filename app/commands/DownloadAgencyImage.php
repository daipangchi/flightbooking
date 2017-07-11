<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DownloadAgencyImage extends Command {

	protected $name = 'download:agency_images';

	protected $description = 'Download agency images for progressbar';

	public function fire()
	{
		$this->comment('.................');
		$this->comment('Download agency images...!');

		$agencyList = array('BravoFly', 'QatarAirways', 'Ticket', 'Travelfinder', 'Sembo',
			'Wegolo', 'Flightfinder', 'TravelPartner', 'AOBTravel', 'Travellink',
			'SuperSaver', 'Budjet', 'Travelstart', 'Mytrip', 'Tripsta',
			'Kiwi', 'Flygvaruhuset', 'SkyTours', 'Flygcity',
			'Kilroy', 'Mrjet', 'Seat24', 'Opodo', 'Expedia',
			'Flygpoolen', 'Flyhi');
		foreach($agencyList as $agency) {
			agency_icon($agency);
		}

		$this->comment('.................');
	}

}
