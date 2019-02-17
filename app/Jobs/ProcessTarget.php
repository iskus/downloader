<?php

namespace App\Jobs;

use App\Repositories\TargetRepository;
use App\Target;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ProcessTarget implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * @var \App\Target
	 */
	protected $target;


	/**
	 * Create a new job instance.
	 *
	 * @param Target $target
	 *
	 * @return void
	 */
	public function __construct(Target $target)
	{
		$this->target = $target;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(TargetRepository $targetRepository): void
	{

		try {
			$this->target->downloading();
			sleep(5);
			ini_set('memory_limit', '-1');
			Storage::put($this->target->filePath(), $this->target->link, 'public');
			$this->target->complete();
		} catch (Exception $e) {
			$this->target->error();
			Log::error($e->getMessage());
		}
	}

}
