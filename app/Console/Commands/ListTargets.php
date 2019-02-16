<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Target;

class ListTargets extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'targets:list';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Show all targets';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
		$targets = Target::all();

		if (!count($targets)) {
			$this->line('No targets available');
		}

		foreach ($targets as $target) {
			$id     = $target->getKey();
			$status = $target->status;
			$url    = $target->link;
			$this->info("Target #$id - $status - $url");
		}
	}

}
