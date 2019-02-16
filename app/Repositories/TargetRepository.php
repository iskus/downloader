<?php

namespace App\Repositories;

use App\Target;
use App\Jobs\ProcessTarget;
use Illuminate\Support\Facades\Storage;

/**
 * Class TargetRepository
 *
 * @package App\Repositories
 */
class TargetRepository extends BaseRepository
{
	/**
	 * @param $link
	 *
	 * @return Target
	 */
	public function create($link)
	{
		$model         = new Target();
		$model->link   = $link;
		$model->status = 'pending';
		$model->save();
		ProcessTarget::dispatch($model);

		return $model;
	}

	public function getTarget($id): Target
	{
		return Target::findOrFail($id);
	}

	public function getCompleted()
	{
		return Target::where('status', 'complete')->get();
	}

	public function getList()
	{
		return Target::all();
	}

	public function downloadFile(Target $target)
	{
		return Storage::download($target->filePath());
	}


}
