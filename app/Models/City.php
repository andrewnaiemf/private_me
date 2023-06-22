<?php

namespace App\Models;

use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Locale;

class City extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name_ar','name_en','name_eu'
    ];

    protected $hidden =[
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function toArray()
    {

        $lang = app(Locales::class)->current();

        $array['name'] =$this->{'name_'.$lang};

        return $array;
    }

    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
}
