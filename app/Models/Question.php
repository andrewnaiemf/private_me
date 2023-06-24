<?php

namespace App\Models;

use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Question extends Model
{
    use HasFactory,Translatable;

    public $translatedAttributes = ['question'];

    protected $fillable = [];

    public function getTable()
    {
        return 'questions';
    }


    protected $hidden =[
        'created_at',
        'updated_at',
    ];



    public function translations()
    {
        return $this->hasMany(QuestionTranslation::class, 'question_id');
    }

}
