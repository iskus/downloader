<?php

namespace App\Console\Commands;

use App\Repositories\TargetRepository;
use Illuminate\Console\Command;

class PutTarget extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'targets:put {link}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Add new targets to the download queue';

	/**
	 * @var \App\Repositories\TargetRepository
	 */
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
	 *
	 * @return mixed
	 */
	public function handle()
	{
		return $this->targetRepository->create($this->argument('link'));

	}
}
