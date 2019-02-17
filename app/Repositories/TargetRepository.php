<?php

namespace App\Repositories;

use App\Jobs\ProcessTarget;
use App\Target;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Class TargetRepository
 *
 * @package App\Repositories
 */
class TargetRepository extends BaseRepository
{
	/**
	 * @param array $attributes
	 *
	 * @return mixed
	 */
	public function create($attributes)
	{
		if (($validator = Validator::make($attributes, ['link' => ['required', 'min:10', 'url']]))->fails()) {
			return ['errors' => $validator->errors()];
		}

		$attributes['status'] = 'pending';
		$target               = new Target($attributes);

		if ($target->save()) {
			ProcessTarget::dispatch($target);

			return $target;
		}

		return false;

	}

	public function getTarget($id): Target
	{
		/**
		 * @var  Target
		 */
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
		return Storage::exists($filePath = $target->filePath()) ? Storage::download($filePath) : null;
	}


}
