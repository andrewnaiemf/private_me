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

    protected $fillable = ['sender_id', 'receiver_id', 'message', 'type', 'is_read'];

    protected $visible = ['id', 'sender_id', 'receiver_id','sender','receiver', 'message', 'type', 'is_read'];


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
