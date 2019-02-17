<?php

namespace App\Http\Controllers;

use App\Repositories\TargetRepository;
use Illuminate\Http\Request;
use Storage;

class TargetsController extends Controller
{
	public function index(TargetRepository $targetRepository)
	{
		$targets = $targetRepository->getList();

		return view('targets', compact('targets'));
	}

	public function add()
	{
		return view('targets');
	}

	public function store(Request $request, TargetRepository $targetRepository)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'title' => 'required|unique:posts|max:255',
				'body'  => 'required',
			]
		);

		if ($validator->fails()) {
			return redirect('post/create')
				->withErrors($validator)
				->withInput();
		}
		$target = $targetRepository->create($request->get('link'));

		return redirect('/targets')->withHeaders(
			[
				'targets-id' => $target->id,
			]
		);
	}

	public function download($targetId, TargetRepository $targetRepository)
	{
		return $targetRepository->downloadFile($targetRepository->getTarget($targetId));

	}
}
