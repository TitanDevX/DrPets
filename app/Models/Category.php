<?php

namespace App\Models;

use App\Enums\CategoryType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{

    use HasTranslations, HasFactory;

    protected $casts = [
        'type' => CategoryType::class
    ];
    protected $guarded = ['id','created_at','updated_at'];

    protected $translatable = ['name','description'];


    public function products(){
        if($this->type != CategoryType::PRODUCT) return null;
        return $this->hasMany(Product::class);
    }
    public function services(){
        if($this->type != CategoryType::SERVICE) return null;
        return $this->hasMany(Service::class);
    }
}
