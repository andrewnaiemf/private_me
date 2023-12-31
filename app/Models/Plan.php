<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Plan  extends Model implements TranslatableContract
{
    use HasFactory,SoftDeletes,Translatable;

    public $translatedAttributes = ['name'];

    public $fillable = ['type'];
    public $appends = ['plan_type'];

    public function getTypeAttribute($value)
    {
        if ($value === 'شهريا' && app()->getLocale() === 'en') {
            return 'Monthly';
        }elseif($value === 'سنويا' && app()->getLocale() === 'en'){
            return 'Yearly';

        }

        return $value;
    }

    public function getPlanTypeAttribute()
    {
        if ($this->type === 'شهريا') {
            return 'Monthly';
        }elseif($this->type === 'سنويا'){
            return 'Yearly';

        }else{
            return $this->type;
        }
    }


    public function planProperties()
    {
        return $this->hasMany(PlanProperty::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, Package::class, 'plan_id', 'id', 'id', 'user_id')->whereNull('packages.deleted_at')->where('packages.status' , 'PAID');
    }

    protected $hidden = [
		'crraed_at',
        'updated_at',
        'deleted_at',
	];
}
