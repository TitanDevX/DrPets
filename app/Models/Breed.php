<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Breed extends Model
{
    use HasTranslations;

    protected $guarded = ['id','created_at','updated_at'];

    protected $translatable = ['name','description'];


    public function pets(){
        return $this->has(Pet::class);
    }
}
