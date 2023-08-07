<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

        // Constants for the 'type' attribute
        const IMAGE = 1;
        const VIDEO = 2;
        const AUDIO = 3;
        const TEXT = 4;
        const FILE = 5;

    protected $fillable = ['sender_id', 'receiver_id', 'message', 'type', 'is_read','firebase_id'];

    protected $visible = ['id', 'sender_id', 'receiver_id','sender','receiver', 'message', 'type', 'is_read','firebase_id'];



    public function getMessageAttribute($value){

        $authUserId = auth()->user()->id;
        if($authUserId == $this->receiver_id){
            switch ($this->type) {
                case 'image':
                    return __('friendship.send_you_an_image');
                case 'video':
                    return  __('friendship.send_you_a_video');
                case 'audio':
                    return  __('friendship.send_you_an_audio');
                case 'file':
                    return  __('friendship.send_you_a_file');
                case 'text':
                    return $value;
                default:
                    return null;
            }
        }else{
            switch ($this->type) {
                case 'image':
                    return __('friendship.you_sent_an_image');
                case 'video':
                    return  __('friendship.you_sent_a_video');
                case 'audio':
                    return  __('friendship.you_sent_an_audio');
                case 'file':
                    return  __('friendship.you_sent_a_file');
                case 'text':
                    return $value;
                default:
                    return null;
            }
        }

    }
     // Accessor for 'type' attribute
     public function getTypeAttribute($value)
     {
         // Cast the integer value to the corresponding text representation
         switch ($value) {
             case self::IMAGE:
                 return 'image';
             case self::VIDEO:
                 return 'video';
             case self::AUDIO:
                 return 'audio';
             case self::TEXT:
                 return 'text';
            case self::FILE:
                return 'file';
             default:
                 return null;
         }
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
