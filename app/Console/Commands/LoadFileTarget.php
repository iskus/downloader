<?php

namespace App\Console\Commands;

use App\Repositories\TargetRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LoadFileTarget extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'target:load {target}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'load target';

	private $targetRepository;

	/**
	 * Create a new command instance.
	 *
	 * @param \App\Repositories\TargetRepository $targetRepository
	 */
	public function __construct(TargetRepository $targetRepository)
	{
		parent::__construct();

		$this->targetRepository = $targetRepository;
	}

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		try {
			$target = $id = (int)$this->argument('target');

			if ($target = $this->targetRepository->getTarget($target)) {

				if ($target->completed() && Storage::exists(
						$filePath = 'downloads/'.$target->filename()
					)
				) {
					$this->info('#'.$target.' File '.$filePath.' downloaded');

					return Storage::get($filePath);
				}
				$this->line('File by target with id #'.$id.' not complete!');
			}
		} catch (\Exception $e) {
			$this->error($e->getMessage());
		}
	}
}
