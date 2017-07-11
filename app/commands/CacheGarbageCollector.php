<?php

use Illuminate\Console\Command;
use Illuminate\Filesystem\FileNotFoundException;
use Symfony\Component\Finder\Finder;

class CacheGarbageCollector extends Command {

	protected $name = 'cache:gc';

	protected $description = 'Garbage-collect the cache files';

	public function __construct()
	{
		parent::__construct();
	}

	public function fire()
	{
		// Make a storage disk for the cache location
		$cachePath = Config::get('cache.path');
		Config::set('laravel-storage::local.path', $cachePath);

		$expired_file_count = 0;
		$active_file_count = 0;

		// Grab the cache files
		$files = $this->allFiles($cachePath);
		// Loop the files and get rid of any that have expired
		foreach($files as $key => $cachefile) {
			// Ignore this file
			if($cachefile == '.gitignore') {
				continue;
			}
			try {
				// Grab the contents of the file
				$contents = Storage::get($cachefile->getRelativePathName());
				// Get the expiration time
				$expire = substr($contents, 0, 10);
				// See if we have expired
				if(time() >= $expire) {
					// Delete the file
					Storage::delete($cachefile->getRelativePathName());
					$expired_file_count++;
				} else {
					$active_file_count++;
				}
			} catch(FileNotFoundException $e) {
				//echo $e->getMessage();
				// Getting an occasional error of this type on the 'get' command above,
				// so adding a try-catch to skip the file if we do.
			}
		}

		$this->line('Total expired cache files removed: ' . $expired_file_count);
		$this->line('Total active cache files remaining: ' . $active_file_count);

		Log::info('Total expired cache files removed: ' . $expired_file_count);
		Log::info('Total active cache files remaining: ' . $active_file_count);
	}

	private function allFiles($directory)
	{
		return iterator_to_array(Finder::create()->files()->in($directory), false);
	}
}
