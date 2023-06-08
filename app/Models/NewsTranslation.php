<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTranslation extends Model
{
    protected $fillable = ['locale', 'title', 'description'];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
