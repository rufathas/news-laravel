<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Http\Resources\NewsResources;
use App\Http\Services\NewsService;
use Illuminate\Http\JsonResponse;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function create(NewsCreateRequest $request): JsonResponse
    {
        $this->newsService->insert($request);
        return response()->json(['message' => 'news created successful']);
    }

    public function getAll() {
        return NewsResources::collection($this->newsService->selectAll());
    }

    public function getOne($id) {
        return new NewsResources($this->newsService->selectOne($id));
    }
}
