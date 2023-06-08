<?php

namespace App\Http\Services;

use App\Exceptions\NewsNotFoundException;
use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;
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
        Log::channel('actionlog')->info("Class: NewsService.insert end");
        return $news;
    }

    public function selectAll()
    {
        return News::all();
    }

    /**
     * @throws NewsNotFoundException
     */
    public function selectOne($id)
    {
        return News::findOrFail($id);
    }

    /**
     * @throws NewsNotFoundException
     */
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

        Log::channel('actionlog')->info("Class: NewsService.update end");
        return $news;
    }

    public function delete($id) : void
    {
        Log::channel('actionlog')->info("Class: NewsService.delete start");

        $news = News::findOrFail($id);
        $news->delete();

        Log::channel('actionlog')->info("Class: NewsService.delete end");
    }
}
