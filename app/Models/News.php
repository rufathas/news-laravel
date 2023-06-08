<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Translatable;

    protected  $table = "news";

    protected $fillable = ['status', 'view_count'];

    public $translatedAttributes = ['title', 'description'];

}
