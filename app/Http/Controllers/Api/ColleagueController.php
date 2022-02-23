<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColleagueResource;
use App\Services\ColleagueApiHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ColleagueController extends Controller
{
    /**
     * @param ColleagueApiHandler $colleagueApiHandler
     * @return JsonResponse
     */
    public function get(ColleagueApiHandler $colleagueApiHandler): JsonResponse
    {
        return response()
            ->json(
                ColleagueResource::collection($colleagueApiHandler->getColleagues())
            );
    }
}
