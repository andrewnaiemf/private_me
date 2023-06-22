<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class PlanProperty extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,Translatable;


    public $translatedAttributes = ['name','value'];


    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }    
}
