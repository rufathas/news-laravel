<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsCreateRequest;
use App\Http\Resources\NewsResources;
use App\Http\Services\NewsService;

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

    public function getAll() {
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
}
