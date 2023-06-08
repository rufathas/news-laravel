<?php

namespace App\Http\Services;

use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Http\Request;

class NewsService
{

    public function insert(Request $request): void
    {
        $news = new News();
        $news->status = $request->status;
        $news->save();


        foreach ($request->data as $languageData) {
            $newsTranslation = new NewsTranslation();
            $newsTranslation->locale = $languageData["locale"];
            $newsTranslation->title = $languageData["title"];
            $newsTranslation->description = $languageData["description"];
            $news->translations()->save($newsTranslation);
        }
    }

    public function selectAll()
    {
        return News::all();
    }

    public function selectOne($id)
    {
        return News::findOrFail($id);
    }
}
