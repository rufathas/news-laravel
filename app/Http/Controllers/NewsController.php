<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Http\Services\NewsService;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function create(NewsCreateRequest $request) {
        $this->newsService->insert($request);
        return response()->json(['message' => 'news created successful']);
    }

}
