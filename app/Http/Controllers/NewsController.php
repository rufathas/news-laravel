<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Http\Resources\NewsResources;
use App\Http\Services\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function create(NewsCreateRequest $request): NewsResources
    {
        return new NewsResources($this->newsService->insert($request));
    }

    public function getAll(): AnonymousResourceCollection
    {
        return NewsResources::collection($this->newsService->selectAll());
    }

    public function getOne($id): NewsResources
    {
        return new NewsResources($this->newsService->selectOne($id));
    }

    public function update($id, NewsCreateRequest $request): NewsResources
    {
        return new NewsResources($this->newsService->update($id,$request));
    }

    public function delete($id): JsonResponse
    {
        $this->newsService->delete($id);
        return response()->json(['message' => 'news deleted successful']);
    }
}
