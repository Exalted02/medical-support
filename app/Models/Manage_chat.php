<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manage_chat extends Model
{
    use HasFactory;
	protected $table = 'manage_chats';
	protected $fillable = [
        'source',
        'user_type',
        'chat_group_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];
	
	public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
