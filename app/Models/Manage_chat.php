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
        'reason',
        'unique_chat_id',
        'chat_group_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'employee_assign_date',
    ];
	
	public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
	
	public function chat_files()
	{
		 return $this->hasMany(Manage_chat_file::class, 'manage_chat_id');
	}
	public function chat_feedback_status()
	{
		 return $this->hasOne(Chat_feedback_status::class, 'chat_group_id', 'chat_group_id');
	}
}
