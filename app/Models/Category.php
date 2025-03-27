<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{

    use HasTranslations;

    protected $casts = [
        'type' => CategoryType::class
    ];
    protected $guarded = ['id','created_at','updated_at'];

    protected $translatable = ['name'];

}
