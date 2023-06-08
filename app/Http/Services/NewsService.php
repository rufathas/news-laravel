<?php

namespace App\Http\Services;

use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class NewsService
{

    public function insert(Request $request): News
    {
        Log::channel('actionlog')->info("Class: NewsService.insert start");

        $news = new News();
        $news->status = $request->status;
        $news->view_count = 0;
        $news->save();

        foreach ($request->data as $languageData) {
            $newsTranslation = new NewsTranslation();
            $newsTranslation->locale = $languageData["locale"];
            $newsTranslation->title = $languageData["title"];
            $newsTranslation->description = $languageData["description"];
            $news->translations()->save($newsTranslation);
        }
        
        Cache::tags(['all_news'])->flush();
        Log::channel('actionlog')->info("Class: NewsService.insert end");
        return $news;
    }

    public function selectAll()
    {
        $currentPage = Paginator::resolveCurrentPage();
        return  Cache::tags(['all_news'])->remember('all_news_'.$currentPage, env('REDIS_EXPIRE_SECONDS'), function () use ($currentPage) {
            $perPage = 5;
            $news = News::paginate($perPage, ['*'], 'page', $currentPage);
            $news->withPath(route('news.getAll'));
            return $news;
        });
    }

    public function selectOne($id)
    {
        return News::findOrFail($id);
    }

    public function update($id, Request $request)
    {
        Log::channel('actionlog')->info("Class: NewsService.update start");

        $news = News::findOrFail($id);
        $news->status = $request->status;
        $news->save();

        foreach ($request->data as $languageData) {
            $newsTranslation = $news->translations()->where('locale', $languageData['locale'])->first();
            if ($newsTranslation) {
                $newsTranslation->title = $languageData['title'];
                $newsTranslation->description = $languageData['description'];
                $newsTranslation->save();
            }
        }

        Cache::tags(['all_news'])->flush();
        Log::channel('actionlog')->info("Class: NewsService.update end");
        return $news;
    }

    public function delete($id) : void
    {
        Log::channel('actionlog')->info("Class: NewsService.delete start");

        $news = News::findOrFail($id);
        $news->delete();

        Cache::tags(['all_news'])->flush();
        Log::channel('actionlog')->info("Class: NewsService.delete end");
    }
}
