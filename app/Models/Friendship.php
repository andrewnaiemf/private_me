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

        $friendLocale = $this->receiver->lng;
        app()->setLocale($friendLocale);

        $friend_name = '';
        if (auth()->user()->id == $this->sender_id) {
            $friend_name = $this->receiver->name;
        }else{
            $friend_name = $this->sender->name;
        }
// dd(auth()->user()->id , $this->sender_id , $this->receiver_id);
        if(auth()->user()->id != $this->sender_id){
            if ($this->status == 1) {
                return __('friendship.YouAccepted', ['friend_name' => $friend_name]);
            }elseif ($this->status == 0) {
                return __('friendship.pending', ['friend_name' => $friend_name]);
            } elseif ($this->status == -1) {
                return __('friendship.YouRejected', ['friend_name' => $friend_name]);
            }
        }else{
            if ($this->status == 1) {
                return __('friendship.accepted', ['friend_name' => $friend_name]);
            } elseif ($this->status == 0) {
                return __('friendship.pending', ['friend_name' => $friend_name]);
            } elseif ($this->status == -1) {
                return __('friendship.rejected', ['friend_name' => $friend_name]);
            }
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
