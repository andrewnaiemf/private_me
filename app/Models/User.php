<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject{
	use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'name',
		'email',
		'password',
		'account_type', // admin | user
		'admin_group_id',
		'created_at',
		'updated_at',
		'deleted_at',
        'device_token',
        'verified',
        'active',
        'question_id',
        'answer',
        'terms',
        'lng',
        'profile',
        'un_used_storage'
	];

    public function toArray()
    {
        $userArray = parent::toArray();
        $userArray = array_merge(['id' => $this->id], $userArray);
        return $userArray;
    }

	protected $deleted_at = 'deleted_at';

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
        'updated_at',
        'deleted_at',
        'admin_group_id',
        'gender',
        'email_verified_at',
        'verified',
        'phone',
        'active'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


	public function getCreatedAtAttribute($date) {
		return empty($date) ? $date : date('Y-m-d', strtotime($date));
	}

	public function getUpdatedAtAttribute($date) {
		return empty($date) ? $date : date('Y-m-d', strtotime($date));
	}

	public function getDeletedAtAttribute($date) {
		return empty($date) ? null : date('Y-m-d', strtotime($date));
	}

	public function getEmailVerifiedAtAttribute($date) {
		return empty($date) ? null : date('Y-m-d', strtotime($date));
	}

    public function getDeviceTokenAttribute($value)
    {
        // Check if the value is already an array
        if (is_array($value)) {
            return $value;
        }

        // Check if the value is a JSON string
        if (is_string($value) && json_decode($value) !== null) {
            return json_decode($value, true);
        }

        // If none of the above conditions match, return an empty array
        return [];

    }


	public function admingroup() {
		return $this->belongsTo(AdminGroup::class, 'admin_group_id');
	}

    public function package(){
        return $this->hasOne(Package::class);
    }

    public function directories(){
        return $this->hasMany(Directory::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'sender_id')->orWhere('receiver_id', $this->id);
    }

}
