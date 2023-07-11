<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Package extends Model
{
    use HasFactory,SoftDeletes;


    public $fillable = ['storage','user_id' ,'plan_id','content','transaction_id','renew','payment_method'];
    protected $appends = ['is_subscribed'];

    // Accessor for the `is_subscribed` attribute
    public function getIsSubscribedAttribute()
    {
        // Get the renew date
        $renewDate = $this->getAttribute('renew');

        // Compare the renew date with the current date
        $isSubscribed = Carbon::parse($renewDate)->isAfter(Carbon::now());

        return $isSubscribed;
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $hidden = [
		'crraed_at',
        'updated_at',
        'deleted_at',
        'content'
	];}
