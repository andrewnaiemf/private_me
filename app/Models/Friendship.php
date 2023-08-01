<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;

class Friendship extends Model
{
    use HasFactory;

    public $table = "frindships";
    public $fillable = ['status', 'sender_id','receiver_id', 'is_read'];

    public function getFriendshipMessageAttribute()
    {
        $currentLanguage = app()->getLocale();

        $friend_name = '';
        // if (auth()->user()->id == $this->sender_id) {
        //     $friend_name = $this->receiver->name;
        // }else{
        //     $friend_name = $this->sender->name;
        // }

        if ($this->status == 1) {
            return __('friendship.accepted', ['friend_name' => $this->receiver->name]);
        } elseif ($this->status == 0) {
            return __('friendship.pending', ['friend_name' => $this->receiver->name]);
        } elseif ($this->status == -1) {
            return __('friendship.rejected', ['friend_name' => $this->receiver->name]);
        }

        return '';
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}
