<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\TargetRepository;

class TargetsController extends Controller
{
    public function index(TargetRepository $targetRepository)
    {
        return $targetRepository->getList();
    }

    public function store(Request $request, TargetRepository $targetRepository)
    {
        return (new Response)->setStatusCode(201)->setContent($targetRepository->create($request->get('link')));
    }

    public function download($targetId, TargetRepository $targetRepository)
    {
        return $targetRepository->downloadFile($targetRepository->getTarget($targetId));
    }
}
