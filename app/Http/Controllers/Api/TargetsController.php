<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Target as TargetResource;
use App\Repositories\TargetRepository;
use App\Target;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TargetsController extends Controller
{
	public function store(Request $request, TargetRepository $targetRepository)
	{
		if (($result = $targetRepository->create($request->all())) instanceof Target) {
			return new TargetResource($result);
		}

		return $result;
	}

	/**
	 * @param                                    $targetId
	 * @param \App\Repositories\TargetRepository $targetRepository
	 *
	 * @return |null
	 */
	public function download($targetId, TargetRepository $targetRepository)
	{
		$target = $targetRepository->getTarget($targetId);
		return $targetRepository->downloadFile($target)
			?? new Response('No file', 404);
	}
}
