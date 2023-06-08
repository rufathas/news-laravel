<?php

namespace App\Http\Services;

use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;

class NewsService
{

    public function insert(Request $request): News
    {
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
        return $news;
    }

    public function selectAll()
    {
        return News::all();
    }

    public function selectOne($id)
    {
        return News::findOrFail($id);
    }

    public function update($id, Request $request)
    {
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
        return $news;
    }

    public function delete($id) : void
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}
