<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['locale', 'question'];

    public function getTable()
    {
        return 'question_translations';
    }
}
